<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('users', function (Blueprint $table) {

        // Remove old Minecraft fields
        $table->dropColumn([
            'x', 'y', 'z', 'world',
            'regdate', 'regip',
            'yaw', 'pitch',
            'hasSession', 'totp'
        ]);

        // Modify column types
        $table->timestamp('lastlogin')->nullable()->change();
        $table->tinyInteger('isLogged')->default(0)->change();

        // Add player_type if missing
        if (!Schema::hasColumn('users', 'player_type')) {
            $table->enum('player_type', ['java', 'bedrock'])
                ->default('java')
                ->after('isLogged');
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
