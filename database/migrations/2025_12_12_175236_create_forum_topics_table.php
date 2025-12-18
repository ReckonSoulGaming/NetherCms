<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forum_topics', function (Blueprint $table) {
            $table->bigIncrements('topic_id');
            $table->unsignedBigInteger('topic_author_id')->index('forum_topics_topic_author_id_foreign');
            $table->unsignedBigInteger('topic_category_id')->index('forum_topics_topic_category_id_foreign');
            $table->longText('topic_title');
            $table->longText('topic_content');
            $table->integer('topic_views');
            $table->boolean('topic_is_published');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_topics');
    }
};
