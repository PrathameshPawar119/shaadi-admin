<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Mail\CompanyCreated;
use App\Models\Company\Company;
use App\Models\Customer\Customer;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

class CompanyController extends Controller
{
    use HttpResponses, HasApiTokens;

    public function index(Company $company){
        $company = Company::find($company->id);
        return $this->success($company, "Company fetched successfully !");
    }


    public function createCompany(Customer $customer, Request $req){
        $validator = $req->validate([
            'name' => 'bail|required|max:100|string',
            'title' => 'bail|required|max:300|string',
            'about' => 'bail|min:100|nullable|string',
            'email' => 'bail|email|max:100|unique:companies,email',
            'services' => 'bail|json|nullable',
            'website' => 'bail|url|nullable',
            'industry_type' => 'bail|string|required',
            'main_city' => 'bail|string|required',
            'company_size' => 'bail|string|required',
            'founded' => 'bail|date|required',
        ]);

        if($validator){
            $company = Company::create([
                'creator' => $customer->id,
                'name' => $validator['name'],
                'title' => $validator['title'],
                'about' => $validator['about'],
                'email' => $validator['email'],
                'services'=> $validator['services'],
                'website'=> $validator['website'],
                'industry_type'=> $validator['industry_type'],
                'main_city'=> $validator['main_city'],
                'company_size'=> $validator['company_size'],
                'founded'=> $validator['founded'],
            ]);

            Mail::to($company->email)->send(new CompanyCreated($company));
            return $this->success($company, "Company Registered Successfully !");
        }
        else{
            return $this->error(null, "Validation Error!", 500);
        }
    }

}
