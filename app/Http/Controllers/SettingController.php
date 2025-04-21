<?php

namespace App\Http\Controllers;


use App\Http\Requests\SettingRequest;
use App\Http\Responses\Response;
use App\Models\Setting;
use App\services\FileService;
use App\services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    protected $settingService, $fileService;
    public function __construct(SettingService $settingService, FileService $fileService)
    {
        $this->settingService = $settingService;
        $this->fileService = $fileService;
    }

    //CREATE NEW SETTING
    public function create(SettingRequest $request)
    {
        $settings = $this->settingService->create($request);
        return Response::Success($settings,'setting create successfully',201);
    }


    public function update(Request $request, $id){

        $setting= Setting::find($id);
        if($setting){
            $setting = $this->settingService->update($request, $setting);
            return Response::Success($setting,'setting updated successfully');
        }
        return Response::Error('not found',404);
    }

    public function delete($id){
        $setting = Setting::find($id);
        if ($setting){
            $this->settingService->delete($setting);
            return Response::Success(null,'Setting deleted successfully');
        }
        return Response::Error('not found',404);
    }

    public function getSetting($id){
        $setting = Setting::find($id);
        if (!$setting){
            return Response::Error('Setting not found', 404);
        }
        return Response::Success($setting, 'Setting');
    }

}
