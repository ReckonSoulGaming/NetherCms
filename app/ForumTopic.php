<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumTopic extends Model
{
    use SoftDeletes;

    protected $table = 'forum_topics';
    protected $primaryKey = 'topic_id';

    protected $fillable = [
        'topic_author_id',
        'topic_title',
        'topic_category_id',
        'topic_content',
        'topic_views',
    ];

    /**
     * A topic has many comments.
     */
 public function comments()
{
    return $this->hasMany(ForumComment::class, 'topic_id');
}



    /**
     * A topic belongs to a user (author).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'topic_author_id', 'id');
    }

    /**
     * A topic belongs to a category.
     */
    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'topic_category_id', 'forum_category_id');
    }
}
