<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Pameran Virtual - {{ config('app.name') }}</title>
    <script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script>
    <script src="https://unpkg.com/aframe-environment-component@1.3.1/dist/aframe-environment-component.min.js"></script>
  </head>
  <body>
    <a href="{{ route('home') }}" style="position: fixed; top: 20px; left: 20px; z-index: 999; color: white; background: rgba(0,0,0,0.5); padding: 10px 20px; border-radius: 5px; text-decoration: none; font-family: sans-serif;">&larr; Keluar Pameran</a>

    <a-scene renderer="antialias: true; colorManagement: true;">
        <!-- Environment -->
        <a-entity environment="preset: starry; groundColor: #111; grid: none; lighting: point"></a-entity>

        <!-- Floor (Removed conflicting plane, relying on environment or reducing z-fighting) -->
        <!-- <a-plane position="0 0.01 0" rotation="-90 0 0" width="100" height="100" color="#111" metalness="0.5" roughness="0.4"></a-plane> -->

        <!-- Lighting -->
        <a-light type="ambient" color="#222"></a-light>
        <a-light type="point" position="0 5 0" intensity="0.5" color="#fff" castShadow="true"></a-light>

        <!-- Gallery Walls (Circular Layout) -->
        @foreach($artworks as $index => $artwork)
            @php
                $angle = ($index / count($artworks)) * 360;
                $radius = 8;
                $x = $radius * sin(deg2rad($angle));
                $z = $radius * cos(deg2rad($angle));
                $rotY = $angle + 180;
            @endphp

            <!-- Canvas/Painting -->
            <a-entity position="{{ $x }} 2 {{ $z }}" rotation="0 {{ $rotY }} 0">
                <!-- Frame -->
                <a-box position="0 0 -0.1" width="3.2" height="2.2" depth="0.1" color="#222"></a-box>
                
                <!-- Image Texture (Moved slightly forward z=0.06) -->
                <a-image src="{{ Storage::url($artwork->image_path) }}" width="3" height="2" position="0 0 0.06"></a-image>

                <!-- Info Plaque (Moved forward z=0.1) -->
                <a-plane position="0 -1.5 0.1" width="1.5" height="0.6" color="black" opacity="0.8">
                    <a-text value="{{ $artwork->title }}" align="center" width="2" position="0 0.1 0.01" color="white"></a-text>
                    <a-text value="karya {{ $artwork->user->name }}" align="center" width="1.5" position="0 -0.1 0.01" color="#aaa"></a-text>
                </a-plane>
            </a-entity>
        @endforeach

        <!-- Camera / Controls -->
        <a-entity position="0 1.6 0">
            <a-camera look-controls wasd-controls="acceleration: 100">
                <a-cursor color="cyan"></a-cursor>
            </a-camera>
        </a-entity>

    </a-scene>
  </body>
</html>
