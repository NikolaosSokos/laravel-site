<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Required BladewindUI CSS -->
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />

    <!-- Alpine.js (Needed for Datepicker, Optional) -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 p-10">

    <h1 class="text-2xl font-bold mb-4">BladewindUI Webview Tabs</h1>

    <x-bladewind::tab-group name="webview-tabs">

        <x-slot:headings>
            <x-bladewind::tab-heading name="solution-details" label="Solution Details" active="true" />
            <x-bladewind::tab-heading name="moment-tensors" label="Moment Tensors" />
            <x-bladewind::tab-heading name="shakemaps" label="Shakemaps" />
        </x-slot:headings>

        <x-bladewind::tab-body>

            <!-- Solution Details Tab -->
            <x-bladewind::tab-content name="solution-details" active="true">
                <iframe src="https://bbnet.gein.noa.gr/Events/2025/02/noa2025dkccq_info.html"
                        width="100%" height="600px" style="border:none;">
                    Your browser does not support iframes.
                </iframe>
            </x-bladewind::tab-content>

            <!-- Moment Tensors Tab -->
            <x-bladewind::tab-content name="moment-tensors">
                <iframe src="https://orfeus.gein.noa.gr/gisola/realtime/2025/noa2025cwqrj/2025-02-10T20:22:04.056471Z/output/index.html"
                        width="100%" height="600px" style="border:none;">
                    Your browser does not support iframes.
                </iframe>
            </x-bladewind::tab-content>

            <!-- Shakemaps Tab -->
            <x-bladewind::tab-content name="shakemaps">
                <iframe src="https://accelnet.gein.noa.gr/noa_sites/noa.shakemaps.gr/public/index/167283"
                        width="100%" height="600px" style="border:none;">
                    Your browser does not support iframes.
                </iframe>
            </x-bladewind::tab-content>

        </x-bladewind::tab-body>

    </x-bladewind::tab-group>

    <!-- Required BladewindUI JavaScript -->
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>

</body>
</html>
