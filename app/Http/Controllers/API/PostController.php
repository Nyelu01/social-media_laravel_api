<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Traits\FileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use FileTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->query->get('per_page');

        $posts = Post::with(['created_by:id,name','comments.client:id,name'])->paginate($per_page);
        return response()->json([$posts], 200);
    }

    /**
     * SFileTraite in storage.
     */
    public function store(Request $request)
    {
        //Valdidatin data from request
        $post = $request->validate([
            'title' => 'required|min:10',
            'description' => 'required',

        ]);
        //Storing  the decoded cover image to storage
        $cover_image_url = $this->storeBase64File($request->input('cover_image'), 'posts/cover_images');

        //Modifying the post request data
        $post['cover_image'] = $cover_image_url;
        $post['user_id'] = Auth::user()->id;

        //Creating the post
        Post::create($post);

        return response()->json(['message' => 'Post created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return response()->json([$post], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            //Valdidatin data from request
            $post = $request->validate([
                'title' => 'required|min:10',
                'description' => 'required',

            ]);

            $post = Post::findOrFail($id);

            //Modify the post if exist
            $post->title = $post['title'];
            $post->description = $post['description'];

            //Ensure if the request contains cover image
            if ($request->has('cover_image')) {
                //Delete the covet image if exists
                $this->deleteFileFromStorage($post->cover_image);
                //decoding cover image from request
                $cover_image_string = base64_decode($request->input('cover_image'));
                //Storing  the decoded cover image to storage
                $cover_image_url = $this->storeBase64File($cover_image_string, 'posts/cover_images');
                $post->cover_image = $cover_image_url;
            }
            $post->save();

            return response()->json(['message' => 'Post updated successfully'], 200);
        }
        catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in PostController.update'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
