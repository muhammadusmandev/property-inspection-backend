<?php

namespace App\Services\Contracts;

interface ReportContactService
{
    public function list(int $reportId);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id): void;
}
