<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\ClientRepository as ClientRepositoryContract;
use App\Resources\ClientResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientRepository implements ClientRepositoryContract
{
    public function getAllForRealtor(int $realtorId, int $perPage = 10): AnonymousResourceCollection
    {
        $clients = User::where('id', $realtorId)
            ->with('realtor')
            ->latest()
            ->paginate($perPage);

        return ClientResource::collection($clients);
    }

    public function findById(int $id): ?User
    {
        return User::where('role', 'client')
            ->with('realtor')
            ->find($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $client, array $data): User
    {
        $client->update($data);
        return $client;
    }

    public function delete(User $client): bool
    {
        return $client->delete();
    }
}
