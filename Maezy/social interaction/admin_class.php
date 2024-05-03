<?php
session_start();
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
					return 1;
			}else{
				return 3;
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
	
		$approve = $this->db->query("UPDATE topics SET status='Approved', date_approved=NOW(), reviewed_by='$login_name', reason='Approved' WHERE id = $id");
	
		if($approve){
			$sql = "SELECT title FROM topics WHERE id=$id LIMIT 1";
			$result = $this->db->query($sql);
	
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$title = $row['title']; 
	
				//type, topic id, comment id
				$notif = $this->db->query("INSERT INTO notifications (posterID, heading, message, time, type, topic_id) VALUES ('$poster_id', '[DISCUSSION FORUM] Your post $title has been approved', 'We are pleased to inform you that your recent post titled $title on our discussion forum has been approved by our moderators. Your contribution to the community is greatly appreciated.Thank you for adhering to our community guidelines and policies. We encourage you to continue engaging with our platform and sharing your insights.' , NOW(), 1, $id)");
	
				if($notif){
					return 1; 
				}
			}
		}
	
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
		extract($_POST);
		$approve_comment = $this->db->query("UPDATE comments SET status='Approved', date_approved=NOW(), reviewed_by='$login_name', reason='Approved' WHERE id = ".$id);
		$title = ''; 
		$comment = '';
		$poster_id = 0; 
		$OP = 0;
		$name = '';
		if($approve_comment){
			$sql = "SELECT t.id AS topic_id, t.title, c.comment, t.user_id AS OP, c.user_id, u.name FROM comments c JOIN topics t ON c.topic_id = t.id JOIN users u ON u.id=c.user_id WHERE c.id=$id LIMIT 1";
			$result = $this->db->query($sql);
	
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$topic_id = $row['topic_id']; 
				$title = $row['title']; 
				$comment = $row['comment'];
				$poster_id = $row['user_id']; 
				$OP = $row['OP'];
				$name = $row['name'];

	
				$notif = $this->db->query("INSERT INTO notifications (posterID, heading, message, time, type, comment_id) VALUES ('$poster_id', '[DISCUSSION FORUM] Your comment for $title has been approved', 'We are pleased to inform you that your comment on the post titled $title on our discussion forum has been approved by our moderators. Your contribution to the community is greatly appreciated.Thank you for adhering to our community guidelines and policies. We encourage you to continue engaging with our platform and sharing your insights.' , NOW(), 3, $id)");
				
				if($notif){

					$notif2 = $this->db->query("INSERT INTO notifications (posterID, heading, message, time, type, topic_id, comment_id) VALUES ('$OP', '[DISCUSSION FORUM] $name commented on your post $title', '$comment' , NOW(), 5, $topic_id, $id)");
					
					if($notif2){
						return 1; 
					}
					
				}
			}
			return 1; 
		}
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
