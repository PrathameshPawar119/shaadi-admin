<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\JobModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    use HttpResponses;

    public function getAll()
    {
        $jobs = JobModel::paginate(20);
        
        if(is_null($jobs)){
            return $this->success(null, "No jobs to display");
        }
        return $this->success($jobs, "All jobs fetched");
    }

    public function getJobById(JobModel $job)
    {
        $job = JobModel::find($job->id);

        if(is_null($job))
        {
            return $this->error(null, "Invalid Job Id", 404);
        }
        return $this->success($job, "Job fetched");
    }
}
