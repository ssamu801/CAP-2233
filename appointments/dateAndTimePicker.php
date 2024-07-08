<style>
  .calendar {
    margin: 20px 20px 0px 20px;
}

.current-date {
    background-color: green;
    color: white;
}

.calendar .card {
    border-radius: 16px; 
}

.calendar .table {
    border-radius: 16px; 
}
.calendar .table td:hover {
    background-color: #e0e0e0;
    cursor: pointer;
}
.bi-x{
    font-size: 30px;
}

.bi {
    color: #444444; 
}

.add-more-btn {
    background-color: transparent;
    border: none;
    color: white;
    padding: 1px 8px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 1px;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 10px;
    margin-top: -11px;
    transform: scale(0.8); /* Scale down the button by 80% */
}

.add-more-btn:hover {
    background-color: #d8d8d8;
}

/* Adjust the size of the plus icon */
.bi-plus {
    font-size: 30px; /* Increase the plus icon size */
}

.remove-btn {
    background-color: transparent;
    border: none;
    color: white;
    padding: 1px 8px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 1px;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 10px;
    margin-top: -5px;
    transform: scale(0.8); /* Scale down the button by 80% */
}

.remove-btn:hover {
    background-color: #d8d8d8;
}

.test {
    margin-right: 12px;
    margin-left: 11px;
    margin-top: -27px;
    border-radius: 16px;
    border-top: 3px solid white; /* Border for the top side only */
    border-top-left-radius: 5px; /* No border radius for top-left corner */
    border-top-right-radius: 5px; /* No border radius for top-right corner */
}

.submit-button {
    margin-top: 10px;
}

.x-button{
    background-color:white;
    border-radius: 16px;
}
.cal-header{
    background-color:white;
    
}
.months-btn {
    background-color: white;
    border-radius: 50%; /* Make the button circular */
}

.months-btn:hover {
    background-color: #f2f2f2;
}
.hr-line{
    margin-top: 5px;
    margin-bottom: 5px;
}


</style>


<div class="container">
    <div class="calendar-container">
        <div id="calendar" class="calendar"></div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-7">
                <div class="card test">
                    <div class="ml-3 d-flex items-center">
                        <p class="text-lg font-semibold ml-2">Available time slots</p>
                        <button id="addTimeSlotBtn" class="add-more-btn" style="display: none;"></i></button>
                    </div>
                    
                    <div class="ml-4 mr-4 d-flex flex-column justify-content-center items-center mb-2 input-fields-wrap">
                        <!-- Time slot fields will be dynamically added here -->
                    </div>
                 <div class="text-center button-wrapper mb-2"> 
                        <button class="btn btn-secondary btn-sm ml-2" id="selectScheduleBtn">Close</button>
                </div> 
        </div>
    </div>
</div>


<script src="js/dateAndTimePicker.js"></script>

<?php 
    /* 
        128-130
    */
?>