<div class="container-fluid">
    <div class="dashboard-header">
        Secretary Dashboard
    </div>
    <div class="row">
        <!-- Appointments for Today -->
        <div class="col-7">
            <div class="card">
                <div class="card-header">
                    <b>Appointments for Today</b>
                </div>
                <div class="card-body">
                    <div class="table-container appointments-table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Student</th>
                                    <th class="text-center">Mode</th>
                                    <th class="text-center">Location</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Start Time</th>
                                    <th class="text-center">End Time</th>
                                    <th class="text-center">Counselor</th>
                                    <th class="text-center">Urgency</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form action="appointments/send.php" method="post">
                                    <?php
                                    include './db_connect.php';
                                    $requests = $conn->query("SELECT user_name, mode, location, date, time_from, time_to, counselor_name, urgency FROM events WHERE status LIKE 'Accepted' AND date = CURDATE();");
                                    $total = mysqli_num_rows($requests);
                                    if ($total > 0):
                                        while ($row = $requests->fetch_assoc()):
                                    ?>
                                            <tr class="client_record record_row">
                                                <td class="text-center"><?php echo $row['user_name'] ?></td>
                                                <td class="text-center"><?php echo $row['mode'] ?></td>
                                                <td class="text-center"><?php echo $row['location'] ?></td>
                                                <td class="text-center"><?php echo $row['date'] ?></td>
                                                <td class="text-center"><?php echo $row['time_from'] ?></td>
                                                <td class="text-center"><?php echo $row['time_to'] ?></td>
                                                <td class="text-center"><?php echo $row['counselor_name'] ?></td>
                                                <td class="text-center"><?php echo $row['urgency'] ?></td>
                                            </tr>
                                    <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan='8' class="text-center">There are currently no pending appointments</td>
                                        </tr>
                                    <?php endif; ?>
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Display -->
        <div class="col-5">
            <div class="card">
                <div class="card-header">
                    <b>Calendar</b>
                </div>
                <div class="card-body calendar-container">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule for the Week -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <b>Cases this Week</b>
                </div>
                <div class="card-body">
                    <div class="table-container counselor-table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Monday</th>
                                    <th class="text-center">Tuesday</th>
                                    <th class="text-center">Wednesday</th>
                                    <th class="text-center">Thursday</th>
                                    <th class="text-center">Friday</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    // Get the current week's dates
                                    $currentWeekDates = [];
                                    for ($i = 0; $i <= 4; $i++) {
                                        $currentWeekDates[] = date('Y-m-d', strtotime("this week +$i day"));
                                    }

                                    // Query the database for each day
                                    foreach ($currentWeekDates as $date) {
                                        $result = $conn->query("SELECT COUNT(*) FROM events WHERE date = '$date';");
                                        $count = $result->fetch_assoc()['COUNT(*)'];
                                        echo "<td class='text-center'>$count</td>";
                                    }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
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
                $events = $conn->query("SELECT user_name AS title, date, time_from AS start, time_to AS end FROM events;");
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
</script>

<style>
    .table-container {
        overflow-y: auto;
    }

    .appointments-table-container {
        height: 55vh;
    }

    .calendar-container {
        height: 55vh;
    }

    .counselor-table-container {
        height: auto;
    }

    .card-header {
        height: 50px;
        line-height: 30px;
    }

    .table thead th {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 2;
    }

    .card-body {
        padding: 0;
    }

    .text-center {
        text-align: center;
    }

    .container-fluid, .row, .col {
        margin: 0;
        padding: 0;
    }

    .card-body p {
        margin: 0;
        padding: 20px;
    }

    .mt-3 {
        margin-top: 1rem !important;
    }

    .dashboard-header {
        background-color: #dcdcdc;
        color: #444444;
        padding: 20px;
        text-align: left;
        font-size: 2rem;
        font-weight: bold;
        position: relative;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
    }

    .dashboard-content {
        margin-top: 80px;
        padding: 20px;
    }
</style>
