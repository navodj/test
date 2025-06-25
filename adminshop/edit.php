<?php
@include 'conf.php'; // Database connection

$id = $_GET['id'];

if (isset($_POST['update_item'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploads/' . $image;

    if (empty($name) || empty($price)) {
        $message[] = 'Please fill out all fields!';
    } else {
        if (!empty($image)) {
            // If a new image is uploaded, validate it
            $image_ext = pathinfo($image, PATHINFO_EXTENSION);
            $allowed_ext = ['jpg', 'jpeg', 'png'];
            if (!in_array($image_ext, $allowed_ext)) {
                $message[] = 'Invalid image format. Please upload JPG, JPEG, or PNG.';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                // Update the image in the database
                $update_data = "UPDATE items SET name='$name', price='$price', image='$image' WHERE itemId = '$id'";
            }
        } else {
            // If no new image, retain the current one
            $update_data = "UPDATE items SET name='$name', price='$price' WHERE itemId = '$id'";
        }

        $upload = mysqli_query($conn, $update_data);
        if ($upload) {
            header('location:shop.php'); // Redirect to shop/admin page
        } else {
            $message[] = 'Error updating item!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link rel="stylesheet" href="styles.css">
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
    <div class="admin-product-form-container centered">

        <?php
        $select = mysqli_query($conn, "SELECT * FROM items WHERE itemId = '$id'");
        while ($row = mysqli_fetch_assoc($select)) {
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <h3>Update Item</h3>
            <input type="text" class="box" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" placeholder="Enter the item name">
            <input type="number" min="0" class="box" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" placeholder="Enter the item price">
            <input type="file" class="box" name="image" accept="image/png, image/jpeg, image/jpg">
            <input type="submit" value="Update Item" name="update_item" class="btn">
            <a href="shop.php" class="btn">Go Back</a>
        </form>

        <?php } ?>

    </div>
</div>

</body>
</html>
