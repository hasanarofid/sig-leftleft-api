@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-body" id="mapid"></div>


</div>
<br>
<div class="row">
        <div class="col-md-12 text-center mb-4">
            <h4>List Villa</h4>
        </div>
    </div>
<div class="row">
    @foreach($list as $outlet)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('villa/') . '/' . $outlet->gambar }}" class="card-img-top" alt="Outlet Image">
                <div class="card-body">
                    <h5 class="card-title">{{ $outlet->name }}</h5>
                    <p class="card-text">{{ $outlet->address }}</p>
                    <p class="card-text">Harga: {{ $outlet->harga }}</p>
                    <a href="{{ route('outlets.show', $outlet->id) }}" class="btn btn-primary">Show</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

<style>
    #mapid { min-height: 500px; }
</style>
@endsection
@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

<script>
    var map = L.map('mapid').setView([{{ config('leaflet.map_center_latitude') }}, {{ config('leaflet.map_center_longitude') }}], {{ config('leaflet.zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    var markers = L.markerClusterGroup();

    axios.get('{{ route('api.outlets.index') }}')
    .then(function (response) {
        var marker = L.geoJSON(response.data, {
            pointToLayer: function(geoJsonPoint, latlng) {
                var properties = geoJsonPoint.properties;
                
                // Build the popup content, including the image
                var popupContent = '<strong>' + properties.name + '</strong><br>' +
                    properties.address + '<br>' +
                    '<img src="{{ asset('villa/') }}/' + properties.gambar + '" alt="Outlet Image" width="100">';

                // Create the marker with the popup
                return L.marker(latlng).bindPopup(popupContent);

                // return L.marker(latlng).bindPopup(function (layer) {
                //     return layer.feature.properties.map_popup_content;
                // });
            }
        });
        markers.addLayer(marker);
    })
    .catch(function (error) {
        console.log(error);
    });
    map.addLayer(markers);

    @can('create', new App\Outlet)
    var theMarker;

    map.on('click', function(e) {
        let latitude = e.latlng.lat.toString().substring(0, 15);
        let longitude = e.latlng.lng.toString().substring(0, 15);

        if (theMarker != undefined) {
            map.removeLayer(theMarker);
        };

        var popupContent = "Your location : " + latitude + ", " + longitude + ".";
        popupContent += '<br><a href="{{ route('outlets.create') }}?latitude=' + latitude + '&longitude=' + longitude + '">Add new outlet here</a>';

        theMarker = L.marker([latitude, longitude]).addTo(map);
        theMarker.bindPopup(popupContent)
        .openPopup();
    });
    @endcan
</script>
@endpush
