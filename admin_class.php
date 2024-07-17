<?php
session_start();
date_default_timezone_set('Asia/Manila');
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		
			extract($_POST);		
			$qry = $this->db->query("SELECT * FROM users where id = '".$idNum."' and password = '".md5($password_login)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}

				if( $_SESSION['login_type'] == 1){
					return 1;
				}
				else if( $_SESSION['login_type'] == 2){
					return 2;
				}
				else if( $_SESSION['login_type'] == 3){
					return 3;
				}
				else if( $_SESSION['login_type'] == 4){
					return 4;
				}
				else if( $_SESSION['login_type'] == 5){
					return 5;
				}

				// return 1;
					
			}else{
				return 9;
			}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = '$type' ";
		$chk = $this->db->query("Select * from users where username = '$username' and id !='$id' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function signup(){
		extract($_POST);
		$data = " name = '".$firstname.' '.$lastname."' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$uid = $this->db->insert_id;
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password')
					continue;
				if(empty($data) && !is_numeric($k) )
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if($_FILES['img']['tmp_name'] != ''){
							$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
							$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
							$data .= ", avatar = '$fname' ";

			}
			$save_alumni = $this->db->query("INSERT INTO alumnus_bio set $data ");
			if($data){
				$aid = $this->db->insert_id;
				$this->db->query("UPDATE users set alumnus_id = $aid where id = $uid ");
				$login = $this->login2();
				if($login)
				return 1;
			}
		}
	}
	function update_account(){
		extract($_POST);
		$data = " name = '".$firstname.' '.$lastname."' ";
		$data .= ", username = '$email' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' and id != '{$_SESSION['login_id']}' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("UPDATE users set $data where id = '{$_SESSION['login_id']}' ");
		if($save){
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password')
					continue;
				if(empty($data) && !is_numeric($k) )
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if($_FILES['img']['tmp_name'] != ''){
							$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
							$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
							$data .= ", avatar = '$fname' ";

			}
			$save_alumni = $this->db->query("UPDATE alumnus_bio set $data where id = '{$_SESSION['bio']['id']}' ");
			if($data){
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				$login = $this->login2();
				if($login)
				return 1;
			}
		}
	}

	
	function save_category(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", description = '$description' ";
		$data .= ", created_by = '$login_id' ";
			if(empty($id)){
				$save = $this->db->query("INSERT INTO categories set $data");
			}else{
				$save = $this->db->query("UPDATE categories set $data where id = $id");
			}
		if($save)
			return 1;
	}
	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM categories where id = ".$id);
		if($delete){
			return 1;
		}
	}

	function follow_category(){
		extract($_POST);
		$data = " user_id = '$login_id' ";
		$data .= ", category_id = '$id' ";

		$save = $this->db->query("INSERT INTO categories_follow set $data");
			
		if($save)
			return 1;
	}

	function unfollow_category() {
		// Sanitize and validate inputs
		$login_id = intval($_POST['login_id']);
		$id = intval($_POST['id']);
		
		// Prepare and execute the SQL query
		$query = "DELETE FROM categories_follow WHERE user_id = $login_id AND category_id = $id";
		$delete = $this->db->query($query);
		
		// Check if deletion was successful
		if ($delete) {
			return 1; // Successful deletion
		} else {
			return 0; // Error occurred
		}
	}

	function save_topic(){
		extract($_POST);
		$data = " title = '$title' ";
		$data .= ", category_ids = '".(implode(",",$category_ids))."' ";
		$data .= ", content = '".htmlentities(str_replace("'","&#x2019;",$content))."' ";
	//	$data .= ", toggle_value = '".(isset($_POST['toggle_value']) ? $_POST['toggle_value'] : 0)."' ";

		if(isset($_POST['toggle_value'])){
			$data .= ", isAnonymous = '".isset($_POST['toggle_value'])."' ";
	 	}
	 	else{
			$data .= ", isAnonymous = '".(isset($_POST['toggle_value']) ? $_POST['toggle_value'] : 0)."' ";
	 	}
		 
		if(empty($id)){
		$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$save = $this->db->query("INSERT INTO topics set ".$data);
		}else{
			$save = $this->db->query("UPDATE topics set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_topic(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM topics where id = ".$id);
		if($delete){
			return 1;
		}
	}

	function approve_topic(){
		extract($_POST);
		
		// Prepare statements to avoid SQL injection
		$approveStmt = $this->db->prepare("UPDATE topics SET status='Approved', date_approved=NOW(), reviewed_by=?, reason='Approved' WHERE id=?");
		$approveStmt->bind_param("si", $login_name, $id);
		
		$sql = "SELECT title FROM topics WHERE id=? LIMIT 1";
		$resultStmt = $this->db->prepare($sql);
		$resultStmt->bind_param("i", $id);
		
		// Execute the approve statement
		if ($approveStmt->execute()) {
			$resultStmt->execute();
			$result = $resultStmt->get_result();
			
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$title = $row['title'];
				
				$notifStmt = $this->db->prepare("INSERT INTO notifications (posterID, heading, message, time, type, topic_id) VALUES (?, ?, ?, NOW(), ?, ?)");
				$message = "We are pleased to inform you that your recent post titled $title on our discussion forum has been approved by our moderators. Your contribution to the community is greatly appreciated. Thank you for adhering to our community guidelines and policies. We encourage you to continue engaging with our platform and sharing your insights.";
				$heading = "[DISCUSSION FORUM] Your post $title has been approved";
				$type = 1;
				
				$notifStmt->bind_param("issii", $poster_id, $heading, $message, $type, $id);
				
				if ($notifStmt->execute()) {
					return 1;
				} else {
					// Notification insert failed
					error_log("Notification insert failed: " . $notifStmt->error);
				}
			} else {
				// No rows found for the topic
				error_log("No topic found with ID: " . $id);
			}
		} else {
			// Approval update failed
			error_log("Approval update failed: " . $approveStmt->error);
		}
		
		return 0;
	}
	
	

	function decline_topic(){
		extract($_POST);
	
		// Update the topic status to 'Rejected' in the database
		$decline = $this->db->query("UPDATE topics SET status='Rejected', reviewed_by='$login_name', reason='$reason' WHERE id = $post_id");
	
		// Check if the update was successful
		if ($decline) {
			// Fetch the title and user_id of the declined topic
			$sql = "SELECT title, user_id FROM topics WHERE id=$post_id LIMIT 1";
			$result = $this->db->query($sql);
	
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$title = $row['title']; 
				$poster_id = $row['user_id']; 
	
				// Insert notification into the notifications table
				$decline_notif = $this->db->query("INSERT INTO notifications (posterID, heading, message, time, type, topic_id) VALUES ('$poster_id', '[DISCUSSION FORUM] Your post $title has been rejected', 'We are regret to inform you that your recent post titled $title on our discussion forum has been rejected by our moderators.',NOW(), 2, $post_id)");
	
				if ($decline_notif) {
					return 1; // Return success code
				}
			}
		}
	
	}

	function like_post(){
		extract($_POST);
		$data = " post_id = '$id' ";
		$data .= ", user_id = '$user_id' ";

		$save = $this->db->query("INSERT INTO post_likes set ".$data);

		if($save)
			return 1;
	}

	function unlike_post(){
		extract($_POST);

		$post_id = 0;
		$sql = "SELECT id FROM post_likes WHERE post_id=$id AND user_id=$user_id ";
		$result =$this->db->query($sql);

		if ($result->num_rows > 0) {
    		$row = $result->fetch_assoc();
    		$post_id = $row["id"];
		}

		
		
		$delete = $this->db->query("DELETE FROM post_likes WHERE id=$post_id");
					
		if($delete)
			return 1; 
	
	}
	
	function save_article(){
		extract($_POST);
		$data = " title = '$title' ";
		$data .= ", link = '$link' ";
		$data .= ", publisher = '$publisher' ";
		$data .= ", added_by = '$added_by' ";

		$save = $this->db->query("INSERT INTO articles set ".$data);

		if($save)
			return 1;
	}

	function save_article_rating(){
		extract($_POST);
		$data = " article_id = '$article_id' ";
		$data .= ", title = '$title' ";
		$data .= ", user_rating = '$user_rating' ";
		$data .= ", voter_id = '$login_id' ";
		$data .= ", type = '$type' ";


		$save = $this->db->query("INSERT INTO resources_ratings set ".$data);

		if($save)
			return 1;
	}

	function save_article_comment(){
		extract($_POST);
		$data = " comment = '".htmlentities(str_replace("'","&#x2019;",$comment))."' ";

		if(empty($id)){
			$data .= ", article_id = '$article_id' ";
			$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$save = $this->db->query("INSERT INTO article_comments set ".$data);
		}else{
			$save = $this->db->query("UPDATE article_comments set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_article_comment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM article_comments where id = ".$id);
		if($delete){
			return 1;
		}
	}

	function save_embed(){
		extract($_POST);
		$data = " title = '$title' ";
		$data .= ", link = '$link' ";
		$data .= ", uploader = '$uploader' ";
		$data .= ", added_by = '$added_by' ";

		$save = $this->db->query("INSERT INTO embed_videos set ".$data);

		if($save)
			return 1;
	}

	function save_embed_comment(){
		extract($_POST);
		$data = " comment = '".htmlentities(str_replace("'","&#x2019;",$comment))."' ";

		if(empty($id)){
			$data .= ", embed_id = '$embed_id' ";
			$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$save = $this->db->query("INSERT INTO embed_comments set ".$data);
		}else{
			$save = $this->db->query("UPDATE embed_comments set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_embed_comment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM embed_comments where id = ".$id);
		if($delete){
			return 1;
		}
	}

	function save_media(){
		include 'db_connect.php';
		$uploadStatus = '';
	
		$query = "SELECT MAX(upload_id) AS max_upload_id FROM media_files";
	
		$result = $conn->query($query);
	
		if ($result) {
			$row = $result->fetch_assoc();
			$maxUploadId = $row['max_upload_id'];
	
			$maxUploadId++;
	
			$result->free();
	
			if(isset($_FILES['mediaFile']['name']) && isset($_POST['mediaTitle'])){
				$fileCount = count($_FILES['mediaFile']['name']);
				$mediaTitle = $_POST['mediaTitle'];
				$added_by = $_POST['added_by'];
				$uploader = $_POST['uploader'];
	
				for($i=0; $i<$fileCount; $i++){
					$fileName = $_FILES['mediaFile']['name'][$i];
					$fileTmpName = $_FILES['mediaFile']['tmp_name'][$i];
					$fileType = $_FILES['mediaFile']['type'][$i];
					$fileSize = $_FILES['mediaFile']['size'][$i];
					$fileError = $_FILES['mediaFile']['error'][$i];
	
					if($fileError === 0){
						$uploadPath = 'information_resources/medias/' . $fileName;
						move_uploaded_file($fileTmpName, $uploadPath);
	
						// Insert file details into database
						$sql = "INSERT INTO media_files (upload_id, file_name, file_type, file_size, title, added_by, uploaded_by) VALUES ($maxUploadId, '$fileName', '$fileType', $fileSize, '$mediaTitle','$added_by', '$uploader')";
						if ($conn->query($sql) === TRUE) {
							$uploadStatus .= "File '$fileName' uploaded successfully.<br>";
	
						} else {
							$uploadStatus .= "Error uploading file '$fileName': " . $conn->error . "<br>";
						}
					} else {
						$uploadStatus .= "Error uploading file '$fileName': " . $fileError . "<br>";
					}
				}
	
				if(!empty($uploadStatus)){ 
					return 1;
				} 
			}
		}
	}

	function save_media_comment(){
		extract($_POST);
		$data = " comment = '".htmlentities(str_replace("'","&#x2019;",$comment))."' ";

		if(empty($id)){
			$data .= ", upload_id = '$media_id' ";
			$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$save = $this->db->query("INSERT INTO media_comments set ".$data);
		}else{
			$save = $this->db->query("UPDATE media_comments set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_media_comment(){
		extract($_POST);
			$comment_id = 0;
			$sql = "SELECT id FROM media_comments where upload_id=".$id;
			$result =$this->db->query($sql);

			if ($result->num_rows > 0) {
				
    			$row = $result->fetch_assoc();
    			$comment_id = $row["id"];
			}

			$delete = $this->db->query("DELETE FROM media_comments where id = ".$comment_id);
			if($delete){
				return 1;
			}
	}

	function save_report_post(){
		extract($_POST);
		
		$data = " post_id = $post_id ";
		$data .= ", reporter_id = $user_id";

		if($choice == "Other"){
			$data .= ", report_reason = '".$issue."' ";
		}
		else{
			$data .= ", report_reason = '".$choice."' ";
		}
		
			$save = $this->db->query("INSERT INTO post_reports set ".$data);
		
		if($save)
			return 1;
		
	}

	function save_comment(){
		extract($_POST);
		$data = " comment = '".htmlentities(str_replace("'","&#x2019;",$comment))."' ";

		if(empty($id)){
			$data .= ", topic_id = '$topic_id' ";
			$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$save = $this->db->query("INSERT INTO comments set ".$data);
		}else{
			$save = $this->db->query("UPDATE comments set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_comment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM comments where id = ".$id);
		if($delete){
			return 1;
		}
	}

	function approve_comment(){
		// Extract variables from $_POST safely
		if (!isset($_POST['id']) || !isset($_POST['login_name'])) {
			return 0; // Required POST variables not set
		}
	
		$id = $_POST['id'];
		$login_name = $_POST['login_name'];
	
		// Use prepared statements to avoid SQL injection
		$approveStmt = $this->db->prepare("UPDATE comments SET status='Approved', date_approved=NOW(), reviewed_by=?, reason='Approved' WHERE id=?");
		$approveStmt->bind_param("si", $login_name, $id);
	
		if ($approveStmt->execute()) {
			// Prepare the query to fetch the required details
			$sql = "SELECT t.id AS topic_id, t.title, c.comment, t.user_id AS OP, c.user_id, u.name 
					FROM comments c 
					JOIN topics t ON c.topic_id = t.id 
					JOIN users u ON u.id = c.user_id 
					WHERE c.id = ? LIMIT 1";
			$resultStmt = $this->db->prepare($sql);
			$resultStmt->bind_param("i", $id);
			$resultStmt->execute();
			$result = $resultStmt->get_result();
	
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$topic_id = $row['topic_id'];
				$title = $row['title'];
				$comment = $row['comment']; // Fixed typo
				$poster_id = $row['user_id'];
				$OP = $row['OP'];
				$name = $row['name'];
	
				// Prepare notification insert statements
				$notifStmt = $this->db->prepare("INSERT INTO notifications (posterID, heading, message, time, type, comment_id) VALUES (?, ?, ?, NOW(), ?, ?)");
				$heading1 = "[DISCUSSION FORUM] Your comment for $title has been approved";
				$message1 = "We are pleased to inform you that your comment on the post titled $title on our discussion forum has been approved by our moderators. Your contribution to the community is greatly appreciated. Thank you for adhering to our community guidelines and policies. We encourage you to continue engaging with our platform and sharing your insights.";
				$type1 = 3;
	
				$notifStmt->bind_param("issii", $poster_id, $heading1, $message1, $type1, $id);
	
				if ($notifStmt->execute()) {
					$notifStmt2 = $this->db->prepare("INSERT INTO notifications (posterID, heading, message, time, type, topic_id, comment_id) VALUES (?, ?, ?, NOW(), ?, ?, ?)");
					$heading2 = "[DISCUSSION FORUM] $name commented on your post $title";
					$type2 = 5;
	
					$notifStmt2->bind_param("issiii", $OP, $heading2, $comment, $type2, $topic_id, $id);
	
					if ($notifStmt2->execute()) {
						return 1;
					} else {
						error_log("Notification 2 insert failed: " . $notifStmt2->error);
					}
				} else {
					error_log("Notification 1 insert failed: " . $notifStmt->error);
				}
			} else {
				error_log("No comment found with ID: " . $id);
			}
		} else {
			error_log("Approval update failed: " . $approveStmt->error);
		}
	
		return 0;
	}
	

	function decline_comment(){
		extract($_POST);
		$decline_comment = $this->db->query("UPDATE comments SET status='Rejected', reviewed_by='$login_name', reason='$reason' WHERE id = ".$post_id);
		if($decline_comment){
			$sql = "SELECT t.id AS topic_id, t.title, c.comment, t.user_id AS OP, c.user_id, u.name FROM comments c JOIN topics t ON c.topic_id = t.id JOIN users u ON u.id=c.user_id WHERE c.id=$post_id LIMIT 1";
			$result = $this->db->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$topic_id = $row['topic_id']; 
				$title = $row['title']; 
				$poster_id = $row['user_id']; 

	
				$dec_notif = $this->db->query("INSERT INTO notifications (posterID, heading, message, time, type, comment_id) VALUES ('$poster_id', '[DISCUSSION FORUM] Your comment for $title has been rejected', 'We regret to inform you that your comment on the post titled $title on our discussion forum has been rejected by our moderators.' , NOW(), 4, $post_id)");
	
				if($dec_notif){
					return 1; 
				}
			}
		}
	}

	function save_reply(){
		extract($_POST);
		$data = " reply = '".htmlentities(str_replace("'","&#x2019;",$reply))."' ";

		if(empty($id)){
			$data .= ", comment_id = '$comment_id' ";
			$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$save = $this->db->query("INSERT INTO replies set ".$data);
		}else{
			$save = $this->db->query("UPDATE replies set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_reply(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM replies where id = ".$id);
		if($delete){
			return 1;
		}
	}


	function save_appointment(){
		extract($_POST);

		$stud_id = $student_id;
		$coun_id = 0;

		$data = " title = '$title' ";
		$data .= ", description = '$description' ";

		$selectedSchedule = $selectedDate;
		$schedParts = explode(', ', $selectedSchedule);
		$datePart = date('Y-m-d', strtotime($schedParts[0]));
		$timeRange = explode(' - ', $schedParts[2]);
		$startTime = date('H:i:s', strtotime($timeRange[0]));
		$endTime = date('H:i:s', strtotime($timeRange[1]));

		$data .= ", mode = '$mode' "; 
		$data .= ", date = '$datePart' ";
		$data .= ", time_from = '$startTime' ";
		$data .= ", time_to = '$endTime' ";
		$data .= ", user_name = '$user_name' ";
		$data .= ", user_email = '$user_email' ";
		$data .= ", student_id = '$student_id' ";

		
		if (!empty($counselor)) {
			// Include counselor ID in the appointment data

			$counselorName = $_SESSION['counselorName'];
        	$counselorEmail = $_SESSION['counselorEmail'];

			$coun_id = $counselor;

			$data .= ", isPreferred = 'Yes' ";
			$data .= ", preferredCounselor = '$counselor' ";
			$data .= ", counselor_name = '$counselorName' ";
			$data .= ", counselor_email = '$counselorEmail' ";
			$data .= ", counselor_id = '$counselor' ";

			
		}
		else {
			// Automatically assign a counselor if not preferred
			$assignedCounselor = $this->assign_counselor($mode, $datePart, $startTime, $endTime);
			if ($assignedCounselor) {
				$data .= ", counselor_name = '{$assignedCounselor['name']}' ";
				$data .= ", counselor_email = '{$assignedCounselor['email']}' ";
				$data .= ", counselor_id = '{$assignedCounselor['id']}' ";

				$coun_id = $assignedCounselor['id'];

				
			} 
		}
		
		if(empty($urgency)){ 
			$urgency = 'Not Urgent';
		} 
		if(empty($notes)){
			$notes = 'No notes indicated.';
		}

		$data .= ", notes = '$notes' ";
		$data .= ", urgency = '$urgency' ";
		
		$appointment = $this->db->query("INSERT INTO events set ".$data);

		$update_avail_status = $this->update_avail_status($mode, $datePart, $startTime, $endTime, $coun_id);

		if($appointment && $update_avail_status){

			$id = 0;
			$sql = "SELECT MAX(id) AS max_value FROM events";
			$result =$this->db->query($sql);

			if ($result->num_rows > 0) {
				
    			$row = $result->fetch_assoc();
    			$id = $row["max_value"];
			}
				$event_notif = $this->db->query("INSERT INTO notifications (posterID, type, event_id) VALUES ($stud_id, 6, $id)");
					
				if($event_notif){
					if($mode == 'Face-To-Face'){
						return $id;
					}
					else{
						return -1;
					}
				
				}
		}
		
	}

	function assign_counselor($mode, $date, $startTime, $endTime) {
		$totalCounselors = 0;
	
		
		// Query to count the number of counselors available on the given date and time
		$sql = "SELECT COUNT(*) AS totalCounselors 
				FROM availability 
				WHERE date = '$date' 
				AND time_from = '$startTime' 
				AND time_to = '$endTime'";
	
		$result = $this->db->query($sql);
	
		if ($result && $result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$totalCounselors = $row['totalCounselors'];
		} 
	
		error_log($date);	
			if ($totalCounselors == 1) {
				// If there is exactly one counselor available, return their details directly
				$sql = "SELECT a.counselorID, u.name, u.email 
						FROM availability a 
						JOIN users u ON a.counselorID = u.id 
						WHERE a.date = '$date'
						AND time_from='$startTime' 
						AND time_to='$endTime'
						LIMIT 1";
	
				$res = $this->db->query($sql);
	
				if ($res && $res->num_rows > 0) {
					$row = $res->fetch_assoc();
					error_log($row['counselorID']);
					return [
						'id' => $row['counselorID'],
						'name' => $row['name'],
						'email' => $row['email']
					];
				}
			} else {
				
				// If more than one counselor is available, find the counselor with the least appointments
				$sql1 = "SELECT a.counselorID, u.name, u.email, COUNT(*) AS total_appointments 
						FROM availability a 
						JOIN users u ON a.counselorID = u.id 
						WHERE a.date = '$date' 
						AND a.status = 'Available'
						GROUP BY a.counselorID 
						ORDER BY total_appointments DESC 
						LIMIT 1";
	
				$res1 = $this->db->query($sql1);
	
				if ($res1 && $res1->num_rows > 0) {
					$row2 = $res1->fetch_assoc();
					
					return [
						'id' => $row2['counselorID'],
						'name' => $row2['name'],
						'email' => $row2['email']
					];
				}
			}

	}
	
	function update_avail_status($mode, $date, $startTime, $endTime, $coun_id){
		$id = 0;
		$sql = "SELECT id 
				FROM availability 
				WHERE counselorID = '$coun_id'
				AND date = '$date' 
				AND time_from = '$startTime' 
				AND time_to = '$endTime'
				AND mode = '$mode'
				LIMIT 1";

		$result = $this->db->query($sql);
	
		if ($result && $result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$id = $row['id'];
		} 		


		$update = $this->db->query("UPDATE availability SET status='Scheduled' WHERE id = $id");

		if ($update) {
			return 1;
		}
	}

	function search(){
		extract($_POST);
		$data = array();
		$tag = $this->db->query("SELECT * FROM categories order by name asc");
		while($row= $tag->fetch_assoc()):
			$tags[$row['id']] = $row['name'];
		endwhile;
		$ts = $this->db->query("SELECT * FROM categories where name like '%{$keyword}%' ");
		$tsearch = '';
		while($row= $ts->fetch_assoc()):
			$tsearch .=" or concat('[',REPLACE(t.category_ids,',','],['),']') like '%[{$row['id']}]%' ";
		endwhile;
		// echo "SELECT t.*,u.name FROM topics t inner join users u on u.id = t.user_id where t.title LIKE '%{$keyword}%' or content LIKE '%{$keyword}%' $tsearch order by unix_timestamp(t.date_created) desc";
		$topic = $this->db->query("SELECT t.*,u.name FROM topics t inner join users u on u.id = t.user_id where t.title LIKE '%{$keyword}%' or content LIKE '%{$keyword}%' $tsearch order by unix_timestamp(t.date_created) desc");
		while($row= $topic->fetch_assoc()):
			$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
	        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
	        $desc = strtr(html_entity_decode($row['content']),$trans);
	        $row['desc']=strip_tags(str_replace(array("<li>","</li>"), array("",","), $desc));
	        $row['view'] = $this->db->query("SELECT * FROM forum_views where topic_id=".$row['id'])->num_rows;
	        $row['comments'] = $this->db->query("SELECT * FROM comments where topic_id=".$row['id'])->num_rows;
	        $row['replies'] = $this->db->query("SELECT * FROM replies where comment_id in (SELECT id FROM comments where topic_id=".$row['id'].")")->num_rows;
	        $row['tags'] = array();
	        foreach(explode(",",$row['category_ids']) as $cat):
	        	$row['tags'][]= $tags[$cat];
			endforeach;
			$row['created'] = date('M d, Y h:i A',strtotime($row['date_created']));
			$row['posted'] = ucwords($row['name']);
	        $data[]= $row;
		endwhile;
		return json_encode($data);
	}
}

/*
	lines:
	28-48 redirection to respective dashboards based on type of user
	176
	192-219 follow and unfollow category functions
	613
	632-661 assignment of counselor  (preferred and random)
	675-677
	696-786 assigment of counselor function and function for updating availability status
*/