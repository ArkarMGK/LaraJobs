<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use App\Models\User;
use App\Models\Company;
use App\Models\JobList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class JobListController extends Controller
{
    public function index(){
        $jobs = JobList::select('job_lists.*','companies.name as company_name')
        ->join('companies','job_lists.company_id','companies.id')
        ->latest()
        ->get();
        // dd($jobs->toArray());
        $allTags = Tags::allTags();
        // dd($allTags['tags']);
        return view('index',compact('jobs','allTags'));
    }

    public function create(){
        $allTags = Tags::allTags();
        // dd($allTags);
        return view('create',compact('allTags'));
    }

    public function store(Request $request){
        // dd($request->all());
        if($request->email){
            $formFields = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => 'required|confirmed|min:6'
            ]);
            // Hash Password
            $formFields['password'] = Hash::make($request->password);
            $user = User::create($formFields);
            auth()->login($user);

        }
        // dd("here");
        $this->formValidationCheck($request);
        $data = $this->requestFormData($request);

        // Company
        $data['company_id'] = $this->getCompanyId($request->companyName);
        // dd($data);
        JobList::create($data);
        return redirect()->route('dashboard');
    }

    private function getCompanyId($companyName){
        $company = Company::where('name',$companyName)->first();
        if($company == null){
            $company = Company::create(['name'=>$companyName,
                                        'email'=> 'example@gmail.com',
                                        'logo' => 'logoName',
                                        'website'=> 'unidentifed',
                                        'location'=>'unidentified',
                                        ]);
        }
        return ($company->id);
    }
    private function formValidationCheck($request){
        $validationRules = [
            'jobTitle' => 'required',
            'jobLocation' => 'required',
            'jobUrl' => 'required|url',
            'companyName' => 'required',
            'selectedTags' => 'required',
        ];
        $validationMessage = [
            'companyName.required' => 'The organization field is required.',
        ];
        Validator::make($request->all(), $validationRules, $validationMessage)->validate();
    }

    private function requestFormData($request){
        return [
            'title' => $request->jobTitle,
            'tags' => $request->selectedTags,
            'user_id' => Auth::user()->id,
            'job_url' => $request->jobUrl,
            'job_location' => $request->jobLocation,
            'employment_type' => $request->employmentType,
        ];
    }
    public function dashboard(){
        $jobs = JobList::select('job_lists.*','companies.name as company_name')
        ->join('companies','job_lists.company_id','companies.id')
        ->where('job_lists.user_id',Auth::user()->id)
        ->latest()
        ->get();
        return view('dashboard', compact('jobs'));
    }
}
