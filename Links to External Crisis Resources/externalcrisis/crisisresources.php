<?php
    require_once 'resources.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/resourcesstyle.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"></script>
</head>
<body>
    <div id="wrapper-container" class="wrapper-container">
        <div class="container-pusher">
            <div class="content-pusher">
                <header id="head" class="site-header">
                    <section class="waspchat">
                        <div class="waspchat-contianer">
                            <!-- link to real chat -->
                            <a href="" title="OCCS - WASP" target="_blank">
                                <span class="waspchat-text">
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
                                        <p>
                                            <span style="font-weight: 400">Need immediate support? If you or someone you know is in crisis, please don't hesitate to seek help from the following resources:</span>
                                        </p>
                                    </section>
                                    <section class="resources">
                                        <div class="resources_wrapper">
                                            <section class="resources_container">
                                                <div class="resources_content">
                                                    <div class="search_bar_col">
                                                        <div class="search_bar_container">
                                                            <div class="search_bar">
                                                                <input type="text" placeholder="Search here" id="find" value="" style="font-style: italic">
                                                                <div class="dropdown">
                                                                    <button class="dropbtn">Filter Items</button>
                                                                    <div class="dropdown-content">
                                                                        <div class="submenu">
                                                                            <label for="expenseCheckbox"><strong>Expenses</strong></label>
                                                                            <div class="subsubmenu">
                                                                                <input type="checkbox" id="freeCheckbox" value="free">
                                                                                <label for="freeCheckbox">Free</label></br>
                                                                                <input type="checkbox" id="outOfPocketCheckbox" value="outOfPocket">
                                                                                <label for="outOfPocketCheckbox">Out of Pocket</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="submenu">
                                                                            <label for="deliveryCheckbox"><strong>Mode of Delivery</strong></label>
                                                                            <div class="subsubmenu">
                                                                                <input type="checkbox" id="faceToFaceCheckbox" value="faceToFace">
                                                                                <label for="faceToFaceCheckbox">Face-to-Face</label></br>
                                                                                <input type="checkbox" id="hybridCheckbox" value="hybrid">
                                                                                <label for="hybridCheckbox">Hybrid</label></br>
                                                                                <input type="checkbox" id="onlineCheckbox" value="online">
                                                                                <label for="onlineCheckbox">Online</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="submenu">
                                                                            <label for="categoryCheckbox"><strong>Categories</strong></label>
                                                                            <div class="subsubmenu">
                                                                                <input type="checkbox" id="advocacyGroupCheckbox" value="advocacyGroup">
                                                                                <label for="advocacyGroupCheckbox">Advocacy Group</label></br>
                                                                                <input type="checkbox" id="facilityClinicCheckbox" value="facilityClinic">
                                                                                <label for="facilityClinicCheckbox">Facility/Clinic</label></br>
                                                                                <input type="checkbox" id="hotlineCheckbox" value="hotline">
                                                                                <label for="hotlineCheckbox">Hotline</label></br>
                                                                                <input type="checkbox" id="hospitalCheckbox" value="hospital">
                                                                                <label for="hospitalCheckbox">Hospital</label></br>
                                                                                <input type="checkbox" id="telementalHealthCheckbox" value="telementalHealth">
                                                                                <label for="telementalHealthCheckbox">Telemental Health</label></br>
                                                                                <input type="checkbox" id="supportGroupCheckbox" value="supportGroup">
                                                                                <label for="supportGroupCheckbox">Support Group</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="submenu">
                                                                            <label for="classificationCheckbox"><strong>Classification</strong></label>
                                                                            <div class="subsubmenu">
                                                                                <input type="checkbox" id="governmentCheckbox" value="government">
                                                                                <label for="governmentCheckbox">Government</label></br>
                                                                                <input type="checkbox" id="nonProfitCheckbox" value="nonProfit">
                                                                                <label for="nonProfitCheckbox">Non-profit Organization</label></br>
                                                                                <input type="checkbox" id="privateCheckbox" value="private">
                                                                                <label for="privateCheckbox">Private</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="resource_elements">
                                                        <div class="elements_container">
                                                            <div class="elements_row">
                                                                <div class="cbox-deck">
                                                                    <?php foreach ($dir_resources as $resources) : ?>
                                                                        <div class="cbox">
                                                                            <div class="cbox-body">
                                                                                <div class="cbox-content">
                                                                                    <p class="cbox-category"><?php echo $resources['category'];?></p>
                                                                                    <a class="cbox-title" href="<?php echo $resources['ref'];?>" target="_blank"><?php echo $resources['name'];?></a>
                                                                                    <p class="cbox-classification"><strong><?php echo $resources['classification'];?></strong></p>
                                                                                    <p class="cbox-services"><strong>Services: </strong><?php echo $resources['services']; ?></p>
                                                                                    <p class="cbox-setup" style="color: green;"><strong><?php echo $resources['setup']; ?></strong></p>
                                                                                    <p class="cbox-expense"><span class="material-icons md-14">attach_money</span><?php echo $resources['expense']; ?></p>
                                                                                    <?php if (!empty($resources['number'])) : ?>
                                                                                        <?php $numbers = explode(' | ', $resources['number']); ?>
                                                                                        <div class="cbox-number">
                                                                                            <span class="material-icons md-14">call</span>
                                                                                            <?php foreach ($numbers as $index => $number) : ?>
                                                                                                <?php if ($index !== 0) : ?>
                                                                                                    <br>
                                                                                                <?php endif; ?>
                                                                                                 <?php echo $number; ?>
                                                                                            <?php endforeach; ?>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['email'])) : ?>
                                                                                        <p class="cbox-email"><span class="material-icons md-14">email</span> <?php echo $resources['email']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['location'])) : ?>
                                                                                        <p class="cbox-location"><span class="material-icons md-14">place</span> <?php echo $resources['location']; ?></p>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </section>
                                </div>
                            </main>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</body>
</html>