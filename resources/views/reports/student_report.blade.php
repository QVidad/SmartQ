<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Performance Report</title>
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
        h1, h2, h3 {
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
        <h1>Student Performance Report</h1>
        <h2>{{ $student->name }}</h2>

        <table>
            <thead>
                <tr>
                    <th>Topic</th>
                    <th>Subtopic</th>
                    <th>Score</th>
                    <th>Maximum Score</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topics as $topic)
                    <tr>
                        <td rowspan="{{ count($topic['subtopics']) }}">{{ $topic['name'] }}</td>
                        @foreach ($topic['subtopics'] as $index => $subtopic)
                            @if ($index > 0)
                                <tr>
                            @endif
                                <td>{{ $subtopic['name'] }}</td>
                                <td>{{ $subtopic['score'] }}</td>
                                <td>{{ $subtopic['max_score'] }}</td>
                                <td>{{ number_format(($subtopic['score'] / $subtopic['max_score']) * 100, 2) }}%</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Generated on {{ now()->format('F d, Y') }}</p>
        </div>
    </div>
</body>
</html>
