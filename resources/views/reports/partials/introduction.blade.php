<style>
    /* Header Styling */
    .introduction-header {
        position: relative;
        overflow: hidden;
        padding: 50px 35px;
        background: #fbf8f8;
        border-bottom: 1px solid #e9e9e9;
    }

    /** .header-diagonal-bg {
        position: absolute;
        top: -150px;
        left: -100px;
        width: 500px;
        height: 500px;
        transform: rotate(45deg);
        z-index: 1;
    } **/

    .header-accent {
        position: absolute;
        bottom: -130px;
        right: -100px;
        width: 450px;
        height: 450px;
        background: linear-gradient(135deg, #06a8d8 50% 0%, #6ab8ff 100%);
        transform: rotate(45deg);
        z-index: 1;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .header-left .report-type {
        display: flex;
        flex-direction: column;
        border-top: 1px solid #e9e9e9;
        margin-top: 5px;
        padding-top: 10px;
    }

    .header-left .report-type-main {
        font-size: 18px;
        font-weight: 700;
        color: #515151;
        letter-spacing: 1px;
        text-transform: capitalize;
    }

    .header-left .report-type-sub {
        font-size: 14px;
        color: #6d6d6d;
        font-weight: 300;
        letter-spacing: 1px;
    }

    .header-right {
        text-align: center;
    }

    .header-right svg {
        stroke: #fff;
    }

    .headline {
        font-size: 25px;
        font-weight: 700;
        color: #ffffffff;
        margin-bottom: 5px;
        letter-spacing: 1px;
    }

    .headline-sub {
        font-size: 14px;
        color: #ffffffff;
        letter-spacing: 1px;
    }

    .content {
        padding: 80px 0px 60px;
    }

    .details-row{
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin-top: 100px;
    }

    .details-section {
        margin-bottom: 50px;
    }

    .section-header {
        margin-bottom: 40px;
    }

    .section-header h2 {
        font-size: 20px;
        font-weight: 700;
        color: #003d7a;
        margin-bottom: 10px;
    }

    .section-line {
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #0066cc 0%, #004a99 100%);
        border-radius: 2px;
    }

    .client-details .client-detail-item{
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .client-details .client-detail-item svg,
    .agent-details .agent-detail-item svg,
    .property-details .property-detail-item svg{
        background: #18afe8;
        stroke: #ffffff;
        width: 40px;
        height: 40px;
        padding: 5px;
        border-radius: 5px;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .details-flex {
        display: flex;
        justify-content: space-between;
    }

    .agent-detail-item,
    .property-detail-item {
        padding: 25px 20px;
        background-color: #f9fafb;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .detail-item.full-width {
        grid-column: 1 / -1;
    }

    .detail-item label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 500;
        color: #7a7a7a;
        line-height: 1.6;
    }

    /* Footer Styling */
    .introduction-footer {
        padding: 30px 40px;
        background-color: #fafafa;
        text-align: center;
        border-top: 1px solid #e0e8f5;
        border-bottom: 1px solid #e0e8f5;
        margin-top: 10px;
    }

    .introduction-footer p {
        font-size: 14px;
        color: #666;
    }

    .introduction-footer .footer-website{
        display: block;
        text-decoration: none;
        color: #242424;
        font-weight: 500;
        margin-top: 7px;
        font-size: 12px;
    }

</style>


<div class="introduction-container page-break">
    <!-- Header with Geometric Design -->
    <div class="introduction-header">
        <div class="header-diagonal-bg"></div>
        <div class="header-content">
            <div class="header-left">
                <img src="{{ image_to_base64('images/Inspexly_logo.jpg') }}" width="200" alt="Inspexly Logo" style="display: inline-block; margin-bottom: 10px">
                <div class="report-type">
                    <span class="report-type-sub">Report Type</span>
                    <span class="report-type-main">{{$report->type}}</span>
                </div>
            </div>
            <div class="header-right">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16v16H4z" />
                    <line x1="8" y1="8" x2="16" y2="8" />
                    <line x1="8" y1="12" x2="16" y2="12" />
                    <line x1="8" y1="16" x2="12" y2="16" />
                </svg>
                <h1 class="headline">Property Inspection Report</h1>
                <p class="headline-sub">Report Date: {{ \Carbon\Carbon::parse($report->report_date)->format('M, d Y') }}</p>
            </div>
        </div>
        <div class="header-accent"></div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Client Details Section -->
        <div class="details-section client-details">
            <div class="section-header">
                <h2>Owner/Tenant/Client Information</h2>
                <div class="section-line"></div>
            </div>
            <div class="details-flex">
                <div class="client-detail-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="4"></circle>
                        <path d="M6 20c0-3.3 2.7-6 6-6s6 2.7 6 6"></path>
                    </svg>
                    <div class="text-detail-item">
                        <label>Full Name</label>
                        <p class="detail-value">{{$report->property?->client?->name ?? 'N/A'}}</p>
                    </div>
                </div>
            
                <div class="client-detail-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="5" width="18" height="14" rx="2" ry="2"></rect>
                        <polyline points="3,7 12,13 21,7"></polyline>
                    </svg>
                    <div class="text-detail-item">
                        <label>Email Address</label>
                        <p class="detail-value">{{$report->property?->client?->email ?? 'N/A'}}</p>
                    </div>
                </div>

                <div class="client-detail-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92V20a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3 5.18 2 2 0 0 1 5 3h3.09a1 1 0 0 1 1 .75c.12.5.28 1.02.46 1.5a1 1 0 0 1-.23 1.06l-1.38 1.38a16 16 0 0 0 6.88 6.88l1.38-1.38a1 1 0 0 1 1.06-.23c.48.18 1 .34 1.5.46a1 1 0 0 1 .75 1z"/>
                    </svg>
                    <div class="text-detail-item">
                        <label>Phone Number</label>
                        <p class="detail-value">{{$report->property?->client?->phone_number ?? 'N/A'}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="details-row">
            <!-- Report Creator Details Section -->
            <div class="details-section agent-details">
                <div class="section-header">
                    <h2>Inspector/Agent Information</h2>
                    <div class="section-line"></div>
                </div>
                <div class="details-grid">
                    <div class="agent-detail-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4"></circle>
                            <path d="M6 20c0-3.3 2.7-6 6-6s6 2.7 6 6"></path>
                        </svg>
                        <div class="agent-text-details">
                            <label>Inspector/Agent Name</label>
                            <p class="detail-value">{{$report->user->name ?? 'N/A'}}</p>
                        </div>
                    </div>

                    <div class="agent-detail-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="5" width="18" height="14" rx="2" ry="2"></rect>
                            <polyline points="3,7 12,13 21,7"></polyline>
                        </svg>
                        <div class="agent-text-details">
                            <label>Email Address</label>
                            <p class="detail-value">{{$report->user->email ?? 'N/A'}}</p>
                        </div>
                    </div>

                    <div class="agent-detail-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92V20a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3 5.18 2 2 0 0 1 5 3h3.09a1 1 0 0 1 1 .75c.12.5.28 1.02.46 1.5a1 1 0 0 1-.23 1.06l-1.38 1.38a16 16 0 0 0 6.88 6.88l1.38-1.38a1 1 0 0 1 1.06-.23c.48.18 1 .34 1.5.46a1 1 0 0 1 .75 1z"/>
                        </svg>
                        <div class="agent-text-details">
                            <label>Phone Number</label>
                            <p class="detail-value">{{$report->user->phone_number ?? 'N/A'}}</p>
                        </div>
                    </div>
            
                </div>
            </div>

            <!-- Images Section -->
            <div class="details-section">
                <div class="intro-image">
                    <img src="{{ image_to_base64('images/report_3.jpg') }}" width="400" height="100%" alt="Report Image">
                </div>
            </div>

            <!-- Property Details Section -->
            <div class="details-section property-details">
                <div class="section-header">
                    <h2>Property Information</h2>
                    <div class="section-line"></div>
                </div>
                <div class="details-grid">
                    <div class="property-detail-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                        <path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/>
                        <path d="M9 21V12h6v9"/>
                        </svg>
                        @php 
                            $address = [$report->property?->address, $report->property?->address_2, $report->property?->city, $report->property?->state, $report->property?->country, $report->property?->postal_code];
                            $formated_address = array_filter($address, fn($value) => !empty($value));
                        @endphp
                        <div class="property-text-details">
                            <label>Property Address</label>
                            <p class="detail-value">{{implode(', ', $formated_address)}}</p>
                        </div>
                    </div>

                    <div class="property-detail-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L3 13V3h10l7.59 7.59a2 2 0 0 1 0 2.82z"/>
                            <circle cx="7.5" cy="7.5" r="1.5"/>
                        </svg>

                        <div class="property-text-details">
                            <label>Property Type</label>
                            <p class="detail-value" style="text-transform: capitalize">{{$report->property?->type ?? 'N/A'}}</p>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>

    @php
        function image_to_base64($path)
        {
            $fullPath = public_path($path);

            if (!file_exists($fullPath)) {
                return null;
            }

            $mime = mime_content_type($fullPath);
            $data = base64_encode(file_get_contents($fullPath));

            return "data:$mime;base64,$data";
        }
    @endphp

    <!-- Footer -->
    <div class="introduction-footer">
        <p>Report Created with Inspexly | All rights are reserved</p>
        <img src="{{ image_to_base64('images/Inspexly_logo.jpg') }}" width="150" alt="Inspexly Logo" style="display: inline-block; margin-top: 20px">
        <a href="https://www.inspexly.com" class="footer-website">https://www.inspexly.com</a>
    </div>
</div>