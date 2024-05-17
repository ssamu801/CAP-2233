
var currentYear, currentMonth, currentDate;
var selectedDate = null;
var clickedMonth = null;// Adding 1 to currentMonth to get the correct month number
var clickedYear = null;

$(document).ready(function() {
    currentDate = new Date();
    console.log(currentDate);
    currentYear = currentDate.getFullYear();
    currentMonth = currentDate.getMonth();
    renderCalendar();
});

function renderCalendar() {
    const calendar = createCalendar(currentYear, currentMonth, currentDate);
    $('#calendar').html(calendar);
}


function createCalendar(year, month, currentDate) {
    let calendar = '<div class="row d-flex justify-content-center">' +
        '<div class="col-md-7">' +
        '<div class="card">' +
        '<div class="float-end x-button">' +
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

                // Get the next two weeks from the current date
                const nextTwoWeeks = new Date(currentDate);
                nextTwoWeeks.setDate(currentDate.getDate() + 14);

                // Check if the date is within the next two weeks
                if (dateToCheck >= currentDate && dateToCheck <= nextTwoWeeks) {
                    row += '<td ' + cellClass + ' onclick="selectDate(this)">' + date + '</td>';
                }
                else if(date === today && year === currentDate.getFullYear() && month === currentDate.getMonth()){
                    row += '<td class="current-date">' + date + '</td>';
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

// Function to select date and time slot
function selectDate(cell) {
    selectedDate = parseInt(cell.textContent);
    const currentMonthName = getMonthName(currentMonth);
    const currentYearNum = currentYear;

    // Get the month and year of the clicked date
    clickedMonth = currentMonth + 1; // Adding 1 to currentMonth to get the correct month number
    clickedYear = currentYear;

    console.log('Clicked date:', selectedDate);
    console.log('Clicked month:', clickedMonth);
    console.log('Clicked year:', clickedYear);

    // Reset font color of all cells
    const allCells = document.querySelectorAll('.calendar .table td');
    allCells.forEach(cell => {
        cell.style.color = '';
        cell.style.backgroundColor = '';
    });

    // Highlight selected date
    cell.style.backgroundColor = '#0496c7';
    cell.style.color = 'white';

    // Show or hide the plus button based on whether a date is selected
    const addTimeSlotBtn = document.getElementById('addTimeSlotBtn');
    if (selectedDate) {
        addTimeSlotBtn.style.display = 'inline-block'; // Show the plus button

        // Send AJAX request to PHP script to get time slots for the selected date
        $.ajax({
            type: "POST",
            url: "./appointments/getTimeSlots.php", // PHP script to handle the request
            data: { selectedDate: selectedDate, selectedMonth: clickedMonth, selectedYear: clickedYear },
            success: function(response) {
                // Handle success response from the server
                // Display the available time slots on the page
                $(".input-fields-wrap").html(response);
            },
            error: function(xhr, status, error) {
                // Handle error response from the server
                console.error(xhr.responseText); // Log the error for debugging
                // You can show an error message to the user
            }
        });
    } else {
        addTimeSlotBtn.style.display = 'none'; // Hide the plus button
    }
}

// Event listener for radio button selection
$('.input-fields-wrap').on('change', 'input[type="radio"]', function() {
    const selectedTimeSlot = $(this).val();
    const formattedDateTime = getFormattedDateTime(selectedDate, selectedTimeSlot);
    $('#selectedDate').val(formattedDateTime); // Update the "Select Date" field
});

// Function to format date and time slot
function getFormattedDateTime(date, timeSlot) {
    const currentMonthName = getMonthName(currentMonth);
    const currentYearNum = currentYear;
    return currentMonthName + ' ' + date + ', ' + currentYearNum + ', ' + timeSlot;
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

// Event listener for "Select Schedule" button
$('#selectScheduleBtn').on('click', function() {
    // Close the modal
    $('#dateModal').modal('hide');

    // Get the selected time slot
    const selectedRadio = $('.input-fields-wrap input[type="radio"]:checked');
    if (selectedRadio.length > 0) {
        const selectedTimeSlot = selectedRadio.val();
        const formattedDateTime = getFormattedDateTime(selectedDate, selectedTimeSlot);
        $('#selectedDate').val(formattedDateTime); // Update the "Select Date" field
    } else {
        // Handle case where no radio button is selected
        console.log('Please select a time slot.');
    }
});
// Event listener for radio button selection
$('.input-fields-wrap').on('change', 'input[type="radio"]', function() {
    const selectedTimeSlot = $(this).val();
    const formattedDateTime = getFormattedDateTime(selectedDate, selectedTimeSlot);
    $('#selectedDate').val(formattedDateTime); // Update the "Select Date" field

    // Enable or disable the "Select Schedule" button based on radio button selection
    const radioChecked = $('.input-fields-wrap input[type="radio"]:checked').length > 0;
    $('#selectScheduleBtn').prop('disabled', !radioChecked);
});

// Event listener for resetting selection and disabling the "Select Schedule" button
$('#calendar').on('click', '#prevMonth, #nextMonth', function() {
    resetSelection(); // Reset the selection
});

function resetSelection() {
    // Clear the selected date and time slot
    selectedDate = null;
    $('#selectedDate').val('');
    $('.input-fields-wrap input[type="radio"]').prop('checked', false);

    // Disable the "Select Schedule" button
    $('#selectScheduleBtn').prop('disabled', true);
}
