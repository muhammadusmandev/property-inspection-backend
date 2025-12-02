<?php

namespace App\Services;

use App\Services\Contracts\ReportContactService as ReportContactServiceContract;
use App\Repositories\Contracts\ReportContactRepository as ReportContactRepositoryContract;
use App\Resources\ReportContactResource;

class ReportContactService implements ReportContactServiceContract
{
    protected ReportContactRepositoryContract $reportContactRepository;

    public function __construct(ReportContactRepositoryContract $reportContactRepository)
    {
        $this->reportContactRepository = $reportContactRepository;
    }

    /**
     * List of report contacts.
     * @param int $reportId
     */
    public function list(int $reportId)
    {
        return ReportContactResource::collection(
            $this->reportContactRepository->list($reportId)
        );
    }

    /**
     * create report contact.
     * @param array $data
     */
    public function create(array $data)
    {
        $contact = $this->reportContactRepository->create($data);
        return new ReportContactResource($contact);
    }

    /**
     * Update report contact.
     * @param array $data
     */
    public function update(int $id, array $data)
    {
        $contact = $this->reportContactRepository->findById($id);

        if (!$contact) {
            throw new \Exception('Report contact not found.');
        }

        $contact = $this->reportContactRepository->update($id, $data);
        return new ReportContactResource($contact);
    }

    /**
     * Update report contact.
     * @param int $id
     */
    public function delete(int $id): void
    {
        $contact = $this->reportContactRepository->findById($id);

        if (!$contact) {
            throw new \Exception('Report contact not found.');
        }

        $this->reportContactRepository->delete($id);
    }
}
