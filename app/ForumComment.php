<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    protected $table = 'forum_comments';
    protected $primaryKey = 'comment_id';

    protected $fillable = [
        'comment_author_id',
        'comment_title',
        'comment_content',
        'topic_id',
    ];

  
  public function topic()
{
    return $this->belongsTo(ForumTopic::class, 'topic_id');
}

  
    public function author()
    {
        return $this->belongsTo(User::class, 'comment_author_id', 'id');
    }
}
