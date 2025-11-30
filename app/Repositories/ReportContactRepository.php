<?php

namespace App\Repositories;

use App\Repositories\Contracts\ReportContactRepository as ReportContactRepositoryContract;
use App\Models\ReportContact;

class ReportContactRepository implements ReportContactRepositoryContract
{
    /**
     * List of report contacts.
     *
     * @param int $reportId
     * @return \App\Models\ReportContact $media
     */
    public function list(int $reportId)
    {
        return ReportContact::where('report_id', $reportId)->get();
    }

    /**
     * Create report contact.
     *
     * @param array $data
     * @return \App\Models\ReportContact
     */
    public function create(array $data)
    {
        return ReportContact::create($data);
    }

    /**
     * Update report contact.
     *
     * @param int $reportId
     * @return \App\Models\ReportContact
     */
    public function update(int $id, array $data)
    {
        $contact = ReportContact::findOrFail($id);
        $contact->update($data);
        return $contact;
    }

    /**
     * Delete report contact.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        ReportContact::findOrFail($id)->delete();
    }

    /**
     * Find report contact by Id.
     *
     * @param int $id
     * @return \App\Models\ReportContact
     */
    public function findById(int $id)
    {
        return ReportContact::findOrFail($id);
    }
}
