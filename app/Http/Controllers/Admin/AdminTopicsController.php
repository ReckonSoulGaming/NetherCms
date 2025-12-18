<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\ForumTopic;

class AdminTopicsController extends AdminController
{
    public function __construct()
    {
        $this->middleware(['auth', 'adminonly']);
    }

    public function index()
    {
        // ADMIN: show ALL topics
        $topics = ForumTopic::with('comments')
            ->whereNull('deleted_at')
            ->get();

        // Deleted topics (trash)
        $deletedtopics = ForumTopic::onlyTrashed()
            ->with('comments')
            ->get();

        return view('manage.admin.topic.index', [
            'topics'        => $topics,
            'deletedtopics' => $deletedtopics,
        ]);
    }

    public function destroy($id)
    {
        $topic = ForumTopic::findOrFail($id);
        $topic->delete();

        return redirect()->route('admin.topic.index');
    }

    public function restore($id)
    {
        $topic = ForumTopic::onlyTrashed()->findOrFail($id);
        $topic->restore();

        return redirect()->route('admin.topic.index');
    }

    public function forcedelete($id)
    {
        $topic = ForumTopic::onlyTrashed()->findOrFail($id);
        $topic->forceDelete();

        return redirect()->route('admin.topic.index');
    }
}
