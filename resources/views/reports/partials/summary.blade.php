<style>
    /* Statistics Section */
    .stats-section {
        display: flex;
        justify-content: space-around;
        align-items: center;
        gap: 40px;
        margin: 40px 0;
        padding: 30px 0;
        border-bottom: 1px solid #ddd;
    }

    .stat-card {
        text-align: center;
        flex: 1;
    }

    .stat-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: bold;
        color: white;
        margin: 0 auto 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .stat-circle.maintenance {
        background-color: #4a7ba7;
    }

    .stat-circle.recommendations {
        background-color: #ff9800;
    }

    .stat-circle.defects {
        background-color: #ef5350;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 1px;
        color: #555;
        text-transform: uppercase;
    }

    /* Summary Content */
    .summary-content {
        margin-top: 30px;
    }

    .summary-content > h2 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 25px;
        color: #333;
    }

    .summary-item {
        margin-bottom: 25px;
    }

    .summary-heading {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 10px;
        padding-bottom: 8px;
    }

    .summary-heading.maintenance {
        color: #4a7ba7;
        border-bottom: 2px solid #4a7ba7;
    }

    .summary-heading.recommendations {
        color: #ff9800;
        border-bottom: 2px solid #ff9800;
    }

    .summary-heading.defects {
        color: #ef5350;
        border-bottom: 2px solid #ef5350;
    }

    .summary-item p {
        font-size: 14px;
        color: #666;
        line-height: 1.7;
        text-align: justify;
    }
</style>

<div class="report-page-container page-break">
    <!-- Title -->
    <h1 class="page-title">SUMMARY</h1>
</div>