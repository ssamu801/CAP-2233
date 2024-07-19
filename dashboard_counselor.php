<?php include 'db_connect.php' ?>
<?php $login_id = $_SESSION['login_id']; ?>

<style>
    span.float-right.summary_icon {
        font-size: 3rem;
        position: absolute;
        right: 1rem;
        color: #ffffff96;
    }
    .imgs {
        margin: .5em;
        max-width: calc(100%);
        max-height: calc(100%);
    }
    .imgs img {
        max-width: calc(100%);
        max-height: calc(100%);
        cursor: pointer;
    }
    #imagesCarousel, #imagesCarousel .carousel-inner, #imagesCarousel .carousel-item {
        height: 60vh !important;
        background: black;
    }
    #imagesCarousel .carousel-item.active {
        display: flex !important;
    }
    #imagesCarousel .carousel-item-next {
        display: flex !important;
    }
    #imagesCarousel .carousel-item img {
        margin: auto;
    }
    #imagesCarousel img {
        width: auto !important;
        height: auto !important;
        max-height: calc(100%) !important;
        max-width: calc(100%) !important;
    }
    .info {
        padding: 7px;
        width: 25%;
        border-radius: 15px; /* Adjust the radius value as needed */
    }
    @media (max-width: 768px) {
        .info {
            width: 100%; /* Full width on smaller screens */
        }
    }
    .appointments {
        margin-left: 20px;
        width: 100%;

    }
    .info-card {
        border-radius: 15px;
    }
    .summary_icon{
        padding: 5px 10px 5px 10px;
        background-color: red;
        font-size:35px;
        border-radius: 10px;
    }
    .card-content{
        padding: 0;
    }
    .num{
       margin: 0; 
    }
    .posts {
        margin-left: -8px;
        width: 99%;

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
    .tiny-square {
    width: 15px;
    height: 15px;
    background-color: black;
    }
    .table-container {
    max-height: 300px; /* Adjust this height as needed */
    overflow-y: auto;
    }

    .table-container::-webkit-scrollbar {
        width: 8px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 4px;
    }

    .fc-content{
        background-color:#107A32;
        color:white;
    }

    .fc-center h2{
        color: #444444;
        font-family: "Open Sans", sans-serif;
        font-weight:bold;
    }
</style>

<div class="container-fluid">
    <div class="row mb-4 mt-4">
        <div class="col-md-12">
        </div>
    </div>
    <div class="row mt-3 ">
        <div class="col-lg-12">
            <b><?php echo "Welcome back " . $_SESSION['login_name'] . "!"; ?></b>
            <div class="row">
                <div class="row d-flex flex-column col-md-7 ml-2">
                    <div class="row mb-3 mr-1">
                        <div class="info">
                            <div class="card info-card">
                                <div class="card-body info-card bg-white">
                                    <div class="card-body text-secondary card-content">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <span class="summary_icon" style="background-color:#CBA6EF;"><i class="bi bi-file-text-fill" style="color:#6200C3;"></i></span>
                                            </div>
                                            <div class="col-sm info-text">
                                                <h4 class="num">
                                                    <b>
                                                        <?php 
                                                            $sql = "SELECT COUNT(*) AS total_rows FROM events WHERE counselor_id = $login_id AND status!= 'Reschedule'";

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
                                                    </b>
                                                </h4>
                                                <b>All</b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info">
                            <div class="card info-card">
                                <div class="card-body info-card bg-white">
                                    <div class="card-body text-secondary card-content">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <span class="summary_icon" style="background-color:#AAC8F4;"><i class="bi bi-people-fill" style="color:#0547AA;"></i></span>
                                            </div>
                                            <div class="col-sm info-text">
                                                <h4 class="num">
                                                    <b>
                                                        <?php 
                                                            $sql = "SELECT COUNT(*) AS total_rows FROM events WHERE counselor_id = $login_id AND status='Scheduled' OR status='Pending'";

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
                                                    </b>
                                                </h4>
                                                <b>Upcoming</b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info">
                            <div class="card info-card">
                                <div class="card-body info-card bg-white">
                                    <div class="card-body text-secondary card-content">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <span class="summary_icon" style="background-color:#A0E3B6;"><i class="bi bi-check2-square" style="color:#107A32;"></i></span>
                                            </div>
                                            <div class="col-sm info-text">
                                                <h4 class="num">
                                                    <b>
                                                        <?php 
                                                            $sql = "SELECT COUNT(*) AS total_rows FROM events WHERE counselor_id = $login_id AND status='Completed' OR status='Accepted'";

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
                                                    </b>
                                                </h4>
                                                <b>Completed</b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info">
                            <div class="card info-card">
                                <div class="card-body info-card bg-white">
                                    <div class="card-body text-secondary card-content">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <span class="summary_icon" style="background-color:#F3B4B4;"><i class="bi bi-person-x-fill" style="color:#B91616;"></i></span>
                                            </div>
                                            <div class="col-sm info-text">
                                                <h4 class="num">
                                                    <b>
                                                        <?php 
                                                            $sql = "SELECT COUNT(*) AS total_rows FROM events WHERE counselor_id = $login_id AND status='Cancelled' OR status='No Show'";

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
                                                    </b>
                                                </h4>
                                                <b>Cancelled</b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="posts">
                        <div class="card">
                            <div class="card-header">
                                <b>Flagged Posts</b>
                            </div>
                            <div class="card-header bg-white border-bottom-0 ml-2">
                                <?php // Get unique student IDs
                                    $sql_students = "SELECT student_id FROM events WHERE counselor_id=$login_id AND student_id != '' GROUP BY student_id";
                                    $result_students = $conn->query($sql_students);

                                    $student_ids = [];
                                    if ($result_students->num_rows > 0) {
                                        while ($row_student = $result_students->fetch_assoc()) {
                                            $student_ids[] = $row_student['student_id'];
                                        }
                                    }
                                ?>
                                <ul class="nav nav-tabs card-header-tabs" id="postTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="tabs active" id="flagged-posts-tab" data-toggle="tab" href="#flagged-posts" role="tab" aria-controls="flagged-posts" aria-selected="true">Clients</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tabs" id="approved-posts-tab" data-toggle="tab" href="#approved-posts" role="tab" aria-controls="approved-posts" aria-selected="false">Non-Clients</a>
                                    </li>
                                </ul>
                            </div>
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

                                            $k = 0;
                                            if (!empty($student_ids)) {
                                                foreach ($student_ids as $student_id) {
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
                                                            $k++;
                                                            ?>
                                                            <li class="list-group-item mb-4">
                                                                <div>
                                                                    <a href="index.php?page=social_interaction/view_forum&id=<?php echo $row['id'] ?>" class="filter-text"><?php echo $row['title'] ?></a>
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
                                                                            echo $word . " ";
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
                                                if($k == 0){
                                                    echo "<li class='list-group-item'>No flagged posts from clients.</li>";
                                                }
                                            } else {
                                                echo "<li class='list-group-item'>No flagged posts from clients.</li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="approved-posts" role="tabpanel" aria-labelledby="approved-posts-tab">
                                    <div class="table-container">
                                        <ul class="w-100 list-group" id="topic-list">
                                            <?php
                                            // Get tags
                                            $tag = $conn->query("SELECT * FROM categories ORDER BY name ASC");
                                            while ($row = $tag->fetch_assoc()) {
                                                $tags[$row['id']] = $row['name'];
                                            }

                                            // Get unique student IDs for the new query
                                            $sql_students = "SELECT student_id FROM events WHERE counselor_id !=$login_id AND student_id != '' GROUP BY student_id";
                                            $result_students = $conn->query($sql_students);

                                            $i = 0;
                                            if ($result_students->num_rows > 0) {
                                                while ($row_student = $result_students->fetch_assoc()) {
                                                    $student_id = $row_student['student_id'];

                                                    // Check if the student_id is in the previous array
                                                    if (!in_array($student_id, $student_ids)) {
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
                                                                                echo $word . " ";
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
                                                }
                                                if($i == 0){
                                                    echo "<li class='list-group-item'>No flagged posts from non-clients.</li>";
                                                }
                                            } else {
                                                echo "<li class='list-group-item'No flagged posts from non-clients.</li>";
                                            }

                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex flex-column col-5" style="margin-top: -20px;">
                    <div class="appointments mb-4">
                        <div class="card">
                            <div class="card-header">
                                <b>Scheduled Appointments For Today <?php echo date('Y-m-d'); ?></b>
                            </div>
                            <div class="card-body table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Start Time</th>
                                            <th class="text-center">End Time</th>
                                            <th class="text-center">Mode</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div class="d-flex justify-content-center">
                                            <div class="tiny-square mr-1" style="background-color: #84b894;"></div>
                                            <div style="margin-top: -5px;"> - Follow-up Session</div>

                                            <div class="tiny-square mr-1 ml-4" style="background-color: #fff; border:1px solid #ccc !important;"></div>
                                            <div style="margin-top: -5px;"> - Initial Consultation</div>
                                        </div>
                                        <tr style="background-color: #84b894;">
                                        <?php
                                            // SQL query to select records from today
                                            $sql = "SELECT user_name, date, time_from, time_to, mode
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
                                                    echo "<td class='text-center'>" . $row["time_from"] . "</td>";
                                                    echo "<td class='text-center'>" . $row["time_to"] . "</td>";
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
</div>

<!-- FullCalendar CSS and JS -->
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
<script>
 
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            events: [
                <?php
                $events = $conn->query("SELECT user_name AS title, date, time_from AS start, time_to AS end FROM events WHERE status='Scheduled' AND counselor_id = $login_id;");
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
    
    $(document).ready(function() {
        $('#postTabs a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
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
