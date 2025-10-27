<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Illuminate\Auth\Access\AuthorizationException;
use App\Services\Contracts\ClientService as ClientServiceContract;
use App\Requests\{ StoreClientRequest, UpdateClientRequest };
use App\Traits\{ Loggable, ApiJsonResponse };

class ClientController extends Controller
{
    use Loggable, ApiJsonResponse;

    protected ClientServiceContract $clientService;

    public function __construct(ClientServiceContract $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(): JsonResponse
    {
        try {
            $data = $this->clientService->listClients()->response()->getData(true);
            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);
        } catch (\Exception $e) {
            $this->logException($e);
            return $this->errorResponse(__('validationMessages.something_went_wrong'), ['error' => $e->getMessage()]);
        }
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        try {
            $data = $this->clientService->createClient($request->validated());
            return $this->successResponse(__('validationMessages.client.created_successfully'), $data, 201);
        } catch (QueryException $qe) {
            $this->logException($qe);
            return $this->errorResponse(__('validationMessages.data_saved_failed'), ['error' => $qe->getMessage()]);
        } catch (\Exception $e) {
            $this->logException($e);
            return $this->errorResponse(__('validationMessages.client.create_failed'), ['error' => $e->getMessage()]);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->clientService->showClient($id);
            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);
        } catch (\Exception $e) {
            $this->logException($e);
            return $this->errorResponse(__('validationMessages.something_went_wrong'), ['error' => $e->getMessage()]);
        }
    }

    public function update(UpdateClientRequest $request, int $id): JsonResponse
    {
        try {
            $data = $this->clientService->updateClient($id, $request->validated());
            return $this->successResponse(__('validationMessages.client.updated_successfully'), $data);
        } catch (AuthorizationException $e) {
            return $this->errorResponse(__('validationMessages.unauthorized_access'), ['error' => $e->getMessage()], 403);
        } catch (QueryException $qe) {
            $this->logException($qe);
            return $this->errorResponse(__('validationMessages.data_saved_failed'), ['error' => $qe->getMessage()]);
        } catch (\Exception $e) {
            $this->logException($e);
            return $this->errorResponse(__('validationMessages.client.update_failed'), ['error' => $e->getMessage()]);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->clientService->deleteClient($id);
            return $this->successResponse(__('validationMessages.client.deleted_successfully'));
        } catch (AuthorizationException $e) {
            return $this->errorResponse(__('validationMessages.unauthorized_access'), ['error' => $e->getMessage()], 403);
        } catch (\Exception $e) {
            $this->logException($e);
            return $this->errorResponse(__('validationMessages.client.delete_failed'), ['error' => $e->getMessage()]);
        }
    }
}
