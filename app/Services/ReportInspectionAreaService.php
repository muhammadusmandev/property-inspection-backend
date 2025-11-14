<?php

namespace App\Services;

use App\Services\Contracts\ReportInspectionAreaService as ReportInspectionAreaServiceContract;
use App\Repositories\Contracts\ReportInspectionAreaRepository as ReportInspectionAreaRepositoryContract;
use App\Resources\ReportInspectionAreaResource;
use App\Models\ReportInspectionArea;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Auth\Access\AuthorizationException;
use \Illuminate\Http\UploadedFile;
use Storage;
use DB;

/**
 * Business logic layer for handling Report Inspection Area operations.
 */
class ReportInspectionAreaService implements ReportInspectionAreaServiceContract
{
    protected ReportInspectionAreaRepositoryContract $reportInspectionAreaRepository;

    public function __construct(ReportInspectionAreaRepositoryContract $reportInspectionAreaRepository)
    {
        $this->reportInspectionAreaRepository = $reportInspectionAreaRepository;
    }

    /**
     * List of report inspection areas.
     *
     * @return \Illuminate\Http\JsonResponse|AnonymousResourceCollection|null
     */
    public function listReportInspectionAreas(): ?AnonymousResourceCollection
    {
        return $this->reportInspectionAreaRepository->listReportInspectionAreas();
    }

    /**
     * Add report inspection area.
     *
     * @param array $data
     * @return \App\Models\InspectionArea
     */
    public function addReportInspectionArea(array $data): ReportInspectionArea
    {
        return DB::transaction(function () use ($data) {
            $area = $this->reportInspectionAreaRepository->addReportInspectionArea($data);
            if (!empty($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    $area->items()->create([
                        'name' => $item
                    ]);
                }
            }

            return $area->load('items');
        });
    }

    /**
     * Show report inspection area.
     *
     * @param int $id
     * @return \App\Resources\InspectionAreaResource
     */
    public function showReportInspectionArea(int $id): ReportInspectionAreaResource
    {
        $area = $this->reportInspectionAreaRepository->findById($id);
        if (!$area) {
            throw new \Exception('Report inspection area not found.');
        }
        return new ReportInspectionAreaResource($area);
    }

    /**
     * Update report inspection area.
     *
     * @param int $id
     * @param array $data
     * @return InspectionArea
     */
    public function updateReportInspectionArea(int $id, array $data): ReportInspectionArea
    {
        $area = $this->reportInspectionAreaRepository->findById($id);
        if (!$area) {
            throw new \Exception('Report inspection area not found.');
        }

        if ($area->report->user_id !== auth()->id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return DB::transaction(function () use ($area, $data) {
            $this->reportInspectionAreaRepository->update($area, $data);
            $area->items()->delete();

            if (!empty($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    $area->items()->create([
                        'name' => $item
                    ]);
                }
            }

            return $area->load('items');
        });
    }

    /**
     * Delete report inspection area.
     *
     * @param int $id
     * @return void
     */
    public function deleteReportInspectionArea(int $id): void
    {
        $area = $this->reportInspectionAreaRepository->findById($id);
        if (!$area) {
            throw new \Exception('Report inspection area not found.');
        }

        if ($area->report->user_id !== auth()->id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        $this->reportInspectionAreaRepository->delete($area);
    }

    /**
     * Store report inspection area images.
     *
     * @param array $data
     * @return void
     */
    public function storeImages(array $data): void
    {
        $area = $this->reportInspectionAreaRepository->findById($data['area_id']);
        if (!$area) {
            throw new \Exception('Report inspection area not found.');
        }

        if ($area->report->user_id !== auth()->id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        DB::beginTransaction();

        try {
            $images = $data['images'];

            if (!$images){
                throw new \Exception('Failed to upload images.');
            }

            foreach ($images as $file) {
                if ($file instanceof UploadedFile) {
                    if (!Storage::disk('public')->exists('report_inspection_areas')) {
                        Storage::disk('public')->makeDirectory('report_inspection_areas');
                    }

                    $image = Image::read($file->getRealPath());

                    $filename = uniqid() . '.' . $file->getClientOriginalExtension();

                    // Optional: create thumbnail (200x200 max)
                    $thumbnail = Image::read($file->getRealPath())
                        ->resize(200, 200, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                    $image_path = 'report_inspection_areas/' . $filename;
                    $thumbnail_path = 'report_inspection_areas/thumbnails/' . $filename;

                    Storage::disk('public')->put(
                        $image_path,
                        (string) $image->encodeByExtension($file->getClientOriginalExtension(), quality: 90) // 90% quality
                    );

                    // thumbnail
                    Storage::disk('public')->put(
                        $thumbnail_path,
                        (string) $thumbnail->encodeByExtension($file->getClientOriginalExtension(), quality: 80) // 80% quality
                    );

                    $area->media()->create([
                        'file_path' => $image_path,
                        'original_name' => $file->getClientOriginalName(),
                        'type' => $file->getClientMimeType(),
                        'thumbnail_path' => $thumbnail_path,
                        'thumbnail_type' => $file->getClientMimeType(),
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
