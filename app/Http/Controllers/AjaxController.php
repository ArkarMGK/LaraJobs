<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
            ->where('job_lists.available', '1')
            ->latest();
        if ($request->tagName == 'all') {
            $jobs = $jobs->get();
        } else {
            $jobs = $jobs
                ->where('job_lists.tags', 'like', '%' . $request->tagName . '%')
                ->get();
        }

        foreach ($jobs as $job) {
            $job->createdAt = $job->created_at->diffForHumans();

            if ($job->logo != null) {
                $job->logo = asset('storage/images/logo/' . $job->logo);
            } else {
                $job->logo = asset('images/default/logo.png');
            }
        }
        // logger($jobs->toArray());
        return $jobs;
    }

    public function filterCompanies(Request $request)
    {
        //  QUERY BUILDER
        $query = Company::query();

        $filterValues = $request->data;

        // logger(count($filterValues));
        // logger($filterValues);

        if ($filterValues[0] != 'all' && count($filterValues) == 1) {
            logger('Price Range Only');
            list($min, $max) = explode('-', $filterValues[0]);
            $query
                ->where('min_budget', '>=', $min)
                ->where('max_budget', '<=', $max);
        }

        if ($filterValues[0] == 'all' && count($filterValues) == 1) {
            logger('Price Range All');
            $query->inRandomOrder()->limit(4);
        }

        if ($filterValues[0] != 'all' && count($filterValues) > 1) {
            logger('Price Range and Region');
            //     // ONE or MORE region
            list($min, $max) = explode('-', $filterValues[0]);
            $query
                    ->where('min_budget', '>=', $min)
                    ->where('max_budget', '<=', $max);
            if (count($filterValues) > 1) {
                $query->where('region', $filterValues[1]);
                array_shift($filterValues);
                while (count($filterValues) > 1) {
                    array_shift($filterValues);
                    $query->orWhere('region', $filterValues[0]);
                }
            }
        }
        if($filterValues[0] == 'all' && count($filterValues) > 1){
            logger('Region Only');
            if (count($filterValues) > 1) {
                $query->where('region', $filterValues[1]);
                array_shift($filterValues);
                while (count($filterValues) > 1) {
                    array_shift($filterValues);
                    $query->orWhere('region', $filterValues[0]);
                }
            }
        }
        $companies = $query->get();
        if (count($companies) > 0) {
            foreach ($companies as $company) {
                if ($company->logo != null) {
                    $company->logo = asset(
                        'storage/images/logo/' . $company->logo
                    );
                } else {
                    $company->logo = asset('images/default/logo.png');
                }
            }
        }
        return $companies;
    }
}
