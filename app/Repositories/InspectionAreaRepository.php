<?php

namespace App\Repositories;

use App\Models\{ InspectionArea, InspectionAreaItem, InspectionAreaItemPivot };
use App\Resources\{ InspectionAreaResource, InspectionAreaItemResource };
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InspectionAreaRepository implements \App\Repositories\Contracts\InspectionAreaRepository
{
    /**
     * List of inspection areas
     *
     * @param \Illuminate\Http\Resources\Json\AnonymousResourceCollection AnonymousResourceCollection
     * @return void
     */
    public function listInspectionAreas(int $perPage = 10): AnonymousResourceCollection
    {
        $columnQuery = request()->input('columnQuery');
        $columnName = request()->input('columnName');

        $query = InspectionArea::with('items')
            ->where('realtor_id', auth()->id())
            ->orWhere('is_default', true)
            ->orderBy('is_default', 'ASC');

        if ($columnName && $columnQuery) {
            if (str_contains($columnName, '.')) {      // search query on relation
                [$relation, $column] = explode('.', $columnName);

                $query->whereHas($relation, function ($q) use ($column, $columnQuery) {
                    $q->where($column, 'LIKE', "%{$columnQuery}%");
                });
            } else {
                $query->where($columnName, 'LIKE', "%{$columnQuery}%");
            }
        }

        // Todo: make trait/helper for getting boolean from request safely
        $paginate = filter_var(
            is_string($v = request()->input('paginate', true)) ? trim($v, "\"'") : $v,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        ) ?? true;

        if (!$paginate) {
            $items = $query->get();
        } else{
            $items = $query->paginate(request()->input('perPage') ?? $perPage);
        }

        return InspectionAreaResource::collection($items);
    }

    /**
     * List of inspection areas items
     *
     * @param \Illuminate\Http\Resources\Json\AnonymousResourceCollection AnonymousResourceCollection
     * @return void
     */
    public function listInspectionAreaItems(): AnonymousResourceCollection
    {
        $items = InspectionAreaItem::where('is_default', true)
            ->latest()
            ->get();
        
        return InspectionAreaItemResource::collection($items);
    }
    
    /**
     * Add inspection area.
     *
     * @param array $data
     * @return \App\Models\InspectionArea
     */

    public function addInspectionArea(array $data): InspectionArea
    {
        $area = InspectionArea::create([
            'name' => $data['name'],
            'is_default' => false,
            'realtor_id' => auth()->id()
        ]);

        foreach ($data['items'] as $key => $item) {
            InspectionAreaItemPivot::create([
                'area_id' => $area->id,
                'item_id' => $item,
            ]);
        }

        return $area;
    }
}
