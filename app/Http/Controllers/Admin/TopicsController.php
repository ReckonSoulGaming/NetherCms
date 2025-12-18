<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\ForumTopic;

class TopicsController extends AdminController
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        $user = $this->getLoggedinUser();

        return view('manage.user.topic.index', [
            'topics'         => $this->getTopicsPostedByUser($user->id),
            'deletedtopics'  => ForumTopic::onlyTrashed()->get(),
           
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $topic = ForumTopic::find($id);
        $topic->delete();

        return redirect()->route('topicmanager.index');
    }

    public function forcedelete($id)
    {
        $topic = ForumTopic::onlyTrashed()->find($id);
        $topic->forceDelete();

        return redirect()->route('topicmanager.index');
    }

    public function restore($id)
    {
        $topic = ForumTopic::onlyTrashed()->find($id);
        $topic->restore();

        return redirect()->route('topicmanager.index');
    }

    public function getCommentOnTopic($id)
    {
        $topic = ForumTopic::find($id);

        return $topic->comment; 

        return view('forum.read', [
            'topics' => $topic,
        ]);
    }

    public function getTopic($id)
    {
        return ForumTopic::find($id);
    }

    public function getAllTopics()
    {
        return ForumTopic::all();
    }

    public function getTopicsPostedByUser($userid)
    {
        return ForumTopic::where('topic_author_id', $userid)->get();
    }

    public function getTopicTopFiveMostView()
    {
        return ForumTopic::orderBy('topic_views', 'desc')
            ->take(5)
            ->get();
    }
}
