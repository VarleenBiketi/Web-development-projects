<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two Owls Cafe Menu</title>
</head>
<body>

<!-- Header -->
<header>
    <h1>Two Owls Cafe</h1>
    <p>Hours of Operation: Mon-Sat 8:00 AM - 8:00 PM</p>
</header>

<!-- Form Section -->
<section>

    <form action="order_process.php" method="post" onsubmit="return validateForm()">
        <!-- Menu Display -->
        <h2>Menu</h2>
        <?php
        // Connect to the database
        $conn = new mysqli("localhost", "upijgdu1t2ffn", "52ckpu@%^v}$", "dbcxln5hiqykbe");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch menu items from the database
        $sql = "SELECT * FROM menu";
        $result = $conn->query($sql);

        // Display menu items
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div>";
                echo "<h3>{$row['name']}</h3>";
                echo "<img src='{$row['image']}' alt='{$row['name']}' style='max-width: 300px;'>";
                echo "<p>{$row['description']}</p>";
                echo "<p>Price:{$row['price']}</p>";
                echo "<label for='{$row['id']}'>Quantity: </label>";
                echo "<select id='{$row['id']}' name='quantity[]'>";
                for ($i = 0; $i <= 10; $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                echo "</select>";
                echo "</div>";
            }
        } else {
            echo "No items found.";
        }

        // Close the database connection
        $conn->close();
        ?>
        <!-- End of Menu Display -->
        <h2>Order Form </h2>
         <!-- User's Name Fields -->
         <label for="first_name">First Name: </label>
        <input type="text" id="first_name" name="first_name" required><br/><br/>
        <label for="last_name">Last Name: </label>
        <input type="text" id="last_name" name="last_name" required><br/><br/>

        <!-- Special Instructions -->
        <label for="special_instructions">Special Instructions: </label><br><br/>
        <textarea id="special_instructions" name="special_instructions" rows="4" cols="50"></textarea><br/><br/>


        <button type="submit">Submit Order</button>
    </form>
</section>

<!-- JavaScript Validation -->
<script>
function validateForm() {
    // Validate item selection
    var selectedItems = document.querySelectorAll('select[name="quantity[]"]');
    var atLeastOneItem = Array.from(selectedItems).some(item => item.value !== "0");

    if (!atLeastOneItem) {
        alert("Please select at least one item.");
        return false;
    }

    // Validate customer's name
    var firstName = document.getElementById('first_name').value.trim();
    var lastName = document.getElementById('last_name').value.trim();

    if (firstName === "" || lastName === "") {
        alert("Please provide your full name.");
        return false;
    }

    // Basic validation for special instructions
    var specialInstructions = document.getElementById('special_instructions').value.trim();
    if (specialInstructions.length > 200) {
        alert("Special instructions should be 200 characters or less.");
        return false;
    }

    // Validation passed
    return true;
}
</script>

</body>
</html>
