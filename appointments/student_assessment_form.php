<?php
include 'db_connect.php';

$session_id = $_GET['session_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mood = $_POST['mood'];
    $progress = $_POST['progress'];
    $student_id = $_SESSION['login_id'];

    $conn->query("INSERT INTO student_assessments (session_id, student_id, mood, progress, completed) VALUES ($session_id, $student_id, $mood, $progress, 'Yes') 
                  ON DUPLICATE KEY UPDATE mood = $mood, progress = $progress");

    // Redirect back to the sessions list
    echo "<script>
            alert('Form submitted successfully.');
            window.location.href = 'index.php?page=appointments/student_sessions';
        </script>";

    exit();
}

// Fetch session details
$session = $conn->query("SELECT * FROM events WHERE id = $session_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Assessment Form</title>
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 12px;
        }
        .container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #555;
        }
        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            background-color: #007aff;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #005bb5;
        }
        .btn-secondary {
            background-color: #aaa;
        }
        .btn-secondary:hover {
            background-color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Assessment Form</h2>
        <form action="index.php?page=appointments/student_assessment_form&session_id=<?php echo $session_id; ?>" method="POST">
            <div class="form-group">
                <label for="session_id">Session ID</label>
                <input type="text" id="session_id" name="session_id" value="1" readonly>
            </div>
            <div class="form-group">
                <label for="mood">Mood</label>
                <select id="mood" name="mood">
                    <option value="1">1 - Very Bad</option>
                    <option value="2">2 - Bad</option>
                    <option value="3">3 - Neutral</option>
                    <option value="4">4 - Good</option>
                    <option value="5">5 - Very Good</option>
                </select>
            </div>
            <div class="form-group">
                <label for="progress">Progress</label>
                <select id="progress" name="progress">
                    <option value="1">1 - No Progress</option>
                    <option value="2">2 - Slight Progress</option>
                    <option value="3">3 - Moderate Progress</option>
                    <option value="4">4 - Significant Progress</option>
                    <option value="5">5 - Major Progress</option>
                </select>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
