<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;

class ProfileController extends Controller
{
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = $this->userRepository->find($id);
        $user->update($request->all());
        return response()->json($user);
    }
}
