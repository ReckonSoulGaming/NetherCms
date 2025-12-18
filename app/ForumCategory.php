<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    protected $table = 'forum_categories';
    protected $primaryKey = 'forum_category_id';

    protected $fillable = [
        'forum_category_name',
        'forum_category_description',
    ];

    /**
     * A forum category contains many topics.
     */
    public function topics()
    {
        return $this->hasMany(ForumTopic::class, 'topic_category_id', 'forum_category_id');
    }
}
