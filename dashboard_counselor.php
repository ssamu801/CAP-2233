<?php include 'db_connect.php' ?>

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
                                                <h4 class="num"><b>67</b></h4>
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
                                                <h4 class="num"><b>27</b></h4>
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
                                                <h4 class="num"><b>23</b></h4>
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
                                                <h4 class="num"><b>17</b></h4>
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
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Start Time</th>
                                                <th class="text-center">End Time</th>
                                                <th class="text-center">Location</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">Yujin Domingo</td>
                                                <td class="text-center">2024-05-02</td>
                                                <td class="text-center">09:00 AM</td>
                                                <td class="text-center">10:00 AM</td>
                                                <td class="text-center">Andrew Gonzales Hall A1008</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Miles Morales</td>
                                                <td class="text-center">2024-05-07</td>
                                                <td class="text-center">11:00 AM</td>
                                                <td class="text-center">12:00 PM</td>
                                                <td class="text-center">Andrew Gonzales Hall A1008</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Arlo Marquez</td>
                                                <td class="text-center">2024-05-10</td>
                                                <td class="text-center">09:00 AM</td>
                                                <td class="text-center">10:00 AM</td>
                                                <td class="text-center">Andrew Gonzales Hall A1008</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Yana Madrid</td>
                                                <td class="text-center">2024-05-13</td>
                                                <td class="text-center">09:00 AM</td>
                                                <td class="text-center">10:00 AM</td>
                                                <td class="text-center">Zoom Link</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Winston Mercado</td>
                                                <td class="text-center">2024-05-15</td>
                                                <td class="text-center">09:00 AM</td>
                                                <td class="text-center">10:00 AM</td>
                                                <td class="text-center">Andrew Gonzales Hall A1008</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Yujin Domingo</td>
                                                <td class="text-center">2024-05-02</td>
                                                <td class="text-center">09:00 AM</td>
                                                <td class="text-center">10:00 AM</td>
                                                <td class="text-center">Andrew Gonzales Hall A1008</td>
                                            </tr>
                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="approved-posts" role="tabpanel" aria-labelledby="approved-posts-tab">
                                    <div class="table-container">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Start Time</th>
                                                    <th class="text-center">End Time</th>
                                                    <th class="text-center">Location</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">John Doe</td>
                                                    <td class="text-center">2024-06-01</td>
                                                    <td class="text-center">09:00 AM</td>
                                                    <td class="text-center">10:00 AM</td>
                                                    <td class="text-center">Room 101</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Jane Smith</td>
                                                    <td class="text-center">2024-06-03</td>
                                                    <td class="text-center">11:00 AM</td>
                                                    <td class="text-center">12:00 PM</td>
                                                    <td class="text-center">Room 102</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Alice Johnson</td>
                                                    <td class="text-center">2024-06-05</td>
                                                    <td class="text-center">01:00 PM</td>
                                                    <td class="text-center">02:00 PM</td>
                                                    <td class="text-center">Room 103</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Bob Brown</td>
                                                    <td class="text-center">2024-06-07</td>
                                                    <td class="text-center">03:00 PM</td>
                                                    <td class="text-center">04:00 PM</td>
                                                    <td class="text-center">Room 104</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                                <b>Scheduled Appointments</b>
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
                                            <td class="text-center">
                                                Yujin Domingo
                                            </td>
                                            <td class="text-center">
                                                2024-05-02
                                            </td>
                                            <td class="text-center">
                                                09:00 AM
                                            </td>
                                            <td class="text-center">
                                                10:00 AM
                                            </td>
                                            <td class="text-center">
                                                Face-to-Face
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                Miles Morales
                                            </td>
                                            <td class="text-center">
                                                2024-05-07
                                            </td>
                                            <td class="text-center">
                                                11:00 AM
                                            </td>
                                            <td class="text-center">
                                                12:00 PM
                                            </td>
                                            <td class="text-center">
                                                Face-to-Face
                                            </td>
                                        </tr>
                                        <tr style="background-color: #84b894;">
                                            <td class="text-center">
                                                Arlo Marquez
                                            </td>
                                            <td class="text-center">
                                                2024-05-10
                                            </td>
                                            <td class="text-center">
                                                09:00 AM
                                            </td>
                                            <td class="text-center">
                                                10:00 AM
                                            </td>
                                            <td class="text-center">
                                                Face-to-Face
                                            </td>
                                        </tr>
                                        <tr style="background-color: #84b894;">
                                            <td class="text-center">
                                                Yana Madrid
                                            </td>
                                            <td class="text-center">
                                                2024-05-13
                                            </td>
                                            <td class="text-center">
                                                09:00 AM
                                            </td>
                                            <td class="text-center">
                                                10:00 AM
                                            </td>
                                            <td class="text-center">
                                                Online
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                Winston Mercado
                                            </td>
                                            <td class="text-center">
                                                2024-05-15
                                            </td>
                                            <td class="text-center">
                                                09:00 AM
                                            </td>
                                            <td class="text-center">
                                                10:00 AM
                                            </td>
                                            <td class="text-center">
                                                Online
                                            </td>
                                        </tr>
                                        <tr style="background-color: #84b894;">
                                            <td class="text-center">
                                                Yujin Domingo
                                            </td>
                                            <td class="text-center">
                                                2024-05-17
                                            </td>
                                            <td class="text-center">
                                                09:00 AM
                                            </td>
                                            <td class="text-center">
                                                10:00 AM
                                            </td>
                                            <td class="text-center">
                                                Online
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="appointments mb-4">
                        <div class="card">
                            <div class="card-header">
                                <b>Appointments Booked</b>
                            </div>
                            <div class="card-body">
                            <?php
 
                                $dataPoints = array( 
                                    array("label"=>"Upcoming", "symbol" => "Upcoming","y"=>27),
                                    array("label"=>"Cancelled", "symbol" => "Cancelled","y"=>13),
                                    array("label"=>"No Show", "symbol" => "No Show","y"=>4),
                                )
  
                            ?>
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script>
    window.onload = function() {
 
 var chart = new CanvasJS.Chart("chartContainer", {
     theme: "light2",
     animationEnabled: true,
     title: {
         text: ""
     },
     data: [{
         type: "doughnut",
         indexLabel: "{symbol} - {y}",
         yValueFormatString: "#,##0.0",
         showInLegend: true,
         legendText: "{label} : {y}",
         dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
     }]
 });
 chart.render();
  
 }
    
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
