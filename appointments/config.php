<?php 
 
// Database configuration    
define('DB_HOST', 'cap-2233-cap2233.a.aivencloud.com:10292'); 
define('DB_USERNAME', 'avnadmin'); 
define('DB_PASSWORD', 'AVNS_ZQTc4dKbpYkzHCia2nZ'); 
define('DB_NAME', 'cap2233'); 
 
// Google API configuration 
define('GOOGLE_CLIENT_ID', '96495206225-nrkdgli2pu259k6fclc647ntorprf0qj.apps.googleusercontent.com'); 
define('GOOGLE_CLIENT_SECRET', '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'); 
define('GOOGLE_OAUTH_SCOPE', 'https://www.googleapis.com/auth/calendar'); 
define('REDIRECT_URI', 'http://localhost/cap-2233/index.php?page=appointments/calendarsync'); 
 
// Start session 
if(!session_id()) session_start(); 
 
// Google OAuth URL 
$googleOauthURL = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode(GOOGLE_OAUTH_SCOPE) . '&redirect_uri=' . REDIRECT_URI . '&response_type=code&client_id=' . GOOGLE_CLIENT_ID . '&access_type=online'; 
 
?>