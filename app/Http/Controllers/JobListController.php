<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use App\Models\JobList;
use Illuminate\Http\Request;

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
        dd($request->all());
    }
}
