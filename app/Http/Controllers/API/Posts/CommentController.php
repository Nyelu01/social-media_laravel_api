<?php

namespace App\Http\Controllers\API\Posts;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Comment::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comments._create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'comment' => 'string',
            'client_id' => 'exists:users,id',
            'post_id' => 'exists:posts,id'
        ]);

        Comment::create($data);
        return response()->json(['message' => 'Comment created successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
