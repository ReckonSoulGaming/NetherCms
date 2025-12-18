<?php

namespace App\Http\Controllers\Forum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ForumTopic;
use App\ForumCategory;

class ForumController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::all();

        return view('forum.index', [
            'topics'     => $this->getAllTopics(),
            'mostviews'  => $this->getTopicTopMostView(),
            'categories' => $categories,
            'lastest'    => $this->getLastestTopic(),
        ]);
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

    public function getTopicTopMostView()
    {
        return ForumTopic::orderBy('topic_views', 'desc')
            ->take(15)
            ->get();
    }

    public function getLastestTopic()
    {
        return ForumTopic::orderBy('created_at', 'desc')
            ->take(15)
            ->get();
    }
}
