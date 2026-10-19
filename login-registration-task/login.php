
<?php
session_start();
require_once 'config/db.php';
$error = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $loginInput = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($loginInput === '' || $password === '') {
        $error = "All fields are required!";
    } else {
        $stmt = $pdo->prepare(
            "SELECT * FROM person WHERE Email = ? OR Name = ?"
        );
        $stmt->execute([$loginInput, $loginInput]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['username'] = $user['Name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid email/username or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="form-container">

        <h2>Login</h2>

        <?php if ($error !== ''): ?>
            <div class="alert-error">
                <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">

            <div class="form-group">

                <label for="email">Email or Username:</label>

                <input
                    type="text"
                    id="email"
                    name="email"
                    value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label for="password">Password:</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >

            </div>

            <button type="submit">Login</button>

        </form>

        <div class="form-link">
            Don't have an account?
            <a href="register.php">Register here</a>
        </div>

    </div>

</body>

</html>
