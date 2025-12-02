<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\EventHelper;

class EventController extends Controller
{
    public function show($event_id)
    {
        // -------------------------------
        // Step 1: Fetch FDSN Event Time
        // -------------------------------
        $event_time = null;
        $event_year = '2025';   // fallback
        $event_month = '01';    // fallback

        $fdsn_response = Http::withoutVerifying()->get(
            "https://eida.gein.noa.gr/fdsnws/event/1/query",
            [
                'eventid' => $event_id,
                'format'  => 'text',
                'nodata'  => 404
            ]
        );

        if ($fdsn_response->successful()) {
            $lines = explode("\n", trim($fdsn_response->body()));

            if (count($lines) >= 2) {
                $columns = explode('|', $lines[1]);

                if (isset($columns[1])) {
                    $event_time = trim($columns[1]);

                    $timestamp = strtotime($event_time);
                    if ($timestamp !== false) {
                        $event_year  = date('Y', $timestamp);
                        $event_month = date('m', $timestamp);
                    }
                }
            }
        }

        // -------------------------------
        // Step 2: Moment Tensor Folder
        // -------------------------------
        $latest_date = EventHelper::getLatestEventDate($event_id);

        $moment_tensors_url = $latest_date
            ? "https://orfeus.gein.noa.gr/gisola/realtime/{$event_year}/{$event_id}/{$latest_date}/output/index.html"
            : null;

        // -------------------------------
        // Step 3: BBNet Event Info Page
        // -------------------------------
        $bbnet_url =
            "https://bbnet.gein.noa.gr/Events/{$event_year}/{$event_month}/{$event_id}_info.html";

        // -------------------------------
        // Step 4: Download URLs
        // -------------------------------
        $ims_url =
            "https://bbnet2.gein.noa.gr/events/{$event_year}/{$event_month}/{$event_id}.alert";

        $quakeml_url =
            "https://eida.gein.noa.gr/fdsnws/event/1/query?eventid={$event_id}&nodata=404";

        // -------------------------------
        // Step 5: Fetch QuakeID (ShakeMap)
        // -------------------------------
        $quake_id = null;

        $quake_response = Http::withoutVerifying()->get(
            "https://accelnet.gein.noa.gr/temp13434/connect.php",
            ['id' => $event_id]
        );

        if ($quake_response->successful()) {
            $quake_id = trim($quake_response->body());
        }

        // -------------------------------
        // Step 6: Return to Blade View
        // -------------------------------
        return view('tabs', [
            'event_id'           => $event_id,
            'event_time'         => $event_time,
            'moment_tensors_url' => $moment_tensors_url,
            'bbnet_url'          => $bbnet_url,
            'quake_id'           => $quake_id,
            'ims_url'            => $ims_url,
            'quakeml_url'        => $quakeml_url,
        ]);
    }

    /**
     * Force QuakeML download as XML file
     */
    public function downloadQuakeML($event_id)
    {
        $url = "https://eida.gein.noa.gr/fdsnws/event/1/query?eventid={$event_id}&nodata=404";

        // Fetch XML (ignore SSL issues)
        $response = Http::withoutVerifying()->get($url);

        if (!$response->successful()) {
            abort(404, "Event not found or QuakeML unavailable.");
        }

        $xml = $response->body();

        return response($xml)
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename="' . $event_id . '.xml"');
    }

}
