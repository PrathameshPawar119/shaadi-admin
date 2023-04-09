<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SkillController extends Controller
{
    use HttpResponses;

    public function index(){
        return $this->success(Skill::select('name', 'id')->get(), "All skills fetched");
    }


    public function addSkill(Request $request)
    {
        $validator = $request->validate([
            'customers_id' => 'required|exists:customers,id',
            'skills_id' => 'required|exists:skills,id'
        ]);

        $skill_pair = Skill::find($validator['skills_id']);
        try {
            $skill = DB::table('customers_skills')->insert(['customers_id' => $validator['customers_id'], 'skills_id' => $validator['skills_id']]);
            return $this->success($skill_pair, "Skill added");
        } catch (Throwable $th) {
            return $this->error(null, $th->getMessage(), 500);
        }
    }

    public function removeSkill(Request $request)
    {
        $validator = $request->validate([
            'customers_id' => 'required|exists:customers,id',
            'skills_id' => 'required|exists:skills,id'
        ]);

        try {
            $skill = DB::table('customers_skills')->where('customers_id', $validator['customers_id'])->where('skills_id', $validator['skills_id'])->delete();
            return $this->success($skill, "SKill Removed");
        } catch (Throwable $th) {
            return $this->error(null, $th->getMessage(), 500);
        }
    }
}
