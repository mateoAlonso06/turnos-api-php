<?php

class AuthController
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(): void
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input)
        {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON input']);
            return;
        }

        $dto = LoginRequest::fromArray($input);

        try {
            $responseDto = $this->authService->login($dto);

            http_response_code(200);
            echo json_encode($responseDto);
        } catch (\DomainException $e) {
            http_response_code(401);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
