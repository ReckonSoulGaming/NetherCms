<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use MinecraftServerStatus\MinecraftServerStatus;
use Thedudeguy\Rcon;

use App\Packages;
use App\PackageCategory;
use App\User;
use App\Role;
use App\GeneralSettings;
use App\Logs;
use App\Alert;
use App\PaymentTransaction;
use App\ServerSettings;
use App\PackageClaims;

use MinecraftPing;
use xPaw\MinecraftPingException;
use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;
use xPaw\SourceQuery\SourceQuery;

use App\ExternalClasses\WebSenderAPI;

use Auth;
use Exception;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /* ===============================================================
     * Core Helpers
     * =============================================================== */

    public function getLoggedinUser()
    {
        return Auth::user();
    }

    public function getSettings()
    {
        return GeneralSettings::find(1);
    }

    /* ===============================================================
     * Minecraft Server Query
     * =============================================================== */

    public function getServerInfo()
    {
        $query = new MinecraftQuery();

        try {
            $query->Connect(
                $this->getSettings()->hostname,
                $this->getSettings()->hostname_port
            );

            return $query;
        } catch (MinecraftQueryException $e) {
            return null;
        }
    }

    public function testServerConnection($serverId)
    {
        $server = ServerSettings::findOrFail($serverId);
        $query  = new MinecraftQuery();

        try {
            $query->Connect($server->hostname, $server->hostname_port);
            return response()->json(true);
        } catch (MinecraftQueryException $e) {
            return response()->json(false);
        }
    }

    /* ===============================================================
     * Server Console (Primary & Fallback WebSender)
     * =============================================================== */

    public function sendCommandbata($cmd)
    {
        $player   = Auth::user()->name;
        $commands = explode(';', $cmd);

        $rcon = new SourceQuery();

        try {
            $rcon->Connect(
                $this->getSettings()->hostname,
                $this->getSettings()->rcon_port,
                10,
                SourceQuery::SOURCE
            );

            $rcon->SetRconPassword($this->getSettings()->rcon_password);

            foreach ($commands as $command) {
                $rcon->Rcon(str_replace('%player', $player, $command));
            }

            return true;

        } catch (Exception $e) {

            $wsr = new WebSenderAPI(
                $this->getSettings()->hostname,
                $this->getSettings()->websender_password,
                $this->getSettings()->websender_port
            );

            if ($wsr->connect()) {
                foreach ($commands as $command) {
                    $wsr->sendCommand(str_replace('%player', $player, $command));
                }
                $wsr->disconnect();
                return true;
            }

            return false;

        } finally {
            $rcon->Disconnect();
        }
    }

    public function sendCommand($cmd)
    {
        $player   = Auth::user()->name;
        $commands = explode(';', $cmd);

        $rcon = new Rcon(
            $this->getSettings()->hostname,
            $this->getSettings()->rcon_port,
            $this->getSettings()->rcon_password,
            3
        );

        try {
            if ($rcon->connect()) {
                foreach ($commands as $command) {
                    $rcon->sendCommand(str_replace('%player', $player, $command));
                }
                return true;
            }

            return false;

        } catch (Exception $e) {

            $wsr = new WebSenderAPI(
                $this->getSettings()->hostname,
                $this->getSettings()->websender_password,
                $this->getSettings()->websender_port
            );

            if ($wsr->connect()) {
                foreach ($commands as $command) {
                    $wsr->sendCommand(str_replace('%player', $player, $command));
                }
                $wsr->disconnect();
                return true;
            }

            return false;
        }
    }



    /* ===============================================================
     * Package / Category / Payment / User Fetchers
     * =============================================================== */

    public function getAllPackage()
    {
        return Packages::all();
    }

    public function getDiscountPackage()
    {
        return Packages::whereNotNull('package_discount_price')->get();
    }

    public function getAllUsers()
    {
        return User::all();
    }

    public function getLastestAddPackage()
    {
        return Packages::orderBy('created_at', 'desc')->take(4)->get();
    }

    public function getBestSellerPackage()
    {
        return Packages::orderBy('package_sold', 'desc')->take(4)->get();
    }

    public function getAllCategory()
    {
        return PackageCategory::all();
    }

    public function getAllPaymentTransactions()
    {
        return PaymentTransaction::all();
    }

    public function getPackage($packageid)
    {
        return Packages::where('package_id', $packageid)->first();
    }

    public function getUser($id)
    {
        return User::where('id', $id)->first();
    }

    public function getUserByName($username)
    {
        return User::where('name', $username)->first();
    }

    public function getAllRoles()
    {
        return Role::all();
    }

    /* ===============================================================
     * Logging
     * =============================================================== */

    public function addLog($buyer, $type, $msg)
    {
        Logs::create([
            'user_id'       => $buyer,
            'type'          => $type,
            'action_detail' => $msg,
        ]);
    }

    public function addLogAsUser($type, $msg)
    {
        Logs::create([
            'user_id'       => $this->getLoggedinUser()->id,
            'type'          => $type,
            'action_detail' => $msg,
        ]);
    }

    /* ===============================================================
     * Alerts
     * =============================================================== */

    public function getAllAlerts()
    {
        return Alert::all();
    }

    public function getOnlyStoreAlerts()
    {
        return Alert::orderBy('created_at', 'desc')
            ->where('alert_show_on_store', 1)
            ->take(3)
            ->get();
    }

    public function getAlert($id)
    {
        return Alert::find($id);
    }
}
