<?php

namespace App\Services\Contracts;

use App\Models\Template;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface TemplateService
{
    public function listTemplates(): AnonymousResourceCollection;
    public function createTemplate(array $data): Template;
    public function showTemplate(int $id): Template;
    public function updateTemplate(int $id, array $data): Template;
    public function deleteTemplate(int $id): void;
}
