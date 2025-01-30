<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Times Table</title>
</head>
<body>
    <h1>Times Table Generator</h1>
    <form method="get">
        <label for="n">Enter a number: </label>
        <input type="number" name="n" id="n">
        <input type="submit" value="Generate Times Table">
    </form>
    
    <?php
    if (isset($_GET['n'])) {
        $n = $_GET['n'];
        echo "<h2>Times Table for $n</h2>";
        echo "<ul>";
        for ($i = 1; $i <= 12; $i++) {
            $result = $i * $n;
            echo "<li>$i x $n = $result</li>";
        }
        echo "</ul>";
    } else {
        echo "Please provide a value for 'n' in the form above.";
    }
    ?>
</body>
</html>
