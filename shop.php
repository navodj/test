<?php
@include 'conf.php'; // Database connection

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="adminshop\styles.css">
</head>
<body>

<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '<span class="message">' . htmlspecialchars($message) . '</span>';
    }
}
?>

<div class="container">

    <?php
    $select = mysqli_query($conn, "SELECT * FROM items");
    ?>
    <div class="product-display">
        <table class="product-display-table">
            <thead>
            <tr>
                <th>Item Image</th>
                <th>Item Name</th>
                <th>Item Price</th>
            </tr>
            </thead>
            <?php while ($row = mysqli_fetch_assoc($select)) { ?>
            <tr>
            <td>
  <img src="../adminshop/Uploads/<?php echo htmlspecialchars($row['image']); ?>" height="100" alt="name">
</td>

                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>$<?php echo htmlspecialchars($row['price']); ?>/-</td>

            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>
