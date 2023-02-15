<?php

namespace App\Http\Controllers;

use App\Models\JobList;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function index(Request $request)
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
        ->latest();
        if ($request->tagName == 'all') {
            $jobs = $jobs->get();
        } else {
            $jobs = $jobs
                ->where('job_lists.tags', 'like', '%' . $request->tagName . '%')
                ->get();
        }

        foreach($jobs as $job){
            $job->createdAt = $job->created_at->diffForHumans();

            if ( $job->logo != null) {
                $job->logo = asset('storage/images/logo/' . $job->logo);
            } else {
                $job->logo = asset('images/default/logo.png');
            };
        }
        logger($jobs->toArray());
        return $jobs;
    }
}
