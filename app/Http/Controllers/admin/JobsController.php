<?php

namespace App\Http\Controllers\admin;

use App\Models\Tags;
use App\Models\JobList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobsController extends Controller
{
    // SHOW ACTIVE JOBS
    public function index()
    {
        $jobs = $this->getJobs('active');
        // dd($jobs->toArray());
        return view('admin.jobs.index', compact('jobs'));
    }

    // SHOW OLD JOBS
    public function oldJobs()
    {
        $jobs = $this->getJobs('old');
        return view('admin.jobs.olds', compact('jobs'));
    }

    private function getJobs($status){

        $status == 'active' ? $status = 1 : $status =  0;
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
            ->when(request('search'), function ($query) {
                $key = request('search');
                $query
                    ->where('job_lists.title', 'like', '%' . $key . '%')
                    ->orWhere('job_lists.tags', 'like', '%' . $key . '%')
                    ->orWhere(
                        'job_lists.job_location',
                        'like',
                        '%' . $key . '%'
                    )
                    ->orWhere('companies.name', 'like', '%' . $key . '%')
                    ->orWhere('employment_type', 'like', '%' . $key . '%');
            })
            ->where('available', $status)
            ->latest()
            // ->get();
            ->paginate(3);

        return $jobs;
    }

    // APPROVE A HIRED JOB (not vacant)
    public function hiredJob(Request $request, JobList $job)
    {
        Joblist::where('id', $job->id)->update([
            'available' => $request->jobCurrentStatus,
        ]);

        $message = 'Job #' . $job->id . ' has been hired! View on older jobs';
        return redirect()
            ->route('admin#jobList')
            ->with('message', $message);
    }

    public function vacantJob(Request $request, JobList $job)
    {
        Joblist::where('id', $job->id)->update([
            'available' => $request->jobCurrentStatus,
        ]);

        $message = 'Job #' . $job->id . ' is now Vacant! See on Active Jobs';
        return redirect()
            ->route('admin#oldJobList')
            ->with('message', $message);
    }

    public function destroy(JobList $job)
    {
        $jobId = $job->id;
        $job->delete();
        $message = 'Hired Job #' . $jobId . ' is now Deleted !';
        return redirect()
            ->route('admin#oldJobList')
            ->with('message', $message);
    }
}
