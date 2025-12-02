<?php

namespace App\Repositories\Contracts;

interface ReportContactRepository
{
    public function list(int $reportId);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id): void;
    public function findById(int $id);
}
