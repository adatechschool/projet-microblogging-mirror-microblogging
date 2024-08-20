<?php

namespace App\Http\Controllers;


use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Category;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with(['user', 'category'])->get();
        return view('your_view', compact('posts'));
    }

    public function store(StorePostRequest $request)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'image' => 'image|max:2048',
    ]);

    // Store the image and get the path
    $path = $request->file('image')->store('posts', 'public');

    // Create a new post using the validated data
    $post = Post::create([
        'title' => $validated['title'],
        'content' => $validated['content'],
        'category_id' => $validated['category_id'],
        'image' => $path,
        'user_id' => auth()->id(), // Associate the post with the currently authenticated user
    ]);

    // Redirect to the 'yourPage' route with a success message
    return redirect()->route('yourPage.view')->with('success', 'Your post has been created successfully.');
}


    public function create(){
        $categories = Category::all();
        return view('post.create', compact('categories'));
    }
    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        // If a new image is uploaded, store it and update the path
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated['image'] = $path;
        }

        // Update the post with the validated data
        $post->update($validated);

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(null, 204);
    }
}
