<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Mail\CompanyCreated;
use App\Models\Company\Company as CompanyModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            dd($validator);
    
            if($validator['services'])
            {
                dd($validator['services']);
            }
            else{
                $companies = CompanyModel::orderBy('followers', 'DESC')->paginate(20);
                return $this->success($companies, "Popular Companies...");
            }
        } catch (ModelNotFoundException $th) {
            return $this->error(null, $th->getMessage(), 500);
        }
        
        // if ($validator['type'] == "latest") 
        // {
        //     $companies = Company::orderBy('created_at', 'DESC')->paginate(20);
        //     return $this->success($companies, "Latest Companies...");
        // }
        // else
        // {
        //     $companies = Company::orderBy('followers', 'DESC')->paginate(20);
        //     return $this->success($companies, "Popular Companies...");
        // }
    }


    public function createCompany(Request $req){
        $validator = $req->validate([
            'name' => 'bail|required|max:100|string',
            'title' => 'bail|required|max:300|string',
            'about' => 'bail|min:100|nullable|string',
            'email' => 'bail|email|max:100|unique:companies,email',
            'services' => 'array|required',
            'website' => 'bail|url|nullable',
            'industry_type' => 'bail|string|required',
            'main_city' => 'bail|string|required',
            'available_cities' => 'array|required',
            'company_size' => 'bail|string|required',
            'founded' => 'bail|date|required',
        ]);

        $validator['services'] = implode(',', $validator['services']);
        $validator['available_cities'] = implode(',', $validator['available_cities']);

        // dd($validator);
        $validator['creator'] = Auth::guard('customer')->id();
        if($validator){
            try {
                $company = CompanyModel::create($validator);

                throw_if($company->count() == 0,'Post Generation failed');

                Mail::to($company->email)->send(new CompanyCreated($company));
                return $this->success($company, "Company Registered Successfully !");

            } catch (\Throwable $th) {
                return $this->error(null, $th->getMessage(), 500);
            }
        }
        else{
            return $this->error(null, "Validation Error!", 500);
        }

    }

}
