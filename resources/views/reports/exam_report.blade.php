<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            margin: 20px;
        }
        h1, h2 {
            text-align: center;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Exam Scores Report</h1>
        <h2>{{ $exam->exam_name }}</h2>

        <table>
            <tr>
                <th>Description</th>
                <td colspan="3">{{ $exam->description }}</td>
            </tr>
            <tr>
                <th>Start Date</th>
                <td>{{ \Carbon\Carbon::parse($exam->start_date)->format('F j, Y') }}</td>
                <th>End Date</th>
                <td>{{ \Carbon\Carbon::parse($exam->end_date)->format('F j, Y') }}</td>
            </tr>
            <tr>
                <th>Exam Type</th>
                <td>{{ $exam->exam_type == 1 ? 'Major Exam' : 'Trial' }}</td>

                <th>Number of Items</th>
                <td>{{ $exam->item_num }}</td>
            </tr>
            <tr>
                <th>Duration (Minutes)</th>
                <td>{{ $exam->duration }}</td>
                <th>Created By</th>
                <td>{{ $exam->created_by }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Generated on {{ now()->format('F d, Y') }}</p>
        </div>
    </div>
</body>
</html>
