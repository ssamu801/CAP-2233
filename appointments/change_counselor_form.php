<?php
include './db_connect.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values from POST request
    $client_id = $_POST['client_id'];
    $client_name = $_POST['client_name'];
    $former_counselor_id = $_SESSION['login_id']; // Assuming current login ID is the former counselor
    $new_counselor_id = $_POST['newCounselor'];
    $reason = $_POST['reason'];
    $goal = $_POST['goal'];
    $intervention = $_POST['intervention'];

    // Insert form data into change_requests table
    $stmt = $conn->prepare("INSERT INTO change_requests (client_id, client_name, former_counselor_id, new_counselor_id, reason, goal, intervention, approved) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $approved = 'Pending'; // Initially, set the status as 'Pending'
    $stmt->bind_param("isssssss", $client_id, $client_name, $former_counselor_id, $new_counselor_id, $reason, $goal, $intervention, $approved);
    
    if ($stmt->execute()) {
        // Redirect or show success message
        echo "<script>alert('Your request has been submitted successfully.'); window.location.href='index.php?page=appointments/client_records';</script>";
    } else {
        echo "<script>alert('An error occurred. Please try again later.');</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Counselor</title>
    <style>
        /* General styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 1.8em;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #1c1c1e;
        }

        label {
            font-size: 1em;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #d1d1d6;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-size: 1em;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #007aff;
            outline: none;
        }

        select.form-control {
            height: auto;
            line-height: normal;
            padding: 12px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #007aff;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #005bb5;
        }

        .btn-secondary {
            background-color: #8e8e93;
        }

        .btn-secondary:hover {
            background-color: #6c6c70;
        }

        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Change Counselor</h1>

    <form id="changeCounselorForm" method="POST" action="">
        <div class="form-group">
            <label for="client_name">Client Name</label>
            <input type="text" id="client_name" class="form-control" name="client_name" value="<?php echo htmlspecialchars(trim($_GET['clientName'])); ?>" readonly>
        </div>

        <div class="form-group">
            <label for="client_id">Client ID</label>
            <input type="text" id="client_id" class="form-control" name="client_id" value="<?php echo htmlspecialchars($_GET['user_id']); ?>" readonly>
        </div>

        <div class="form-group">
            <label for="newCounselor">Select New Counselor</label>
            <select id="newCounselor" class="form-control" name="newCounselor" required>
                <?php
                    $users = $conn->query("SELECT * FROM users WHERE type = 3 AND NOT id = {$_SESSION['login_id']}");
                    while($row = $users->fetch_assoc()):
                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                    endwhile;
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="reason">Reason for Changing Counselor</label>
            <textarea id="reason" class="form-control" name="reason" rows="3" placeholder="Explain the reason for changing the counselor..."></textarea>
        </div>

        <div class="form-group">
            <label for="goal">Goal</label>
            <textarea id="goal" class="form-control" name="goal" rows="3" placeholder="State the goal for the counseling..."></textarea>
        </div>

        <div class="form-group">
            <label for="intervention">Intervention</label>
            <textarea id="intervention" class="form-control" name="intervention" rows="3" placeholder="Mention any specific intervention..."></textarea>
        </div>

        <button type="submit" class="btn">Submit</button>
    </form>

    <div class="footer">
        <button class="btn btn-secondary" onclick="window.location.href='index.php';">Cancel</button>
    </div>
</div>

</body>
</html>
