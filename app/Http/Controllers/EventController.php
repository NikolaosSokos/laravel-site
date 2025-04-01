<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\EventHelper;

class EventController extends Controller
{
    public function show($event_id)
    {
        // Step 1: Get event time from FDSN event service
        $event_time_year = '2025'; // fallback
        $event_time = null;
        $month = '01'; // fallback

        $fdsn_response = Http::get("https://eida2.gein.noa.gr/fdsnws/event/1/query", [
            'eventid' => $event_id,
            'format' => 'text',
            'nodata' => 404
        ]);

        if ($fdsn_response->successful()) {
            $lines = explode("\n", trim($fdsn_response->body()));
            if (count($lines) >= 2) {
                $data_line = $lines[1]; // second line is the actual data
                $columns = explode('|', $data_line);
                if (isset($columns[1])) {
                    $event_time = trim($columns[1]); // ISO timestamp
                    $event_time_year = date('Y', strtotime($event_time));
                    $month = date('m', strtotime($event_time));
                }
            }
        }

        // Step 2: Get the latest folder name for Moment Tensors
        $latest_date = EventHelper::getLatestEventDate($event_id);

        // Step 3: Build Moment Tensors URL using latest_date and event year
        $moment_tensors_url = $latest_date 
            ? "https://orfeus.gein.noa.gr/gisola/realtime/{$event_time_year}/$event_id/$latest_date/output/index.html"
            : null;

        // Step 4: Build BBNet URL using year/month from event time
        $bbnet_url = "https://bbnet.gein.noa.gr/Events/{$event_time_year}/{$month}/{$event_id}_info.html";

        // Step 5: Fetch quake_id using API
        $quake_id = null;
        $response = Http::get("https://accelnet.gein.noa.gr/temp13434/connect.php", [
            'id' => $event_id
        ]);

        if ($response->successful()) {
            $quake_id = trim($response->body());
        }

        // Step 6: Pass everything to the Blade view
        return view('tabs', [
            'event_id' => $event_id,
            'event_time' => $event_time,
            'moment_tensors_url' => $moment_tensors_url,
            'bbnet_url' => $bbnet_url,
            'quake_id' => $quake_id,
        ]);
    }
}
