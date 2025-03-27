<?php
use Illuminate\Support\Facades\Route;
use App\Helpers\EventHelper;

Route::get('/tabs/{event_id}', function ($event_id) {
    $latest_date = EventHelper::getLatestEventDate($event_id);

    if ($latest_date) {
        $moment_tensors_url = "https://orfeus.gein.noa.gr/gisola/realtime/2025/$event_id/$latest_date/output/index.html";
    } else {
        $moment_tensors_url = null;
    }
    // Construct BBNet Event Info URL dynamically
    $bbnet_url = "https://bbnet.gein.noa.gr/Events/2025/02/{$event_id}_info.html";
    return view('tabs', [
        'event_id' => $event_id,
        'moment_tensors_url' => $moment_tensors_url,
        'bbnet_url' => $bbnet_url
    ]);
});
