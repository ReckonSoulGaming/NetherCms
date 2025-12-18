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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique('name');
            $table->string('rolename')->default('Player');
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('role_id')->default(2)->index('users_role_id_foreign');
            $table->string('profile_image_path')->nullable();
            $table->string('ip', 40)->nullable();
            $table->bigInteger('lastlogin')->nullable();
            $table->double('x')->default(0);
            $table->double('y')->default(0);
            $table->double('z')->default(0);
            $table->string('world')->default('world');
            $table->bigInteger('regdate')->default(0);
            $table->string('regip', 40)->nullable();
            $table->double('yaw')->nullable();
            $table->double('pitch')->nullable();
            $table->smallInteger('isLogged')->default(0);
            $table->smallInteger('hasSession')->default(0);
            $table->string('totp', 16)->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
