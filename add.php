<?php 
include 'db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prod_name = $_POST['prod_name'];
    $prod_quant = $_POST['prod_quant'];
    $prod_price = $_POST['prod_price'];

    // Insert into database
    $sql = "INSERT INTO products (prod_name, prod_quant, prod_price) VALUES ('$prod_name', '$prod_quant', '$prod_price')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to index.php after successful insertion
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>