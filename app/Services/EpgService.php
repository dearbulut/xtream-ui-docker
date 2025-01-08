<?php

namespace App\Services;

use App\Models\Channel;
use App\Models\EpgProgram;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class EpgService
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function refreshData()
    {
        $epgUrl = $this->settingService->get("epg_url");
        if (!$epgUrl) {
            return;
        }

        try {
            $response = Http::get($epgUrl);
            if (!$response->successful()) {
                throw new \Exception("Failed to fetch EPG data: " . $response->status());
            }

            $xml = new SimpleXMLElement($response->body());
            $this->processEpgData($xml);
        } catch (\Exception $e) {
            Log::error("EPG refresh failed: " . $e->getMessage());
            throw $e;
        }
    }

    protected function processEpgData(SimpleXMLElement $xml)
    {
        // Önce tüm programları temizle
        EpgProgram::truncate();

        // Kanal eşleştirmelerini al
        $channels = Channel::whereNotNull("epg_channel_id")->pluck("id", "epg_channel_id");

        foreach ($xml->programme as $programme) {
            $channelId = (string) $programme["channel"];
            if (!isset($channels[$channelId])) {
                continue;
            }

            $startTime = $this->parseXmlTime((string) $programme["start"]);
            $endTime = $this->parseXmlTime((string) $programme["stop"]);

            EpgProgram::create([
                "channel_id" => $channels[$channelId],
                "title" => (string) $programme->title,
                "description" => (string) $programme->desc,
                "start_time" => $startTime,
                "end_time" => $endTime,
                "category" => (string) $programme->category,
                "language" => (string) $programme->language,
            ]);
        }
    }

    protected function parseXmlTime($time)
    {
        // XMLTV zamanı: 20240105123000 +0000 formatında
        $date = substr($time, 0, 14);
        $tz = substr($time, 15);

        return \Carbon\Carbon::createFromFormat("YmdHis", $date, $tz)
            ->setTimezone(config("app.timezone"));
    }

    public function getChannels()
    {
        $epgUrl = $this->settingService->get("epg_url");
        if (!$epgUrl) {
            return [];
        }

        try {
            $response = Http::get($epgUrl);
            if (!$response->successful()) {
                throw new \Exception("Failed to fetch EPG data: " . $response->status());
            }

            $xml = new SimpleXMLElement($response->body());
            $channels = [];

            foreach ($xml->channel as $channel) {
                $id = (string) $channel["id"];
                $name = (string) $channel->{"display-name"};
                $icon = (string) $channel->icon["src"];

                $channels[] = [
                    "id" => $id,
                    "name" => $name,
                    "icon" => $icon,
                ];
            }

            return $channels;
        } catch (\Exception $e) {
            Log::error("EPG channel list fetch failed: " . $e->getMessage());
            return [];
        }
    }
}
