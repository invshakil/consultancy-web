<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Repositories\User\UserRepository;
use Illuminate\Http\JsonResponse;
use Throwable;
use Illuminate\Http\Request;

class ProfileController extends ApiController
{
    private UserRepository $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function update(Request $request)
    {
        try {
            $user = auth()->user();
            if ($request->hasFile('image')) {
                return $this->repository->updateProfileAndImage($user, $request);
            } else {
                return $this->repository->updateProfile($user, $request);
            }
        } catch (Throwable $exception) {
            $this->errorLog($exception, 'api');

            return $this->failResponse($exception->getMessage());
        }
    }
}
