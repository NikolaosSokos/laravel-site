<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class EventHelper
{
    public static function getLatestEventDate($event_id)
    {
        $baseUrl = "https://orfeus.gein.noa.gr/gisola/realtime/2025/$event_id/";
        
        // Fetch the directory listing
        $response = Http::get($baseUrl);

        if (!$response->successful()) {
            return null; // Return null if request fails
        }

        // Extract dates using regex (format: YYYY-MM-DDTHH:MM:SS.ssssssZ)
        preg_match_all('/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.\d+Z/', $response->body(), $matches);

        if (empty($matches[0])) {
            return null; // No dates found
        }

        // Sort timestamps in descending order to get the latest one
        rsort($matches[0]);

        return $matches[0][0]; // Return latest timestamp
    }
}
