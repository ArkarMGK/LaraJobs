<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use App\Models\User;
use App\Models\Company;
use App\Models\JobList;
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
            'companies.logo as logo'
        )
            ->join('companies', 'job_lists.company_id', 'companies.id')
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
        return view('create', compact('allTags'));
    }

    public function store(Request $request)
    {
        $this->formValidationCheck($request);

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

    public function edit($id)
    {
        $job = JobList::select(
            'job_lists.*',
            'companies.name as company_name',
            'companies.logo as logo'
        )
            ->join('companies', 'job_lists.company_id', 'companies.id')
            ->where('job_lists.id', $id)
            ->first();
        $allTags = Tags::allTags();
        // dd($job->toArray());
        return view('edit', compact('job', 'allTags'));
    }

    public function update(Request $request, $id)
    {
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
            'jobTag' => 'required',
            'logo' => 'mimes:png,jpeg,jpg|file',
            'companyName' => 'required',
            'selectedTags' => 'required',
        ];
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
            'employment_type' => $request->employmentType,
        ];
    }
    public function dashboard()
    {
        $jobs = JobList::select(
            'job_lists.*',
            'companies.name as company_name',
            'companies.logo as logo'
        )
            ->join('companies', 'job_lists.company_id', 'companies.id')
            ->where('job_lists.user_id', Auth::user()->id)
            ->latest()
            ->get();
        return view('dashboard', compact('jobs'));
    }
}
