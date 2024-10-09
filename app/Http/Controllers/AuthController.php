<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\Userresource;
use App\Interfaces\UserInterface;
use App\Mail\OtpCodeMail;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private UserInterface $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function create(RegisterRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'password_confirmation' => $request->password_confirmation,
        ];

        DB::beginTransaction();
        try {
            
            $user = $this->userInterface->create($data);


            DB::commit();

            if(!$user){
                return ApiResponse::sendResponse(
                     false,
                    [$user],
                    'Opération échouée',
                    400

                
                );
            }

            return ApiResponse::sendResponse(
                true,
                [new UserResource($user)],
                'Opération effectuée avec succès.'
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
            return ApiResponse::rollback($th);
        }
    }



    public function List_user(){
        $users = User::all();
    return response()->json($users->map(function ($user) {
        // S'assurer que l'avatar existe
        if ($user->avatar) {
            $user->avatar = asset('uploads/' . $user->avatar);
        }
        return $user;
    }));
    }




    public function login(LoginRequest $loginRequest)
    {
        $data = [
            'email' => $loginRequest->email,
            'password' => $loginRequest->password,
        ];

        DB::beginTransaction();
        try {
            $user = $this->userInterface->login($data);

            DB::commit();

            return ApiResponse::sendResponse(
                $user,
                [],
                'Connexion effectuée.',
                200
            );
        } catch (\throwable $th) {
            return $th;

            return ApiResponse::rollback(e: $th);
        }
    }


    public function update(UpdateProfileRequest $request)
    {
        $data = $request->validated();
    }

    public function checkOtpCode(Request $request)
    {
        $data = [
            'email' => $request->email,
            'code' => $request->code,
            
        ];


        DB::beginTransaction();
        try {
            $user = $this->userInterface->checkOtpCode($data);

            DB::commit();

            if (!$user) {
                return ApiResponse::sendResponse(
                    false,
                    [new UserResource($user)],
                    'Code de confirmation invalide.',
                    200
                );
            }

            return ApiResponse::sendResponse(
                true,
                [new UserResource($user)],
                'Opération effectuée',
                200
            );
        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);
        }

    }


    public function user(Request $request)
    {
        $name = $request->name; // Récupère le nom directement depuis la requête
        // Vous pouvez maintenant utiliser la variable $name
    }

}
