<?php
include 'db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['prod_id'])) {
        $prod_ids = $_POST['prod_id'];
        foreach ($prod_ids as $prod_id) {
            $sql = "DELETE FROM products WHERE prod_id='$prod_id'";
            if (!$conn->query($sql)) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        /* Redirect to index.php after deletion */
        header('Location: index.php');
        exit;
    } else {
        echo "No products selected for deletion.";
    }
}

$conn->close();
?>
