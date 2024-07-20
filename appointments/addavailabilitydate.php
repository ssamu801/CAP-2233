<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counselor Availability</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <style>
        .calendar {
            margin-bottom: 20px;
        }
        .month {
            margin-bottom: 10px;
        }
        .week {
            display: flex;
        }
        .day {
            width: 18%;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            box-sizing: border-box;
            cursor: pointer;
        }
        .day.empty {
            border: none;
        }
        .day-header {
            background-color: #f8f9fa;
            font-weight: bold;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            width: 18%;
            box-sizing: border-box;
        }
        .bg-leave {
            background-color: #dc3545 !important;
            color: white !important;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Counselor Availability</h2>
    <div class="input-group input-daterange mb-3">
        <input type="text" class="form-control" id="start-date" placeholder="Start Date">
        <div class="input-group-addon mx-2">to</div>
        <input type="text" class="form-control" id="end-date" placeholder="End Date">
    </div>
    
    <div id="calendar" class="calendar"></div>

    <!-- Day Modal -->
    <div class="modal fade" id="dayModal" tabindex="-1" aria-labelledby="dayModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dayModalLabel">Set Availability</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="dayForm">
                        <div class="form-group">
                            <label for="startTime">Start Time</label>
                            <select class="form-control" id="startTime">
                                <option value="8">8 AM</option>
                                <option value="9">9 AM</option>
                                <option value="10">10 AM</option>
                                <option value="11">11 AM</option>
                                <option value="13">1 PM</option>
                                <option value="14">2 PM</option>
                                <option value="15">3 PM</option>
                                <option value="16">4 PM</option>
                                <option value="17">5 PM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="endTime">End Time</label>
                            <select class="form-control" id="endTime">
                                <option value="9">9 AM</option>
                                <option value="10">10 AM</option>
                                <option value="11">11 AM</option>
                                <option value="12">12 PM</option>
                                <option value="14">2 PM</option>
                                <option value="15">3 PM</option>
                                <option value="16">4 PM</option>
                                <option value="17">5 PM</option>
                                <option value="18">6 PM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mode">Mode</label>
                            <select class="form-control" id="mode">
                                <option value="Face-to-Face">Face to Face</option>
                                <option value="Online" selected="selected">Online</option>
                            </select>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="leaveDay">
                            <label class="form-check-label" for="leaveDay">Leave Day</label>
                        </div>
                        <input type="hidden" id="modalDate">
                        <button type="submit" class="btn btn-primary mt-3">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <button id="saveCalendar" class="btn btn-primary mt-4">Save Calendar</button>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function(){
        $('.input-daterange').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        // Handle date range selection and generate calendar
        $('#start-date, #end-date').change(function() {
            const startDate = $('#start-date').datepicker('getDate');
            const endDate = $('#end-date').datepicker('getDate');
            if (startDate && endDate) {
                generateCalendar(startDate, endDate);
            }
        });

        // Generate calendar for the selected date range
        function generateCalendar(startDate, endDate) {
            const calendar = document.getElementById('calendar');
            calendar.innerHTML = '';

            let currentMonth = null;
            let monthDiv = null;
            let weekDiv = null;

            for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
                // Skip weekends (Saturday and Sunday)
                if (d.getDay() === 0 || d.getDay() === 6) {
                    continue;
                }

                if (d.getMonth() !== currentMonth) {
                    currentMonth = d.getMonth();
                    
                    // Create a new month section
                    monthDiv = document.createElement('div');
                    monthDiv.className = 'month';
                    const monthHeader = document.createElement('h3');
                    monthHeader.textContent = d.toLocaleString('default', { month: 'long', year: 'numeric' });
                    monthDiv.appendChild(monthHeader);

                    // Add day headers
                    const dayHeaderDiv = document.createElement('div');
                    dayHeaderDiv.className = 'week';
                    const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                    days.forEach(day => {
                        const dayHeader = document.createElement('div');
                        dayHeader.className = 'day-header';
                        dayHeader.textContent = day;
                        dayHeaderDiv.appendChild(dayHeader);
                    });
                    monthDiv.appendChild(dayHeaderDiv);

                    calendar.appendChild(monthDiv);

                    // Create a new week header
                    weekDiv = document.createElement('div');
                    weekDiv.className = 'week';
                    monthDiv.appendChild(weekDiv);

                    // Fill initial empty days to align the first day
                    let dayOfWeek = (d.getDay() + 6) % 7; // Adjust so that Monday is the first day
                    for (let i = 0; i < dayOfWeek; i++) {
                        const emptyDay = document.createElement('div');
                        emptyDay.className = 'day empty';
                        weekDiv.appendChild(emptyDay);
                    }
                }

                // Add day to the week
                const dayElement = document.createElement('div');
                dayElement.className = 'day';
                dayElement.textContent = d.getDate(); // Only show the day number
                dayElement.dataset.date = d.toISOString().split('T')[0]; // Store date in YYYY-MM-DD format
                weekDiv.appendChild(dayElement);

                // Add event listener for opening the modal
                dayElement.addEventListener('click', function() {
                    $('#dayModal').modal('show');
                    $('#modalDate').val(dayElement.dataset.date);
                    $('#startTime').val(8);
                    $('#endTime').val(18);
                    $('#mode').val('Online');
                    $('#leaveDay').prop('checked', false);
                });

                // If the week is complete, create a new one
                if (weekDiv.children.length === 5) {
                    weekDiv = document.createElement('div');
                    weekDiv.className = 'week';
                    monthDiv.appendChild(weekDiv);
                }
            }

            // Fill trailing empty days to complete the last week
            while (weekDiv.children.length < 5) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'day empty';
                weekDiv.appendChild(emptyDay);
            }
        }
            // Handle availability form submission
            document.getElementById('dayForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const modalDate = document.getElementById('modalDate').value;
            const startTime = parseInt(document.getElementById('startTime').value);
            const endTime = parseInt(document.getElementById('endTime').value);
            const mode = document.getElementById('mode').value;
            const isLeaveDay = document.getElementById('leaveDay').checked;

            if (endTime <= startTime) {
                alert('End time must be after start time.');
                return;
            }

            const dayElements = document.querySelectorAll('.day');
            dayElements.forEach(dayElement => {
                if (dayElement.dataset.date === modalDate) {
                    if (isLeaveDay) {
                        dayElement.classList.add('bg-leave');
                        dayElement.textContent = dayElement.textContent.split(' ')[0] + ' (Leave)';
                    } else {
                        dayElement.classList.remove('bg-leave');
                        let displayTime = startTime < 12 ? `${startTime} AM` : `${startTime - 12} PM`;
                        displayTime += ' - ';
                        displayTime += endTime <= 12 ? `${endTime} AM` : `${endTime - 12} PM`;
                        dayElement.textContent = `${dayElement.textContent.split(' ')[0]} (${displayTime}, ${mode})`;
                    }
                }
            });

            $('#dayModal').modal('hide');
        });

        // Save calendar data to the server
        document.getElementById('saveCalendar').addEventListener('click', function() {
            const dayElements = document.querySelectorAll('.day');
            let calendarData = [];

            dayElements.forEach(dayElement => {
                const date = dayElement.dataset.date;
                const text = dayElement.textContent;
                if (text.includes('(Leave)')) {
                    calendarData.push({
                        date: date,
                        time_from: null,
                        time_to: null,
                        status: 'Leave',
                        mode: null
                    });
                } else {
                    const [day, timeMode] = text.split(' (');
                    const [startTime, endTimeMode] = timeMode.split(' - ');
                    const endTime = endTimeMode.split(')')[0];
                    const mode = endTimeMode.split(')')[1];
                    
                    for (let hour = parseInt(startTime); hour < parseInt(endTime); hour++) {
                        // Exclude the 12:00 PM to 1:00 PM timeframe
                        if (hour === 12) continue;
                        calendarData.push({
                            date: date,
                            time_from: `${hour < 10 ? '0' : ''}${hour}:00:00`,
                            time_to: `${(hour + 1) < 10 ? '0' : ''}${hour + 1}:00:00`,
                            status: 'Available',
                            mode: mode
                        });
                    }
                }
            });

            $.ajax({
                url: 'save_calendar.php',
                type: 'POST',
                data: { calendar: JSON.stringify(calendarData) },
                success: function(response) {
                    alert('Calendar saved successfully!');
                },
                error: function() {
                    alert('Error saving calendar.');
                }
            });
        });

        // Initialize the calendar with an example date range
        const startDate = new Date();
        const endDate = new Date();
        endDate.setMonth(endDate.getMonth() + 1);
        generateCalendar(startDate, endDate);
    });
</script>
</body>
</html>

            