<style>
    /* Table of Contents Content */
    .toc-content {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .toc-item {
        display: grid;
        grid-template-columns: 30px 1fr 30px;
        gap: 15px;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px dotted #eeebeb;
        font-size: 14px;
        color: #555;
        line-height: 1.5;
    }

    .toc-item-last {
        border-bottom: none;
    }

    .toc-number {
        font-weight: 600;
        color: #333;
        text-align: left;
    }

    .toc-label {
        color: #555;
        word-break: break-word;
    }

    .toc-page {
        text-align: right;
        font-weight: 500;
        color: #333;
        min-width: 30px;
    }
</style>

<div class="container page-break">
    <!-- Title -->
    <div class="page-title">TABLE OF CONTENTS</div>

    @php
        $toc_num = 0;
    @endphp
    <!-- Table of Contents Items -->
    <div class="toc-content">
        <div class="toc-item">
            <span class="toc-number">{{ ++$toc_num }}:</span>
            <span class="toc-label">Inspection Information</span>
            <span class="toc-page">5</span>
        </div>
        @if(count($report->areas) > 0)
            @foreach($report->areas as $area)
                <div class="toc-item">
                    <span class="toc-number">{{ ++$toc_num }}:</span>
                    <span class="toc-label">Area - {{$area->name}}</span>
                    <span class="toc-page">10</span>
                </div>
            @endforeach
        @endif
        
        <div class="toc-item">
            <span class="toc-number">{{ ++$toc_num }}:</span>
            <span class="toc-label">Final Checklist</span>
            <span class="toc-page">95</span>
        </div>
        <div class="toc-item toc-item-last">
            <span class="toc-number">{{ ++$toc_num }}:</span>
            <span class="toc-label">Standards of Practice</span>
            <span class="toc-page">98</span>
        </div>
    </div>
</div>