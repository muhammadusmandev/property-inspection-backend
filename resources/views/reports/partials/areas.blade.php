<style>
    .area-section {
        margin-bottom: 40px;
        text-align: center;
    }

    .area-items{
        margin-top: 20px;
        color: #535353;
        font-size: 15px;
        border-top: 1px solid #d3d3d3;
        padding: 25px 0px;
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
    }

    .area-items strong{
        color: #050505;
        font-size: 17px;
        margin-right: 100px;
    }

    .area-section .quality-flex{
        display: flex;
        gap: 100px;
        align-items: center;
        padding: 15px 0px;
        border-bottom: 1px solid #d3d3d3;
        border-top: 1px solid #d3d3d3;
        margin-bottom: 20px;
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
    }

    .area-section .quality-item{
        text-align: center;
        color: #404040;
        font-size: 15px;
    }

    .area-section .quality-grade{
        border-radius: 25px;
        color: #fff;
        text-align: center;
        padding: 6px 25px;
        margin-top: 10px;
        font-size: 13px;
        font-weight: 500;
    }

    .status-excellent {
        background-color: #2ecc71;
    }

    .status-good {
        background-color: #27ae60;
    }

    .status-fair {
        background-color: #f1c40f;
    }

    .status-poor {
        background-color: #e67e22;
    }

    .status-unacceptable {
        background-color: #e74c3c;
    }

    /* Image grid */
    .image-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px
    }

    .image-grid img {
        width: calc(33.33% - 10px);
        height: auto;
        object-fit: cover;
    }
</style>

<div class="container page-break">
    <!-- Title -->
    <h2 class="page-title">Inspection Areas</h2>
    @foreach($report->areas as $area)
        <div class="area-section">
            <h4 class="area-name">Interior Area</h4>

            @php
                $itemsString = 'N/A';

                if(isset($area->items) && count($area->items) > 0){
                    $itemsString = $area->items->pluck('name')->implode(', ');
                }
            @endphp

            <div class="area-items"><strong>Items</strong> {{ $itemsString }}</div>

            @php
                $cleanliness_status = $area->cleanliness;
                $condition_status = $area->condition;
            @endphp

            <div class="quality-flex">
                <h4>Quality</h4>
                <div class="quality-item">
                    <div class="quality-title">
                        Condition
                    </div>
                    <div class="quality-grade status-{{ $condition_status }}">
                        {{ ucfirst($condition_status) }}
                    </div>
                </div>
                <div class="quality-item">
                    <div class="quality-title">
                        Cleanliness
                    </div>
                    <div class="quality-grade status-{{ $cleanliness_status }}">
                        {{ ucfirst($cleanliness_status) }}
                    </div>
                </div>
            </div>

            <h4>Area Photos</h4>
            <!-- Image grid -->
            <div class="image-grid">
                @if(isset($area->media) && count($area->media) > 0)
                    @foreach($area->media as $media)
                        <img src="{{ asset('storage/' . $media->file_path) }}" alt="Area Image">
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
</div>