var currentYear, currentMonth, currentDate;
var selectedDate = null;
var clickedMonth = null;
var clickedYear = null;

$(document).ready(function() {
    currentDate = new Date();
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
                row += '<td ' + cellClass + ' onclick="selectDate(this)">' + date + '</td>'; // Add onclick event to select date
                date++;
            }
        }
        row += '</tr>';
        calendar += row;
    }

    calendar += '</tbody></table></div></div></div></div></div></div>';

    return calendar;
}

// Function to select date and change color
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
    } else {
        addTimeSlotBtn.style.display = 'none'; // Hide the plus button
    }
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
    var maxTimeSlots = 7; // Maximum time slots allowed
    var timeSlotsWrapper = $(".input-fields-wrap"); // Time slots wrapper
    var buttonWrapper = $(".button-wrapper");
    var addTimeSlotButton = $(".add-more-btn"); // Add time slot button
    var submitButtonContainer = $(".submit-button"); // Submit button container
    var saveTimeSlotsBtn = $(".saveTimeSlotsBtn"); // Save button

    var timeSlotCount = 1; // Initial time slot count

    // Function to check if save button should be enabled or disabled
    function checkSaveButton() {
        var isTimeFieldsValid = true;
        $(".input-field").each(function() {
            if ($(this).val() === '') {
                isTimeFieldsValid = false;
                return false; // Exit loop early if any field is empty
            }
        });

        var isRadioSelected = $("input[name='scheduleType']:checked").length > 0;

        if (isTimeFieldsValid && isRadioSelected && timeSlotCount > 1) {
            saveTimeSlotsBtn.prop("disabled", false); // Enable save button
        } else {
            saveTimeSlotsBtn.prop("disabled", true); // Disable save button
        }
    }

    // Function to toggle radio buttons visibility
    function toggleRadioButtons() {
        if (timeSlotCount > 1) {
            $(".radio-wrapper").show();
        } else {
            $(".radio-wrapper").hide();
        }
    }

    $(addTimeSlotButton).click(function(e) { // On add time slot button click
        e.preventDefault();
        if (timeSlotCount < maxTimeSlots) { // Max time slots allowed
            // Check if all existing time slots are filled
            var allTimeSlotsFilled = true;
            $(".input-field").each(function() {
                if ($(this).val() === '') {
                    allTimeSlotsFilled = false;
                    return false; // Exit loop early if any field is empty
                }
            });
    
            if (allTimeSlotsFilled) {
                timeSlotCount++; // Increment time slot count
                $(timeSlotsWrapper).append('<div class="ml-4 d-flex justify-content-center items-center mb-2"><input type="time" name="time_from[]" class="form-control input-field" value="" required><h3> - </h3><input type="time" name="time_to[]" class="form-control input-field" value="" required><button class="remove-btn mr-4"><i class="bi bi-x"></i></button></div>'); // Add time slot fields
                toggleRadioButtons(); // Toggle radio buttons visibility
                checkSaveButton(); // Check if save button should be enabled or disabled
            } else {
                // Handle case where not all time slots are filled
                // Optionally show an error message or prevent adding new slots
                alert('Please fill up the existing time slot before adding a new time slot.');
            }
        } else {
            // Show alert when max time slots are reached
            alert('Maximum number of time slots per day reached.');

        }
    });
    

    $(timeSlotsWrapper).on("click", ".remove-btn", function(e) { // On remove time slot button click
        e.preventDefault();
        $(this).parent('div').remove(); // Remove the time slot fields
        timeSlotCount--; // Decrement time slot count
        toggleRadioButtons(); // Toggle radio buttons visibility
    });

    // Check initial state of save button
    checkSaveButton();

    // Check on change events for time fields and radio buttons
    $(timeSlotsWrapper).on('change', '.input-field', function() {
        checkSaveButton();
    });

    $("input[name='scheduleType']").change(function() {
        checkSaveButton();
    });

    toggleRadioButtons();
});

$(".saveTimeSlotsBtn").click(function() {
    // Collect time slot data from the input fields
    console.log('Save button clicked');
    var timeSlotsData = {
        timeSlots: [],
        selectedDate: selectedDate, // Add the selected date
        selectedMonth: clickedMonth, // Add the selected month (adding 1 because months are zero-indexed)
        selectedYear: clickedYear, // Add the selected year
        scheduleType: $("input[name='scheduleType']:checked").val() // Get the selected schedule type
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
        data: { 
            timeSlotsData: JSON.stringify(timeSlotsData),
            scheduleType: timeSlotsData.scheduleType // Include the scheduleType in the AJAX data
        },
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
