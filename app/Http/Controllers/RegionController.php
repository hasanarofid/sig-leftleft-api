<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apiToken = Session::get('api_token');
        // dd($apiToken);
        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer ' . $apiToken,
        // ])->get('https://gisapis.manpits.xyz/api/mregion');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
        ])->get('https://gisapis.manpits.xyz/api/meksisting');

        if ($response->successful()) {
            // Decode the JSON response
            $responseData = $response->json();
            $region = $responseData;
            // Do something with the data from the response
            dd($responseData);
        } else {
            // Handle the error if the request was not successful
            $errorMessage = $response->body();
            $region = null;
            // dd($errorMessage);
        }

        return view('region.index',compact('region'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
