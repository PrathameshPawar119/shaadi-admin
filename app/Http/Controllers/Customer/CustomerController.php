<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

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


}
