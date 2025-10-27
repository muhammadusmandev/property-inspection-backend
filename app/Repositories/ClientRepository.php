<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\ClientRepository as ClientRepositoryContract;
use Illuminate\Support\Facades\Hash;
use App\Resources\ClientResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientRepository implements ClientRepositoryContract
{
    public function getAllForRealtor(int $realtorId, int $perPage = 10): AnonymousResourceCollection
    {
        $columnQuery = request()->input('columnQuery');
        $columnName = request()->input('columnName');
        
        $query = User::where('realtor_id', $realtorId)
            ->with('realtor')
            ->latest();

        if ($columnName && $columnQuery) {
            if (str_contains($columnName, '.')) {      // search query on relation
                [$relation, $column] = explode('.', $columnName);

                $query->whereHas($relation, function ($q) use ($column, $columnQuery) {
                    $q->where($column, 'LIKE', "%{$columnQuery}%");
                });
            } else {
                $query->where($columnName, 'LIKE', "%{$columnQuery}%");
            }
        }

        // Todo: make trait/helper for getting boolean from request safely
        $paginate = filter_var(
            is_string($v = request()->input('paginate', true)) ? trim($v, "\"'") : $v,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        ) ?? true;

        if (!$paginate) {
            $clients = $query->get();
        } else{
            $clients = $query->paginate(request()->input('perPage') ?? $perPage);
        }

        return ClientResource::collection($clients);
    }

    public function findById(int $id): ?User
    {
        return User::with('realtor')
            ->find($id);
    }

    public function create(array $data): User
    {
        $user =  User::create([
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'] ? phone($data['phone_number'])->formatE164() : null,
            'password' => Hash::make(\Str::random(8)), // Todo: password if needed for client
            'gender' => $data['gender'],
            'realtor_id'  => $data['realtor_id'],
            'is_active' => true
        ]);

        $user->assignRole('client');

        return $user;
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
