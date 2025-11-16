<style>
    /* Legend */
    .legend-table {
        margin-bottom: 40px;
    }

    .legend-header {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        background-color: #a8c5dd;
        padding: 0;
        margin-bottom: 8px;
    }

    .legend-cell {
        padding: 12px;
        text-align: center;
        font-weight: 600;
        color: #005fa3;
        font-size: 13px;
    }

    .legend-description {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
        font-size: 12px;
        color: #666;
        text-align: center;
    }

    .legend-description span {
        padding: 8px;
        border-right: 1px solid #e0e0e0;
    }

    .legend-description span:last-child {
        border-right: none;
    }

    /* Section */
    .section {
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #005fa3;
        padding-bottom: 10px;
        border-bottom: 2px solid #005fa3;
        margin-bottom: 30px;
    }

    /* Checklist Grid */
    .checklist-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .checklist-item {
        padding: 12px;
        background-color: #fafafa;
        border-left: 3px solid #005fa3;
    }

    .question {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
        font-size: 17px;
    }

    .answer {
        color: #666;
        font-size: 19px;
    }
</style>
<div class="container page-break">
    <!-- Title -->
    <div class="page-title">CHECKLIST</div>

    <!-- Legend ---
    <div class="legend-table">
        <div class="legend-header">
            <div class="legend-cell">IN</div>
            <div class="legend-cell">NI</div>
            <div class="legend-cell">NP</div>
            <div class="legend-cell">C</div>
        </div>
        <div class="legend-description">
            <span>IN = Inspected</span>
            <span>NI = Not Inspected</span>
            <span>NP = Not Present</span>
            <span>C = Comments</span>
        </div>
    </div> -->

    <!-- Information Section -->
    <div class="section">
        <!--<h2 class="section-title">Information</h2> -->

        <div class="checklist-grid">
            @foreach($report->checklist as $item)
            <div class="checklist-item">
                <div class="question">{{$item['label']}}?</div>
                <div class="answer">{{$item['checked'] ? 'No' : 'Yes'}}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>