<?php

namespace App\Http\Controllers;

use App\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    /** @api {get} {{host}}/api/stations
     * Display a listing of the resource.
     */
    public function index()
    {
        $stations = Station::all();
        if($stations) {
            return response()->json(['success' => true, 'data' => $stations]);
        } else {
            return 404;
        }
    }

    /** @api {post} {{host}}/api/station
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $station = new Station($request->all());
        $station->city()->associate($request->city_id);
        if($station->save()) {
            return response()->json(['success' => true, 'data' => $station]);
        } else {
            return response()->json(['success' => false, 'data' => $station]);
        }
    }

    /** @api {get} {{host}}/api/station/1
     * Display the specified resource.
     */
    public function show($id)
    {
        $station = Station::findOrFail($id);
        if($station) {
            return response()->json(['success' => true, 'data' => $station]);
        } else {
            return 404;
        }
    }

    /** @api {put} {{host}}/api/station/58
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $station = Station::findOrFail($id);
        $station->update($request->except('city_id'));
        return response()->json(['success' => true, 'data' => $station]);
    }

    /** @api {delete} {{host}}/api/station/58
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $station = Station::findOrFail($id);
        $station->delete();

        return response()->json(['success' => true]);
    }
    
    /** @api {post} {{host}}/api/city/stations
     * Display the specified resource by City.
     * @apiParam {int} isOpen 
     * @apiParam {int} city_id
     */
    public function showByCity(Request $request)
    {
        $isOpen = $request->isOpen ?? null;
        $data = \App\City::where('id', $request->city_id)->whereHas('stations', function($q) use($isOpen)
        {
            if($isOpen) {
                $q->where('isOpen', 1);
            }
        })
                ->with('stations')
                ->first()
                ->stations;
        
        return response()->json(['success' => true, 'data' => $data]);
    }
    
    
    /** @api {post} {{host}}/api/station/nearest
     * Display nearest station.
     * @apiParam {string} latitude 
     * @apiParam {string} longitude
     */
    public function showNearest(Request $request)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $data = \Illuminate\Support\Facades\DB::table('stations')
        ->select('name', 'isOpen', 'latitude', 'longitude', \Illuminate\Support\Facades\DB::raw(
            "(3956 * 2 * ASIN(SQRT( POWER(SIN(($latitude-latitude) *  pi()/180 / 2), 2) +COS($latitude*pi()/180) * COS(latitude * pi()/180) * POWER(SIN(($longitude-longitude) * pi()/180 / 2), 2) )))"
                . ' AS distance'
        ))
        ->having('distance', '<', 500)
        ->orderBy('distance', 'asc')
        ->limit(1)
        ->get();
        
        return response()->json(['success' => true, 'data' => $data]);
    }
}
