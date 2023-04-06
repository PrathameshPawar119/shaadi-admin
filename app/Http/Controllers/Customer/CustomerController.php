<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\Experience;
use App\Models\Skill;
use App\Models\Tag;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $skill_pair = Skill::find($validator['skills_id']);
        try{
            $skill = DB::table('customers_skills')->insert(['customers_id' => $validator['customers_id'], 'skills_id' => $validator['skills_id']]);
            return $this->success($skill_pair, "SKill added");
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

    public function createExperience(Request $request){
        $user = Auth::guard('customer');
        $validator = $request->validate([
            'title' => 'string|required|max:300',
            'content' => 'string|required|max:1000',
            'tags' => 'nullable',
            'image' => 'file|max:5120|mimes:jpeg,jpg,png,gif|nullable',
            'city' => 'string|nullable'
        ]);

        $file = $request->file('image');
        if($file){
            $destinationPath = 'experiences/';
            $imageName = date('YmdHis')."-".$file->getClientOriginalName();
            $file->move($destinationPath, $imageName);
            $validator['image'] = $destinationPath.$imageName;
        }


        $validator['customer_id'] =  $user->id();
        if(is_null($validator['city']))
        {  
            $validator['city'] = $user->city;
        }
        $validator['tags'] = explode(",", $validator['tags']);

        // $validator['comments'] = implode(", ", $validator['comments']);
        // dd($validator);

        try {
            $experience = Experience::create($validator);
            throw_if($experience->count() == 0,'Experience Generation failed');

            if(is_null($validator['tags']) == false){
                foreach ($validator['tags'] as $key => $tag) {
                    $tags_id = Tag::where('name', $tag)->select('id')->first();
                    DB::table('tags_experiences')->insert(['tags_id' => $tags_id->id, 'experiences_id' => $experience->id]);
                }
            }

            return $this->success($experience, "Experience Created Successfully !");
        } catch (\Throwable $th) {
            return $this->error(null, $th->getMessage(), 500);
        }

    }

    public function getExperiences(Customer $customer)
    {
        $user = Customer::find($customer->id);
        $experiences = $user->experiences()->get();
        if(is_null($experiences))
        {
            return $this->error(null, "No experiences added yet", 400);
        }
        return $this->success($experiences, "All experiences");
    }

}
