<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Utils\ResponseDTO;
use App\Models\Hotels;
use App\Models\AssignmentRooms;
use Exception;

class AssignmentRoomsController extends Controller
{
    public $responseDTO;

    public function __construct(){
        $this->responseDTO = new ResponseDTO();   
    }

    /**
     * Show the assignments.
     */
    public function index()
    {
        $assignments = AssignmentRooms::all();
        return $this->responseDTO->response(array('status' => 200, 'message' => 'OK'), $assignments);
    }

     /**
     * Show the assignment rooms to hotel.
     */
    public function show($id)
    {
        $assignment = AssignmentRooms::where('idHotel', $id)->get();
        return $this->responseDTO->response(array('status' => 200, 'message' => 'OK'), $assignment);
    }

     /**
     * Create the assignment.
     */
    public function store(Request $request)
    {
        try {
            $hotel = Hotels::where('id', $request->idHotel)->first();
            $rooms = AssignmentRooms::where('idHotel', $request->idHotel)->get();
            $this->validateRooms($hotel, $rooms, $request);
            $assignment = new AssignmentRooms;
            $assignment->numberRooms = $request->numberRooms;
            $assignment->typeRoom = $request->typeRoom;
            $assignment->typeAccomodation = $request->typeAccomodation;
            $assignment->idHotel = $request->idHotel;
            $assignment->save();
            return $this->responseDTO->response(array('status' => 200, 'message' => 'Registro Guardado Correctamente'), $assignment);
    
        } catch (Exception  $e) {
            return $this->responseDTO->response(array('status' => 400, 'message' => $e->getMessage()));
        }  
    }

    public function validateRooms($hotel, $rooms, Request $request){
        $totalRooms = 0;
        for ($i=0; $i <count($rooms); $i++) { 
            $room = (object) $rooms[$i];
            $totalRooms += $room->numberRooms;
            if($room->typeRoom == $request->typeRoom && $room->typeAccomodation == $request->typeAccomodation){
                throw new Exception ('Ya existe la configuración de la habitación con los mismos parametros');
            }
        }
        $totalRooms += $request->numberRooms;
       
        if($hotel->numberRooms < $totalRooms){
            throw new Exception ('La cantidad de habitaciones supera el número maximo del hotel '.$hotel->name. '!');
        }
    }

     /**
     * Update the specified assignment.
     */
    public function update(Request $request,  $id)
    {
        // Update the assignment...
        $assignment = AssignmentRooms::where('id', $id)->first();
        $assignment->numberRooms = $request->numberRooms;
        $assignment->save();
        return $this->responseDTO->response(array('status' => 200, 'message' => 'Se ha actualizado Correctamente'), $assignment);
        
    }

    /**
     * Delete the specified assignment room.
     */
    public function destroy(Request $request, $id)
    {
        $assignment = AssignmentRooms::where('id', $id)->first();
        if ($assignment) {
            $assignment->delete();
        }
        return $this->responseDTO->response(array('status' => 200, 'message' => 'Se ha eliminado Correctamente'));
    }
}
