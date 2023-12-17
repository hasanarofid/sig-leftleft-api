<?php

namespace App\Http\Controllers;

use App\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    /**
     * Display a listing of the outlet.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('manage_outlet');

        $outletQuery = Outlet::query();
        $outletQuery->where('name', 'like', '%'.request('q').'%');
        $outlets = $outletQuery->paginate(25);

        return view('outlets.index', compact('outlets'));
    }

    /**
     * Show the form for creating a new outlet.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Outlet);

        return view('outlets.create');
    }

    /**
     * Store a newly created outlet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $this->authorize('create', new Outlet);

        $newOutlet = $request->validate([
            'name'      => 'required|max:60',
            'address'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
        ]);
        $newOutlet['creator_id'] = auth()->id();
        $newOutlet['provinsi_id'] = $request->provinsi_id;
        $newOutlet['kabupaten_id'] = $request->kabupaten_id;
        $newOutlet['kecamatan_id'] = $request->kecamatan_id;
        $newOutlet['kelurahan_id'] = $request->kelurahan_id;
        $newOutlet['deskripsi'] = $request->deskripsi;
        $newOutlet['harga'] = $request->harga;
        $newOutlet['room'] = $request->room;
        $newOutlet['harga_range'] = $request->maxPrice;
        
        $newOutlet['bed'] = $request->bed;
        $newOutlet['bathroom'] = $request->bathroom;
        $newOutlet['categori'] =implode(',', $request->input('categori', []));
        $newOutlet['rules'] =implode(',', $request->input('rules', []));
        $newOutlet['fasilitas'] =implode(',', $request->input('fasilitas', []));

        // dd($newOutlet);
        if(!empty($request->gambar)){
        $imageName = time().'.'.$request->gambar->extension();
        $request->gambar->move(public_path('villa'), $imageName);
        $newOutlet['gambar'] = $imageName;
        }

        if(!empty($request->roompic)){
            $imageNamepic = time().'.'.$request->roompic->extension();
            $request->roompic->move(public_path('room'), $imageNamepic);
            $newOutlet['roompic'] = $imageNamepic;
        }

        

        $outlet = Outlet::create($newOutlet);

        return redirect()->route('outlets.show', $outlet);
    }

    /**
     * Display the specified outlet.
     *
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\View\View
     */
    public function show(Outlet $outlet)
    {
        // dd($outlet->gambar);
        return view('outlets.show', compact('outlet'));
    }

    /**
     * Show the form for editing the specified outlet.
     *
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\View\View
     */
    public function edit(Outlet $outlet)
    {
        $this->authorize('update', $outlet);

        return view('outlets.edit', compact('outlet'));
    }

    /**
     * Update the specified outlet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Outlet $outlet)
    {
        // dd($request);
        $this->authorize('update', $outlet);

        $outletData = $request->validate([
            'name'      => 'required|max:60',
            'address'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
        ]);
        $outletData['creator_id'] = auth()->id();
        $outletData['provinsi_id'] = $request->provinsi_id;
        $outletData['kabupaten_id'] = $request->kabupaten_id;
        $outletData['kecamatan_id'] = $request->kecamatan_id;
        $outletData['kelurahan_id'] = $request->kelurahan_id;
        $outletData['deskripsi'] = $request->deskripsi;
        $outletData['harga'] = $request->harga;
        $outletData['room'] = $request->room;
        $outletData['harga_range'] = $request->maxPrice;
        
        $outletData['bed'] = $request->bed;
        $outletData['bathroom'] = $request->bathroom;
        $outletData['categori'] =implode(',', $request->input('categori', []));
        $outletData['rules'] =implode(',', $request->input('rules', []));
        $outletData['fasilitas'] =implode(',', $request->input('fasilitas', []));

        // dd($outletData);
        if(!empty($request->gambar)){
        $imageName = time().'.'.$request->gambar->extension();
        $request->gambar->move(public_path('villa'), $imageName);
        $outletData['gambar'] = $imageName;
        }

        if(!empty($request->roompic)){
            $imageNamepic = time().'.'.$request->roompic->extension();
            $request->roompic->move(public_path('room'), $imageNamepic);
            $outletData['roompic'] = $imageNamepic;
        }

        $outlet->update($outletData);

        return redirect()->route('outlets.show', $outlet);
    }

    /**
     * Remove the specified outlet from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Outlet $outlet)
    {
        $this->authorize('delete', $outlet);

        $request->validate(['outlet_id' => 'required']);

        if ($request->get('outlet_id') == $outlet->id && $outlet->delete()) {
            return redirect()->route('outlets.index');
        }

        return back();
    }
}
