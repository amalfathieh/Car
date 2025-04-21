<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Responses\Response;
use App\Models\User;
use App\services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use function Ramsey\Collection\add;

class UserController extends Controller
{
    protected $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function register(RegisterRequest $request){
        $info = $request->except('profile_picture');

        if($request->hasFile('profile_picture')){
            $file = $request->file('profile_picture');
            $info['profile_picture'] = $this->fileService->upload($file, "profileImages");
        }
        $user = User::create($info);
        $data['user']= $user;
        $data['token'] = $user->createToken("API TOKEN")->plainTextToken;
        return Response::Success($data,'User has been register successfully');
    }


    public function editProfile(Request $request){
        $user = Auth::user();
        $old_image = $user->profile_image;

        $data = $request->except('profile_image');

        if($request->hasFile('profile_image')){
            $file = $request->file('profile_image');
            $new_image = $this->fileService->replace($file, $old_image, "profileImages");

            $data['profile_image'] = $new_image;
        }
        $user->update($data);

        return Response::Success($user,'profile edit successfully');

    }

    public function login(LoginRequest $request){

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken('API TOKEN')->plainTextToken;
        $data['user']= $user;
        $data['token']= $token;

        return Response::Success($data,'user logged in successfully');

    }

    public function logout()
    {
        request()->user()->currentAccessToken()->delete();
        return Response::Success(null,'user logged out successfully');
    }

    public function delete(){
        $user = Auth::user();
        $user->delete();
        $this->fileService->delete($user->profile_picture);
        return Response::Success(null,'user deleted successfully');
    }
}
