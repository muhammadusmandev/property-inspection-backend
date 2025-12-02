<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inpsection Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffffff;
            padding: 0px 12px;
        }

        /* Title */
        .page-title {
            text-align: center;
            font-size: 32px;
            font-weight: 300;
            letter-spacing: 2px;
            margin: 30px 0;
            padding-bottom: 20px;
            border-bottom: 1px solid #f3f3f3;
            color: #333;
        }

        /* page break for PDF generation */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    @include('reports.partials.introduction')
    @include('reports.partials.table_of_content')
    @include('reports.partials.areas')
    @include('reports.partials.checklist')
    @include('reports.partials.standard_practices')
</body>
</html>
