<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two Owls Cafe Order Summary</title>
</head>
<body>

<!-- Header -->
<header>
    <h1>Two Owls Cafe</h1>
    <p>Hours of Operation: Mon-Sat 8:00 AM - 8:00 PM</p>
</header>

<!-- Order Summary -->
<section>
    <h2>Order Summary</h2>
    <?php
    // Retrieve form data
    $quantities = $_POST['quantity'];
    $customerFirstName = $_POST['first_name'];
    $customerLastName = $_POST['last_name'];
    $specialInstructions = $_POST['special_instructions'];

    // Connect to the database
    $conn = new mysqli("localhost", "upijgdu1t2ffn", "52ckpu@%^v}$", "dbcxln5hiqykbe");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch ordered items from the database based on the submitted quantities
    $orderedItems = [];
    $totalCost = 0;

    foreach ($quantities as $itemId => $quantity) {
        $itemId = intval($itemId); // Make sure it's an integer to prevent SQL injection
        $itemId += 1;

        // Only process items with a quantity greater than zero
        if ($quantity > 0) {
            $sql = "SELECT * FROM menu WHERE id = $itemId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $itemName = $row['name'];
                $itemPrice = $row['price'];
                $totalItemCost = $itemPrice * $quantity;

                // Display ordered item details
                echo "<p>{$quantity}x {$itemName} - Price: {$row['price']} each - Total: $${totalItemCost}</p>";

                $orderedItems[] = [
                    'name' => $itemName,
                    'quantity' => $quantity,
                    'price' => $itemPrice,
                    'totalCost' => $totalItemCost
                ];

                $totalCost += $totalItemCost;
            }
        }
    }

    // Calculate tax (assuming 8% tax rate)
    $taxRate = 0.08;
    $taxAmount = $totalCost * $taxRate;
    $subtotal = $totalCost;
    $totalCost += $taxAmount;

    // Display order details
    echo "<h3>Order Details</h3>";
    echo "<p>Name: $customerFirstName $customerLastName</p>";
    echo "<p>Special Instructions: $specialInstructions</p>";


    // Display subtotal, tax, and total
    echo "<h3>Order Totals</h3>";
    echo "<p>Subtotal: $${subtotal}</p>";
    echo "<p>Tax (8%): $${taxAmount}</p>";
    echo "<p>Total: $${totalCost}</p>";

    // Close the database connection
    $conn->close();
    ?>
</section>
<script>
    //Handle pickup time
    var now = new Date();
    var pickupTime = new Date(now.getTime() + 20 * 60000); // Adding 20 minutes to the current time

    var hours = pickupTime.getHours();
    var minutes = pickupTime.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // Handle midnight
    minutes = minutes < 10 ? '0' + minutes : minutes;

    var pickupTimeString = hours + ':' + minutes + ' ' + ampm;
    document.write('<h3>Pickup Information</h3>');
    document.write('<p>Your order will be ready for pickup at: ' + pickupTimeString + '</p>');
</script>

</body>
</html>
