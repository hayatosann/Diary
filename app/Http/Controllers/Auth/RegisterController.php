<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'picture' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ], [], [
            'name' => 'ユーザー名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'picture' => 'プロフィール画像'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $imgPath = $this->saveProfileImage($data['picture']);
        
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'picture_path' => $imgPath,
        ]);
    }

    private function saveProfileImage($image)
    {
        // デフォルトではstorage/appに画像が保存されます。 
        // 第2引数にpublicをつけることで、storage/app/publicに保存されます。 
        // 今回は、/images/profilePictureをつけて、
        // storage/app/public/images/profilePictureに画像が保存されるようにしています。
        // 自分で指定しない場合、ファイル名は自動で設定されます。  
        $imgPath = $image->store('images/profilePicture', 'public');

        return 'storage/' . $imgPath;
    }

    
}
