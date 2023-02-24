<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Company;
use App\Models\HireProject;
use App\Models\UserCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ConsultantController extends Controller
{
    // Laravel-Consultant Page
    public function index()
    {
        $companies = Company::get();
        $regions = Region::allRegions();
        // dd($regions);
        // $locations = $companies->unique('region');
        $randomCompanies = Company::inRandomOrder()
            ->limit(4)
            ->get();
        return view('consultants.index', compact('randomCompanies', 'regions'));
    }

    // List-Agency Page
    public function create()
    {
        $regions = Region::allRegions();
        // dd($regions);
        return view('consultants.create', compact('regions'));
    }

    // Hire an Agency for A project
    public function contactCompany(Company $company){
        return view('consultants.hire', compact('company'));
    }

    // Store User's Agency
    public function store(Request $request)
    {
        $this->formValidationCheck($request);
        $data = $this->requestFormData($request);
        if ($request->hasFile('image')) {
            $photo =
                uniqid() . $request->file('image')->getClientOriginalName();
            // Store in Public Folder
            $request->file('image')->storeAs('public/images/logo', $photo);
            $data['logo'] = $photo;
        }
        $company = Company::create($data);
        $this->listUserAndCompany(
            $userId = Auth::user()->id,
            $companyId = $company->id
        );
        return redirect()->route('consultant');
    }

    // Hire Project to a company
    public function hireProject(Request $request){
        // dd($request->all());
        $this->validateProjectData($request);
        $data = $this->getProjectData($request);
        $data['user_company_id'] = $this->getCompanyId($request->companyName);
        if(Auth::user()){
            $data['user_id'] = Auth::user()->id;
        }
        HireProject::create($data);
        return redirect()->route('consultant')->with('message','Your Project Request Email has been Sent');
    }

    private function validateProjectData($request){
        $validationRules = [
            'name' => 'required',
            'email' => 'required',
            'companyName' => 'required',
            'budget' => 'required',
            'description' => 'min:5',
        ];

        $validationMessages = [
            'budget.required' => 'Please select budget for your project',
        ];
        Validator::make(
            $request->all(),
            $validationRules,
            $validationMessages
        )->validate();
    }

    private function getProjectData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'budget' => $request->budget,
            'description' => $request->description,
            'hiring_company_id' => $request->hiring_company_id,
        ];
    }
    private function getCompanyId($companyName)
    {
        $company = Company::where('name', $companyName)->first();
        if ($company == null) {
            $company = Company::create([
                'name' => $companyName,
                'details' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                            Officia architecto reiciendis, tenetur iure unde,
                            minima sed ut veritatis pariatur inventore esse beatae maiores
                            fugit ullam qui nobis nulla, vel fugiat.',
            ]);
        }
        return $company->id;
    }

    private function listUserAndCompany($userId, $companyId)
    {
        UserCompany::create(['user_id' => $userId, 'company_id' => $companyId]);
    }

    private function formValidationCheck($request)
    {
        $validationRules = [
            'name' => 'required|unique:companies,name',
            'details' => 'required',
            'email' => 'required|email',
            'website' => 'required|url',
            'location' => 'required',
            'image' => 'mimes:png,jpeg,jpg|file',
            'region' => 'required',
            'min_budget' =>
                'required_with:min_budget|numeric|min:2000|max:50000',
            'max_budget' => 'required_with:max_budget|numeric|gte:min_budget',
        ];

        $validationMessages = [
            'max_budget.gte' =>
                'The maximum budget should be higher than the minimum budget',
        ];

        Validator::make(
            $request->all(),
            $validationRules,
            $validationMessages
        )->validate();
    }

    private function requestFormData($request)
    {
        return [
            'name' => $request->name,
            'details' => $request->details,
            'email' => $request->email,
            'website' => $request->website,
            'location' => $request->location,
            'region' => $request->region,
            'min_budget' => $request->min_budget,
            'max_budget' => $request->max_budget,
        ];
    }
}
