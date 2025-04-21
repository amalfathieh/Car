<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Http\Responses\Response;
use App\Models\Ad;
use App\services\AdService;
use App\services\FileService;
use Illuminate\Http\Request;

class AdController extends Controller
{
    protected $adService;
    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }

    //CREATE NEW AD
    public function create(AdRequest $request)
    {
        $ad = $this->adService->create($request);

        return Response::Success($ad,'Advertisement create successfully',201);
    }


    public function updateAd(Request $request, $id){
        $ad= Ad::find($id);
        if($ad){
            $ad = $this->adService->update($request, $ad);
            return Response::Success($ad,'ad updated successfully');
        }
        return Response::Error('not found',404);
    }

    public function delete($id){
        $ad = Ad::find($id);
        if ($ad){
            $this->adService->delete($ad);
            return Response::Success(null,'Advertisement deleted successfully');
        }
        return Response::Error('not found',404);
    }

    //  RETRIEVE SPECIFIC AD BY ID
    public function getAd($id){
        $ad = Ad::find($id);
        if ($ad){
            $ad->increment('hit');
            return Response::Success($ad, 'Ad');
        }
        return Response::Error('Advertisement not found', 404);
    }

    //  RETRIEVE A LIST OF ADS
    public function getAds(){
        $ads = Ad::all();

        return Response::Success($ads, 'all advertisements');
    }
}
