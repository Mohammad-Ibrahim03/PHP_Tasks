<?php
session_start();
require_once 'db.php';

// Security check for session management[cite: 3]
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$action = $_GET['action'] ?? 'overview';
$section = $_GET['section'] ?? 'users';
$message = '';

// --- HANDLE USER CRUD ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_user'])) {
        $id = $_POST['user_id'] ?? '';
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (!empty($name) && !empty($email)) {
            if (empty($id)) {
                // Create User
                if (!empty($password)) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                    $stmt->execute([$name, $email, $hashedPassword]);
                    $message = "User added successfully.";
                } else {
                    $message = "Password is required for new users.";
                }
            } else {
                // Update User
                if (!empty($password)) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
                    $stmt->execute([$name, $email, $hashedPassword, $id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
                    $stmt->execute([$name, $email, $id]);
                }
                $message = "User updated successfully.";
            }
        }
    }

    // --- HANDLE PRODUCT CRUD ---
    if (isset($_POST['save_product'])) {
        $id = $_POST['product_id'] ?? '';
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        if (!empty($name) && is_numeric($price) && is_numeric($quantity)) {
            if (empty($id)) {
                // Create Product
                $stmt = $pdo->prepare("INSERT INTO products (name, description, price, quantity) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $description, $price, $quantity]);
                $message = "Product added successfully.";
            } else {
                // Update Product
                $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, quantity = ? WHERE id = ?");
                $stmt->execute([$name, $description, $price, $quantity, $id]);
                $message = "Product updated successfully.";
            }
        }
    }
}

// Handle Deletions via GET query
if (isset($_GET['delete_user'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET['delete_user']]);
    header("Location: dashboard.php?section=users");
    exit();
}

if (isset($_GET['delete_product'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete_product']]);
    header("Location: dashboard.php?section=products");
    exit();
}

// Fetch Totals and Data[cite: 2, 3]
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();

$usersStmt = $pdo->query("SELECT id, name, email, created_at FROM users");
$users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

$productsStmt = $pdo->query("SELECT * FROM products");
$products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);

// Edit lookups
$editUser = null;
if (isset($_GET['edit_user'])) {
    $stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE id = ?");
    $stmt->execute([$_GET['edit_user']]);
    $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
}

$editProduct = null;
if (isset($_GET['edit_product'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['edit_product']]);
    $editProduct = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f9; display: flex; }
        .sidebar { width: 250px; background: #343a40; color: #fff; height: 100vh; padding: 20px; box-sizing: border-box; position: fixed; }
        .sidebar h2 { font-size: 20px; color: #fff; margin-bottom: 30px; }
        .sidebar a { display: block; color: #adb5bd; text-decoration: none; padding: 10px 0; font-size: 16px; }
        .sidebar a:hover, .sidebar a.active { color: #fff; font-weight: bold; }
        .main-content { margin-left: 250px; padding: 30px; width: calc(100% - 250px); box-sizing: border-box; }
        .header { display: flex; justify-content: space-between; align-items: center; background: #fff; padding: 15px 20px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .stats-container { display: flex; gap: 20px; margin-bottom: 20px; }
        .stat-card { background: #fff; padding: 20px; border-radius: 8px; flex: 1; box-shadow: 0 0 5px rgba(0,0,0,0.05); text-align: center; }
        .stat-card h3 { margin: 0; color: #6c757d; font-size: 14px; }
        .stat-card p { font-size: 24px; font-weight: bold; margin: 10px 0 0; color: #343a40; }
        .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.05); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; border: 1px solid #dee2e6; text-align: left; }
        th { background-color: #f8f9fa; color: #343a40; }
        input, textarea { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { padding: 10px 15px; background: #007BFF; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; text-decoration: none; padding: 6px 10px; color: white; border-radius: 4px; font-size: 12px; }
        .btn-danger:hover { background: #c82333; }
        .btn-warning { background: #ffc107; text-decoration: none; padding: 6px 10px; color: #343a40; border-radius: 4px; font-size: 12px; }
        .btn-warning:hover { background: #e0a800; }
        .logout-btn { background: #dc3545; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; }
        .logout-btn:hover { background: #c82333; }
        .message { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>

    <!-- Sidebar Navigation Links[cite: 2] -->
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="dashboard.php?section=users" class="<?= $section === 'users' ? 'active' : '' ?>">User Management</a>
        <a href="dashboard.php?section=products" class="<?= $section === 'products' ? 'active' : '' ?>">Product Management</a>
        <br><hr style="border-color: #495057;"><br>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <!-- Header & Logout[cite: 3] -->
        <div class="header">
            <h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></h2>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Statistics Overview[cite: 2] -->
        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?= $totalUsers ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Products</h3>
                <p><?= $totalProducts ?></p>
            </div>
        </div>

        <!-- USER MANAGEMENT SECTION[cite: 2, 3] -->
        <?php if ($section === 'users'): ?>
            <div class="card">
                <h3><?= $editUser ? 'Edit User' : 'Add New User' ?></h3>
                <form method="POST" action="">
                    <input type="hidden" name="user_id" value="<?= $editUser['id'] ?? '' ?>">
                    <input type="text" name="name" placeholder="Full Name" value="<?= htmlspecialchars($editUser['name'] ?? '') ?>" required>
                    <input type="email" name="email" placeholder="Email Address" value="<?= htmlspecialchars($editUser['email'] ?? '') ?>" required>
                    <input type="password" name="password" placeholder="Password <?= $editUser ? '(Leave blank to keep current)' : '' ?>" <?= $editUser ? '' : 'required' ?>>
                    <button type="submit" name="save_user"><?= $editUser ? 'Update User' : 'Create User' ?></button>
                    <?php if ($editUser): ?>
                        <a href="dashboard.php?section=users" style="margin-left: 10px; text-decoration: none; color: #6c757d;">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="card">
                <h3>Registered Users Table</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?= htmlspecialchars($u['id']) ?></td>
                                <td><?= htmlspecialchars($u['name']) ?></td>
                                <td><?= htmlspecialchars($u['email']) ?></td>
                                <td><?= htmlspecialchars($u['created_at']) ?></td>
                                <td>
                                    <a href="dashboard.php?section=users&edit_user=<?= $u['id'] ?>" class="btn-warning">Edit</a>
                                    <a href="dashboard.php?delete_user=<?= $u['id'] ?>" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- PRODUCT MANAGEMENT SECTION[cite: 2, 3] -->
        <?php if ($section === 'products'): ?>
            <div class="card">
                <h3><?= $editProduct ? 'Edit Product' : 'Add New Product' ?></h3>
                <form method="POST" action="">
                    <input type="hidden" name="product_id" value="<?= $editProduct['id'] ?? '' ?>">
                    <input type="text" name="name" placeholder="Product Name" value="<?= htmlspecialchars($editProduct['name'] ?? '') ?>" required>
                    <textarea name="description" placeholder="Product Description" rows="3"><?= htmlspecialchars($editProduct['description'] ?? '') ?></textarea>
                    <input type="number" step="0.01" name="price" placeholder="Price ($)" value="<?= htmlspecialchars($editProduct['price'] ?? '') ?>" required>
                    <input type="number" name="quantity" placeholder="Quantity" value="<?= htmlspecialchars($editProduct['quantity'] ?? '') ?>" required>
                    <button type="submit" name="save_product"><?= $editProduct ? 'Update Product' : 'Create Product' ?></button>
                    <?php if ($editProduct): ?>
                        <a href="dashboard.php?section=products" style="margin-left: 10px; text-decoration: none; color: #6c757d;">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="card">
                <h3>Product Inventory Table</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['id']) ?></td>
                                <td><?= htmlspecialchars($p['name']) ?></td>
                                <td><?= htmlspecialchars($p['description']) ?></td>
                                <td>$<?= number_format($p['price'], 2) ?></td>
                                <td><?= htmlspecialchars($p['quantity']) ?></td>
                                <td><?= htmlspecialchars($p['created_at']) ?></td>
                                <td>
                                    <a href="dashboard.php?section=products&edit_product=<?= $p['id'] ?>" class="btn-warning">Edit</a>
                                    <a href="dashboard.php?delete_product=<?= $p['id'] ?>" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>