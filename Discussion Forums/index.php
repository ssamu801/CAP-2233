<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Forum</title>
</head>
<body>
    <h1>Discussion Forum</h1>

    <form action="post_message.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="message">Message:</label>
        <textarea name="message" rows="4" cols="50" required></textarea>
        <br>
        <input type="submit" value="Post Message">
    </form>

    <?php include 'view_posts.php'; ?>
</body>
</html>
