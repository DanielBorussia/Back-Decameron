<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseDTO;
use DB;
use App\Models\Hotels;
use App\Models\AssignmentRooms;

class HotelController extends Controller
{
    public $responseDTO;

    public function __construct(){
        $this->responseDTO = new ResponseDTO();   
    }

    /**
     * Show the hotels.
     */
    public function index()
    {
       
        $hotels = Hotels::all();
        for ($i=0; $i <count($hotels); $i++) { 
            $hotel = (object) $hotels[$i];
            $hotel->rooms = AssignmentRooms::where('idHotel', $hotel->id)->get();
            $hotels[$i] = $hotel;
        }
        return $this->responseDTO->response(array('status' => 200, 'message' => 'OK'), $hotels);
    }

     /**
     * Show the specified hotel.
     */
    public function show($id)
    {
        $hotel = Hotels::where('id', $id)->first();
        return $this->responseDTO->response(array('status' => 200, 'message' => 'OK'), $hotel);
    }

     /**
     * Create the hotel.
     */
    public function store(Request $request)
    {
        $hotelFound = Hotels::where('name', $request->name)->first();
        if($hotelFound){
            return $this->responseDTO->response(array('status' => 400, 'message' => 'El hotel '.$request->name. ' ya existe!'), $hotelFound);
        }
        $hotel = new Hotels;
        $hotel->name = $request->name;
        $hotel->address = $request->address;
        $hotel->nit = $request->nit;
        $hotel->city = $request->city;
        $hotel->numberRooms = $request->numberRooms;
        $hotel->save();
        return $this->responseDTO->response(array('status' => 200, 'message' => 'Registro Guardado Correctamente'), $hotel);
    }


     /**
     * Update the specified hotel.
     */
    public function update(Request $request,  $id)
    {
        // Update the hotel...
        $hotel = Hotels::where('id', $id)->first();
        $hotel->name = $request->name;
        $hotel->address = $request->address;
        $hotel->city = $request->city;
        $hotel->nit = $request->nit;
        $hotel->save();
        return $this->responseDTO->response(array('status' => 200, 'message' => 'Se ha actualizado Correctamente'), $hotel);
        
    }

    /**
     * Delete the specified hotel.
     */
    public function destroy(Request $request, $id)
    {
        $hotel = Hotels::where('id', $id)->first();
        if ($hotel) {
            $hotel->delete();
        }
        return $this->responseDTO->response(array('status' => 200, 'message' => 'Se ha eliminado Correctamente'));
    }
}
