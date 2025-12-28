<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Repository\ProfessionalRepository;
use App\Model\Professional;

use App\Utils\JwtUtils;

use App\Dto\LoginRequest;
use App\Dto\LoginResponse;
use App\Dto\RegisterRequest;
use App\Dto\RegisterResponse;

use App\Utils\PasswordEncoder;

use DomainException;

class AuthService
{
    public function __construct(
        private UserRepository $userRepository,
        private ProfessionalRepository $professionalRepository
    )
    {
    }

    public function login(LoginRequest $request): LoginResponse
    {
        $user = $this->userRepository->getByEmail($request->getEmail());

        if (!$user) 
            throw new DomainException("User not found");

        if (PasswordEncoder::verify($request->getPassword(), $user->getPassword()) === false) 
            throw new DomainException("Invalid credentials");

        // Obtener el profesional asociado al usuario
        $professional = $this->professionalRepository->getByUserId($user->getId());
        
        if (!$professional)
            throw new DomainException("Professional profile not found");

        $token = JwtUtils::generateToken($user->getId(), $user->getEmail(), $user->getRole());

        return new LoginResponse(
            $user->getId(),
            $professional->getName(),
            $user->getEmail(),
            $user->getRole(),
            $token
        );
    }

    public function register(RegisterRequest $request): RegisterResponse
    {
        // Verificar si el usuario ya existe
        $user = $this->userRepository->getByEmail($request->getEmail());

        if ($user)
            throw new DomainException("User has already registered with this email");

        // Hashear la contraseña
        $passwordHash = PasswordEncoder::hash($request->getPassword());

        // Crear usuario en la tabla users
        $newUser = $this->userRepository->create(
            $request->getEmail(),
            $passwordHash
        );

        // Crear perfil de profesional en la tabla professionals
        $professional = Professional::createNew(
            $newUser->getId(),
            $request->getName(),
            $request->getSpecialty(),
            $request->getPhone()
        );

        $this->professionalRepository->create($professional);

        return new RegisterResponse(
            $newUser->getId(),
            $request->getName(),
            $newUser->getEmail(),
            $newUser->getRole()
        );
    }
}