<?php


namespace App\services;


use App\Models\Ad;
use http\Env\Request;

class AdService
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function create($request)
    {
        $info = $request->except('image');

        if($request->hasFile('image')){
            $image = $request->file('image');
            $info['image'] = $this->fileService->upload($image, "AdsImages");
        }
        $ad = Ad::create($info);
        return $ad;
    }

    public function update($request, $ad){

        $old_image = $ad->image;

        $data = $request->except('image');

        if($request->hasFile('image')){
            $image = $request->file('image');
            $new_image = $this->fileService->replace($image, $old_image, "image");

            $data['image'] = $new_image;
        }
        $ad->update($data);
        return $ad;
    }

    public function delete($ad){
        $ad->delete();
        $this->fileService->delete($ad->image);
    }

}
