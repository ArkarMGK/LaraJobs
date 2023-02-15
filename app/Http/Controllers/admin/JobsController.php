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
            ->where('available', 1)
            ->latest()
            // ->get();
            ->paginate(3);

        // dd($jobs->toArray());
        return view('admin.jobs.index', compact('jobs'));
    }

    // SHOW OLD JOBS
    public function oldJobs()
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
            ->where('available', '0')
            ->latest()
            // ->get();
            ->paginate(3);
        return view('admin.jobs.olds', compact('jobs'));
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
        $message = 'Hired Job #' . $jobId .' is now Deleted !';
        return redirect()
            ->route('admin#oldJobList')
            ->with('message', $message);
    }
}
