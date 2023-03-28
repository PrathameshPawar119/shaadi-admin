<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $tags = Tag::select('id', 'name')->get();

        if (is_null($tags)) {
            return $this->error(null, "No tags yet", 400);
        }
        return $this->success($tags, "All tags");
    }
}
