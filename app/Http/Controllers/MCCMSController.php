<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MCCMSController extends Controller
{
    public function add(Request $r)
    {
        $server = $r->attributes->get('server');

        if (!$r->player || !$r->command) {
            return response()->json(['error' => 'missing_parameters']);
        }

        DB::table('command_queue')->insert([
            'server_id'   => $server->server_id,
            'player'      => $r->player,
            'command'     => $r->command,
            'status'      => 'pending',
            'created_at'  => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function pending(Request $r)
    {
        $server = $r->attributes->get('server');

        $rows = DB::table('command_queue')
            ->where('server_id', $server->server_id)
            ->where('status', 'pending')
            ->orderBy('id', 'ASC')
            ->get();

        return response()->json($rows);
    }

    public function done(Request $r)
    {
        $server = $r->attributes->get('server');

        if (!$r->id) {
            return response()->json(['error' => 'missing_id']);
        }

        DB::table('command_queue')
            ->where('id', $r->id)
            ->where('server_id', $server->server_id)
            ->update([
                'status' => 'done'
            ]);

        return response()->json(['success' => true]);
    }
public function run(Request $r)
{
    $server = $r->server;

    if (!$r->command) {
        return response()->json(['error' => 'missing_command']);
    }

    // SEND command to plugin instantly
    return response()->json([
        'success' => true,
        'execute' => $this->sendToPlugin($server, $r->command)
    ]);
}

private function sendToPlugin($server, $command)
{
    $url = env('APP_URL') . "/api/mccms/direct";
}

    public function log(Request $r)
    {
        $server = $r->attributes->get('server');

        if (!$r->player || !$r->command || !$r->status) {
            return response()->json(['error' => 'missing_parameters']);
        }

        DB::table('command_logs')->insert([
            'server_id'  => $server->server_id,
            'player'     => $r->player,
            'command'    => $r->command,
            'status'     => $r->status,
            'reason'     => $r->reason ?? '',
            'created_at' => now()
        ]);

        return response()->json(['success' => true]);
    }
}
