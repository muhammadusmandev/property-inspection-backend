<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use App\Services\Contracts\AuthService as AuthServiceContract;
use App\Requests\LoginRequest;
use App\Traits\{ Loggable, ApiJsonResponse };

class AuthController extends Controller
{
    use Loggable, ApiJsonResponse;

    protected $authService;

    /**
     * Inject AuthServiceContract via constructor.
     * @param \App\Services\Contracts\AuthService $authService
    */
    public function __construct(AuthServiceContract $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle user login.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Illuminate\Auth\AuthenticationException on authentication failure
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception unexpected error
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $validData = $request->validated();
            $data = $this->authService->loginUser($validData);

            return $this->successResponse('Great! User login successfully.', $data);

        } catch (AuthenticationException $e) {
            return $this->errorResponse('Oops! Something went wrong.',[
                'error' => $e->getMessage()
            ], 401);

        } catch (AuthorizationException $e) {
            return $this->errorResponse('Oops! Something went wrong.',[
                'error' => $e->getMessage()
            ], 403);

        } catch (\Exception $e) {
            $this->logException($e, 'Login API request failed');

            return $this->errorResponse('Oops! Something went wrong.', [
                'error' => $e->getMessage()
            ], 500);
            
        }
    }

    /**
     * Handle user logout.
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     */
    public function logout(): JsonResponse
    {
        try {
            $logoutFromDevices = filter_var(request()->query('logout_from_devices', false), FILTER_VALIDATE_BOOLEAN);
            $this->authService->logoutUser($logoutFromDevices);

            return $this->successResponse('User logout successfully.');

        } catch (\Exception $e) {
            $this->logException($e, 'Logout API request failed');

            return $this->errorResponse('Oops! Something went wrong.', [
                'error' => $e->getMessage()
            ], 500);
            
        }
    }
}
