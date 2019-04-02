<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Comment;
use Illuminate\Http\Request;
use Validator;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->with([
            'user',
            'comments',
            'likes'
        ])->paginate(5);

        return view('announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:2|max:255',
            'content' => 'required|min:2|max:500'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $announcement = Announcement::create([
            'user_id' => $request->user()->id,
            'title' => $request->get('title'),
            'content' => $request->get('content')
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function edit()
    {

    }

    public function update(Request $request)
    {
        
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        
        return redirect()->back();
    }

    public function comment(Announcement $announcement)
    {
        $validator = Validator::make(request()->all(), [
            'comment' => 'required|min:2|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $announcement->comments()->create([
            'user_id' => request()->user()->id,
            'body' => request()->get('comment'),
            'commentable_type' => get_class($announcement),
            'commentable_id' => $announcement->id
        ]);

        return redirect()->back();
    }

    public function like(Announcement $announcement)
    {
        $like = $announcement->likes()->where('user_id', request()->user()->id)->first();

        if ($like) {
            $like->delete();
        } else {
            $announcement->likes()->create([
                'user_id' => request()->user()->id,
                'likeable_type' => get_class($announcement),
                'likeable_id' => $announcement->id
            ]);
        }

        return redirect()->back();
    }
}
