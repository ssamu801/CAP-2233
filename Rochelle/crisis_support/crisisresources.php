<?php
include('db_connect.php');

    // Fetch categories from the database
    $query = "SELECT id, name FROM crisis_resources_tags";
    $result = $conn->query($query);

    $crisis_tags = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $crisis_tags[] = $row;
        }
    }

    // Fetch crisis resources data from the database
    $query2 = "SELECT * FROM crisis_resources ORDER BY name ASC";
    $result2 = $conn->query($query2);

    $resources = [];
    if($result2->num_rows > 0) {
        while($row = $result2->fetch_assoc()) {
            $resources[] = $row;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/resourcesstyle.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
</head>
<style>
    input[type=checkbox] {
        -ms-transform: scale(1.5); /* IE */
        -moz-transform: scale(1.5); /* FF */
        -webkit-transform: scale(1.5); /* Safari and Chrome */
        -o-transform: scale(1.5); /* Opera */
        transform: scale(1.5);
        padding: 10px;
    }

    .list-group-item +  .list-group-item {
        border-top-width: 1px !important;
    }

    #tagIcon {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
    }

    .input-group-text {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }

    .form-group {
        padding: 5px;
    }

    .tag-btn {
        margin: 2px;    
    }

    .badge-info {
        margin: 2px;
    }

    .fa-tag {
        margin: 5px;
    }

    #searchQuery {
        width: 100%;
    }
</style>
<body>
    <div id="wrapper-container" class="wrapper-container">
        <div class="container-pusher">
            <div class="content-pusher">
                <header id="head" class="site-header">
                    <section class="waspchat">
                        <div class="waspchat-contianer">
                            <a href="" title="OCCS - WASP" target="_blank">
                                <span class="waspchat-text" style="text-decoration: underline;">
                                    WASP Real-Time Chat Support
                                </span>
                            </a>
                        </div>
                    </section>
                </header>
                <div id="main-content">
                    <section class="content-area">
                        <div class="top_heading  _out">
                            <div class="top_site_main" style="background-image: url(assets/img/DLSUbg.jpg);"></div>
                        </div>
                        <div class="site-content">
                            <main id="main">
                                <div class="content-wrapper">
                                    <section class="wrapper">
                                        <h2>
                                            <span style="color: green; font-size: 30px; font-weight: 700; font-style: normal;">
                                                <strong>Crisis Directory</strong>
                                            </span>
                                        </h2>
                                        <p><span style="font-weight: 400">Are you or someone you know in need of mental and wellbeing support? Browse through the directory below to seek help and guidance from external resources.</span></p>
                                    </section>
                                    <hr>
                                    <section class="resources">
                                        <div class="resources_wrapper">
                                            <section class="resources_container">
                                                <div class="resources_content">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <nav class="float-right navbar navbar-light bg-light">
                                                                <div class="form-inline">
                                                                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModalCenter">
                                                                        <i class="fas fa-search"></i> Advanced Search
                                                                    </button>
                                                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header d-flex justify-content-center">
                                                                                    <h5 class="modal-title" id="exampleModalLongTitle" style="font-weight: 700; font-size: 24px;">Advanced Search</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form id="manage-search">
                                                                                        <input type="text" placeholder="Search" class="form-control" id="searchBtn" value="<?php echo isset($_GET['keyword'])? $_GET['keyword'] :'' ?>">
                                                                                        <div class="form-group">
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text" id="tagIcon"><i class="fa fa-tag"></i></span>
                                                                                                </div>
                                                                                                <input type="text" placeholder="Tags" class="form-control" id="tagsInput" value="<?php echo isset($_GET['tag'])? $_GET['tag'] :'' ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                    
                                                                                    <div class="form-group">
                                                                                        <!-- Display category names from db -->
                                                                                        <?php foreach ($crisis_tags as $tags): ?>
                                                                                            <button class="btn btn-info tag-btn" data-tag="<?php echo htmlspecialchars($tags['name']); ?>"><?php echo htmlspecialchars($tags['name']); ?></button>
                                                                                        <?php endforeach; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </nav>
                                                        </div>
                                                    </div>
                                                    <div class="resource_elements">
                                                        <div class="headings">
                                                            <h2 style="color: white; background: green; font-size: 25px; font-weight: bold; padding: 15px;">
                                                                Resources
                                                                <!-- make this change depending on the tags selected -->
                                                            </h2>
                                                        </div>
                                                        <div class="elements_container">
                                                            <div class="elements_row">

                                                                    <!-- Fetch and display resources from db -->                                                                        
                                                                    <div class="card" style="margin-bottom: 10px;">
                                                                        <div class="card-body">
                                                                            <ul class="w-100 list-group" id="topic-list">
                                                                                <?php foreach ($resources as $resource): ?>
                                                                                    <li class="list-group-item mb-4">
                                                                                        <div>
                                                                                            <h3 class="filter-text name"><?php echo $resource['name'] ?></h3>
                                                                                        </div>
                                                                                        
                                                                                        <div class="badge badge-default"><i class="fa fa-tags"></i> Tags: 
                                                                                            <?php
                                                                                                $resource_tags = explode(',', $resource['tags']);
                                                                                                foreach ($resource_tags as $tag_id) {
                                                                                                    foreach ($crisis_tags as $tag) {
                                                                                                        if ($tag['id'] == $tag_id) {
                                                                                                            echo '<span class="badge badge-info text-white">' . htmlspecialchars($tag['name']) . '</span>';
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                        </div>
                                                                                        <hr>
                                                                                        <div class="card-classification"><strong> Classification: </strong> <?php echo $resource['classification'];?></div>
                                                                                        <div class="card-services"><span class="material-icons md-14">info</span><strong>  Services: </strong> <?php echo $resource['services']; ?></div>
                                                                                        <div class="card-setup" style="color: green;"><strong><?php echo $resource['setup']; ?></strong></div>
                                                                                        <div class="card-expense"><span class="material-icons md-14">attach_money</span><strong>Expense: </strong> <?php echo $resource['expense']; ?></div>
                                                                                        <?php if (!empty($resource['number'])) : ?>
                                                                                            <div class="card-number">
                                                                                                <span class="material-icons md-14">phone</span><strong> Number: </strong> <?php echo $resource['number'] ?>
                                                                                            </div>
                                                                                        <?php endif; ?>
                                                                                        <?php if (!empty($resource['email'])) : ?>
                                                                                            <div class="card-email">
                                                                                                <span class="material-icons md-14">email</span><strong>  Email: </strong> <?php echo $resource['email']; ?>
                                                                                            </div>
                                                                                        <?php endif; ?>
                                                                                        <?php if (!empty($resource['ref'])) : ?>
                                                                                            <span class="material-icons md-14">link</span> <strong> Link: </strong>
                                                                                            <a class="card-ref" href="<?php echo $resource['ref'];?>" target="_blank"> <?php echo $resource['ref']; ?></a>
                                                                                        <?php endif; ?>
                                                                                        <?php if (!empty($resource['location'])) : ?>
                                                                                            <div class="card-location"><span class="material-icons md-14">place</span><strong>  Location: </strong> <?php echo $resource['location']; ?></div>
                                                                                        <?php endif; ?>
                                                                                    </li>
                                                                                <?php endforeach; ?>
                                                                            </ul>
                                                                        </div>
                                                                    </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </section>
                                    <hr>
                                </div>
                            </main>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('table').dataTable();
        });

        $('#topic-list').JPaging({
            pageSize: 15,
            visiblePageSize: 10
        });

        $('#searchBtn').keypress(function(e){
            if(e.which == 13){
                $('#manage-search').submit();
            }
        });

        $('#tagsInput').keypress(function(e){
            if(e.which == 13){
                $('#manage-search1').submit();
            }
        });

        $('#manage-search').submit(function(e){
            e.preventDefault();
            location.href = "index.php?page=crisis_support/search_resources&keyword=" + $('#searchBtn').val();
        });

        $('#manage-search1').submit(function(e){
            e.preventDefault();
            location.href = "index.php?page=crisis_support/search_resources&tag=" + $('#tagsInput').val();
        });

        $('.tag-btn').click(function(){
            var tag = $(this).data('tag');
            location.href = "index.php?page=crisis_support/search_resources&tag=" + tag;
        });
    </script>
</body>
</html>
