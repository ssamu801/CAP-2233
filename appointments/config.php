<?php 
 
// Database configuration    
define('DB_HOST', 'cap-2233-cap2233.a.aivencloud.com:10292'); 
define('DB_USERNAME', 'avnadmin'); 
define('DB_PASSWORD', 'AVNS_ZQTc4dKbpYkzHCia2nZ'); 
define('DB_NAME', 'cap2233'); 
 
// Google API configuration 
define('GOOGLE_CLIENT_ID', '472089813729-248s67smlbbus4r3jl488hdjh0pe77ck.apps.googleusercontent.com'); 
define('GOOGLE_CLIENT_SECRET', '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'); 
define('GOOGLE_OAUTH_SCOPE', 'https://www.googleapis.com/auth/calendar'); 
define('REDIRECT_URI', 'http://localhost:3000/calendarsync.php'); 
 
// Start session 
if(!session_id()) session_start(); 
 
// Google OAuth URL 
$googleOauthURL = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode(GOOGLE_OAUTH_SCOPE) . '&redirect_uri=' . REDIRECT_URI . '&response_type=code&client_id=' . GOOGLE_CLIENT_ID . '&access_type=online'; 
 
?>