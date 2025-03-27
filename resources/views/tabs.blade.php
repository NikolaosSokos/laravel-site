<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BladewindUI Webview Tabs</title>

    <!-- Required BladewindUI CSS -->
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />

    <!-- Alpine.js (Needed for Datepicker, Optional) -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        /* Make sure the iframe fills the screen */
        .full-screen-iframe {
            width: 100vw;
            height: 100vh;
            border: none;
        }
    </style>
</head>
<body class="bg-gray-100">

    <h1 class="text-2xl font-bold text-center p-4">Event: {{ $event_id }}</h1>

    <x-bladewind::tab-group name="webview-tabs">

        <x-slot:headings>
            <x-bladewind::tab-heading name="solution-details" label="Solution Details" active="true" />
            <x-bladewind::tab-heading name="moment-tensors" label="Moment Tensors" />
            <x-bladewind::tab-heading name="shakemaps" label="Shakemaps" />
            <x-bladewind::tab-heading name="bbnet" label="BBNet Info" />
        </x-slot:headings>

        <x-bladewind::tab-body>

            <!-- Solution Details Tab -->
            <x-bladewind::tab-content name="solution-details" active="true">
                <iframe src="https://eida2.gein.noa.gr/fdsnws/event/1/query?eventid={{ $event_id }}&format=text&nodata=404"
                        class="full-screen-iframe">
                    Your browser does not support iframes.
                </iframe>
            </x-bladewind::tab-content>

            <!-- Moment Tensors Tab -->
            <x-bladewind::tab-content name="moment-tensors">
                @if($moment_tensors_url)
                    <iframe src="{{ $moment_tensors_url }}" class="full-screen-iframe">
                        Your browser does not support iframes.
                    </iframe>
                @else
                    <p class="text-red-500 text-center">No data available for this event.</p>
                @endif
            </x-bladewind::tab-content>

            <!-- Shakemaps Tab -->
            <x-bladewind::tab-content name="shakemaps">
                <iframe src="https://accelnet.gein.noa.gr/noa_sites/noa.shakemaps.gr/public/index/167283"
                        class="full-screen-iframe">
                    Your browser does not support iframes.
                </iframe>
            </x-bladewind::tab-content>

            <!-- BBNet Event Info Tab -->
            <x-bladewind::tab-content name="bbnet">
                <iframe src="{{ $bbnet_url }}" class="full-screen-iframe">
                    Your browser does not support iframes.
                </iframe>
            </x-bladewind::tab-content>

        </x-bladewind::tab-body>

    </x-bladewind::tab-group>

    <!-- Required BladewindUI JavaScript -->
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>

</body>
</html>
