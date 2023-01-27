<?php

namespace App\Http\Controllers;

use App\Models\JobList;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function index(Request $request){
        if ($request->tagName == 'all') {
            $jobs = JobList::select('job_lists.*','companies.name as company_name')
            ->join('companies','job_lists.company_id','companies.id')
            ->latest()
            ->get();
            return $jobs;
        }
        $jobs = JobList::select('job_lists.*','companies.name as company_name')
        ->join('companies','job_lists.company_id','companies.id')
        ->where('job_lists.tags', 'like', '%'.$request->tagName.'%')
        ->latest()
        ->get();
        return $jobs;
    }
}
