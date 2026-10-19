<?php
session_start();
require_once 'config/db.php';
$username = $_SESSION['username'] ?? 'Admin';
$error = '';
$prod_error = '';


if (isset($_GET['delete_product_id'])) {
    $del_p_id = $_GET['delete_product_id'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$del_p_id]);
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_user_submit'])) {
    $name = trim($_POST['addname'] ?? '');
    $email = trim($_POST['addemail'] ?? '');
    $pass = trim($_POST['addpass'] ?? '');

    if (empty($name) || empty($email) || empty($pass)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address!";
    } else {
        $check = $pdo->prepare("SELECT id FROM person WHERE email = ?");
        $check->execute([$email]);
        if ($check->rowCount() > 0) {
            $error = "Email is already registered. Please use another one.";
        } else {
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $insertStmt = $pdo->prepare("INSERT INTO person (name, email, password) VALUES (?, ?, ?)");
            if ($insertStmt->execute([$name, $email, $hashed_password])) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $error = "Something went wrong, please try again later.";
            }
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_product_submit'])) {
    $p_name = trim($_POST['product_name'] ?? '');
    $p_desc = trim($_POST['description'] ?? '');
    $p_price = $_POST['price'] ?? 0;
    $p_qty = $_POST['quantity'] ?? 0;
    $p_cat = !empty($_POST['category_id']) ? $_POST['category_id'] : null;

    if (empty($p_name) || empty($p_price) || empty($p_qty)) {
        $prod_error = "Product name, price, and quantity are required!";
    } else {
        $insertProd = $pdo->prepare("INSERT INTO products (product_name, description, price, quantity, category_id, created_date) VALUES (?, ?, ?, ?, ?, NOW())");
        if ($insertProd->execute([$p_name, $p_desc, $p_price, $p_qty, $p_cat])) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $prod_error = "Failed to add product.";
        }
    }
}


$users_stmt = $pdo->query("SELECT id, name, email FROM person");
$users = $users_stmt->fetchAll();


$cat_stmt=$pdo->query("SELECT id ,category_name FROM CATEGORIES");
$categories=$cat_stmt->fetchAll();

try {
    $prod_stmt = $pdo->query("
        SELECT p.id, p.product_name, p.description, p.price, p.quantity, p.created_date, c.category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id
    ");
    $products = $prod_stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
}

$total_users = count($users);
$total_products = count($products);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="users-container" style="max-width: 1000px; margin: 30px auto; padding: 20px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 15px;">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <div>
            <a href="logout.php" style="color: red; font-weight: bold; text-decoration: none;">Logout</a>
        </div>
    </div>

    <div style="display: flex; gap: 20px; margin-bottom: 30px;">
        <div style="background: #f8f9fa; border: 1px solid #ddd; padding: 15px; border-radius: 5px; flex: 1; text-align: center;">
            Total Users
            <span style="font-size: 22px; font-weight: bold; color: #007BFF; display: block; margin-top: 5px;"><?php echo $total_users; ?></span>
        </div>
        <div style="background: #f8f9fa; border: 1px solid #ddd; padding: 15px; border-radius: 5px; flex: 1; text-align: center;">
            Total Products
            <span style="font-size: 22px; font-weight: bold; color: #28a745; display: block; margin-top: 5px;"><?php echo $total_products; ?></span>
        </div>
    </div>

    <div style="margin-bottom: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3>Users Management</h3>
            <button type="button" class="btn btn--primary" id="user-add-btn" style="background: #007BFF; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">+ Add User</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $user['id']; ?>" style="color: blue; text-decoration: none;">Edit</a> | 
                            <button type="button" onclick="if(confirm('Are you sure you want to delete this user?')) { window.location.href='?delete_user_id=<?php echo $user['id']; ?>'; }" style="color: red; background-color: white; border: none; cursor: pointer;">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h2>Product Management</h2>
            <button type="button" class="btn btn--primary" id="prod-add-btn" style="background: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">+ Add Product</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Describtion</th>
                    <th>Price</th>
                    <th>quantity</th>
                    <th>created date</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product) :?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($product['category_name'] ?? 'Uncategorized'); ?></td>
                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                        <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                        <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($product['created_date']); ?></td>
                        <td>
                            <button type="button" onclick="if(confirm('Are you sure you want to delete this product?')) { window.location.href='?delete_product_id=<?php echo $product['id']; ?>'; }" style="color: red; background-color: white; border: none; cursor: pointer;">Delete</button>
                        </td>
                        <td><a href="update_product.php?id=<?php echo $product['id']; ?>" style="color: blue; text-decoration: none;">Edit</a></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<dialog id="user-dialog" style="padding: 20px; border-radius: 8px; border: 1px solid #ccc; width: 400px;">
    <form method="post" novalidate>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h2>Add User</h2>
            <button type="button" id="user-close" style="background: none; border: none; font-size: 18px; cursor: pointer;">✕</button>
        </div>

        <?php if (!empty($error) && isset($_POST['add_user_submit'])): ?>
            <div style="color: red; margin-bottom: 10px;"><?php echo $error; ?></div>
        <?php endif; ?>

        <label>Username:</label>
        <input type="text" name="addname" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
                
        <label>Email Address:</label>
        <input type="email" name="addemail" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
                
        <label>Password:</label>
        <input type="password" name="addpass" required style="width: 100%; padding: 8px; margin-bottom: 15px;">
        
        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" id="user-cancel" style="padding: 8px 15px; cursor: pointer;">Cancel</button>
            <button type="submit" name="add_user_submit" style="background: #007BFF; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer;">Save User</button>
        </div>
    </form>
</dialog>

<dialog id="prod-dialog" style="padding: 20px; border-radius: 8px; border: 1px solid #ccc; width: 400px;">
    <form method="post" novalidate>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h2>Add Product</h2>
            <button type="button" id="prod-close" style="background: none; border: none; font-size: 18px; cursor: pointer;">✕</button>
        </div>

        <?php if (!empty($prod_error)): ?>
            <div style="color: red; margin-bottom: 10px;"><?php echo $prod_error; ?></div>
        <?php endif; ?>

        <label>Product Name:</label>
        <input type="text" name="product_name" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
        
        <label>Category:</label>
        <select name="category_id" style="width: 100%; padding: 8px; margin-bottom: 10px;">
         <option value=""> Select categorie</option>
         <?php foreach($categories as $cat) :?>
         <option value="<?php echo $cat['id'] ;?>"><?php echo htmlspecialchars($cat['category_name']); ?></option>
        <?php endforeach ;?>
        </select>

        <label>Description:</label>
        <textarea name="description" style="width: 100%; padding: 8px; margin-bottom: 10px;"></textarea>
        
        <label>Price ($):</label>
        <input type="number" step="0.01" name="price" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
        
        <label>Quantity:</label>
        <input type="number" name="quantity" required style="width: 100%; padding: 8px; margin-bottom: 15px;">
        
        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" id="prod-cancel" style="padding: 8px 15px; cursor: pointer;">Cancel</button>
            <button type="submit" name="add_product_submit" style="background: #28a745; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer;">Save Product</button>
        </div>
    </form>
</dialog>

<script>
    const userDialog = document.getElementById('user-dialog');
    document.getElementById('user-add-btn').addEventListener('click', () => userDialog.showModal());
    document.getElementById('user-close').addEventListener('click', () => userDialog.close());
    document.getElementById('user-cancel').addEventListener('click', () => userDialog.close());

    const prodDialog = document.getElementById('prod-dialog');
    document.getElementById('prod-add-btn').addEventListener('click', () => prodDialog.showModal());
    document.getElementById('prod-close').addEventListener('click', () => prodDialog.close());
    document.getElementById('prod-cancel').addEventListener('click', () => prodDialog.close());

    <?php if (!empty($error) && isset($_POST['add_user_submit'])): ?>
        userDialog.showModal();
    <?php endif; ?>

    <?php if (!empty($prod_error)): ?>
        prodDialog.showModal();
    <?php endif; ?>
</script>
</body>
</html>