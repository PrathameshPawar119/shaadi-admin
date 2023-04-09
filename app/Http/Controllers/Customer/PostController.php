<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Customer\Customer;
use App\Models\Customer\Post;
use App\Models\Tag;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class PostController extends Controller
{
    use HttpResponses, HasApiTokens;

    public function getNewPosts():JsonResponse
    {
        try {
            $posts = Post::orderBy('created_at', 'DESC')->paginate(20);
            return $this->success($posts, "Latest Posts...");
        } catch (\Throwable $th) {
            return $this->error(null, $th->getMessage(), 500);
        }
    }

    public function getPopularPosts():JsonResponse
    {
        try {
            $posts = Post::join('customers', 'customers.id', 'posts.creator')
                        ->select('posts.*', 'customers.id', 'customers.name', 'customers.title')->orderBy('likes', 'DESC')->paginate(20);
            return $this->success($posts, "Popular Posts...");
        } catch (\Throwable $th) {
            return $this->error(null,$th->getMessage(), 500);
        }
    }

    // shuffled posts by city
    // Posts by city with filters
    public function postsByCityFilteres(City $city ,Request $request):JsonResponse
    {
        $validator = $request->validate([
            "type" => 'string|in:latest,popular'
        ]);

        if ($validator['type'] == "latest") 
        {
            $posts = Post::orderBy('created_at', 'DESC')->where('city', $city->name)->paginate(20);
            return $this->success($posts, "Latest Posts...");
        }
        else
        {
            $posts = Post::orderBy('likes', 'DESC')->where('city', $city->name)->paginate(20);
            return $this->success($posts, "Popular Posts...");
        }

        // $new_posts = Post::orderBy('created_at', 'DESC')->where('city', $city->name)->paginate(20)->toArray();
        // $popular_posts = Post::orderBy('likes', 'DESC')->where('city', $city->name)->paginate(20)->toArray();
        // $posts = $new_posts + $popular_posts;
        // $posts = shuffle($posts);
        // return $this->success($posts, "Popular and latest posts shuffled for ".$city);

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

    public function deletePost(Post $post)
    {
        try {            
            $user = Auth::check('customer');
            if($user){
                Post::where('id', $post->id)->delete();
            }
        } catch (\Throwable $th) {
            return $this->error(null, $th->getMessage(), 500);
        }
    }

    public function createPost(Request $request){
        $user = Auth::guard('customer');
        $validator = $request->validate([
            'title' => 'string|required|max:300',
            'content' => 'string|required|max:1000',
            'tags' => 'nullable',
            'image' => 'file|max:5120|mimes:jpeg,jpg,png,gif|nullable',
            'city' => 'string|nullable'
        ]);

        $file = $request->file('image');
        // $path = Storage::putFile('posts', $file);
        // $public_path = storage_path('app');
        // $opt_path = substr($path, 6);
        if($file){
            $destinationPath = 'posts/';
            $imageName = date('YmdHis')."-".$file->getClientOriginalName();
            $file->move($destinationPath, $imageName);
            $validator['image'] = $destinationPath.$imageName;
        }


        $validator['creator'] =  $user->id();
        if(is_null($validator['city']))
        {
            $validator['city'] = $user->city;
        }
        $validator['tags'] = explode(",", $validator['tags']);

        // $validator['comments'] = implode(", ", $validator['comments']);
        // dd($validator);

        try {
            $post = Post::create($validator);
            throw_if($post->count() == 0,'Post Generation failed');

            if(is_null($validator['tags']) == false){
                foreach ($validator['tags'] as $key => $tag) {
                    $tags_id = Tag::where('name', $tag)->select('id')->first();
                    DB::table('tags_posts')->insert(['tags_id' => $tags_id->id, 'posts_id' => $post->id]);
                }
            }

            return $this->success($post, "Post Created Successfully !");
        } catch (\Throwable $th) {
            return $this->error(null, $th->getMessage(), 500);
        }

    }
}
