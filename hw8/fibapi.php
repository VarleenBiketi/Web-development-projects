<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fibonacci API</title>
</head>
<body>
    <h1>Fibonacci API</h1>
    <p>This API generates a Fibonacci sequence based on the 'n' parameter in the query string.</p>
    
    <?php
    if (isset($_GET['n'])) {
        $n = $_GET['n'];

        $fibonacci = array();
        $a = 0;
        $b = 1;

        for ($i = 0; $i < $n; $i++) {
            $fibonacci[] = $a;
            $next = $a + $b;
            $a = $b;
            $b = $next;
        }

        header('Content-Type: application/json');
        echo json_encode($fibonacci);
    } else {
        echo "Please provide a value for 'n' in the query string.";
    }
    ?>
</body>
</html>
