<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\MinecraftService;
use App\ServerSettings;
use Auth;

class ServerConsoleController extends AdminController
{
    
    public function index()
    {
        return view('manage.admin.serverconsole', [
            'settings' => $this->getSettings(),
        ]);
    }


public function store(Request $request)
{
    $request->validate([
        'command' => 'required|string',
        'run_as'  => 'required|in:console,player'
    ]);

    $admin = Auth::user()->username ?? Auth::user()->name;

    // Select server
    $server = ServerSettings::where('server_id', 1)->first();

    if (!$server) {
        return back()->with('command_error', 'No server configured.');
    }

    // Split commands by ;
    $commands = array_filter(array_map('trim', explode(';', $request->command)));

    foreach ($commands as $cmd) {

        if ($request->run_as === "player") {
            // Replace placeholder with admin name
            $cmdWithPlayer = str_replace('%player', $admin, $cmd);

            \DB::table('command_queue')->insert([
                'server_id'  => $server->server_id,
                'player'     => $admin,    // waits for admin
                'command'    => $cmdWithPlayer,
                'type'       => 'player',
                'status'     => 'pending',
                'created_at' => now(),
            ]);

        } else {
            // Console mode → no player required
            \DB::table('command_queue')->insert([
                'server_id'  => $server->server_id,
                'player'     => 'CONSOLE',
                'command'    => $cmd,
                'type'       => 'console',
                'status'     => 'pending',
                'created_at' => now(),
            ]);
        }
    }

    return back()->with('command_result', "Commands queued successfully!");
}





}
