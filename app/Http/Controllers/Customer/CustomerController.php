<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CustomerController extends Controller
{
    use HttpResponses;

    public function getCustomerPosts (Customer $customer)
    {
        try {
            $customer = Customer::find($customer->id);
            $posts = $customer->posts()->paginate(20);
    
            return $this->success($posts, "Posts...");
        } catch (\Throwable $th) {
            return $this->error(null, $th->getMessage(), 500);
        }
    }

    public function addSkill(Request $request)
    {
        $validator = $request->validate([
            'customers_id' => 'required|exists:customers,id',
            'skills_id' => 'required|exists:skills,id'
        ]);

        try{
            $skill = DB::table('customers_skills')->insert(['customers_id' => $validator['customers_id'], 'skills_id' => $validator['skills_id']]);
            return $this->success($skill, "SKill added");
        }
        catch(Throwable $th){
            return $this->error(null, $th->getMessage(), 500);
        }
    }

    public function removeSkill(Request $request)
    {
        $validator = $request->validate([
            'customers_id' => 'required|exists:customers,id',
            'skills_id' => 'required|exists:skills,id'
        ]);

        try{
            $skill = DB::table('customers_skills')->where('customers_id', $validator['customers_id'])->where('skills_id', $validator['skills_id'])->delete();
            return $this->success($skill, "SKill Removed");
        }
        catch(Throwable $th){
            return $this->error(null, $th->getMessage(), 500);
        }
    }

    public function getSkills(Customer $customer)
    {
        $user = Customer::find($customer->id);
        if(is_null($user)){
            return $this->error(null, "User not Found", 400);
        }
        try {
            $skills = $user->skills()->select('id', 'name')->get();
            return $this->success($skills, "Skills Fetched");
        } catch (\Throwable $th) {
            return $this->error(null, $th->getMessage(), 500);
        }
    }

}
