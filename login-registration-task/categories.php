<?php
session_start();
require_once 'config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $cat_name = trim($_POST['category_name'] ?? '');
    if (empty($cat_name)) {
        $error = "Category name is required!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->execute([$cat_name]);
        header("Location: categories.php");
        exit();
    }
}

if (isset($_GET['delete_id'])) {
    $del_id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$del_id]);
    header("Location: categories.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<div style="max-width: 600px; margin: 30px auto; padding: 20px;">
    <h2>Category Management</h2>
    <a href="dashboard.php">← Back to Dashboard</a>

    <form method="POST" style="margin: 20px 0;">
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <input type="text" name="category_name" placeholder="New Category Name" required style="padding: 8px; width: 70%;">
        <button type="submit" name="add_category" style="padding: 8px 15px; background: #28a745; color: white; border: none;">Add Category</button>
    </form>
    <table border="1" width="100%" style="border-collapse: collapse; text-align: left;">
        <thead>
            <tr>
                <th style="padding: 10px;">ID</th>
                <th style="padding: 10px;">Category Name</th>
                <th style="padding: 10px;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
            <tr>
                <td style="padding: 10px;"><?php echo htmlspecialchars($cat['id']); ?></td>
                <td style="padding: 10px;"><?php echo htmlspecialchars($cat['category_name']); ?></td>
                <td style="padding: 10px;">
                    <a href="?delete_id=<?php echo $cat['id']; ?>" onclick="return confirm('Are you sure?')" style="color: red;">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>