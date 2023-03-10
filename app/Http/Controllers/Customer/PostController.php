<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\Post;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class PostController extends Controller
{
    use HttpResponses, HasApiTokens;

    public function getAllPosts(Request $request):JsonResponse
    {
        $validator = $request->validate([
            "type" => 'string|required|in:latest,popular'
        ]);

        if ($validator['type'] == "latest") 
        {
            $posts = Post::orderBy('created_at', 'DESC')->paginate(20);
            return $this->success($posts, "Latest Posts...");
        }
        else if($validator['type'] == "popular")
        {
            $posts = Post::orderBy('likes', 'DESC')->paginate(20);
            return $this->success($posts, "Popular Posts...");
        }

        return $this->error(null, "Validation Error", 500);
    }

    public function getUserPosts(Customer $customer ,Request $request):JsonResponse
    {
        $validator = $request->validate([
            "type" => 'string|required|in:latest,popular'
        ]);

        if ($validator['type'] == "latest") 
        {
            $posts = Post::orderBy('created_at', 'DESC')->where('creator', $customer->id)->paginate(20);
            return $this->success($posts, "Latest Posts...");
        }
        else if($validator['type'] == "popular")
        {
            $posts = Post::orderBy('likes', 'DESC')->where('creator', $customer->id)->paginate(20);
            return $this->success($posts, "Popular Posts...");
        }

        return $this->error(null, "Validation Error", 500);
        
    }

    public function deletePost()
    {

    }

    public function createPost(Request $request){
        $user = Auth::guard('customer')->id();
        $validator = $request->validate([
            'title' => 'string|required|max:300',
            'content' => 'string|required|max:1000',
            'tags' => 'nullable|array',
            'image' => 'file|max:5120|mimes:jpeg,jpg,png,gif|nullable',
        ]);
        $validator['creator'] =  $user;
        
        
        $validator['tags'] = implode(",", $validator['tags']);
        // $validator['comments'] = implode(", ", $validator['comments']);
        // dd($validator);

        try {
            $post = Post::create($validator);
            throw_if($post->count() == 0,'Post Generation failed');

            return $this->success($post, "Post Created Successfully !");
        } catch (\Throwable $th) {
            return $this->error(null, $th->getMessage(), 500);
        }

    }
}
