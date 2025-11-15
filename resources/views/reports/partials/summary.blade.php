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

<div class="container page-break">
    <!-- Title -->
    <h1 class="page-title">SUMMARY</h1>

    <!-- Statistics Cards -->
    <div class="stats-section">
        <div class="stat-card">
            <div class="stat-circle maintenance">4</div>
            <p class="stat-label">MAINTENANCE ITEMS</p>
        </div>
        <div class="stat-card">
            <div class="stat-circle recommendations">6</div>
            <p class="stat-label">RECOMMENDATIONS</p>
        </div>
        <div class="stat-card">
            <div class="stat-circle defects">13</div>
            <p class="stat-label">DEFECTS/SAFETY</p>
        </div>
    </div>

    <!-- Summary Content -->
    <div class="summary-content">
        <h2>SUMMARY</h2>

        <div class="summary-item">
            <h3 class="summary-heading maintenance">1) Maintenance Items</h3>
            <p>Primarily comprised of maintenance items. These observations are not unimportant and should be addressed, however, some of them can be addressed as a DIY. These items can either be used in negotiation prior to closing or as a do list for addressing later.</p>
        </div>

        <div class="summary-item">
            <h3 class="summary-heading recommendations">2) Recommendations</h3>
            <p>Most items typically fall into this category. These observations usually require a qualified contractor to evaluate further, in order to determine if repairs or replacements are necessary. Also included in this category are mechanical and structural systems that are nearing the end of their useful life but are still working. Items in this category may or may not enter into negotiations. Please consult your real estate agent.</p>
        </div>

        <div class="summary-item">
            <h3 class="summary-heading defects">3) Defects</h3>
            <p>This category is composed of "material defects" (as defined by the state of Pennsylvania). These defects normally enter into the negotiation phase of the home sale. They consist of systems, structures, or components that are broken, not working as intended, not installed properly, of immediate safety concern, or have a significant adverse impact on the value of the property. These items should be addressed by a qualified contractor as soon as possible.</p>
        </div>
    </div>
</div>