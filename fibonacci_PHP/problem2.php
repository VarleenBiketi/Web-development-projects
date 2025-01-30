<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Office Hours</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Office Hours</h1>
    <table>
        <tr>
            <th>Day</th>
            <th>Hours</th>
        </tr>
        <?php
        $officeHours = array(
            "Monday" => "9am - 5pm",
            "Tuesday" => "9am - 5pm",
            "Wednesday" => "9am - 5pm",
            "Thursday" => "9am - 5pm",
            "Friday" => "9am - 4pm"
        );

        foreach ($officeHours as $day => $hours) {
            echo "<tr><td>$day</td><td>$hours</td></tr>";
        }
        ?>
    </table>
</body>
</html>
