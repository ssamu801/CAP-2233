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
            color: #0d622a; /* Text color for links */
            transition: background-color 0.3s, color 0.3s; /* Smooth transition effect */
            padding-right: 100px;
        }

        /* Active link color */
        .nav-link.active-link{
            color: #0b5523; /* Text color for active links */
            background-color: #ffffff; /* Background color for active links */
            border-radius: 30px;
        }

        @media (min-width: 768px) {

            ul{
                margin-left: -10px;
            }

            .nav li.submenu {
                width:500%;
                border-radius: 30px;
            }

            .nav li:hover {
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
        }

        .bi {
            color: #ffffff; /* Color for icons */
        }

		.collapse a{
		text-indent:10px;
	}
    </style>

<div class="container-fluid overflow-hidden">
    <div class="row vh-100 overflow-auto">
        <div class="col-12 col-sm-3 col-xl-2 px-sm-2 navbar-color px-0 d-flex sticky-top ">
            <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-sm-start px-3 pt-2 text-white">

                <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-sm-start" id="menu">
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
					<?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="col d-flex flex-column h-sm-100">
            <main class="row overflow-auto">
                <div class="col">
                 
			
