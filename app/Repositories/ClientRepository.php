<?php

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Client::get();
    }

    public function create(array $data): ?Client
    {
        return Client::create($data);
    }

    public function update(array $data, int $id): int
    {
        $client = Client::findOrFail($id);

        return $client->update($data);
    }

    public function delete(int $id): bool
    {
        $client = Client::findOrFail($id);

        return $client->delete();
    }

    public function find(int $id): ?Client
    {
        return Client::find($id);
    }
}