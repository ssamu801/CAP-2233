<?php
    include 'db_connect.php';

    $login_id = $_SESSION['login_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/resourcesstyle.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
</head>
<style>
    .navbarr {
        display: flex;
        justify-content: flex-start;
        text-align: center;
        background-color: #333;
        padding: 0;
    }

    .btn {
        font-size: 15px;
        margin-left: -5px;
    }

    .navbarr a {
        text-decoration: none;
        color: white;
        font-size: 18px;
        margin: 0 15px 0 15px;
        cursor: pointer;
        padding: 10px;
    }

    .navbarr a:hover:not(.activee) {
        background-color: #111;
        padding: 10px;
    }

    .activee {
        background-color: #04AA6D;
    }

    .content {
        margin: 10px 20px;
        padding: 10px;
    }

    .card {
        background-color: #fff;
        border-radius: 10px;
        border: none;
        position: relative;
        margin-bottom: 30px;
        box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1);
    }

    .sm-bg-green {
        background: linear-gradient(to right, #493240, #f09) !important;
        color: #fff;
    }

    .sm-bg-green {
        background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
        color: #fff;
    }

    .cards .row {
        display: flex;
        flex-wrap: wrap;
    }

    .cards .col-md-3, .cards .col-sm-6 {
        padding: 2px;
        margin-bottom: 2px;
    }

    .cards .card {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        margin: 5px;
        text-align: start;
    }

    .card-icon-large {
        font-size: 40px;
        bottom: 25px;
        right: 15px;
        opacity: 0.15;
        color: #000;
        position: absolute;
    }

    .card-title {
        font-size: 16px;
        margin: 10px;
    }

    .card h1 {
        font-size: 36px; 
        margin-left: 10px;
        margin-top: 10px;
    }

    .nav-tabs .tabs {
        padding: 5px 10px 5px 10px;
        margin-left: 5px;
        color: #444444;
        border-radius: 10px 10px 0 0;
        
    }
    .nav-tabs .tabs.active {
        background-color: #107a32;
        border-color: #dee2e6 #dee2e6 #fff;
        color: white;
        border-radius: 10px 10px 0 0;
    }
    .nav-tabs .tabs:hover {
        background-color: #107a32;
        border-color: #dee2e6 #dee2e6 #fff;
        color: white;
        border-radius: 10px 10px 0 0;
    }

    @media screen & (max-width: 768px) {
        .navbarr {
            flex-direction: column;
            align-items: stretch;
        }
        .navbarr a {
            margin: 5px 0;
        }
    }
</style>
<body>
    <div class="main">
        <div id="wrapper-container" class="wrapper-container">
            <div class="container-pusher">
                <div class="content-pusher">
                    <header id="head" class="site-header" style="margin: 10px;">
                        <div class="headings" style="margin-top: 10px;">
                            <h2 style="color: green; font-size: 30px; font-weight: 700; font-style: normal;">Admin Dashboard</h2>
                            <b><?php echo "Welcome back, " . $_SESSION['login_name'] . "!"; ?></b>
                        </div>
                    </header>
                    <hr style="margin: 10px 20px;">
                    <div class="row">
                        <!-- users and resources column -->
                        <div class="col-md-6">
                            <div class="card user-info">
                                <div class="card-body">
                                    <div class="content">
                                        <h4>
                                            <button type="button" class="btn btn-outline-success">View Users</button>
                                        </h4>
                                        <div class="cards">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-6">
                                                    <div class="card sm-bg-green">
                                                        <div class="card-statistic-3 p-2">
                                                            <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                                            <div class="mb-0">
                                                                <h5 class="card-title mb-0">Total Users</h5>
                                                            </div>
                                                            <div class="row align-items-center mb-2 d-flex">
                                                                <div class="col-8">
                                                                    <h1 class="d-flex align-items-center mb-0">
                                                                        <?php
                                                                            $sql = "SELECT COUNT(*) AS total_users FROM users";
                                                                            $result = $conn->query($sql);
                                                                            if ($result->num_rows > 0) {
                                                                                $row = $result->fetch_assoc();
                                                                                echo $row['total_users'];
                                                                            } else {
                                                                                echo "0";
                                                                            }
                                                                        ?>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="card sm-bg-green">
                                                        <div class="card-statistic-3 p-2">
                                                            <div class="card-icon card-icon-large"><i class="fas fa-user-graduate"></i></div>
                                                            <div class="mb-0">
                                                                <h5 class="card-title mb-0">Students</h5>
                                                            </div>
                                                            <div class="row align-items-center mb-2 d-flex">
                                                                <div class="col-8">
                                                                    <h1 class="d-flex align-items-center mb-0">
                                                                        <?php
                                                                            $sql = "SELECT COUNT(*) AS total_users FROM users WHERE type = '5'";
                                                                            $result = $conn->query($sql);
                                                                            if ($result->num_rows > 0) {
                                                                                $row = $result->fetch_assoc();
                                                                                echo $row['total_users'];
                                                                            } else {
                                                                                echo "0";
                                                                            }
                                                                        ?>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="card sm-bg-green">
                                                        <div class="card-statistic-3 p-2">
                                                            <div class="card-icon card-icon-large"><i class="fas fa-user-tie"></i></div>
                                                            <div class="mb-0">
                                                                <h5 class="card-title mb-0">Counselors</h5>
                                                            </div>
                                                            <div class="row align-items-center mb-2 d-flex">
                                                                <div class="col-8">
                                                                    <h1 class="d-flex align-items-center mb-0">
                                                                        <?php
                                                                            $sql = "SELECT COUNT(*) AS total_users FROM users WHERE type = '3'";
                                                                            $result = $conn->query($sql);
                                                                            if ($result->num_rows > 0) {
                                                                                $row = $result->fetch_assoc();
                                                                                echo $row['total_users'];
                                                                            } else {
                                                                                echo "0";
                                                                            }
                                                                        ?>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="card sm-bg-green">
                                                        <div class="card-statistic-3 p-2">
                                                            <div class="card-icon card-icon-large"><i class="fas fa-user-secret"></i></div>
                                                            <div class="mb-0">
                                                                <h5 class="card-title mb-0">Moderators</h5>
                                                            </div>
                                                            <div class="row align-items-center mb-2 d-flex">
                                                                <div class="col-8">
                                                                    <h1 class="d-flex align-items-center mb-0">
                                                                        <?php
                                                                            $sql = "SELECT COUNT(*) AS total_users FROM users WHERE type = '4'";
                                                                            $result = $conn->query($sql);
                                                                            if ($result->num_rows > 0) {
                                                                                $row = $result->fetch_assoc();
                                                                                echo $row['total_users'];
                                                                            } else {
                                                                                echo "0";
                                                                            }
                                                                        ?>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="card sm-bg-green">
                                                        <div class="card-statistic-3 p-2">
                                                            <div class="card-icon card-icon-large"><i class="fas fa-user"></i></div>
                                                            <div class="mb-0">
                                                                <h5 class="card-title mb-0">Others</h5>
                                                            </div>
                                                            <div class="row align-items-center mb-2 d-flex">
                                                                <div class="col-8">
                                                                    <h1 class="d-flex align-items-center mb-0">
                                                                        <?php
                                                                            $sql = "SELECT COUNT(*) AS total_users FROM users WHERE type = '1' OR type = '2'";
                                                                            $result = $conn->query($sql);
                                                                            if ($result->num_rows > 0) {
                                                                                $row = $result->fetch_assoc();
                                                                                echo $row['total_users'];
                                                                            } else {
                                                                                echo "0";
                                                                            }
                                                                        ?>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--
                                        <button type="button" class="btn btn-outline-primary">Edit Users</button>
                                        <button type="button" class="btn btn-outline-danger">Deactivate Users</button>
                                        -->
                                    </div>
                                    <div class="posts">
                                        <div class="card">
                                            <div class="card-header">
                                                <ul class="nav nav-tabs card-header-tabs" id="postTabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="tabs active" id="flagged-posts-tab" data-toggle="tab" href="#flagged-posts" role="tab" aria-controls="flagged-posts" aria-selected="true">Flagged Posts</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="tabs" id="reported-posts-tab" data-toggle="tab" href="#reported-posts" role="tab" aria-controls="reported-posts" aria-selected="false">Post Reports</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-header bg-white border-bottom-0 ml-2">
                                                <?php // Get unique student IDs
                                                    $sql_students = "SELECT id FROM users WHERE type = '5'";
                                                    $result_students = $conn->query($sql_students);

                                                    $student_ids = [];
                                                    if ($result_students->num_rows > 0) {
                                                        while ($row_student = $result_students->fetch_assoc()) {
                                                            $student_ids[] = $row_student['id'];
                                                        }
                                                    }
                                                ?>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-body tab-content pt-1" id="postTabsContent">
                                                    <div class="tab-pane fade show active" id="flagged-posts" role="tabpanel" aria-labelledby="flagged-posts-tab">
                                                        <div class="table-container">
                                                            <ul class="w-100 list-group" id="topic-list">
                                                                <?php
                                                                // Get tags
                                                                $tag = $conn->query("SELECT * FROM categories ORDER BY name ASC");
                                                                while ($row = $tag->fetch_assoc()) {
                                                                    $tags[$row['id']] = $row['name'];
                                                                }

                                                                // Get unique student IDs for the new query
                                                                $sql_students = "SELECT id FROM users WHERE type = '5'";
                                                                $result_students = $conn->query($sql_students);

                                                                $i = 0;
                                                                if ($result_students->num_rows > 0) {
                                                                    while ($row_student = $result_students->fetch_assoc()) {
                                                                        $student_id = $row_student['id'];

                                                                            // Get topics for each student_id
                                                                            $sql_topics = "SELECT t.*, u.name 
                                                                                        FROM topics t 
                                                                                        INNER JOIN users u ON u.id = t.user_id 
                                                                                        WHERE t.user_id = $student_id 
                                                                                        ORDER BY unix_timestamp(date_created) DESC";
                                                                            $topic = $conn->query($sql_topics);

                                                                            while ($row = $topic->fetch_assoc()) {
                                                                                $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
                                                                                unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                                                                                $desc = strtr(html_entity_decode($row['content']), $trans);
                                                                                $desc = str_replace(array("<li>", "</li>"), array("", ","), $desc);
                                                                                $view = $conn->query("SELECT * FROM forum_views WHERE topic_id=" . $row['id'])->num_rows;
                                                                                $comments = $conn->query("SELECT * FROM comments WHERE topic_id=" . $row['id'])->num_rows;
                                                                                $replies = $conn->query("SELECT * FROM replies WHERE comment_id IN (SELECT id FROM comments WHERE topic_id=" . $row['id'] . ")")->num_rows;

                                                                                // Check for detected words
                                                                                $wordsToDetect = [];
                                                                                $stmt = $conn->query("SELECT word FROM word_bank WHERE type='Mental Health'");
                                                                                while ($word_row = $stmt->fetch_assoc()) {
                                                                                    $wordsToDetect[] = $word_row['word'];
                                                                                }

                                                                                $text = strip_tags($desc);
                                                                                $detected = false;

                                                                                foreach ($wordsToDetect as $word) {
                                                                                    if (stripos($text, $word) !== false) {
                                                                                        $detected = true;
                                                                                        break;
                                                                                    }
                                                                                }

                                                                                if ($detected) {
                                                                                    $i++;
                                                                                    ?>
                                                                                    <li class="list-group-item mb-4">
                                                                                        <div>
                                                                                            <a href="index.php?page=social_interaction/view_pending_post&id=<?php echo $row['id'] ?>" class="filter-text"><?php echo $row['title'] ?></a>
                                                                                        </div>
                                                                                        <div>
                                                                                            <span style="font-size: smaller;"> <i class="bi bi-tags-fill"></i> Tags: </span>
                                                                                            <?php foreach (explode(",", $row['category_ids']) as $cat): ?>
                                                                                                <span class="badge badge-info text-white ml-2"><?php echo $tags[$cat] ?></span>
                                                                                            <?php endforeach; ?>
                                                                                        </div>
                                                                                        <hr>
                                                                                        <p class="truncate filter-text"><?php echo strip_tags($desc) ?></p>
                                                                                        <?php if ($row['isAnonymous'] == 1): ?>
                                                                                            <p class="row justify-content-left mr-1"><span class="badge badge-success text-white"><i>Posted anonymously</i></span></p>
                                                                                        <?php else: ?>    
                                                                                            <p class="row float-right mr-1"><span class="badge badge-success text-white"><i>Posted By: <?php echo $row['name'] ?></i></span></p>
                                                                                            <br>
                                                                                        <?php endif; ?>
                                                                                        <hr>
                                                                                        <span class="float-left"><strong>Words Detected: </strong></span>
                                                                                        <br>
                                                                                        <span class="float-left mr-1"><small><i>
                                                                                        <?php
                                                                                            $i = 0;
                                                                                            foreach ($wordsToDetect as $word) {
                                                                                                if (stripos($text, $word) !== false) {
                                                                                                    echo  $word . " ";
                                                                                                    $i++;
                                                                                                }
                                                                                            }

                                                                                            if ($i == 0) {
                                                                                                echo "None detected.";
                                                                                            }
                                                                                        ?>
                                                                                        </i></small>
                                                                                    </li>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                    }
                                                                    if($i == 0){
                                                                        echo "<li class='list-group-item'>No values. </li>";
                                                                    }
                                                                } else {
                                                                    echo "<li class='list-group-item'No flagged posts.</li>";
                                                                }

                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="reported-posts" role="tabpanel" aria-labelledby="reported-posts-tab">
                                                        <div class="table-container">
                                                            <ul class="w-100 list-group" id="topic-list">
                                                                <?php 
                                                                    $report = $conn->query("SELECT u.username, t.content, t.id, pr.date_reported, pr.report_reason FROM post_reports pr JOIN users u on u.id=pr.reporter_id JOIN topics t on pr.post_id = t.id ORDER BY unix_timestamp(date_reported) DESC");
                                                                    while($row = $report->fetch_assoc()):
                                                                        $rawCommentDateTime = $row['date_reported'];
                                                                        $commentDateTimeObj = new DateTime($rawCommentDateTime);
                                                                        $formattedCommentDateTime = $commentDateTimeObj->format('Y-m-d h:i A');
                                                                        $trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
                                                                        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                                                                        $desc = strtr(html_entity_decode($row['content']),$trans);
                                                                        $desc=str_replace(array("<li>","</li>"), array("",","), $desc);
                                                                    ?>
                                                                    <li class='list-group-item mb-4'>
                                                                        <div>
                                                                            <span><b>Reported By: <?php echo $row['username'] ?></b></span>
                                                                        </div>
                                                                        <div>
                                                                            <span><b>Date Reported: <?php echo $formattedCommentDateTime?></b></span>
                                                                        </div>
                                                                        <div>
                                                                            <span><b>Reason for Reporting: </b><?php echo $row['report_reason'] ?></span>
                                                                        </div>
                                                                        <div>
                                                                            <span><b>Content: </b></span>
                                                                            <span class="truncate"><?php echo strip_tags($desc) ?></span>
                                                                            <a href="index.php?page=social_interaction/view_forum&id=<?php echo $row['id'] ?>" class="truncate text-primary">View full post</a>
                                                                        </div>
                                                                    </li>
                                                                <?php endwhile; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- appointments column -->
                        <div class="col-md-6">
                            <div class="card user-info">
                                <div class="card-body">
                                    <div class="content">
                                        <h4>
                                            <button type="button" class="btn appointments btn-outline-success">View Appointments</button>
                                        </h4>
                                        <div class="cards">
                                            <div class="row">
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="card sm-bg-green">
                                                        <div class="card-statistic-3 p-2">
                                                            <div class="card-icon card-icon-large"><i class="bis bi-file-text-fill"></i></div>
                                                            <div class="mb-0">
                                                                <h5 class="card-title mb-0">All Events</h5>
                                                            </div>
                                                            <div class="row align-items-center mb-2 d-flex">
                                                                <div class="col-8">
                                                                    <h1 class="d-flex align-items-center mb-0">
                                                                    <?php 
                                                                        $sql = "SELECT COUNT(*) AS total_rows FROM events";

                                                                        // Execute the query
                                                                        $result = $conn->query($sql);

                                                                        if ($result->num_rows > 0) {
                                                                            // Fetch the result
                                                                            $row = $result->fetch_assoc();
                                                                            echo $row['total_rows'];
                                                                        } else {
                                                                            echo "0";
                                                                        }
                                                                    ?>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="card sm-bg-green">
                                                        <div class="card-statistic-3 p-2">
                                                            <div class="card-icon card-icon-large"><i class="bis bi-people-fill"></i></div>
                                                            <div class="mb-0">
                                                                <h5 class="card-title mb-0">Pending</h5>
                                                            </div>
                                                            <div class="row align-items-center mb-2 d-flex">
                                                                <div class="col-8">
                                                                    <h1 class="d-flex align-items-center mb-0">
                                                                        <?php
                                                                            $sql = "SELECT COUNT(*) AS total_pending FROM events WHERE status = 'Pending'";
                                                                            $result = $conn->query($sql);
                                                                            if ($result->num_rows > 0) {
                                                                                $row = $result->fetch_assoc();
                                                                                echo $row['total_pending'];
                                                                            } else {
                                                                                echo "0";
                                                                            }
                                                                        ?>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="card sm-bg-green">
                                                        <div class="card-statistic-3 p-2">
                                                            <div class="card-icon card-icon-large"><i class="bis bi-check2-square"></i></div>
                                                            <div class="mb-0">
                                                                <h5 class="card-title mb-0">Completed</h5>
                                                            </div>
                                                            <div class="row align-items-center mb-2 d-flex">
                                                                <div class="col-8">
                                                                    <h1 class="d-flex align-items-center mb-0">
                                                                        <?php
                                                                            $sql = "SELECT COUNT(*) AS total_completed FROM events WHERE status = 'Accepted'";
                                                                            $result = $conn->query($sql);
                                                                            if ($result->num_rows > 0) {
                                                                                $row = $result->fetch_assoc();
                                                                                echo $row['total_completed'];
                                                                            } else {
                                                                                echo "0";
                                                                            }
                                                                        ?>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="card sm-bg-green">
                                                        <div class="card-statistic-3 p-2">
                                                            <div class="card-icon card-icon-large"><i class="bis bi-person-x-fill"></i></div>
                                                            <div class="mb-0">
                                                                <h5 class="card-title mb-0">Cancelled</h5>
                                                            </div>
                                                            <div class="row align-items-center mb-2 d-flex">
                                                                <div class="col-8">
                                                                    <h1 class="d-flex align-items-center mb-0">
                                                                        <?php
                                                                            $sql = "SELECT COUNT(*) AS total_cancel FROM events WHERE status = 'No Show'";
                                                                            $result = $conn->query($sql);
                                                                            if ($result->num_rows > 0) {
                                                                                $row = $result->fetch_assoc();
                                                                                echo $row['total_cancel'];
                                                                            } else {
                                                                                echo "0";
                                                                            }
                                                                        ?>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--
                                        <button type="button" class="btn btn-outline-primary">Edit Users</button>
                                        <button type="button" class="btn btn-outline-danger">Deactivate Users</button>
                                        -->
                                    </div>

                                    <!-- display scheduled appointments for the day -->
                                    <div class="appointments mb-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <b>Scheduled Appointments</b>
                                                <b class="float-right"><?php echo date('Y-m-d') . ", " . date('l'); ?></b>
                                            </div>
                                            <div class="card-body table-container">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Student</th>
                                                            <th class="text-center">Date</th>
                                                            <th class="text-center">Counselor</th>
                                                            <th class="text-center">Time</th>
                                                            <th class="text-center">Mode</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr style="background-color: #84b894;">
                                                        <?php
                                                            // SQL query to select records from today
                                                            $sql = "SELECT user_name, date, counselor_name, time_from, time_to, mode
                                                                    FROM events
                                                                    WHERE DATE(date) = CURDATE()
                                                                    ORDER BY time_from, time_to";
                                                            
                                                            // Execute the query
                                                            $result = $conn->query($sql);

                                                            if ($result->num_rows > 0) {
                                                                // Output data of each row
                                                                while($row = $result->fetch_assoc()) {
                                                                    echo "<tr>";
                                                                    echo "<td class='text-center'>" . $row["user_name"] . "</td>";
                                                                    echo "<td class='text-center'>" . $row["date"] . "</td>";
                                                                    echo "<td class='text-center'>" . $row["counselor_name"] . "</td>";
                                                                    echo "<td class='text-center'>" . $row["time_from"] . " - ". $row["time_to"] . "</td>";
                                                                    echo "<td class='text-center'>" . $row["mode"] . "</td>";
                                                                    echo "</tr>";
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='5' class='text-center'>No appointments scheduled for today</td></tr>";
                                                            } 
                                                        ?>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="appointments mb-4">
                                        <div class="card">
                                            <div class="card-header mb-3">
                                                <b>Calendar</b>
                                            </div>
                                            <div class="card-body calendar-container px-3">
                                                <div id="calendar"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--
                    <nav class="navbarr" style="margin: 10px 20px;">
                        <a class = "activee" href="#articlesmedia">Articles & Media</a>
                        <a href="#socialinteract">Social Interaction</a>
                        <a href="#appointments">Appointments</a>
                        <a href="#crisis">Crisis Directory</a>
                        <a href="#users">Users</a>
                        <a href="#faqs">FAQs</a>
                    </nav>
                    <div class="card">
                        <div class="card-body activee" id="articlesmedia">
                            <div class="content">
                                <p>
                                    articles
                                </p>
                            </div>
                        </div>
                        <div class="card-body" id="socialinteract">
                            <div class="content">
                                <p>
                                    posts
                                </p>
                            </div>
                        </div>
                        <div class="card-body" id="appointments">
                            <div class="content">
                                <p>
                                    appoint
                                </p>
                            </div>
                        </div>
                        <div class="card-body" id="crisis">
                            <div class="content">
                                <p>
                                    crisis
                                </p>
                            </div>
                        </div>
                        
                        <div class="card-body" id="faqs">
                            <div class="content">
                                <p>
                                    faqs
                                </p>

                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    
    <!-- FullCalendar CSS and JS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var navLinks = document.querySelectorAll('.navbarr a');
            var contentSections = document.querySelectorAll('.card-body');

            navLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    navLinks.forEach(function(nav) {
                        nav.classList.remove('activee');
                    });
                    this.classList.add('activee');

                    contentSections.forEach(function(section) {
                        section.classList.remove('activee');
                    });
                    
                    var target = this.getAttribute('href').substring(1);
                    document.getElementById(target).classList.add('activee');
                });
            });
        });

        $('.btn').click(function(){
            location.href = "index.php?page=social_interaction/users";
        });

        $('.btn.appointments').click(function(){
            //Edit location to view appointments
            location.href = "index.php?page=appointments/client_records";
        });

        $(document).ready(function() {
            $('#calendar').fullCalendar({
                events: [
                    <?php
                    $events = $conn->query("SELECT user_name AS title, date, time_from AS start, time_to AS end FROM events WHERE status='Scheduled';");
                    while ($event = $events->fetch_assoc()):
                    ?>
                    {
                        title: '<?php echo $event['title']; ?>',
                        start: '<?php echo $event['date'] . 'T' . $event['start']; ?>',
                        end: '<?php echo $event['date'] . 'T' . $event['end']; ?>'
                    },
                    <?php endwhile; ?>
                ],
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultView: 'month',
                editable: false
            });
        });


        $('#manage-records').submit(function(e){
            e.preventDefault()
            start_load()
            $.ajax({
                url:'ajax.php?action=save_track',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success:function(resp){
                    resp = JSON.parse(resp)
                    if(resp.status == 1){
                        alert_toast("Data successfully saved", 'success')
                        setTimeout(function(){
                            location.reload()
                        }, 800)
                    }
                }
            })
        })

        $('#tracking_id').on('keypress', function(e){
            if(e.which == 13){
                get_person()
            }
        })

        $('#check').on('click', function(e){
            get_person()
        })

        function get_person(){
            start_load()
            $.ajax({
                url:'ajax.php?action=get_pdetails',
                method:"POST",
                data:{tracking_id : $('#tracking_id').val()},
                success:function(resp){
                    if(resp){
                        resp = JSON.parse(resp)
                        if(resp.status == 1){
                            $('#name').html(resp.name)
                            $('#address').html(resp.address)
                            $('[name="person_id"]').val(resp.id)
                            $('#details').show()
                            end_load()
                        } else if(resp.status == 2){
                            alert_toast("Unknown tracking id.", 'danger');
                            end_load();
                        }
                    }
                }
            })
        }
    </script>
</body>
</html>
