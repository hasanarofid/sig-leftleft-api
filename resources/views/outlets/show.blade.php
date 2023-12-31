@extends('layouts.app')

@section('title', __('outlet.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Detail Villa</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>Nama</td><td>{{ $outlet->name }}</td></tr>
                        <tr><td>Alamat</td><td>{{ $outlet->address }}</td></tr>
                        <tr><td>{{ __('outlet.latitude') }}</td><td>{{ $outlet->latitude }}</td></tr>
                        <tr><td>{{ __('outlet.longitude') }}</td><td>{{ $outlet->longitude }}</td></tr>
                        <tr><td>Price Range</td><td>{{ $outlet->harga_range }}</td></tr>
                        <tr><td>Gambar Villa</td><td>                            <img src="{{ asset('villa/' . $outlet->gambar) }}" alt="Outlet Image" width="100"></td></tr>
                        <tr><td>Categori</td><td>
                            @php
                                 $categori = explode(',', $outlet->categori);

                            @endphp
                                @foreach ($categori as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </td>
                        
                        </tr>
                        <tr><td>Deskripsi</td><td>{{ $outlet->deskripsi }}</td></tr>

                        <tr><td>House Rules</td><td>
                            @php
                                 $rules = explode(',', $outlet->rules);

                            @endphp
                                @foreach ($rules as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </td>
                        
                        </tr>

                        <tr><td>Fasilitas</td><td>
                            @php
                                 $fasilitas = explode(',', $outlet->fasilitas);

                            @endphp
                                @foreach ($fasilitas as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </td>
                        
                        </tr>

                        <tr><td>Room Name</td><td>{{ $outlet->room }}</td></tr>
                        <tr><td>Bed</td><td>{{ $outlet->bed }}</td></tr>
                        <tr><td>Bathroom</td><td>{{ $outlet->bathroom }}</td></tr>
                        <tr><td>Gambar Room</td><td>                            <img src="{{ asset('room/' . $outlet->roompic) }}" alt="Outlet Image" width="100"></td></tr>

                        <tr><td>Harga</td><td>{{ $outlet->harga }}</td></tr>

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $outlet)
                    <a href="{{ route('outlets.edit', $outlet) }}" id="edit-outlet-{{ $outlet->id }}" class="btn btn-warning">Edit Villa</a>
                @endcan
                @if(auth()->check())
                    <a href="{{ route('outlets.index') }}" class="btn btn-link">Kembali</a>
                @else
                    <a href="{{ route('outlet_map.index') }}" class="btn btn-link">Kembali</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ trans('outlet.location') }}</div>
            @if ($outlet->coordinate)
            <div class="card-body" id="mapid"></div>
            @else
            <div class="card-body">{{ __('outlet.no_coordinate') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>

<style>
    #mapid { height: 400px; }
</style>
@endsection
@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>

<script>
    var map = L.map('mapid').setView([{{ $outlet->latitude }}, {{ $outlet->longitude }}], {{ config('leaflet.detail_zoom_level') }});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var popupContent = '<strong>{{ $outlet->name }}</strong><br>' +
    '{{ $outlet->address }}<br>' +
    '<img src="{{ asset('villa/' . $outlet->gambar) }}" alt="Outlet Image" width="100">';

L.marker([{{ $outlet->latitude }}, {{ $outlet->longitude }}])
    .addTo(map)
    .bindPopup(popupContent);
    // var map = L.map('mapid').setView([{{ $outlet->latitude }}, {{ $outlet->longitude }}], {{ config('leaflet.detail_zoom_level') }});

    // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    // }).addTo(map);

    // L.marker([{{ $outlet->latitude }}, {{ $outlet->longitude }}]).addTo(map)
    //     .bindPopup('{!! $outlet->map_popup_content !!}');
</script>
@endpush
