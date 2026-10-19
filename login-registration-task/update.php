<?php
session_start();
require_once 'config/db.php';

$error = '';
$success = '';
$user = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $pdo->prepare("SELECT id, name, email FROM person WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if (!$user) {
        header("Location: dashboard.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $id = $_POST['id'] ?? '';

    if (empty($name) || empty($email)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address!";
    } else {
        $check = $pdo->prepare("SELECT id FROM person WHERE email = ? AND id != ?");
        $check->execute([$email, $id]);
        
        if ($check->rowCount() > 0) {
            $error = "Email is already taken by another user.";
        } else {
            $updateStmt = $pdo->prepare("UPDATE person SET name = ?, email = ? WHERE id = ?");
            if ($updateStmt->execute([$name, $email, $id])) {
                $success = "User updated successfully!";
                $user['name'] = $name;
                $user['email'] = $email;
            } else {
                $error = "Something went wrong, please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Edit User</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="users-container" style="max-width: 500px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <h2>Edit User Information</h2>

    <?php if (!empty($error)): ?>
        <div style="color: red; background: #ffe6e6; padding: 10px; margin-bottom: 15px; border-radius: 4px;"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div style="color: green; background: #e6ffed; padding: 10px; margin-bottom: 15px; border-radius: 4px;"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($user): ?>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        
        <label for="name">Username:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required style="width: 100%; padding: 8px; margin: 5px 0 15px 0;">
        
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required style="width: 100%; padding: 8px; margin: 5px 0 15px 0;">
        
        <button type="submit" style="background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">Update User</button>
    </form>
    <?php endif; ?>

    <br>
    <a href="dashboard.php" style="color: #007BFF; text-decoration: none;">← Back to Dashboard</a>
</div>

</body>
</html>