<?php include 'topbar.php' ?>

    <style>
        /* Custom CSS for navbar */
        .navbar-color {
            background-color: #0d622a; /* Navbar background color */
            overflow: hidden;
        }

        .nav-link {
            color: #ffffff; /* Text color for links */
            transition: background-color 0.3s, color 0.3s; /* Smooth transition effect */
            border-radius: 30px;
            
        }

        .dropdown-item {
            color: #0b5523; /* Text color for links */
            transition: background-color 0.3s, color 0.3s; /* Smooth transition effect */
            padding-left: 15px;
        }

        .dditem-link{
            color: #ffffff; /* Text color for links */
            transition: background-color 0.3s, color 0.3s; /* Smooth transition effect */
            border-radius: 30px;
            padding-left: 15px;
        }

        /* Active link color */
        .nav-link.active-link{
            color: #0b5523; /* Text color for active links */
            background-color: #ffffff; /* Background color for active links */
            border-radius: 30px;
        }

        @media (min-width: 768px) {

            .dditem{
                margin-left:20px;
                width: 200px;
            }

            .dditem1{
                margin-left:20px;
                width: 280px;
            }

            ul{
                margin-left: -10px;
            }

            .nav li.submenu {
                width:500%;
                border-radius: 30px;
            }

            .nav li.submenu:hover {
                background-color: #ffffff; /* Background color for links on hover */
                border-radius: 30px;
                transition: background-color 0.3s, color 0.3s;
                color: #0b5523;
            }

            .nav-link:hover{
                color: #0b5523; /* Text color for links on hover */
                border-radius: 30px;
            }

            .dropdown-item:hover {
                color: #ffffff; /* Text color for links on hover */
                background-color: #0b5523; /* Background color for links on hover */
                transition: background-color 0.3s, color 0.3s;
            }
            

            .accordion-dropdown a:hover{
                background-color: #ffffff; /* Background color for links on hover */
                border-radius: 30px;
                transition: background-color 0.3s, color 0.3s;
                color: #0b5523;
            }

            .accordion-dropdown a.smenu {
                width:500%;
                border-radius: 30px;
            }
        }

        /* Hover effect for smaller screens */
        @media (max-width: 767px) {
            .nav-link:hover {
                color: #0b5523; /* Text color for links on hover */
                background-color: #ffffff; /* Background color for links on hover */
            }

            .dropdown-item:hover {
                color: #ffffff; /* Text color for links on hover */
                background-color: #0b5523; /* Background color for links on hover */
            }

            .accordion-dropdown a:hover{
                background-color: #ffffff; /* Background color for links on hover */
                border-radius: 30px;
                transition: background-color 0.3s, color 0.3s;
                color: #0b5523;
            }
        }

        .bi {
            color: #ffffff; /* Color for icons */
        }


        .navbar-links a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .notification-badge {
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 3px 6px;
            font-size: 12px;
            position: relative;
            top: -10px;
            left: -6px;
        }


    </style>

<?php
    // Start session and connect to your database
    include 'db_connect.php';  // Include your database connection

    // Assuming you have a session to track the logged-in user
    $userID = $_SESSION['login_id'];

    // Query to count unread notifications
    $sql = "SELECT COUNT(*) as unread_count FROM notifications WHERE posterID=? AND is_read=0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $unreadCount = 0;

    if ($result && $row = $result->fetch_assoc()) {
        $unreadCount = $row['unread_count'];
    }
?>

<div class="container-fluid overflow-hidden">
    <div class="row overflow-auto">
        <div class="col-12 col-sm-3 col-xl-2 px-sm-2 navbar-color px-0 d-flex sticky-top ">
            <div class="d-flex flex-sm-column vh-100  flex-row flex-grow-1 align-items-sm-start px-3 pt-2 text-white">

                <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-sm-start" id="menu">
                    <li class="submenu">
                        <a href="index.php?page=home" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline"> Home</span>
                        </a>
                    </li>
                    <?php if($_SESSION['login_type'] != 4): ?>
                    <li class="submenu">
                        <a href="index.php?page=notifications/notification" class="nav-link px-sm-3 px-2" id="notificationLink">
                             <i class="fs-5 bi bi-bell"><?php if ($unreadCount > 0): ?>
                                <span class="notification-badge"><?php echo $unreadCount; ?></span>
                            <?php endif; ?></i> Notifications
                            
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="accordion accordion-dropdown" id="accordion1">
                        <a href="index.php?page=" class="collapsed nav-link px-sm-3 px-2 smenu" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <i class="fs-5 bi-info-circle"></i><span class="ms-1 d-none d-sm-inline"> Resources and Information</span> </a>
                    
                        </a>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion1">
                            <div>
                                <ul class="nav">   
                               <!-- <li class="dditem"><a class="dropdown-item dditem-link" href="index.php?page=information_resources/home"><i class="fs-5 bi-house-door"></i> Home</a></li> -->
                                <li class="dditem"><a class="dropdown-item dditem-link" href="index.php?page=information_resources/articles"><i class="fs-5 bi-newspaper"></i> Articles</a></li>
                                <li class="dditem"><a class="dropdown-item dditem-link" href="index.php?page=information_resources/medias"><i class="fs-5 bi-image"></i> Media Resources</a></li>
                            </ul>
                            </div>  
                        </div>
                    </li>

                    <li class="accordion accordion-dropdown" id="accordion2">
                        <a href="index.php?page=" class="collapsed nav-link px-sm-3 px-2 smenu" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="fs-5 bi-chat-dots"></i><span class="ms-1 d-none d-sm-inline"> Social Interaction</span> </a>
                    
                        </a>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion2">
                            <div>
                                <ul class="nav">   
                                <li class="dditem"><a class="dropdown-item dditem-link" href="index.php?page=social_interaction/categories"><i class="fs-5 bi-tag"></i> Categories/Tags</a></li>
                                <li class="dditem"><a class="dropdown-item dditem-link" href="index.php?page=social_interaction/followed_categories"><i class="fs-5 bi-tags"></i> Followed Categories</a></li>
                                <li class="dditem"><a class="dropdown-item dditem-link" href="index.php?page=social_interaction/topics"><i class="fs-5 bi-chat"></i> Discussion</a></li>
                                <?php if($_SESSION['login_type'] == 1 || $_SESSION['login_type'] == 4): ?>
                                <li class="dditem"><a class="dropdown-item dditem-link" href="index.php?page=social_interaction/post_approval"><i class="fs-5 bi-file-earmark-check"></i> Pending Posts</a></li>
                                <li class="dditem"><a class="dropdown-item dditem-link" href="index.php?page=social_interaction/comment_approval"><i class="fs-5 bi-chat-left-quote"></i> Pending Comments</a></li>
                                <?php endif; ?>
                            </ul>
                            </div>  
                        </div>
                    </li>
                    <?php if($_SESSION['login_type'] != 4): ?>               
                    <li class="accordion accordion-dropdown" id="accordion3">
                        <a href="index.php?page=" class="collapsed nav-link px-sm-3 px-2 smenu" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <i class="fs-5 bi-calendar-check"></i><span class="ms-1 d-none d-sm-inline"> Counseling Appointment</span> </a>
                    
                        </a>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion3">
                            <div>
                                <ul class="nav">   
                                <?php if($_SESSION['login_type'] == 1): ?>
                                <li class="dditem"><a class="dropdown-item dditem-link" href="index.php?page=appointments/counselor_approval"><i class="fs-5 bi-file-earmark-check"></i> Counselor Requests</a></li>
                                <?php endif; ?>
                                <?php if($_SESSION['login_type'] == 5): ?>
                                <li class="dditem1"><a class="dropdown-item dditem-link" href="index.php?page=appointments/eventmaker"><i class="fs-5 bi-clipboard-plus"></i> Add Appointment Request</a></li>
                                <?php endif; ?>
                                <?php if( $_SESSION['login_type'] == 3): ?>
                                <li class="dditem1"><a class="dropdown-item dditem-link" href="index.php?page=appointments/pendingappointments"><i class="fs-5 bi-file-earmark-check"></i> Appointments</a></li>
                                <li class="dditem"><a class="dropdown-item dditem-link" href="index.php?page=appointments/client_records"><i class="fs-5 bi-archive"></i> Client Records</a></li>
                                <?php endif; ?>
                            </ul>
                            </div>  
                        </div>
                    </li>
                    <?php endif; ?>

                    <li class="accordion accordion-dropdown" id="accordion4">
                        <a href="index.php?page=" class="collapsed nav-link px-sm-3 px-2 smenu" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <i class="fs-5 bi-activity"></i><span class="ms-1 d-none d-sm-inline"> Crisis Support</span> </a>
                    
                        </a>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion4">
                            <div>
                                <ul class="nav">   
                                <li class="dditem1"><a class="dropdown-item dditem-link" href="index.php?page=crisis_support/crisisresources"><i class="fs-5 bi-link-45deg"></i> External Crisis Support Links</a></li>
                            </ul>
                            </div>  
                        </div>
                    </li>

                    <?php if($_SESSION['login_type'] == 1): ?>
                    <li class="accordion accordion-dropdown" id="accordion5">
                        <a href="index.php?page=" class="collapsed nav-link px-sm-3 px-2 smenu" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            <i class="fs-5 bi-gear"></i><span class="ms-1 d-none d-sm-inline"> Admin Tools</span> </a>
                    
                        </a>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion5">
                            <div>
                                <ul class="nav">   
                           <!--     <li class="dditem"><a class="dropdown-item dditem-link" href="index.php?page=social_interaction/post_reports"><i class="fs-5 bi-flag"></i> Post Reports</a></li> -->
                                <li class="dditem"><a class="dropdown-item dditem-link" href="index.php?page=social_interaction/users"><i class="fs-5 bi-people"></i> Users</a></li>
                            </ul>
                            </div>  
                        </div>
                    </li>
                    <?php endif; ?>
                    
                    <!-- FAQs page -->
                    <li class="submenu">
                        <a href="index.php?page=faqs" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-question-circle"></i><span class="ms-1 d-none d-sm-inline"> FAQs</span>
                        </a>
                    </li>

<!--
                    <li class="nav-item submenu">
                        <a href="index.php?page=home" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline"> Home</span>
                        </a>
                    </li>
                    <li class="submenu">
                        <a href="index.php?page=categories" data-bs-toggle="collapse" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-tag"></i><span class="ms-1 d-none d-sm-inline"> Category/Tags</span> </a>
                    </li>
                    <li class="submenu">
                        <a href="index.php?page=topics" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-chat"></i><span class="ms-1 d-none d-sm-inline"> Discussion</span></a>
                    </li>
					<?php if($_SESSION['login_type'] == 1): ?>
                    	<li class="submenu">
                        	<a href="index.php?page=users" class="nav-link px-sm-3 px-2">
                            	<i class="fs-5 bi-people"></i><span class="ms-1 d-none d-sm-inline"> Users</span></a>
                    	</li>
                    	<li class="submenu">
                        	<a href="index.php?page=post_reports" class="nav-link px-sm-3 px-2">
                            	<i class="fs-5 bi-flag"></i><span class="ms-1 d-none d-sm-inline"> Post Reports</span> </a>
                    	</li>
					<?php endif; ?> -->
                </ul>
            </div>
        </div>
        <div class="col d-flex flex-column h-sm-100">
            <main class="row overflow-auto">
                <div class="col">
                 
			
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the current page URL
        var currentPageUrl = window.location.href;

        // Get all navbar links
        var navbarLinks = document.querySelectorAll(".nav-link");

        // Loop through each navbar link
        navbarLinks.forEach(function(link) {
            // Check if the link's href matches the current page URL
            if (link.href === currentPageUrl) {
                // Add the "active" class to the active link
                link.classList.add("active-link");
            }
        });
    });
</script>