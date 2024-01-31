<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Forum</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Discussion Forum</h1>

    <form action="post_message.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="message">Message:</label>
        <textarea id="expandingTextarea" name="message" rows="1" placeholder="Start typing..." oninput="autoExpand(this)" required></textarea>
        <br>
        <input type="submit" value="Post Message">
    </form>

    <?php include 'view_posts.php'; ?>
    <script src="script.js"></script>
</body>
</html>
