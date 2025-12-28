<?php

use App\Controller\AuthController;
use App\Service\AuthService;
use App\Repository\UserRepository;
use App\Repository\ProfessionalRepository;

$userRepository = new UserRepository();
$professionalRepository = new ProfessionalRepository();
$authService = new AuthService($userRepository, $professionalRepository);
$authController = new AuthController($authService);

$router->post('/api/auth/login', [$authController, 'login']);
$router->post('/api/auth/register', [$authController, 'register']);
