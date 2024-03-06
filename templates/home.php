<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'parts/header.php'; ?>
    <div class="home-container">
        <h1>Welcome to Our User Management System</h1>
        <p>This system allows you to register, login, and manage your user profile.</p>
        <div class="home-links">
            <a href="index.php?route=signup">Register</a> | <a href="index.php?route=signin">Login</a>
        </div>
    </div>
    <?php include 'parts/footer.php'; ?>
</body>
</html>