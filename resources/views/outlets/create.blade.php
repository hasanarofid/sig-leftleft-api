@extends('layouts.app')

@section('title', __('outlet.create'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">Buat Toko Sepatu Baru</div>
            <form method="POST" action="{{ route('outlets.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Nama Villa</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="control-label">Provinsi</label>
                                    <select name="provinsi_id" id="provinsi_id" class="form-control" onchange="pilihKabupaten(this)">
                                    </select>
                                </div>
                                
            
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="control-label">Kabupaten</label>
                                    <select name="kabupaten_id" id="kabupaten_id" class="form-control" onchange="pilihKecamatan(this)">
            
                                    </select>
                                </div>
                                
            
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="control-label">Kecamatan</label>
                                    <select name="kecamatan_id" id="kecamatan_id" class="form-control" onchange="pilihDesa(this)">
            
                                    </select>
                                </div>
                                
            
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="control-label">Desa</label>
                                    <select name="kelurahan_id" id="kelurahan_id" class="form-control" >
            
                                    </select>
                                </div>
                                
            
                            </div>
                        </div>


                    <div class="form-group">
                        <label for="address" class="control-label">Alamat</label>
                        <textarea id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" rows="4">{{ old('address') }}</textarea>
                        {!! $errors->first('address', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="control-label">Price Range</label>
                        <input type="text" id="priceRangeInput" class="form-control" readonly>
                        <input type="hidden" id="minPrice" name="minPrice">
                        <input type="hidden" id="maxPrice" name="maxPrice">
                    
                        <input type="range" class="form-range" id="priceRangeSlider" min="100000" max="10000000">
                    
                    </div>



                        <div class="form-group">
                            <label for="name" class="control-label">Gambar Villa</label>
                            <input type="file" name="gambar" id="gambar" class="form-control">
                            </select>
                        </div>
                        
    

                    <div class="form-group">
                        <label for="deskripsi" class="control-label">Categori</label>
                        @php
                            $categori = ['Farm','Beachfront','Mansions','Tiny House','Luxes','Amazing Views','Natural','Tropis'];
                        @endphp

                        @foreach($categori as $key => $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="category{{ $key }}" name="categori[]" value="{{ $category }}">
                            <label class="form-check-label" for="category{{ $key }}">{{ $category }}</label>
                        </div>
                        @endforeach

                    </div>

                    
                    <div class="form-group">
                        <label for="deskripsi" class="control-label">Deskripsi</label>
                        <textarea id="deskripsi" class="form-control{{ $errors->has('deskripsi') ? ' is-invalid' : '' }}" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                        {!! $errors->first('deskripsi', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="control-label">House Rules</label>
                        @php
                            $rules = ['Gatherings allowed','Smoking allowed','Pets allowed',
                                        'Suitable for infants (under 2 years)',
                                        'Children friendly home (2-12 years)'
                                    ];
                        @endphp

                        @foreach($rules as $key => $rule)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rule{{ $key }}" name="rules[]" value="{{ $rule }}">
                            <label class="form-check-label" for="rule{{ $key }}">{{ $rule }}</label>
                        </div>
                        @endforeach

                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="control-label">Fasilitas</label>
                        @php
                            $fasilitass = ['TV','Parking','Fan','Swimming Pool','Wi-fi'
                                    ];
                        @endphp

                        @foreach($fasilitass as $key => $fasilitas)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fasilitas{{ $key }}" name="fasilitas[]" value="{{ $fasilitas }}">
                            <label class="form-check-label" for="fasilitas{{ $key }}">{{ $fasilitas }}</label>
                        </div>
                        @endforeach

                    </div>
                    <h5>Room Information</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="control-label">Room Name</label>
                                <input type="tex" name="room" id="room" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label">Bed</label>
                                <input type="tex" name="bed" id="bed" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label">Bathroom</label>
                                <input type="tex" name="bathroom" id="bathroom" class="form-control">
                                </select>
                            </div>
                        </div>

                    </div>


                 

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label">Gambar Room</label>
                                <input type="file" name="roompic" id="roompic" class="form-control">
                                </select>
                            </div>
                            
        
                        </div>


                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="name" class="control-label">Harga</label>
                                <input type="number" name="harga" id="harga" class="form-control">
                            </div>
                        </div>

                       
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="control-label">{{ __('outlet.latitude') }}</label>
                                <input id="latitude" type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" name="latitude" value="{{ old('latitude', request('latitude')) }}" required>
                                {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">{{ __('outlet.longitude') }}</label>
                                <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" name="longitude" value="{{ old('longitude', request('longitude')) }}" required>
                                {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div id="mapid"></div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="Simpan" class="btn btn-success">
                    <a href="{{ route('outlets.index') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>

<style>
    #mapid { height: 300px; }
</style>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>
<script>
const priceRangeSlider = document.getElementById('priceRangeSlider');
const priceRangeInput = document.getElementById('priceRangeInput');
const minPriceInput = document.getElementById('minPrice');
const maxPriceInput = document.getElementById('maxPrice');

if (priceRangeSlider && priceRangeInput && minPriceInput && maxPriceInput) {
  priceRangeSlider.addEventListener('input', updatePriceRange);
}

function updatePriceRange() {
  const selectedValue = priceRangeSlider.value;
  priceRangeInput.value = selectedValue;

  // Split the range value into min and max
  const [minValue, maxValue] = selectedValue.split(',');

  // Update minPrice and maxPrice inputs if they exist
    minPriceInput.value = 100000;

    maxPriceInput.value = minValue;

}

    var mapCenter = [{{ request('latitude', config('leaflet.map_center_latitude')) }}, {{ request('longitude', config('leaflet.map_center_longitude')) }}];
    var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker(mapCenter).addTo(map);
    function updateMarker(lat, lng) {
        marker
        .setLatLng([lat, lng])
        .bindPopup("Your location :  " + marker.getLatLng().toString())
        .openPopup();
        return false;
    };

    map.on('click', function(e) {
        let latitude = e.latlng.lat.toString().substring(0, 15);
        let longitude = e.latlng.lng.toString().substring(0, 15);
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
        updateMarker(latitude, longitude);
    });

    var updateMarkerByInputs = function() {
        return updateMarker( $('#latitude').val() , $('#longitude').val());
    }
    $('#latitude').on('input', updateMarkerByInputs);
    $('#longitude').on('input', updateMarkerByInputs);


    $(document).ready(function() {
        getProvinsi();
            // Use jQuery to make an AJAX GET request to the API endpoint
           
        });

        function getProvinsi(){
            var apiUrl = "{{ route('get-provinsi') }}";
            $.ajax({
                url: apiUrl,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Handle the successful response
                    

                    // Display the data in the container
                    // Update your view with the received data, for example:
                    var select = $('#provinsi_id');
                    select.empty(); // Clear previous options
                    select.append('<option value="">.:PILIH:.</option>');
                    // Assuming the array is nested under the key 'response'
                    $.each(response, function(key, value) {
                        select.append('<option value="' + value.id + '">' + value.provinsi + '</option>');
                    });
                },
                error: function(error) {
                    // Handle the error
                    console.error('Error:', error);
                }
            });
        }

        function pilihKabupaten(obj){
            var provinsi_id = $(obj).val();
            var apiUrl = "{{ route('get-kabupaten') }}";
            $.ajax({
                url: apiUrl,
                method: 'GET',
                data : {
                    provinsi_id : provinsi_id
                },
                dataType: 'json',
                success: function(response) {
                    // Handle the successful response
                    

                    // Display the data in the container
                    // Update your view with the received data, for example:
                    var select = $('#kabupaten_id');
                    select.empty(); // Clear previous options
                    select.append('<option value="">.:Pilih Kabupaten:.</option>');
                    // Assuming the array is nested under the key 'response'
                    $.each(response, function(key, value) {
                        select.append('<option value="' + value.id + '">' + value.value + '</option>');
                    });
                },
                error: function(error) {
                    // Handle the error
                    console.error('Error:', error);
                }
            });
        }

        function pilihKecamatan(obj){
            var kabupaten_id = $(obj).val();
            var apiUrl = "{{ route('get-kecamatan') }}";
            $.ajax({
                url: apiUrl,
                method: 'GET',
                data : {
                    kabupaten_id : kabupaten_id
                },
                dataType: 'json',
                success: function(response) {
                    // Handle the successful response
                    

                    // Display the data in the container
                    // Update your view with the received data, for example:
                    var select = $('#kecamatan_id');
                    select.empty(); // Clear previous options
                    select.append('<option value="">.:Pilih Kecamatan:.</option>');
                    // Assuming the array is nested under the key 'response'
                    $.each(response, function(key, value) {
                        select.append('<option value="' + value.id + '">' + value.value + '</option>');
                    });
                },
                error: function(error) {
                    // Handle the error
                    console.error('Error:', error);
                }
            });
        }

        function pilihDesa(obj){
            var kecamatan_id = $(obj).val();
            var apiUrl = "{{ route('get-desa') }}";
            $.ajax({
                url: apiUrl,
                method: 'GET',
                data : {
                    kecamatan_id : kecamatan_id
                },
                dataType: 'json',
                success: function(response) {
                    // Handle the successful response
                    

                    // Display the data in the container
                    // Update your view with the received data, for example:
                    var select = $('#kelurahan_id');
                    select.empty(); // Clear previous options
                    select.append('<option value="">.:Pilih Desa:.</option>');
                    // Assuming the array is nested under the key 'response'
                    $.each(response, function(key, value) {
                        select.append('<option value="' + value.id + '">' + value.value + '</option>');
                    });
                },
                error: function(error) {
                    // Handle the error
                    console.error('Error:', error);
                }
            });
        }
        

    

</script>
@endpush
