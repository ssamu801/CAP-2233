<?php include('db_connect.php');?>
<?php
if(  $_SESSION['login_type'] != 1){
	echo '<script type="text/javascript">
	setTimeout(function() {
		window.location.href = "index.php?page=home";
	}, 0000); 
	</script>';
}

$requests = $conn->query("SELECT * FROM events 
                            WHERE isPreferred = 'Yes'
                            AND status='Scheduled'
                            AND isDirectorApproved='Pending';");
?>
<div class="container-fluid">
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

<div class="container">
    <h1>Preferred Counselor Requests</h1>
    <?php if ($requests->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Client Name</th>
                    <th>Preferred Counselor</th>
                    <th>Reason</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php while($row = $requests->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['counselor_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['reason']); ?></td>
                        <td class="text-center">
                            <?php if ($row['isDirectorApproved'] === 'Approved'): ?>
                                <span style="color: green; font-weight: bold;">Approved</span>
                            <?php elseif ($row['isDirectorApproved'] === 'Declined'): ?>
                                <span style="color: red; font-weight: bold;">Declined</span>
                            <?php else: ?>
                                <div class="d-flex justify-content-center">
                                <button class="btn btn-success btn-sm ml-2 accept" id="accept" data-id="<?php echo $row['id'] ?>">Accept</button>
                                <button class="btn btn-decline btn-sm ml-2 decline" id="decline" data-id="<?php echo $row['id'] ?>">Decline</button>
                                </div>
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
</div>

<script>
	$(document).ready(function(){
    
    

    $('.accept').click(function(){
        _conf("Approve this request?","approve_request",[$(this).attr('data-id')],'mid-large'); 
    });

	$('.decline').click(function(){
		_conf("Decline this request?","decline_request",[$(this).attr('data-id')],'mid-large'); 
	})

	$('.edit_topic').click(function(){
		uni_modal("Edit Topic","social_interaction/manage_topic_mod.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
});



function approve_request(id){
	var login_name = '<?php echo $_SESSION['login_name']; ?>'; 
    start_load();
    $.ajax({
        url: 'ajax.php?action=approve_counselor_request',
        method: 'POST',
        data: { id: id },
        success: function(resp){
            if(resp == 1){
                alert_toast("Request approved", 'success');
                setTimeout(function(){
                    location.reload();
                }, 1500);
            }
        }
    });
}

function decline_request(id){
	var login_name = '<?php echo $_SESSION['login_name']; ?>'; 
    start_load();
    $.ajax({
        url: 'ajax.php?action=decline_counselor_request',
        method: 'POST',
        data: { id: id },
        success: function(resp){
            if(resp == 1){
                alert_toast("Request declined", 'success');
                setTimeout(function(){
                    location.reload();
                }, 1500);
            }
        }
    });
}

$('.requests').click(function(){

    view_modal("Preferred Request Details", "./appointments/request_details.php", 'mid-large');
});

</script>