<div class="container-fluid">
    <div class="dashboard-header">
        Secretary Dashboard
    </div>
    <div class="row">
        <!-- Appointments for Today -->
        <div class="col-7">
            <div class="card">
                <div class="card-header">
                    <b>Appointments for Today // change db query to specific day</b>
                </div>
                <div class="card-body">
                    <div class="table-container appointments-table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Title</th>
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
                                    $requests = $conn->query("SELECT title, mode, location, date, time_from, time_to, counselor_name, urgency FROM events WHERE status LIKE 'Accepted'");
                                    $total = mysqli_num_rows($requests);
                                    if ($total > 0):
                                        while ($row = $requests->fetch_assoc()):
                                    ?>
                                            <tr class="client_record record_row">
                                                <td class="text-center"><?php echo $row['title'] ?></td>
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

        <!-- Counselor for the Day and Schedule for the Week -->
        <div class="col-5">
            <div class="card">
                <div class="card-header">
                    <b>Counselor of the Day</b>
                </div>
                <div class="card-body">
                    <p class="text-center"><strong>Bini Eilish</strong></p> <!-- Change as per current counselor -->
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <b>Counselor of the Day Schedule</b>
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
                                    <td class="text-center">Cindy Ka-To</td>
                                    <td class="text-center">Jo Jo</td>
                                    <td class="text-center">Sean Kamas</td>
                                    <td class="text-center">Pin Tohra</td>
                                    <td class="text-center">Juan Ted</td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- New Cases, Cancelled, Urgent table -->
            <div class="card mt-3">
                <div class="card-header">
                    <b>Weekly Cases</b>
                </div>
                <div class="card-body">
                    <div class="table-container additional-table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Cases</th>
                                    <th class="text-center">Cancelled</th>
                                    <th class="text-center">Urgent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">5</td> 
                                    <td class="text-center">2</td> 
                                    <td class="text-center">3</td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS for positioning the table */
    .table-container {
        overflow-y: auto; /* Add vertical scroll if content exceeds the height */
    }

    .appointments-table-container {
        height: 50vh; /* Set height to half the screen */
    }

    .counselor-table-container {
        height: auto; /* Align with the bottom of Appointments table, accounting for the header and margin */
    }
    
    .additional-table-container {
        height: auto; /* Adjust height as needed */
    }

    .card-header {
        height: 50px; /* Adjust height to accommodate the header content */
        line-height: 30px; /* Center the text vertically */
    }

    .table thead th {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 2;
    }

    .card-body {
        padding: 0; /* Remove default padding if any */
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
        z-index: 1000; /* Ensure it's above other content */
    }

    .dashboard-content {
        margin-top: 80px; /* Adjust according to header height */
        padding: 20px;
    }
</style>
