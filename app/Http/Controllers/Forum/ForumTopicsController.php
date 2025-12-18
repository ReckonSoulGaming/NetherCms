<?php

namespace App\Http\Controllers\Forum;

use Illuminate\Http\Request;
use App\Http\Requests\ForumPostRequest;
use App\ForumTopic;
use App\ForumComment;
use App\ForumCategory;

class ForumTopicsController extends ForumController
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);

        
        $this->middleware('PostOwnerOnly', [
            'except' => ['create', 'store', 'show', 'addcomment'] 
        ]);
    }

    public function index()
    {
        //
    }

    public function create()
    {
        $categories = ForumCategory::all();

        return view('forum.newpost', [
            'categories' => $categories,
        ]);
    }

    public function store(ForumPostRequest $request)
    {
        $topic = new ForumTopic;

        $topic->topic_title       = $request->topic;
        $topic->topic_content     = $request->content;
        $topic->topic_category_id = $request->category;

        $topic->topic_author_id   = $this->getLoggedinUser()->id;
        $topic->topic_views       = 0;

        $topic->topic_is_published = empty($request->is_published) ? 1 : 0;

        $topic->save();

        return redirect()->route('topic.show', [$topic->topic_id]);
    }

    public function show($id)
    {
        $topic = ForumTopic::find($id);

        $topic->update([
            'topic_views' => $topic->topic_views + 1,
        ]);

        return view('forum.read', [
            'topic' => $this->getTopic($id),
        ]);
    }

    public function edit($id)
    {
        $categories = ForumCategory::all();

        return view('forum.editpost', [
            'categories' => $categories,
            'topic'      => $this->getTopic($id),
        ]);
    }

    public function update(ForumPostRequest $request, $id)
    {
        $topic = ForumTopic::find($id);

        $topic->topic_title       = $request->topic;
        $topic->topic_content     = $request->content;
        $topic->topic_category_id = $request->category;

        $topic->topic_author_id   = $this->getLoggedinUser()->id;
        $topic->topic_views       = 0;

        $topic->topic_is_published = empty($request->is_published) ? 1 : 0;

        $topic->save();

        return redirect()->route('topic.show', [$topic->topic_id]);
    }

    public function destroy($id)
    {
        $topic = ForumTopic::find($id);
        $topic->delete();

        return redirect()->route('forum.main');
    }
}
