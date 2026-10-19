<?php
session_start();
require_once 'config/db.php';
require_once 'classes/function.php';
$error = '';
$success = '';
$product = null;

$cat_stmt = $pdo->query("SELECT id, category_name FROM categories");
$categories = $cat_stmt->fetchAll();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if (!$product) {
        header("Location: dashboard.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p_name = trim($_POST['product_name'] ?? '');
    $p_desc = trim($_POST['description'] ?? '');
    $p_price = $_POST['price'] ?? 0;
    $p_qty = $_POST['quantity'] ?? 0;
    $p_cat = !empty($_POST['category_id']) ? $_POST['category_id'] : null;

    if (empty($p_name) || empty($p_price) || empty($p_qty)) {
        $error = "Product name, price, and quantity are required!";
    } else {
       $update= new DB_con();
       $sql=$update-> update_pro($p_name,$p_desc,$p_price,$p_qty,$p_cat,$id);
        if ($sql) {
            $success = "Product updated successfully!";
            $product['product_name'] = $p_name;
            $product['description'] = $p_desc;
            $product['price'] = $p_price;
            $product['quantity'] = $p_qty;
            $product['category_id'] = $p_cat;
        } else {
            $error = "Something went wrong.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="users-container" style="max-width: 500px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <h2>Edit Product</h2>

    <?php if (!empty($error)): ?>
        <div style="color: red; background: #ffe6e6; padding: 10px; margin-bottom: 15px; border-radius: 4px;"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div style="color: green; background: #e6ffed; padding: 10px; margin-bottom: 15px; border-radius: 4px;"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($product): ?>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        
        <label>Product Name:</label>
        <input type="text" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required style="width: 100%; padding: 8px; margin: 5px 0 15px 0;">
        
       
        <label>Category:</label>
        <select name="category_id" style="width: 100%; padding: 8px; margin: 5px 0 15px 0;">
            <option value="">Select Category</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo $cat['id']; ?>" <?php echo ($product['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['category_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Description:</label>
        <textarea name="description" style="width: 100%; padding: 8px; margin: 5px 0 15px 0;"><?php echo htmlspecialchars($product['description']); ?></textarea>
        
        <label>Price ($):</label>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required style="width: 100%; padding: 8px; margin: 5px 0 15px 0;">
        
        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required style="width: 100%; padding: 8px; margin: 5px 0 15px 0;">
        
        <button type="submit" style="background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">Update Product</button>
    </form>
    <?php endif; ?>

    <br>
    <a href="dashboard.php" style="color: #007BFF; text-decoration: none;">← Back to Dashboard</a>
</div>

</body>
</html>