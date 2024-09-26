<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'update_account'){
	$save = $crud->update_account();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_category"){
	$save = $crud->save_category();
	if($save)
		echo $save;
}

if($action == "delete_category"){
	$delete = $crud->delete_category();
	if($delete)
		echo $delete;
}

if($action == "follow_category"){
	$follow = $crud->follow_category();
	if($follow)
		echo $follow;
}

if($action == "unfollow_category"){
	$unfollow = $crud->unfollow_category();
	if($unfollow)
		echo $unfollow;
}

if($action == "save_topic"){
	$save = $crud->save_topic();
	if($save)
		echo $save;
}
if($action == "delete_topic"){
	$save = $crud->delete_topic();
	if($save)
		echo $save;
}

if($action == "approve_topic"){
	$save = $crud->approve_topic();
	if($save)
		echo $save;
}

if($action == "decline_topic"){
	$save = $crud->decline_topic();
	if($save)
		echo $save;
}

if($action == "like_post"){
	$save = $crud->like_post();
	if($save)
		echo $save;
}

if($action == "unlike_post"){
	$save = $crud->unlike_post();
	if($save)
		echo $save;
}

if($action == "save_report_post"){
	$save = $crud->save_report_post();
	if($save)
		echo $save;
}


if($action == "save_comment"){
	$save = $crud->save_comment();
	if($save)
		echo $save;
}
if($action == "delete_comment"){
	$save = $crud->delete_comment();
	if($save)
		echo $save;

}

if($action == "approve_comment"){
	$save = $crud->approve_comment();
	if($save)
		echo $save;
}

if($action == "decline_comment"){
	$save = $crud->decline_comment();
	if($save)
		echo $save;
}

if($action == "save_reply"){
	$save = $crud->save_reply();
	if($save)
		echo $save;
}
if($action == "delete_reply"){
	$save = $crud->delete_reply();
	if($save)
		echo $save;

}
if($action == "update_alumni_acc"){
	$save = $crud->update_alumni_acc();
	if($save)
		echo $save;
}

if($action == "delete_gallery"){
	$save = $crud->delete_gallery();
	if($save)
		echo $save;
}

if($action == "save_career"){
	$save = $crud->save_career();
	if($save)
		echo $save;
}
if($action == "delete_career"){
	$save = $crud->delete_career();
	if($save)
		echo $save;
}

if($action == "save_article"){
	$save = $crud->save_article();
	if($save)
		echo $save;
}

if($action == "save_appointment"){
	$save = $crud->save_appointment();
	if($save)
		echo $save;
}

if($action == "approve_counselor_request"){
	$save = $crud->approve_counselor_request();
	if($save)
		echo $save;
}

if($action == "decline_counselor_request"){
	$save = $crud->decline_counselor_request();
	if($save)
		echo $save;
}

if($action == "save_article_rating"){
	$save = $crud->save_article_rating();
	if($save)
		echo $save;
}

if($action == "save_article_comment"){
	$save = $crud->save_article_comment();
	if($save)
		echo $save;
}

if($action == "delete_article_comment"){
	$save = $crud->delete_article_comment();
	if($save)
		echo $save;
}

if($action == "save_embed"){
	$save = $crud->save_embed();
	if($save)
		echo $save;
}

if($action == "save_embed_comment"){
	$save = $crud->save_embed_comment();
	if($save)
		echo $save;
}

if($action == "delete_embed_comment"){
	$save = $crud->delete_embed_comment();
	if($save)
		echo $save;
}

if($action == "save_media"){
	$uploadStatus = $crud->save_media();
    if($uploadStatus)
        echo $uploadStatus;
}

if($action == "save_media_comment"){
	$save = $crud->save_media_comment();
	if($save)
		echo $save;
}

if($action == "delete_media_comment"){
	$save = $crud->delete_media_comment();
	if($save)
		echo $save;
}

if($action == "save_event"){
	$save = $crud->save_event();
	if($save)
		echo $save;
}
if($action == "delete_event"){
	$save = $crud->delete_event();
	if($save)
		echo $save;
}

if($action == 'search2'){
	$search = $crud->search2();
	echo $search;
	exit();
}

if($action == 'search_resources'){
	$search = $crud->search_resources();
	echo $search;
	exit();
}
if($action == "search"){
	$get = $crud->search();
	if($get)
		echo $get;
}

if($action == "mark_as_read"){
	$mark_as_read = $crud->mark_as_read();
    if($mark_as_read)
        echo $mark_as_read;
}

if($action == "participate"){
	$save = $crud->participate();
	if($save)
		echo $save;
}
if($action == "get_venue_report"){
	$get = $crud->get_venue_report();
	if($get)
		echo $get;
}
if($action == "save_art_fs"){
	$save = $crud->save_art_fs();
	if($save)
		echo $save;
}
if($action == "delete_art_fs"){
	$save = $crud->delete_art_fs();
	if($save)
		echo $save;
}
if($action == "get_pdetails"){
	$get = $crud->get_pdetails();
	if($get)
		echo $get;
}
ob_end_flush();
?>