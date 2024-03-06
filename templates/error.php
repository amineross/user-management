<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'parts/header.php'; ?>
    <div class="error-container">
        <h1>Oops! Something went wrong.</h1>
        <p><?php echo isset($errorMsg) ? htmlspecialchars($errorMsg) : "An unknown error occurred."; ?></p>
        <a href="index.php">Back to Home</a>
    </div>
    <?php include 'parts/footer.php'; ?>
</body>
</html>
