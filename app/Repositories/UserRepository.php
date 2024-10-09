<?php

namespace App\Repositories;


use App\Interfaces\UserInterface;
use App\Mail\OtpCodeMail;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserRepository implements UserInterface
{
  /**
   * Create a new class instance.
   */
  public function __construct()
  {
    //
  }

  public function find($id)
  {
    return User::find($id);
  }

  public function create(array $data)
  {
    $user = User::create($data);
    $otp_code = [
      'email' => $data['email'],
      'code' => rand(111111, 999999)
    ];
    OtpCode::where('email', $data['email'])->delete();
    OtpCode::create($otp_code);
    Mail::to($data['email'])->send(new OtpCodeMail(

      $data['name'],
      $data['email'],
      $otp_code['code'],
    ));

    return $user;
  }
  public function update($id, array $data)
  {
    $user = User::find($id);
    if ($user) {
      $user->update($data);
      return $user;
    }
    return null;
  }

  public function delete($id)
  {
    $user = User::find($id);
    if ($user) {
      $user->delete();
      return true;
    }
    return false;
  }

  public function all()
  {
    return User::all();
  }


  public function checkOtpCode(array $data)
  {
    $otp_code = OtpCode::where('email', $data['email'])->first();

    if (!$otp_code)

      return false;

    if (Hash::check($data['code'], $otp_code['code'])) {
      $user = User::where('email', $data['email'])->first();

      $user->update(['is_confirmed' => true]);

      $otp_code->delete();

      $user->token = $user->createToken($user->id)->plainTextToken;
      return $user;
    }
    return false;
  }

  public function login(array $data)
  {
    $user = User::where('email', $data['email'])->first();

    if (!$user)


      return false;

    if (!Hash::check($data['password'], $user->password)) {
      return false;
    }
    $user->tokens()->delete();
    $user->token = $user->createToken($user->id)->plainTextToken;
    return $user;
  }
}
