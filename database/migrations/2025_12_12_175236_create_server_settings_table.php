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
        Schema::create('server_settings', function (Blueprint $table) {
            $table->bigIncrements('server_id');
            $table->string('server_name');
            $table->string('hostname');
            $table->integer('hostname_port');
            $table->integer('hostname_query_port');
            $table->integer('rcon_port');
            $table->string('rcon_password')->nullable();
            $table->integer('websender_port');
            $table->string('websender_password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_settings');
    }
};
