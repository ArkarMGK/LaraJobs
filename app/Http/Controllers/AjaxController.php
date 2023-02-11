<?php

namespace App\Http\Controllers;

use App\Models\JobList;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobList::select('job_lists.*', 'companies.name as company_name')
            ->join('companies', 'job_lists.company_id', 'companies.id')
            ->latest();
        if ($request->tagName == 'all') {
            $jobs = $jobs->get();
        } else {
            $jobs = $jobs
                ->where('job_lists.tags', 'like', '%' . $request->tagName . '%')
                ->get();
        }
        return $jobs;
    }
}
