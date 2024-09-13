<?php
include './db_connect.php'; // Include database connection

// Handle the form submission for approving/declining requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];
    $action = $_POST['action']; // "approve" or "decline"
    
    // Fetch the change request details for the selected request
    $stmt = $conn->prepare("SELECT client_id, client_name, new_counselor_id, new_counselor.name AS new_counselor_name 
                            FROM change_requests 
                            JOIN users new_counselor ON change_requests.new_counselor_id = new_counselor.id 
                            WHERE change_requests.id = ?");
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $request = $result->fetch_assoc();
    
    if ($action === 'approve') {
        // Update the assigned_counselors table with the new counselor details
        $client_id = $request['client_id'];
        $new_counselor_id = $request['new_counselor_id'];
        $new_counselor_name = $request['new_counselor_name'];

        // Prepare the update statement for the assigned_counselors table
        $update_stmt = $conn->prepare("UPDATE assigned_counselors SET counselor_id = ?, counselor_name = ? WHERE client_id = ?");
        $update_stmt->bind_param("isi", $new_counselor_id, $new_counselor_name, $client_id);
        $update_stmt->execute();
        $update_stmt->close();

        // Mark the request as approved
        $stmt = $conn->prepare("UPDATE change_requests SET approved = 'Approved' WHERE id = ?");
    } else if ($action === 'decline') {
        // Mark the request as declined
        $stmt = $conn->prepare("UPDATE change_requests SET approved = 'Declined' WHERE id = ?");
    }

    $stmt->bind_param("i", $request_id);

    if ($stmt->execute()) {
        echo "<script>alert('Request has been updated successfully.'); window.location.href='index.php?page=appointments/manage_counselor_requests';</script>";
    } else {
        echo "<script>alert('An error occurred. Please try again later.');</script>";
    }
    
    $stmt->close();
}

// Retrieve all pending counselor change requests
$requests = $conn->query("SELECT 
                            cr.id AS request_id, 
                            cr.client_name, 
                            former_counselor.name AS former_counselor_name, 
                            new_counselor.name AS new_counselor_name, 
                            cr.reason, 
                            cr.goal, 
                            cr.intervention, 
                            cr.approved
                        FROM 
                            cap2233.change_requests cr
                        JOIN 
                            cap2233.users former_counselor ON cr.former_counselor_id = former_counselor.id
                        JOIN 
                            cap2233.users new_counselor ON cr.new_counselor_id = new_counselor.id;");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Counselor Requests</title>
    <style>

        .container {
            max-width: 1500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #1c1c1e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #d1d1d6;
        }

        th {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .btn {
            padding: 8px 16px;
            margin: 4px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .btn-approve {
            background-color: #28a745;
            color: white;
        }

        .btn-approve:hover {
            background-color: #218838;
        }

        .btn-decline {
            background-color: #dc3545;
            color: white;
        }

        .btn-decline:hover {
            background-color: #c82333;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            text-decoration: none;
            color: #007aff;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Manage Counselor Change Requests</h1>

    <?php if ($requests->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Former Counselor</th>
                    <th>New Counselor</th>
                    <th>Reason</th>
                    <th>Goal</th>
                    <th>Intervention</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $requests->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['request_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['former_counselor_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['new_counselor_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['reason']); ?></td>
                        <td><?php echo htmlspecialchars($row['goal']); ?></td>
                        <td><?php echo htmlspecialchars($row['intervention']); ?></td>
                        <td>
                            <?php if ($row['approved'] === 'Approved'): ?>
                                <span style="color: green; font-weight: bold;">Approved</span>
                            <?php elseif ($row['approved'] === 'Declined'): ?>
                                <span style="color: red; font-weight: bold;">Declined</span>
                            <?php else: ?>
                                <form method="POST" style="display:inline-block;">
                                    <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-approve">Approve</button>
                                </form>

                                <form method="POST" style="display:inline-block;">
                                    <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                                    <input type="hidden" name="action" value="decline">
                                    <button type="submit" class="btn btn-decline">Decline</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No pending counselor change requests at the moment.</p>
    <?php endif; ?>

</div>

</body>
</html>
