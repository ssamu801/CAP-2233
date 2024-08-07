var currentYear, currentMonth, currentDate;
var selectedDate = null;
var clickedMonth = null; // Adding 1 to currentMonth to get the correct month number
var clickedYear = null;

$(document).ready(function() {
    currentDate = new Date();
    currentYear = currentDate.getFullYear();
    currentMonth = currentDate.getMonth();
    renderCalendar();

    // Event listener for the No. of Sessions input
    $('#sessionsNo').on('input', function() {
        validateSessionsInput();
        addTimeSlotFields();
    });
});

function validateSessionsInput() {
    const sessionsInput = $('#sessionsNo');
    let sessionsNo = sessionsInput.val();

    // Remove leading zeros
    sessionsNo = sessionsNo.replace(/^0+/, '');

    // Ensure it's a positive integer and not in scientific notation
    if (!/^\d+$/.test(sessionsNo)) {
        // Not a valid positive integer, reset to 1
        sessionsNo = 1;
    } else {
        // Convert to integer
        sessionsNo = parseInt(sessionsNo);

        // Limit maximum sessions to 20
        if (sessionsNo > 20) {
            sessionsNo = 20;
        }
    }

    // Update the input field value
    sessionsInput.val(sessionsNo);
}

function renderCalendar() {
    const calendar = createCalendar(currentYear, currentMonth, currentDate);
    $('#calendar').html(calendar);
}

function createCalendar(year, month, currentDate) {
    let calendar = '<div class="row d-flex justify-content-center">' +
    '<div class="col-md-7">' +
    '<div class="card">' +
    '<div class="float-end x-button">' +
    '<div class="float-left mt-3 ml-4"><h5>Select Starting Date</h5></div>' +
    '<button type="button" class="close mt-3 mr-3" data-dismiss="modal">&times;</button>' +
    '</div>' +
    '<hr class="hr-line">' +
    '<div class="card-header pr-2 pt-2 cal-header d-flex justify-content-between align-items-center">' +
    '<h4 class="mb-0">' + getMonthName(month) + ' ' + year + '</h4>' +
    '<div>' +
    '<span class="btn months-btn" id="prevMonth"><i class="bi bi-chevron-left"></i></span>' +
    '<span class="btn months-btn" id="nextMonth"><i class="bi bi-chevron-right"></i></span>' +
    '</div>' +
    '</div>' +
    '<div class="card-body">' +
    '<div class="row">' +
    '<div class="col-md-12">' +
    '<table class="table table-bordered">' +
    '<thead>' +
    '<tr>';
    const daysOfWeek = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
    for (let i = 0; i < daysOfWeek.length; i++) {
        calendar += '<th>' + daysOfWeek[i] + '</th>';
    }

    calendar += '</tr></thead><tbody>';

    const firstDay = new Date(year, month, 1).getDay();
    let date = 1;
    let row = '';
    const today = new Date().getDate();

    for (let i = 0; i < 5; i++) {
        row = '<tr>';
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDay) {
                row += '<td></td>';
            } else if (date > new Date(year, month + 1, 0).getDate()) {
                row += '<td></td>';
            } else {
                let cellClass = '';
                if (date === today && year === currentDate.getFullYear() && month === currentDate.getMonth()) {
                    cellClass = 'class="current-date"';
                }

                const dateToCheck = new Date(year, month, date);

                if (dateToCheck >= currentDate) {
                    row += '<td ' + cellClass + ' onclick="selectDate(this)">' + date + '</td>';
                }
                else if(date === today && year === currentDate.getFullYear() && month === currentDate.getMonth()){
                    row += '<td class="current-date"' + ' onclick="selectDate(this)">' + date + '</td>';
                }
                else {
                    row += '<td class="disabled-date">' + date + '</td>';
                }
                date++;
            }
        }
        row += '</tr>';
        calendar += row;
    }

    calendar += '</tbody></table></div></div></div></div></div></div>';

    return calendar;
}

function selectDate(cell) {
    selectedDate = parseInt(cell.textContent);
    clickedMonth = currentMonth + 1; // Adding 1 to currentMonth to get the correct month number
    clickedYear = currentYear;

    // Reset font color of all cells
    const allCells = document.querySelectorAll('.calendar .table td');
    allCells.forEach(cell => {
        cell.style.color = '';
        cell.style.backgroundColor = '';
    });

    // Highlight selected date
    cell.style.backgroundColor = '#0496c7';
    cell.style.color = 'white';

    // Add time slot fields
    addTimeSlotFields();
}

function addTimeSlotFields() {
    const sessionsNo = $('#sessionsNo').val();
    const timeSlotsWrapper = $('.input-fields-wrap');
    timeSlotsWrapper.empty(); // Clear existing time slots

    if (selectedDate && sessionsNo > 0) {
        for (let i = 0; i < sessionsNo; i++) {
            const sessionDate = new Date(clickedYear, clickedMonth - 1, selectedDate);
            sessionDate.setDate(sessionDate.getDate() + (i * 7)); // Increment by weeks

            const formattedDate = getFormattedDate(sessionDate);

            timeSlotsWrapper.append(
                `<div class="ml-4 d-flex mb-2">
                    <span>${formattedDate}</span>
                </div>`
            ); 
            /*
            timeSlotsWrapper.append(
                `<div class="ml-4 d-flex justify-content-center items-center mb-2">
                    <span>${formattedDate}</span>
                    <input type="time" name="time_from[]" class="form-control input-field" value="" required>
                    <h3> - </h3>
                    <input type="time" name="time_to[]" class="form-control input-field" value="" required>
                </div>`
            ); 
            */
        }
    }
}

function getFormattedDate(date) {
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const month = monthNames[date.getMonth()];
    const day = date.getDate();
    const year = date.getFullYear();

    return `${month} ${day}, ${year}`;
}


function getMonthName(month) {
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    return monthNames[month];
}

$('#calendar').on('click', '#prevMonth', function() {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    renderCalendar();
});

$('#calendar').on('click', '#nextMonth', function() {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    renderCalendar();
});

$(document).ready(function() {
    var maxTimeSlots = 10; // Maximum time slots allowed
    var timeSlotsWrapper = $(".input-fields-wrap"); // Time slots wrapper
    var buttonWrapper = $(".button-wrapper");
    var addTimeSlotButton = $(".add-more-btn"); // Add time slot button
    var submitButtonContainer = $(".submit-button"); // Submit button container
    var saveTimeSlotsBtn = $(".saveTimeSlotsBtn"); // Save button

    var timeSlotCount = 1; // Initial time slot count

    // Function to check if save button should be enabled or disabled
    function checkSaveButton() {
        if (timeSlotCount > 1) {
            saveTimeSlotsBtn.prop("disabled", false); // Enable save button
        } else {
            saveTimeSlotsBtn.prop("disabled", true); // Disable save button
        }
    }

    $(addTimeSlotButton).click(function(e) { // On add time slot button click
        e.preventDefault();
        if (timeSlotCount < maxTimeSlots) { // Max time slots allowed
            timeSlotCount++; // Time slot increment
            $(timeSlotsWrapper).append('<div class="ml-4 d-flex justify-content-center items-center mb-2"><input type="time" name="time_from[]" class="form-control input-field" value="" required><h3> - </h3><input type="time" name="time_to[]" class="form-control input-field" value="" required><button class="remove-btn mr-4"><i class="bi bi-x"></i></button></div>'); // Add time slot fields
            checkSaveButton(); // Check if save button should be enabled or disabled
        }
    });

    $(timeSlotsWrapper).on("click", ".remove-btn", function(e) { // On remove time slot button click
        e.preventDefault();
        $(this).parent('div').remove(); // Remove the time slot fields
        timeSlotCount--; // Decrement time slot count
        checkSaveButton(); // Check if save button should be enabled or disabled
    });

    checkSaveButton(); // Check initial state of save button
});

$(".saveTimeSlotsBtn").click(function() {
    // Collect time slot data from the input fields
    console.log('Save button clicked');
    var timeSlotsData = {
        timeSlots: [],
        selectedDate: selectedDate, // Add the selected date
        selectedMonth: clickedMonth, // Add the selected month (adding 1 because months are zero-indexed)
        selectedYear: clickedYear // Add the selected year
    };

    $(".input-field").each(function() {
        var timeFrom = $(this).val(); // Use val() to get the input field's value
        var timeTo = $(this).next().next().val(); // Assuming time_to inputs are after time_from inputs

        // Check if timeFrom and timeTo are not empty before adding to timeSlotsData
        if (timeFrom && timeTo) {
            timeSlotsData.timeSlots.push({ timeFrom: timeFrom, timeTo: timeTo });
        }
    });

    // Send the data to the server using AJAX
    $.ajax({
        type: "POST",
        url: "./appointments/save_slots.php", // PHP file to handle the data on the server
        data: { timeSlotsData: JSON.stringify(timeSlotsData) }, // Send the data as JSON
        success: function(response) {
            // Handle success response from the server
            console.log(response); // For debugging purposes
            alert_toast("Schedule Saved.", 'success');

            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function(xhr, status, error) {
            // Handle error response from the server
            console.error(xhr.responseText); // Log the error for debugging
            // You can show an error message to the user
        }
    });
});
