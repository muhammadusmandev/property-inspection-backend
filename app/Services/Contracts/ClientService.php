<?php

namespace App\Services\Contracts;

use App\Resources\ClientResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\User;

interface ClientService
{
    public function listClients(): AnonymousResourceCollection;
    public function createClient(array $data): User;
    public function showClient(int $id): ClientResource;
    public function updateClient(int $id, array $data): User;
    public function deleteClient(int $id): void;
}
