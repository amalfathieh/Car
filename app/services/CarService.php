<?php


namespace App\services;



use App\Http\Responses\Response;
use App\Models\Car;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;

class CarService
{

    protected $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

//    public function create($request){
//
//        $data = $request->except('images');
//        $data['user_id'] = Auth::user()->id;
//
//        if ($request->hasFile('images')) {
//            foreach ($request->file('images') as $image) {
//                $name = $this->fileService->upload($image, "carsImages");
//                $images[] = $name;
//            }
//            $data['images'] =json_encode($images);
//        }
//
//        $car = Car::create($data);
//
//        return $car;
//    }

    public function create($request)
    {
        $data = $request->except('images');
        $data['user_id'] = Auth::user()->id;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $this->fileService->upload($image, "carsImages");
            }

            $data['images'] = $images; // بدون json_encode
        }

        $car = Car::create($data);
        return $car;
    }
//    public function update( $request, $car){
//        $data = $request->except('images');
//        $images = json_decode($car->images);
//
//        if ($request->hasFile('images')) {
//            foreach ($request->file('images') as $image) {
//                $name = $this->fileService->upload($image, "carsImages");
//                $images[] = $name;
//            }
//            $data['images'] =json_encode($images);
//        }
//
//        $car->update($data);
//        return $car;
//    }
    public function update($request, $car)
    {
        $data = $request->except('images');
        $images = $car->images ?? [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $this->fileService->upload($image, "carsImages");
            }

            $data['images'] = $images; // بدون json_encode
        }

        $car->update($data);
        return $car;
    }

//    public function delete($car){
//        if($car->user_id != Auth::user()->id){
//            return Response::Error('unauthorized');
//        }
//
//        $car->delete();
//        $images = json_decode($car->images);
//        foreach ($images as $image){
//            $this->fileService->delete($image);
//        }
//    }

    public function delete($car)
    {
        if ($car->user_id != Auth::user()->id) {
            return Response::Error('unauthorized');
        }
        $car->delete();

        $images = $car->images ?? [];

        foreach ($images as $image) {
            $this->fileService->delete($image);
        }
    }
}
