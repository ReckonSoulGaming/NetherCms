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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->bigIncrements('setting_id');
            $table->string('hostname');
            $table->integer('hostname_port');
            $table->integer('rcon_port');
            $table->string('rcon_password')->nullable();
            $table->integer('websender_port');
            $table->string('websender_password');
            $table->string('website_name');
            $table->string('website_desc')->nullable();
            $table->string('site_tagline')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('homepage_highlight')->nullable();
            $table->string('navbar_color')->nullable();
            $table->string('background_image')->nullable();
            $table->string('background_color')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('nav_text_color')->nullable();
            $table->longText('custom_css')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
