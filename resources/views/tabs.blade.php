<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOA Event Solutions</title>

    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }
        .logo-img { height: 65px; }
        .seismo-img { height: 65px; }

        .event-title-block {
            text-align: center;
            margin: 20px 0 10px;
        }
        .event-title {
            font-size: 26px;
            font-weight: bold;
        }

        .full-screen-iframe {
            width: 100%;
            height: 85vh;
            border: none;
        }

        /* Loading overlay for Shakemap */
        .loading-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255,255,255,0.95);
            padding: 25px 40px;
            border-radius: 12px;
            text-align: center;
            z-index: 999;
            box-shadow: 0 4px 14px rgba(0,0,0,0.2);
        }

        /* DOWNLOAD DROPDOWN INSIDE DOWNLOAD TAB */
        .download-box {
            margin: 30px auto;
            max-width: 420px;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.12);
            text-align: center;
        }
        .download-link {
            display: block;
            margin: 10px 0;
            font-size: 17px;
            color: #1a202c;
            text-decoration: none;
            font-weight: bold;
        }
        .download-link:hover {
            color: #4a5568;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- ===================== -->
    <!-- HEADER (unchanged) -->
    <!-- ===================== -->
    <div class="header-container">
        <img src="{{ asset('vendor/bladewind/images/noalogo_gmap.png') }}" class="logo-img">

        <div class="event-title">
            Event: {{ $event_id }}
        </div>

        <img src="{{ asset('vendor/bladewind/images/seismo.png') }}" class="seismo-img">
    </div>

    @if($event_time)
    <div class="event-title-block">
        <p class="text-gray-600"><strong>Event Time:</strong> {{ $event_time }}</p>
    </div>
    @endif


    <!-- ===================== -->
    <!-- TABS -->
    <!-- ===================== -->
    <x-bladewind::tab-group name="webview-tabs">

        <x-slot:headings>
            <x-bladewind::tab-heading name="solution" label="Event Solution" active="true"/>
            <x-bladewind::tab-heading name="moment" label="Moment Tensor"/>
            <x-bladewind::tab-heading name="shakemap" label="ShakeMap"/>
            <x-bladewind::tab-heading name="bbnet" label="BBNet Info"/>
            <x-bladewind::tab-heading name="download" label="Download"/>
        </x-slot:headings>

        <x-bladewind::tab-body>

            <!-- EVENT SOLUTION -->
            <x-bladewind::tab-content name="solution" active="true">
                <iframe class="full-screen-iframe"
                        src="https://eida.gein.noa.gr/fdsnws/event/1/query?eventid={{ $event_id }}&format=text&nodata=404">
                </iframe>
            </x-bladewind::tab-content>


            <!-- MOMENT TENSOR -->
            <x-bladewind::tab-content name="moment">
                @if($moment_tensors_url)
                    <iframe class="full-screen-iframe" src="{{ $moment_tensors_url }}"></iframe>
                @else
                    <p class="text-center text-red-500 mt-4">No Moment Tensor available.</p>
                @endif
            </x-bladewind::tab-content>


            <!-- SHAKEMAP -->
            <x-bladewind::tab-content name="shakemap">
                @if($quake_id)

                    <div id="loading-shakemap" class="loading-overlay">
                        <img src="{{ asset('vendor/bladewind/images/Loading_icon.gif') }}" height="80"><br>
                        Loading ShakeMap...
                    </div>

                    <iframe id="shakemap-frame"
                            class="full-screen-iframe"
                            src="https://accelnet.gein.noa.gr/noa_sites/noa.shakemaps.gr/public/index/{{ $quake_id }}">
                    </iframe>

                    <script>
                        document.getElementById('shakemap-frame').addEventListener('load', function () {
                            document.getElementById('loading-shakemap').style.display = 'none';
                        });
                    </script>

                @else
                    <p class="text-center text-red-500 mt-4">No Shakemap available.</p>
                @endif
            </x-bladewind::tab-content>


            <!-- BBNet INFO -->
            <x-bladewind::tab-content name="bbnet">
                <iframe class="full-screen-iframe" src="{{ $bbnet_url }}"></iframe>
            </x-bladewind::tab-content>


            <!-- DOWNLOAD TAB (dropdown panel style) -->
            <x-bladewind::tab-content name="download">
                <div class="download-box">

                    <h2 class="text-xl font-bold mb-3">Download Formats</h2>

                    <a class="download-link" href="{{ $ims_url }}" download>
                        • IMS Format (.alert)
                    </a>

                    <a class="download-link" href="/download/quakeml/{{ $event_id }}">
                        • QuakeML Format (.xml)
                    </a>
                </div>
            </x-bladewind::tab-content>

        </x-bladewind::tab-body>
    </x-bladewind::tab-group>


    <!-- Bladewind JS -->
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>

</body>
</html>
