<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    use HttpResponses;

    public function index(){
        return $this->success(Skill::select('name', 'id')->get(), "All skills fetched");
    }
}
