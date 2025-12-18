<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\ServerSettings;

class ServerSettingsController extends AdminController
{
    public function index()
    {
        $servers = ServerSettings::all();

        return view('manage.admin.server.index', [
            'servers' => $servers,
        ]);
    }

    public function create()
    {
        return view('manage.admin.server.addserver');
    }

    public function store(Request $request)
    {
        $server = new ServerSettings;

        $server->server_name          = $request->server_name;
        $server->hostname             = $request->hostname;
        $server->hostname_port        = $request->hostname_port;
        $server->hostname_query_port  = $request->hostname_query_port;
        $server->rcon_port            = $request->rcon_port;
        $server->rcon_password        = $request->rcon_password;
        $server->websender_port       = $request->websender_port;
        $server->websender_password   = $request->websender_password;

        $server->save();

        return redirect()->route('server.index');
    }

    public function edit($id)
    {
        return view('manage.admin.server.editserver', [
            'server' => ServerSettings::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $server = ServerSettings::findOrFail($id);

        $server->update([
            'server_name'          => $request->server_name,
            'hostname'             => $request->hostname,
            'hostname_port'        => $request->hostname_port,
            'hostname_query_port'  => $request->hostname_query_port,
            'rcon_port'            => $request->rcon_port,
            'rcon_password'        => $request->rcon_password,
            'websender_port'       => $request->websender_port,
            'websender_password'   => $request->websender_password,
        ]);

        return redirect()->route('server.index');
    }

    public function destroy($id)
    {
        ServerSettings::findOrFail($id)->delete();

        return redirect()->route('server.index');
    }

    public function doDelete(Request $request)
    {
        ServerSettings::findOrFail($request->id)->delete();

        return redirect()->route('server.index');
    }

    public function doUpdate(Request $request)
    {
        $server = ServerSettings::findOrFail($request->id);

        $server->update([
            'server_name'          => $request->server_name,
            'hostname'             => $request->hostname,
            'hostname_port'        => $request->hostname_port,
            'hostname_query_port'  => $request->hostname_query_port,
            'rcon_port'            => $request->rcon_port,
            'rcon_password'        => $request->rcon_password,
            'websender_port'       => $request->websender_port,
            'websender_password'   => $request->websender_password,
        ]);

        return redirect()->route('server.index');
    }
}
