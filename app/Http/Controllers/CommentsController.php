<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use App\Models\Post;
use Validator;
class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return Comments::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'comments' => 'required|max:1000',
            'post_id'=> 'required|integer'
        ]);

        if($validate->fails()) {
            return $validate->errors();
        } 
        

        $post = Post::find($request->post_id);
        $comment = new Comments([
            'comments'=> $request->comments,
            'post_id'=>$request->post_id
        ]);
        return $post->comments()->save($comment);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function show($comment)
    {
        return Comments::find($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $comments)
    {

        $comments = Comments::find($comments);
        $comments->update([
            'comments'=>$request->comments
        ]);
        return $comments;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function destroy($comments)
    {
        $comments = Comments::find($comments);
        $comments->delete();
        return response()->json(["deleted"=> $comments]);
    }
}
