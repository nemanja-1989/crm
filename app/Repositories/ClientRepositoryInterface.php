<?php

namespace App\Repositories;

use App\Models\Client;

interface ClientRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection;

    public function create(array $data): ?Client;

    public function update(array $data, int $id): int;

    public function delete(int $id): bool;

    public function find(int $id): ?Client;
}