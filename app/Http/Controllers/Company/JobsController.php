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
        $jobs = JobModel::all();
        
        if(is_null($jobs)){
            return $this->success(null, "No jobs to display");
        }
        return $this->success($jobs, "All jobs fetched");
    }
}
