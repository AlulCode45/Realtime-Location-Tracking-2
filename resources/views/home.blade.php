@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <b>List Users</b>
                    </div>
                    <div class="card-body">
                        <div class="card card-body">
                            <div class="d-flex gap-3 align-items-center">
                                <div style="width: 50px; height:50px; background:gray;" class="rounded rounded-circle">
                                </div>
                                <div class="user-profile">
                                    <b>Mamat</b>
                                    <small class="d-block">mamat@mail.com</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <b>Maps & Location</b>
                    </div>
                    <div class="card-body">
                        {{-- leftlet map --}}
                        <div id="map" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Routing Machine -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>

    @php
        $locations = [
            ['lat' => -6.2000, 'lng' => 106.8166], // Jakarta
            ['lat' => -6.3000, 'lng' => 106.9000],
            ['lat' => -6.4000, 'lng' => 107.0000],
            ['lat' => -6.9147, 'lng' => 107.6098], // Bandung
        ];
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('map').setView([-6.5, 107.2], 8);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Kirim data dari PHP ke JS
            const coordinates = @json($locations);

            // Ubah format ke [lat, lng]
            const latlngs = coordinates.map(coord => [coord.lat, coord.lng]);

            // Gambar garis rute
            const route = L.polyline(latlngs, { color: 'red' }).addTo(map);

            // Zoom agar sesuai rute
            map.fitBounds(route.getBounds());

            // Optional: Tambahkan marker di tiap titik
            // latlngs.forEach((point, index) => {
            //     L.marker(point).addTo(map).bindPopup('Point ' + (index + 1));
            // });
        });
    </script>

@endsection