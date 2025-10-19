<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use App\Services\Contracts\AuthService as AuthServiceContract;
use App\Exceptions\LoginPreconditionException;
use App\Requests\{LoginRequest, RegisterRequest};
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

            return $this->successResponse(__('validationMessages.login_successfully'), $data);

        } catch (AuthenticationException $e) {
            return $this->errorResponse(__('validationMessages.something_went_wrong'),[
                'error' => $e->getMessage()
            ], 401);

        } catch (AuthorizationException $e) {
            return $this->errorResponse(__('validationMessages.something_went_wrong'),[
                'error' => $e->getMessage()
            ], 403);

        } catch (LoginPreconditionException $e) {
            return $this->errorResponse(__('validationMessages.something_went_wrong'),[
                'error' => $e->getMessage(),
                'flag' => $e->flag,
            ], 403);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.login_api_failed'));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage()
            ], 500);
            
        }
    }

    /**
     * Handle user register.
     *
     * @param  \App\Http\Requests\RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $validData = $request->validated();
            $data = $this->authService->registerUser($validData);

            return $this->successResponse(__('validationMessages.user_registered_successfully'), $data);

        } catch (QueryException $qe) {
            $this->logException($qe, __('validationMessages.data_saved_failed'));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => __('validationMessages.data_saved_failed')
            ], 500);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.register_api_request_failed'));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
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

            return $this->successResponse(__('validationMessages.user_logout_successfully'));

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.logout_api_failed'));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage()
            ], 500);
            
        }
    }
}
