<style>
    .area-section {
        margin-bottom: 40px;
    }

    .area-section .area-name{
        margin-bottom: 40px;
    }

    .area-section .area-name span {
        font-weight: normal;
        color: #535353;
    }

    .area-section .area-name svg .area {
        fill: #005ab6;
    }

    .area-section .area-name svg .line {
        fill: none;
        stroke: steelblue;
        stroke-width: 1;
    }

    .area-items{
        margin-top: 20px;
        color: #535353;
        font-size: 15px;
        border: 1px solid #d3d3d3;
        padding: 25px 22px;
        border-left: 6px solid #06a8d8;
        margin-bottom: 15px;
        width: fit-content;
    }

    .area-items strong{
        color: #5b5b5b;
        font-size: 15px;
        margin-right: 110px;
    }

    .area-section .quality-flex{
        display: flex;
        gap: 100px;
        align-items: center;
        color: #535353;
        font-size: 15px;
        border: 1px solid #d3d3d3;
        padding: 15px 22px;
        border-left: 6px solid #06a8d8;
        margin-bottom: 20px;
        width: fit-content;
    }

    .area-section .quality-flex h4 strong{
        color: #5b5b5b;
        font-size: 15px;
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

    .area-section .area-photos-heading{
        font-size: 18px;
        font-weight: 700;
        color: #003d7a;
        margin-bottom: 10px;
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
    @php
        function image_to_base64_storage($path)
        {
            $fullPath = storage_path('app/public/' . $path);

            if (!file_exists($fullPath)) {
                return null;
            }

            $mime = mime_content_type($fullPath);
            $data = base64_encode(file_get_contents($fullPath));

            return "data:$mime;base64,$data";
        }
    @endphp
    <!-- Title -->
    <h2 class="page-title">Inspection Areas</h2>
    @foreach($report->areas as $area)
        <div class="area-section">
            <h3 class="area-name">
                 <svg width="30" height="30" viewBox="0 0 40 40">
                    <polygon class="area" points="0,40 5,30 10,28 15,20 20,25 25,15 30,18 35,10 40,40" />
                    <polyline class="line" points="0,40 5,30 10,28 15,20 20,25 25,15 30,18 35,10 40,40" />
                </svg> Area Name: <span>{{$area->name}}</span></h3>

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
                <h4><strong>Quality</strong></h4>
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

            <h4 class="area-photos-heading">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="17"
                    height="17"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                    <circle cx="8.5" cy="8.5" r="1.5" />
                    <polyline points="21 15 16 10 5 21" />
                </svg> Area Photos
            </h4>
            <div class="section-line"></div>
            <!-- Image grid -->
            <div class="image-grid">
                @if(isset($area->media) && count($area->media) > 0)
                    @foreach($area->media as $media)
                        <img src="{{ image_to_base64_storage($media->file_path) }}" alt="Area Image">
                    @endforeach
                @endif
            </div>
        </div>
        <div style="page-break-after: always;"></div>
    @endforeach
</div>