<?php
include 'db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prod_ids = $_POST['prod_id'];
    $prod_names = $_POST['prod_name'];
    $prod_quants = $_POST['prod_quant'];
    $prod_prices = $_POST['prod_price'];

    for ($i = 0; $i < count($prod_ids); $i++) {
        $prod_id = $prod_ids[$i];
        $prod_name = $prod_names[$i];
        $prod_quant = $prod_quants[$i];
        $prod_price = $prod_prices[$i];

        // Update product in database
        $sql = "UPDATE products SET prod_name='$prod_name', prod_quant='$prod_quant', prod_price='$prod_price' WHERE prod_id='$prod_id'";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    /*after the action is done, the page directs to index page*/
    header('Location: index.php');
    exit;
}

$conn->close();
?>
