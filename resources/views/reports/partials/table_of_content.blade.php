<style>
    /* Table of Contents Content */
    .toc-content {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .toc-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px dotted #eeebeb;
        font-size: 17px;
        color: #555;
        line-height: 1.5;
    }

    .toc-item-last {
        border-bottom: none;
    }

    .toc-number {
        color: #333;
        text-align: left;
    }

    .toc-number span {
        font-weight: 600;
    }

    .toc-label {
        text-align: right;
        color: #555;
        min-width: 30px;
    }
</style>

<div class="report-page-container page-break">
    <!-- Title -->
    <div class="page-title">TABLE OF CONTENTS</div>

    @php
        $toc_num = 0;
    @endphp
    <!-- Table of Contents Items -->
    <div class="toc-content">
        <div class="toc-item">
            <span class="toc-number">Chapter <span>({{ ++$toc_num }})</span></span>
            <span class="toc-label">Inspection Information</span>
        </div>
        @if(count($report->areas) > 0)
            @foreach($report->areas as $area)
                <div class="toc-item">
                    <span class="toc-number">Chapter <span>({{ ++$toc_num }})</span></span>
                    <span class="toc-label">Area - {{$area->name}}</span>
                </div>
            @endforeach
        @endif
        
        <div class="toc-item">
            <span class="toc-number">Chapter <span>({{ ++$toc_num }})</span></span>
            <span class="toc-label">Final Checklist</span>
        </div>
        <div class="toc-item toc-item-last">
            <span class="toc-number">Chapter <span>({{ ++$toc_num }})</span></span>
            <span class="toc-label">Standards of Practice</span>
        </div>
    </div>
</div>