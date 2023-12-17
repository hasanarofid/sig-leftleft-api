@extends('layouts.app')

@section('title', __('outlet.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        @if (request('action') == 'delete' && $outlet)
        @can('delete', $outlet)
            <div class="card">
                <div class="card-header">{{ __('outlet.delete') }}</div>
                <div class="card-body">
                    <label class="control-label text-primary">{{ __('outlet.name') }}</label>
                    <p>{{ $outlet->name }}</p>
                    <label class="control-label text-primary">{{ __('outlet.address') }}</label>
                    <p>{{ $outlet->address }}</p>
                    <label class="control-label text-primary">{{ __('outlet.latitude') }}</label>
                    <p>{{ $outlet->latitude }}</p>
                    <label class="control-label text-primary">{{ __('outlet.longitude') }}</label>
                    <p>{{ $outlet->longitude }}</p>
                    {!! $errors->first('outlet_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('outlet.delete_confirm') }}</div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('outlets.destroy', $outlet) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="outlet_id" type="hidden" value="{{ $outlet->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    <a href="{{ route('outlets.edit', $outlet) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">{{ __('outlet.edit') }}</div>
            <form method="POST" action="{{ route('outlets.update', $outlet) }}" accept-charset="UTF-8" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('patch') }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Nama Villa</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $outlet->name }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    

                        <div class="row" style="display: none">
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
                        <textarea id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" rows="4">{{ $outlet->address }}</textarea>
                        {!! $errors->first('address', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="control-label">Price Range</label>
                        <input value="{{ $outlet->maxPrice }}" type="text" id="priceRangeInput" class="form-control" readonly>
                        <input type="hidden" id="minPrice" name="minPrice" value="100000">
                        <input type="hidden" id="maxPrice" name="maxPrice" value="{{ $outlet->maxPrice }}">
                    
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
                                <input id="latitude" type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" name="latitude" value="{{ old('latitude', $outlet->latitude) }}" required>
                                {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">{{ __('outlet.longitude') }}</label>
                                <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" name="longitude" value="{{ old('longitude', $outlet->longitude) }}" required>
                                {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div id="mapid"></div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('outlet.update') }}" class="btn btn-success">
                    <a href="{{ route('outlets.show', $outlet) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @can('delete', $outlet)
                        <a href="{{ route('outlets.edit', [$outlet, 'action' => 'delete']) }}" id="del-outlet-{{ $outlet->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
@endif
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
    var mapCenter = [{{ $outlet->latitude }}, {{ $outlet->longitude }}];
    var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.detail_zoom_level') }});

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
</script>
@endpush
