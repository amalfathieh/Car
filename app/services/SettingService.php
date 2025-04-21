<?php


namespace App\services;


use App\Models\Setting;

class SettingService
{
    protected $fileService;
    public function __construct( FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function create($request){
        $iconImagePath = $request->file('icon_image')? $this->fileService->upload($request->file('icon_image'), 'intro') : null;
        $logoImagePath = $request->file('logo_image') ? $this->fileService->upload($request->file('logo_image'), 'intro') : null;
        $image1Path = $request->file('image_1') ? $this->fileService->upload($request->file('image_1'), 'intro') : null;
        $image2Path = $request->file('image_2') ? $this->fileService->upload($request->file('image_2'), 'intro') : null;
        $image3Path = $request->file('image_3') ? $this->fileService->upload($request->file('image_3'), 'intro') : null;

        $settings = Setting::create([
            'site_name' => $request->site_name,
            'icon_image' => $iconImagePath,
            'logo_image' => $logoImagePath,
            'facebook_link' => $request->facebook_link,
            'instagram_link' => $request->instagram_link,
            'whatsapp_number' => $request->whatsapp_number,
            'image_1' => $image1Path,
            'image_2' => $image2Path,
            'image_3' => $image3Path,
            'text_1' => $request->text_1,
            'text_2' => $request->text_2,
            'text_3' => $request->text_3,
        ]);
        return $settings;
    }
    public function update($request, $setting)
    {
        foreach (['icon_image', 'logo_image', 'image_1', 'image_2', 'image_3'] as $field) {
            if ($request->hasFile($field)) {
                $setting->$field = $this->fileService->upload($request->file($field), 'intro');
            }
        }

        foreach (['site_name', 'facebook_link', 'instagram_link', 'whatsapp_number', 'text_1', 'text_2', 'text_3'] as $field) {
            $setting->$field = $request->filled($field) ? $request->$field : $setting->$field;
        }

        $setting->save();

        return $setting;
    }


    public function delete($setting){
        $setting->delete();
        $this->fileService->delete($setting->icon_image);
        $this->fileService->delete($setting->logo_image);
        $this->fileService->delete($setting->image_1);
        $this->fileService->delete($setting->image_2);
        $this->fileService->delete($setting->image_3);
    }


}
