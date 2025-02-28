<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        // Get all posts
        $posts = Post::latest()->paginate(5);

        // Return collection of post as a resource
        return new PostResource(true, 'List data post', $posts);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'content' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Error validation
            return response()->json($validator->errors(), 422);
        }

        // Upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());
        /* File gambar yang diupload akan dimasukan ke dalam folder "storage", yang berada di dalam "storage/app/public/posts" */

        // Create post
        $post = Post::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return new PostResource(true, 'Data post berhasil ditambahkan.', $post);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        // Find post by ID
        $post = Post::find($id);

        // Return single post as a resource
        return new PostResource(true, 'Detail data post.', $post);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Error validation
            return response()->json($validator->errors(), 422);
        }

        // Find post by ID
        $post = Post::find($id);

        if ($request->hasFile('image')) {
            // Upload image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            // Delete old image
            Storage::delete('public/posts/'.basename($post->image));

            // Update post with new image
            $post->update([
                'image' => $image->hashName(),
                'title' => $request->title,
                'content' => $request->content,
            ]);

        } else {
            // Update post without image
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }
        
        return new PostResource(true, 'Data post berhasil diubah.', $post);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        // Find post by ID
        $post = Post::find($id);

        // Delete image
        Storage::delete('public/posts/'.basename($post->image));

        // Delete post
        $post->delete();
        
        return new PostResource(true, 'Data post berhasil dihapus.', null);
    }
}
