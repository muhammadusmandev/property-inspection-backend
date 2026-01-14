<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\User;

interface ClientRepository
{
    public function getAllForInspector(int $inspectorId, int $perPage = 10): AnonymousResourceCollection;
    public function findById(int $id): ?User;
    public function create(array $data): User;
    public function update(User $client, array $data): User;
    public function delete(User $client): bool;
    public function getClientProperties(int $clientId, int $perPage = 10): AnonymousResourceCollection;
    public function associateProperty(array $data): bool;
}
