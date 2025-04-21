<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Http\Responses\Response;
use App\Models\Car;
use App\services\CarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    protected $carService;
    public function __construct( CarService $carService)
    {
        $this->carService = $carService;
    }

    //CREATE NEW CAR
    public function create(CarRequest $request)
    {
        $car = $this->carService->create($request);

        if ($car){
            return Response::Success($car, 'Car created successfully');
        }
    }

    //  UPDATE SPECIFIC CAR BY ID
    public function update(Request $request, $id){
        $car = Car::find($id);
        if($car){
            if($car->user_id != Auth::user()->id){
                return Response::Error('unauthorized', 403);
            }

            $car = $this->carService->update($request, $car);
            return Response::Success($car, 'Car updated successfully');
        }

        return Response::Error('Car not found', 404);
     }

    //  DELETE SPECIFIC CAE BY ID
    public function delete($id){
        $car = Car::find($id);
        $user = Auth::user();
        if($car){
            if($car->user_id != $user->id || $user->role != 'admin'){
                return Response::Error('unauthorized', 403);
            }
            $this->carService->delete($car);
            return Response::Success(null, 'Car deleted successfully');
        }
        return Response::Error( 'Car not found');
    }

    //  RETRIEVE SPECIFIC CAR BY ID
    public function getCar($id){
        $car = Car::find($id);
        if (!$car) {
            return Response::Error('car not found', 404);
        }
        return Response::Success($car, 'Car');
    }

    //  RETRIEVE A LIST OF CARS
    public function getCars(){
        $cars = Car::all();
        return Response::Success($cars, 'all cars');

    }
}
