<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\ClientRepository;
use App\Resources\ClientResource;
use App\Services\Contracts\ClientService as ClientServiceContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ClientService implements ClientServiceContract
{
    protected ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function listClients(): AnonymousResourceCollection
    {
        return $this->clientRepository->getAllForRealtor(Auth::id());
    }

    public function createClient(array $data): User
    {
        $data['realtor_id'] = Auth::id();
        return $this->clientRepository->create($data);
    }

    public function showClient(int $id): ClientResource
    {
        $client = $this->clientRepository->findById($id);

        if (!$client) {
            throw new \Exception('Client not found.');
        }

        if ($client->realtor_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return new ClientResource($client);
    }

    public function updateClient(int $id, array $data): User
    {
        $client = $this->clientRepository->findById($id);

        if (!$client) {
            throw new \Exception('Client not found.');
        }

        if ($client->realtor_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return $this->clientRepository->update($client, $data);
    }

    public function deleteClient(int $id): void
    {
        $client = $this->clientRepository->findById($id);

        if (!$client) {
            throw new \Exception('Client not found.');
        }

        if ($client->realtor_id !== Auth::id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        $this->clientRepository->delete($client);
    }

    public function listClientProperties(int $clientId): AnonymousResourceCollection
    {
        return $this->clientRepository->getClientProperties($clientId);
    }

    public function associateProperty(array $data): bool
    {
        return $this->clientRepository->associateProperty($data);
    }
}
