<?php

namespace App\Repositories\Contracts;

use App\Models\Template;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface TemplateRepository
{
    public function getAllForUser(int $userId): AnonymousResourceCollection;
    public function findById(int $id): ?Template;
    public function create(array $data): Template;
    public function update(Template $template, array $data): Template;
    public function delete(Template $template): bool;
}
