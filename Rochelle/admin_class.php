<?php
//session_start();
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
		$approve = $this->db->query("UPDATE topics SET status='Approved', date_approved=NOW(), reviewed_by='$login_name', reason='Approved' WHERE id = ".$id);
		if($approve){
			return 1;
		}
	}

	function decline_topic(){
		extract($_POST);
		$decline = $this->db->query("UPDATE topics SET status='Rejected', reviewed_by='$login_name', reason='$reason' WHERE id = ".$post_id);
		if($decline){
			return 1;
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
		if($approve_comment){
			return 1;
		}
	}

	function decline_comment(){
		extract($_POST);
		$decline_comment = $this->db->query("UPDATE comments SET status='Rejected', reviewed_by='$login_name', reason='$reason' WHERE id = ".$post_id);
		if($decline_comment){
			return 1;
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

	function search() {
		if (isset($_POST['keyword']) || isset($_POST['tag'])) {
			$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
			$tag = isset($_POST['tag']) ? $_POST['tag'] : '';
	
			$tags = array();
			$data = array();
	
			$tag_query = $this->db->query("SELECT * FROM categories ORDER BY name ASC");
			if (!$tag_query) {
				die("Error fetching categories: " . $this->db->error);
			}
			while ($row = $tag_query->fetch_assoc()) {
				$tags[$row['id']] = $row['name'];
			}
	
			$tsearch = '';
			if ($tag) {
				$tagResult = $this->db->query("SELECT id FROM categories WHERE name='$tag'");
				if ($tagResult && $tagResult->num_rows > 0) {
					$tagRow = $tagResult->fetch_assoc();
					$tagId = $tagRow['id'];
					$tsearch = " CONCAT('[', REPLACE(category_ids, ',', '],['), ']') LIKE '%[$tagId]%' ";
				}
			}
	
			$data = array();
	
			$mediaQuery = "SELECT upload_id AS file_id, MAX(title) AS name, MAX(category_ids) AS category_ids, 'File' AS type
						   FROM media_files 
						   WHERE title LIKE '%$keyword%'
						   " . ($tsearch ? "AND $tsearch " : "") . "
						   GROUP BY file_id
						   UNION 
						   SELECT video_id AS file_id, MAX(title) AS name, MAX(category_ids) AS category_ids, 'Video' AS type
						   FROM embed_videos 
						   WHERE title LIKE '%$keyword%'
						   " . ($tsearch ? "AND $tsearch " : "") . "
						   GROUP BY video_id
						   ORDER BY name ASC";
	
			$media = $this->db->query($mediaQuery);
	
			if (!$media) {
				die("Error fetching media: " . $this->db->error);
			}
	
			while ($row = $media->fetch_assoc()) {
				$view = $this->db->query("SELECT * FROM resources_views WHERE article_id=" . $row['file_id']);
				$view_count = ($view) ? $view->num_rows : 0;
	
				$comments = $this->db->query("SELECT * FROM embed_comments WHERE embed_id=" . $row['file_id']);
				$comments_count = ($comments) ? $comments->num_rows : 0;
	
				$row['views'] = $view_count;
				$row['comments'] = $comments_count;
	
				$media_tags = array();
				if (!empty($row['category_ids'])) {
					$category_ids = explode(',', $row['category_ids']);
					foreach ($category_ids as $cat_id) {
						if (isset($tags[$cat_id])) {
							$media_tags[] = $tags[$cat_id];
						}
					}
				}
	
				$row['media_tags'] = $media_tags;
				$data[] = $row;
			}
			return json_encode($data);
		} else {
			return json_encode(array());
		}
	}

	function search2() {
		if (isset($_POST['keyword']) || isset($_POST['tag'])) {
			$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
			$tag = isset($_POST['tag']) ? $_POST['tag'] : '';
	
			$tags = array();
			$data = array();
	
			$tag_query = $this->db->query("SELECT * FROM categories ORDER BY name ASC");
			if (!$tag_query) {
				die("Error fetching categories: " . $this->db->error);
			}
			while ($row = $tag_query->fetch_assoc()) {
				$tags[$row['id']] = $row['name'];
			}
	
			$tsearch = '';
			if ($tag) {
				$tagResult = $this->db->query("SELECT id FROM categories WHERE name='$tag'");
				if ($tagResult && $tagResult->num_rows > 0) {
					$tagRow = $tagResult->fetch_assoc();
					$tagId = $tagRow['id'];
					$tsearch = " CONCAT('[', REPLACE(category_ids, ',', '],['), ']') LIKE '%[$tagId]%' ";
				}
			}
	
			$articleQuery = "SELECT * 
							 FROM articles 
							 WHERE title LIKE '%$keyword%' 
							 " . ($tsearch ? "AND $tsearch " : "") . " 
							 ORDER BY title ASC";
	
			$article = $this->db->query($articleQuery);
			if (!$article) {
				die("Error fetching article: " . $this->db->error);
			}
	
			while ($row = $article->fetch_assoc()) {
				$comments = $this->db->query("SELECT * FROM article_comments WHERE article_id=" . $row['article_id'])->num_rows;
				$row['comments'] = $comments;
	
				$article_tags = array();
				if (!empty($row['category_ids'])) {
					$category_ids = explode(',', $row['category_ids']);
					foreach ($category_ids as $cat_id) {
						if (isset($tags[$cat_id])) {
							$article_tags[] = $tags[$cat_id];
						}
					}
				}
	
				$row['article_tags'] = $article_tags;
				$data[] = $row;
			}
			return json_encode($data);
		} else {
			return json_encode(array());
		}
	}	

	function search_resources() {
        if (isset($_POST['keyword']) || isset($_POST['tag'])) {
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $tag = isset($_POST['tag']) ? $_POST['tag'] : '';

            $data = [];

            // Fetch crisis resource tags
            $rtags_query = $this->db->query("SELECT id, name FROM crisis_resources_tags ORDER BY name ASC");
            if (!$rtags_query) {
                die("Error fetching resource categories: " . $this->db->error);
            }
            $crisis_tags = [];
            while ($row = $rtags_query->fetch_assoc()) {
                $crisis_tags[$row['id']] = $row['name'];
            }

            // Build the query based on keyword and tag
            $tsearch = '';
            if ($tag) {
                $tagResult = $this->db->query("SELECT id FROM crisis_resources_tags WHERE name='$tag'");
                if ($tagResult && $tagResult->num_rows > 0) {
                    $tagRow = $tagResult->fetch_assoc();
                    $tagId = $tagRow['id'];
                    $tsearch = " CONCAT('[', REPLACE(tags, ',', '],['), ']') LIKE '%[$tagId]%' ";
                }
            }

            $resourcesQuery = "SELECT * FROM crisis_resources 
                              WHERE name LIKE '%$keyword%' 
                              " . ($tsearch ? "AND $tsearch " : "") . " 
                              ORDER BY name ASC";

            $resource_result = $this->db->query($resourcesQuery);
            if (!$resource_result) {
                die("Error fetching crisis resources: " . $this->db->error);
            }

            while ($row = $resource_result->fetch_assoc()) {
                $resource_tags = [];
                if (!empty($row['tags'])) {
                    $tags = explode(',', $row['tags']);
                    foreach ($tags as $tag_id) {
                        if (isset($crisis_tags[$tag_id])) {
                            $resource_tags[] = $crisis_tags[$tag_id];
                        }
                    }
                }
                $row['resource_tags'] = $resource_tags;
                $data[] = $row;
            }
            return json_encode($data);
        } else {
            return json_encode([]);
        }
    }

	/* function search(){
    	if(isset($_POST['keyword'])) {
            $keyword = $_POST['keyword'];
            $data = array();
            $media = $this->db->query("SELECT upload_id AS file_id, MAX(title) AS name, 'File' AS type
                                        FROM media_files 
                                        WHERE title LIKE '%$keyword%'
                                        GROUP BY file_id
                                        UNION 
                                        SELECT video_id AS file_id, MAX(title) AS name, 'Video' AS type
                                        FROM embed_videos 
                                        WHERE title LIKE '%$keyword%'
                                        GROUP BY video_id
                                        ORDER BY name ASC");
            
            while($row= $media->fetch_assoc()):
                $result_html = '<a href="index.php?page=information_resources/view_media&id='.$row['file_id'].'&type='.$row['type'].'" class="filter-text">'.$row['name'].'</a>';
                $data[] = $result_html;
            endwhile;
            return implode('', $data);
        } else {
            return '';
        }
    }
	*/
}
