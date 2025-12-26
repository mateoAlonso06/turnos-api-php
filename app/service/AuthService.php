<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Dto\LoginRequest;
use App\Dto\LoginResponse;
use DomainException;

class AuthService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function login(LoginRequest $request): LoginResponse 
    {
        $user = $this->userRepository->getByEmail($request->getEmail());

        if (!$user)
        {
            throw new DomainException("Invalid credentials");
        }

        if (!password_verify($request->getPassword(), $user->getPassword()))
        {
            throw new DomainException("Invalid credentials");
        }

        if (!$user->isActive())
        {
            throw new DomainException("User is inactive");
        }

        $token = $this->generateJwtToken($user);

        return new LoginResponse(
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
            $user->getRole(),
            $token
        );
    }
}