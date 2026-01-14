<?php

namespace App\Services;

use App\Services\Contracts\ReportInspectionAreaDefectService as ReportInspectionAreaDefectServiceContract;
use App\Repositories\Contracts\ReportInspectionAreaDefectRepository as ReportInspectionAreaDefectRepositoryContract;
use App\Models\ReportDefect;
use App\Resources\InspectionAreaDefectResource;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Auth\Access\AuthorizationException;
use \Illuminate\Http\UploadedFile;
use Storage;
use DB;

class ReportInspectionAreaDefectService implements ReportInspectionAreaDefectServiceContract
{
    protected ReportInspectionAreaDefectRepositoryContract $reportInspectionAreaDefectRepository;

    public function __construct(ReportInspectionAreaDefectRepositoryContract $reportInspectionAreaDefectRepository)
    {
        $this->reportInspectionAreaDefectRepository = $reportInspectionAreaDefectRepository;
    }

    /**
     * Add report inspection area defect.
     *
     * @param array $data
     * @return \App\Models\ReportDefect
     */
    public function addInspectionAreaDefect(array $data): ReportDefect
    {
        DB::beginTransaction();

        try {
            $defect = $this->reportInspectionAreaDefectRepository->addInspectionAreaDefect($data);

            $images = $data['images'] ?? null;

            if ($images){
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

                        $image_path = 'report_inspection_area_defects/' . $filename;
                        $thumbnail_path = 'report_inspection_area_defects/thumbnails/' . $filename;

                        Storage::disk('public')->put(
                            $image_path,
                            (string) $image->encodeByExtension($file->getClientOriginalExtension(), quality: 90) // 90% quality
                        );

                        // thumbnail
                        Storage::disk('public')->put(
                            $thumbnail_path,
                            (string) $thumbnail->encodeByExtension($file->getClientOriginalExtension(), quality: 80) // 80% quality
                        );

                        $defect->media()->create([
                            'file_path' => $image_path,
                            'original_name' => $file->getClientOriginalName(),
                            'type' => $file->getClientMimeType(),
                            'thumbnail_path' => $thumbnail_path,
                            'thumbnail_type' => $file->getClientMimeType(),
                        ]);
                    }
                }
            }

            DB::commit();

            return $defect;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Show report inspection area defect.
     *
     * @param int $id
     * @return \App\Resources\InspectionAreaDefectResource
     */
    public function showInspectionAreaDefect(int $id): InspectionAreaDefectResource
    {
        $defect = $this->reportInspectionAreaDefectRepository->findById($id);

        if (!$defect) {
            throw new \Exception('Report inspection area defect not found.');
        }

        return new InspectionAreaDefectResource($defect);
    }

    /**
     * Update report inspection area defect.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\ReportDefect
     */
    public function updateInspectionAreaDefect(int $id, array $data): ReportDefect
    {
        $defect = $this->reportInspectionAreaDefectRepository->findById($id);

        if (!$defect) {
            throw new \Exception('Report inspection area defect not found.');
        }

        if ($defect->area?->report?->user_id !== auth()->id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        DB::beginTransaction();

        try {
            $this->reportInspectionAreaDefectRepository->updateAreaDefect($defect, $data);

            $images = $data['images'] ?? null;

            if ($images){
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

                        $image_path = 'report_inspection_area_defects/' . $filename;
                        $thumbnail_path = 'report_inspection_area_defects/thumbnails/' . $filename;

                        Storage::disk('public')->put(
                            $image_path,
                            (string) $image->encodeByExtension($file->getClientOriginalExtension(), quality: 90) // 90% quality
                        );

                        // thumbnail
                        Storage::disk('public')->put(
                            $thumbnail_path,
                            (string) $thumbnail->encodeByExtension($file->getClientOriginalExtension(), quality: 80) // 80% quality
                        );

                        $defect->media()->create([
                            'file_path' => $image_path,
                            'original_name' => $file->getClientOriginalName(),
                            'type' => $file->getClientMimeType(),
                            'thumbnail_path' => $thumbnail_path,
                            'thumbnail_type' => $file->getClientMimeType(),
                        ]);
                    }
                }
            }

            DB::commit();

            return $defect;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete report inspection area defect.
     *
     * @param int $id
     * @return void
     */
    public function deleteInspectionAreaDefect(int $id): void
    {
        $defect = $this->reportInspectionAreaDefectRepository->findById($id);
        
        if (!$defect) {
            throw new \Exception('Report inspection area defect not found.');
        }

        if ($defect->area?->report?->user_id !== auth()->id()) {
            throw new AuthorizationException('Unauthorized access.');
        }

        $this->reportInspectionAreaDefectRepository->delete($defect);
    }
}
