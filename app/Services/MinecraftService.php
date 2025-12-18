<?php

namespace App\Services;

use App\ServerSettings;
use App\Services\WebsenderAPI;

class MinecraftService
{
    protected $ws;
    protected $server;

    public function __construct($serverId)
    {
        $this->server = ServerSettings::findOrFail($serverId);

        $this->ws = new WebsenderAPI(
            $this->server->hostname,
            $this->server->websender_password,
            (int) $this->server->websender_port
        );

        if (!$this->ws->connect()) {
            throw new \Exception("WebSender connection failed.");
        }
    }

    public function run($command)
    {
        return $this->ws->sendCommand($command);
    }

    public function __destruct()
    {
        if ($this->ws) {
            $this->ws->disconnect();
        }
    }
}
