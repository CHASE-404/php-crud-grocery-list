<?php
include 'db_con.php';
$sql = "SELECT prod_id, prod_name, prod_quant, prod_price FROM products";
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Grocery List</h1>
        </header>
        <div class="content">
            <div class="list">
                <div class="header">
                    <span>Name</span>
                    <span>Quantity</span>
                    <span>Estimated Price</span>
                </div>
                <div class="divider"></div>
                <div id="productRows">
                    <?php foreach ($products as $product): ?>
                        <div class="row">
                            <input type="text" value="<?php echo $product['prod_name']; ?>" readonly>
                            <input type="text" value="<?php echo $product['prod_quant']; ?>" readonly>
                            <input type="text" value="<?php echo $product['prod_price']; ?>" readonly>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="total">
                    <span>Total Price:</span>
                    <?php
                    $totalPrice = array_sum(array_column($products, 'prod_price'));
                    ?>
                    <input type="text" id="totalPrice" value="<?php echo number_format($totalPrice, 2); ?>" readonly>
                </div>
            </div>
            <div class="buttons">
                <!-- Add button to open add modal -->
                <button type="button" class="add" onclick="document.getElementById('addModal').style.display='block'">ADD</button>
                <!-- Update button to open update modal -->
                <button type="button" class="update" onclick="document.getElementById('updateModal').style.display='block'">UPDATE</button>
                <!-- Delete button to open delete modal -->
                <button type="button" class="delete" onclick="document.getElementById('deleteModal').style.display='block'">DELETE</button>
            </div>
        </div>
    </div>

    <!-- Modal for adding a new product -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('addModal').style.display='none'">&times;</span>
            <form action="add.php" method="POST">
                <label for="prod_name">Product Name:</label>
                <input type="text" id="prod_name" name="prod_name" required><br><br>

                <label for="prod_quant">Quantity:</label>
                <input type="number" id="prod_quant" name="prod_quant" required><br><br>

                <label for="prod_price">Estimated Price:</label>
                <input type="text" id="prod_price" name="prod_price" required><br><br>

                <div class="modal-buttons">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for updating a product -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('updateModal').style.display='none'">&times;</span>
            <form action="update.php" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Estimated Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <input type="hidden" name="prod_id[]" value="<?php echo $product['prod_id']; ?>">
                                <td><input type="text" name="prod_name[]" value="<?php echo $product['prod_name']; ?>"></td>
                                <td><input type="number" name="prod_quant[]" value="<?php echo $product['prod_quant']; ?>"></td>
                                <td><input type="text" name="prod_price[]" value="<?php echo $product['prod_price']; ?>"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="modal-buttons">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for deleting products -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('deleteModal').style.display='none'">&times;</span>
            <form action="delete.php" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><input type="checkbox" name="prod_id[]" value="<?php echo $product['prod_id']; ?>"></td>
                                <td><?php echo $product['prod_name']; ?></td>
                                <td><?php echo $product['prod_quant']; ?></td>
                                <td><?php echo $product['prod_price']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="confirm-delete">
                    <input type="submit" value="Delete">
                    <button type="button" onclick="document.getElementById('deleteModal').style.display='none'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>