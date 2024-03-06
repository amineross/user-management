<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'parts/header.php'; ?>
    <div class="dashboard-container">
        <h1>Welcome to the Dashboard</h1>
        <p>Hello, <?php echo htmlspecialchars($_SESSION['email']); ?>!</p>
        <p>Here you can view your account details or update them.</p>
        <a href="index.php?route=edit">Edit Profile</a> | <a href="index.php?route=signout">Logout</a>
    </div>
    <?php include 'parts/footer.php'; ?>
</body>
</html>
