<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use App\Models\User;
use App\Models\Company;
use App\Models\JobList;
use App\Models\Employment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JobListController extends Controller
{
    public function index()
    {
        $jobs = JobList::select(
            'job_lists.*',
            'companies.name as company_name',
            'companies.logo as logo',
            'employments.employment_type as employment_type'
        )
            ->leftJoin('companies', 'job_lists.company_id', 'companies.id')
            ->leftJoin(
                'employments',
                'job_lists.employment_type_id',
                'employments.id'
            )
            ->latest()
            ->get();
        $allTags = Tags::allTags();
        // dd($allTags['tags']);
        // dd($jobs->toArray());
        return view('index', compact('jobs', 'allTags'));
    }

    public function create()
    {
        $allTags = Tags::allTags();
        $employments = Employment::get();
        return view('create', compact('allTags', 'employments'));
    }

    public function dashboard()
    {
        $jobs = JobList::select(
            'job_lists.*',
            'companies.name as company_name',
            'companies.logo as logo',
            'employments.employment_type as employment_type'
        )
            ->leftJoin('companies', 'job_lists.company_id', 'companies.id')
            ->leftJoin(
                'employments',
                'job_lists.employment_type_id',
                'employments.id'
            )
            ->where('job_lists.user_id', Auth::user()->id)
            ->latest()
            ->get();
        $employments = Employment::get();
        return view('dashboard', compact('jobs','employments'));
    }

    public function edit($id)
    {
        $job = JobList::select(
            'job_lists.*',
            'companies.name as company_name',
            'companies.logo as logo',
            'employments.employment_type as employment_type'
        )
            ->leftJoin('companies', 'job_lists.company_id', 'companies.id')
            ->leftJoin(
                'employments',
                'job_lists.employment_type_id',
                'employments.id'
            )
            ->where('job_lists.id', $id)
            ->first();
        if($job == null){
            return abort(404);
        }
        $allTags = Tags::allTags();
        $employments = Employment::get();
        return view('edit', compact('job', 'allTags','employments'));
    }

    // Jobs CRUD
    public function store(Request $request)
    {

        if ($request->email) {
            $formFields = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'unique:users'],
                'password' => 'required|confirmed|min:6',
            ]);
            // Hash Password
            $formFields['password'] = Hash::make($request->password);
            $user = User::create($formFields);
            auth()->login($user);
        }

        $this->formValidationCheck($request);
        $data = $this->requestFormData($request);
        // Company
        $data['company_id'] = $this->getCompanyId($request->companyName);
        // IMAGE
        if ($request->hasFile('image')) {
            $this->companyLogoUpdate($request, $data['company_id']);
        }
        JobList::create($data);
        return redirect()->route('dashboard');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->formValidationCheck($request);
        $data = $this->requestFormData($request);
        // Company
        $data['company_id'] = $this->getCompanyId($request->companyName);
        // IMAGE
        if ($request->hasFile('image')) {
            $this->companyLogoUpdate($request, $data['company_id']);
        }
        JobList::where('id', $id)->update($data);
        return redirect()->route('dashboard');
    }

    private function companyLogoUpdate(Request $request, $companyId)
    {
        // Get Old Image
        $oldImage = Company::select('logo')
            ->where('id', $companyId)
            ->first();
        $oldImage = $oldImage->logo;
        // Delete Old Image if Exists
        if ($oldImage != null) {
            Storage::delete('public/images/logo/' . $oldImage);
        }
        $photo = uniqid() . $request->file('image')->getClientOriginalName();
        // Store in Public Folder
        $request->file('image')->storeAs('public/images/logo', $photo);
        Company::where('id', $companyId)->update([
            'logo' => $photo,
        ]);
    }
    private function getCompanyId($companyName)
    {
        $company = Company::where('name', $companyName)->first();
        if ($company == null) {
            $company = Company::create([
                'name' => $companyName,
                'email' => null,
                'logo' => null,
                'website' => null,
                'location' => null,
            ]);
        }
        return $company->id;
    }
    private function formValidationCheck($request)
    {
        $validationRules = [
            'jobTitle' => 'required',
            'jobLocation' => 'required',
            'jobUrl' => 'required|url',
            'selectedTags' => 'required',
            'logo' => 'mimes:png,jpeg,jpg|file',
            'companyName' => 'required',
            'selectedTags' => 'required',
        ];

        if(!Auth::user()){
            $validationRules = [
                'user' => 'required',
            ];
        }
        $validationMessage = [
            'companyName.required' => 'The organization field is required.',
        ];
        Validator::make(
            $request->all(),
            $validationRules,
            $validationMessage
        )->validate();
    }

    private function requestFormData($request)
    {
        return [
            'title' => $request->jobTitle,
            'tags' => $request->selectedTags,
            'user_id' => Auth::user()->id,
            'job_url' => $request->jobUrl,
            'job_location' => $request->jobLocation,
            'employment_type_id' => $request->employmentType,
        ];
    }
}
