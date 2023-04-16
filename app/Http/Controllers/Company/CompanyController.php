<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Mail\CompanyCreated;
use App\Mail\NewCompany;
use App\Models\Company\Company as CompanyModel;
use App\Models\Contractor;
use App\Models\Customer\Customer;
use App\Traits\HttpResponses;
use Faker\Provider\ar_EG\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CompanyController extends Controller
{
    use HttpResponses, HasApiTokens;

    public function index(CompanyModel $company){
        $company = CompanyModel::find($company->id);
        return $this->success($company, "Company fetched successfully !");
    }

    public function getAllCompanies(Request $request)
    {
        try {
            $validator = $request->validate([
                "type" => 'string|in:latest,popular|nullable',
                "services" => 'array|nullable'
            ]);

            if ($validator['type'] == "latest") 
            {
                $companies = CompanyModel::orderBy('created_at', 'DESC')->paginate(20);
                return $this->success($companies, "Latest Companies...");
            }
            else
            {
                $companies = CompanyModel::orderBy('followers', 'DESC')->paginate(20);
                return $this->success($companies, "Popular Companies...");
            }
    
            if($validator['services'])
            {
                dd($validator['services']);
            }

            $companies = CompanyModel::orderBy('followers', 'DESC')->paginate(20);
            return $this->success($companies, "Popular Companies...");

        } catch (ModelNotFoundException $th) {
            return $this->error(null, $th->getMessage(), 500);
        }
        
    }


    public function createCompany(Request $req){
        $validator = $req->validate([
            'name' => 'bail|required|max:100|string',
            'title' => 'bail|required|max:300|string',
            'about' => 'bail|min:10|nullable|string',
            'email' => 'bail|email|max:100|unique:companies,email',
            'services' => 'nullable',
            'website' => 'bail|url|nullable',
            'industry_type' => 'bail|string|required',
            'main_city' => 'bail|string|required',
            'available_cities' => 'nullable',
            'company_size' => 'bail|string|required',
            'founded' => 'bail|date|required',
        ]);

        // if(!is_null($validator['services'])){
        //     $validator['services'] = implode(',', $validator['services']);
        // }

        // if (!is_null($validator['available_cities'])) {
        //     $validator['available_cities'] = implode(',', $validator['available_cities']);
        // }
        

        $validator['creator'] = Auth::guard('customer')->id();
        $validator['slug'] = Str::slug($validator['name']);

        //create contractor for comapny
        $creator = Customer::find($validator['creator'])->toArray();
        $contractor = Contractor::create($creator);
            
        $customer = Customer::find(Auth::guard('customer')->id());
        $customer->hasCompany = 1;
        $customer->save();
        
        if($validator){
            try {
                $company = CompanyModel::create($validator);

                throw_if($company->count() == 0,'Post Generation failed');

                Mail::to($company->email)->send(new CompanyCreated($company, $contractor));
                return $this->success($company, "Company Registered Successfully !");

            } catch (\Throwable $th) {
                return $this->error(null, $th->getMessage(), 500);
            }
        }
        else{
            return $this->error(null, "Validation Error!", 500);
        }

    }

    public function getFollowers(CompanyModel $company)
    {
        try {
            $company = CompanyModel::find($company->id);
    
            $followers = $company->customers()->paginate(20);
            $follower_Count = $company->customers()->count();

            $data = array($follower_Count, $followers);

            return $this->success($data, "Followers fetched");
        } catch (\Throwable $th) {
            return $this->error(null, $th->getMessage(), 500);
        }
    }

    public function getPosts(CompanyModel $company){
        try {
            $company = CompanyModel::find($company->id);

            $posts = $company->posts()->paginate(20);
            return $this->success($posts, "Posts fetched for company");
        }
        catch(\Throwable $th)
        {
            return $this->error(null, $th->getMessage(), 500);
        }
    }

    public function followCompany(Request $request)
    {
        $validator = $request->validate([
            'customers_id' =>'exists:customers,id',
            'companies_id' =>'exists:companies,id'
        ]);
        try {
            DB::table('customers_companies')->insert($validator);
            return $this->success(null, "Following !");
        } catch (\Throwable $th) {
            return $this->error(null, $th->getMessage(), 500);
        }
    }

    public function unFollowCompany(Request $request)
    {
        $validator = $request->validate([
            'customers_id' =>'exists:customers,id',
            'companies_id' =>'exists:companies,id'
        ]);
        try {
            DB::table('customers_companies')->where('customers_id', $validator['customers_id'])->where('companies_id', $validator['companies_id'])->delete();
            return $this->success(null, "Removed from following !");
        } catch (\Throwable $th) {
            return $this->error(null, $th->getMessage(), 500);
        }
    }

    public function addService(Request $request)
    {

    }



}
