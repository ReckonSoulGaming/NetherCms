<?php

namespace App\Http\Controllers\Claim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Packages;
use App\PackageClaims;
use App\ServerSettings;
use App\Services\MinecraftService;
use Auth;

class PackageClaimsController extends Controller
{
    public function __construct()
    {
        $this->middleware('ClaimOwnerOnly', ['except' => ['index']]);
    }


    public function index()
    {
        $claims = PackageClaims::where([
            ['owner_id', Auth::user()->id],
            ['is_claimed', 0]
        ])->get();

        $claimed = PackageClaims::where([
            ['owner_id', Auth::user()->id],
            ['is_claimed', 1]
        ])->get();

        return view('manage.user.claim.index', [
            'claims'  => $claims,
            'claimed' => $claimed,
        ]);
    }

    public function getClaimDetail($id)
    {
        return PackageClaims::findOrFail($id);
    }

    public function getPackage($id)
    {
        return Packages::findOrFail($id);
    }

    public function getServer()
    {
        return ServerSettings::whereNotNull('websender_port')->first();
    }


    public function sendMinecraftCommand($command, $serverId)
    {
        $username = Auth::user()->username ?? Auth::user()->name;

       
        $command = str_replace(
            ['{player}', '{username}'],
            $username,
            $command
        );

        try {
            $mc = new MinecraftService($serverId);
            return $mc->run($command);
        } catch (\Exception $e) {
            return null;
        }
    }

 
 public function store(Request $request)
{
    $claim   = $this->getClaimDetail($request->input('id'));
    $package = $this->getPackage($claim->package_id);

    $server = $this->getServer();

    if (!$server) {
        session()->flash('somethingError');
        return redirect()->back();
    }

    // Which username to send?
    $username = Auth::user()->username ?? Auth::user()->name;

    // Split package commands
    $commands = preg_split("/\r\n|\n|\r/", $package->package_command);

    foreach ($commands as $cmd) {

        $cmd = trim($cmd);
        if ($cmd === '') continue;

        // Replace variables
        $cmd = str_replace(
            ['{player}', '{username}'],
            $username,
            $cmd
        );

        // Insert into MCCMS queue
        \DB::table('command_queue')->insert([
            'server_id'   => $server->server_id,   // NEW
            'player'      => $username,
            'command'     => $cmd,
             'type'        => 'claim', 
            'status'      => 'pending',
            'created_at'  => now()
        ]);
    }

    // Mark package as claimed immediately
    // (Plugin logs execution separately)
    $claim->update(['is_claimed' => 1]);

    $this->addLogAsUser(
        'CLAIM:QUEUED',
        'Your package "' . $package->package_name . '" was added to the delivery queue.'
    );

    session()->flash('claimGetPackage');

    return redirect()->back();
}

}
