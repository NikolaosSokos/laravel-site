<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\EventHelper;

class EventController extends Controller
{
    public function show($event_id)
    {
        // Step 1: Get latest moment tensors date
        $latest_date = EventHelper::getLatestEventDate($event_id);

        $moment_tensors_url = $latest_date 
            ? "https://orfeus.gein.noa.gr/gisola/realtime/2025/$event_id/$latest_date/output/index.html"
            : null;

        // Step 2: Construct BBNet URL
        $bbnet_url = "https://bbnet.gein.noa.gr/Events/2025/02/{$event_id}_info.html";

        // Step 3: Fetch quake_id from database (placeholder query)
        // $quake_id = DB::table('quakes')
        //     ->where('eventId', $event_id)
        //     ->value('quakeId');
        $quake_id = 167283;
        // Step 4: Pass everything to Blade view
        return view('tabs', [
            'event_id' => $event_id,
            'moment_tensors_url' => $moment_tensors_url,
            'bbnet_url' => $bbnet_url,
            'quake_id' => $quake_id,
        ]);
    }
}
