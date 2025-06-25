<?php
@include 'conf.php'; // Database connection

if (isset($_POST['add_item'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploads/' . $image;

    if (empty($name) || empty($price) || empty($image)) {
        $message[] = 'Please fill out all fields';
    } else {
        // Image validation
        $image_ext = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_ext = ['jpg', 'jpeg', 'png'];
        if (!in_array($image_ext, $allowed_ext)) {
            $message[] = 'Invalid image format. Please upload JPG, JPEG, or PNG.';
        } else {
            $insert = "INSERT INTO items(name, price, image) VALUES('$name', '$price', '$image')";
            $upload = mysqli_query($conn, $insert);
            if ($upload) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'New item added successfully';
            } else {
                $message[] = 'Could not add the item';
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete image file along with the record
    $result = mysqli_query($conn, "SELECT image FROM items WHERE itemId = $id");
    $row = mysqli_fetch_assoc($result);
    $image_path = './Uploads/' . $row['image'];

    $delete = mysqli_query($conn, "DELETE FROM items WHERE itemId = $id");

    if ($delete && file_exists($image_path)) {
        unlink($image_path);
    }

    header('location:shop.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
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
    <div class="admin-product-form-container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
            <h3>Add a New Item</h3>
            <input type="text" placeholder="Enter item name" name="name" class="box">
            <input type="number" placeholder="Enter item price" name="price" class="box">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="image" class="box">
            <input type="submit" class="btn" name="add_item" value="Add Item">
        </form>
    </div>

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
                <th>Action</th>
            </tr>
            </thead>
            <?php while ($row = mysqli_fetch_assoc($select)) { ?>
            <tr>
                <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" height="100" alt=""></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>$<?php echo htmlspecialchars($row['price']); ?>/-</td>
                <td>
                    <a href="edit.php?id=<?php echo htmlspecialchars($row['itemId']); ?>" class="btn">Edit</a>
                    <a href="shop.php?delete=<?php echo htmlspecialchars($row['itemId']); ?>" class="btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>
