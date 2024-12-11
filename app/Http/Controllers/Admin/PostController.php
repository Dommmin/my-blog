<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct(private readonly FileService $fileService) {}

    public function index(Request $request)
    {
        return inertia('Admin/Post/Index', [
            'posts' => Post::getPaginatedPostsForAdmin($request),
            'filters' => [
                'search' => $request->input('search', ''),
                'sort' => $request->input('sort', 'created_at'),
                'direction' => $request->input('direction', 'desc'),
            ],
        ]);
    }

    public function create()
    {
        return inertia('Admin/Post/Create');
    }

    public function edit(Post $post)
    {
        return inertia('Admin/Post/Edit', [
            'post' => $post,
        ]);
    }

    public function store(PostStoreRequest $request)
    {
        $validated = $request->validated();
        $image = $request->file('image');

        $validated['image'] = $this->fileService->handleFileUpload($image);

        Post::create($validated + [
            'user_id' => auth()->id(),
        ]);

        return to_route('admin.posts.index')->with('success', 'Post created successfully');
    }

    public function update(Post $post, PostUpdateRequest $request)
    {
        $validated = $request->validated();

        if ($request->file('image')) {
            $image = $request->file('image');
            $validated['image'] = $this->fileService->handleFileUpload($image);
            Storage::disk('public')->delete($post->image);
        } else {
            unset($validated['image']);
        }

        $post->update($validated);

        if ($request->getMethod() === 'PUT') {
            return to_route('admin.posts.index')->with('success', 'Post updated successfully');
        }

        return back()->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        Storage::disk('public')->delete($post->image);

        return back()->with('success', 'Post deleted successfully');
    }
}
