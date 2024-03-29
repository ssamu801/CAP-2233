<?php
    require_once 'resources.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/resourcesstyle.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">  
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
                                        <p><span style="font-weight: 400">Are you or someone you know in need of mental and wellbeing support? Browse through the directory below to seek help and guidance.</span></p>
                                    </section>
                                    <hr>
                                    <section class="resources">
                                        <div class="resources_wrapper">
                                            <section class="resources_container">
                                                <div class="resources_content">
                                                    <div class="custom-select">
                                                        <select id="select-category">
                                                            <option value="0">Jump to: </option>
                                                            <option value="#emergency">Emergency Crisis Hotlines</option>
                                                            <option value="#alcohol">Alcohol and Substance Abuse</option>
                                                            <option value="#anxiety">Anxiety, Depression, and Stress</option>
                                                            <option value="#covid">COVID Support</option>
                                                            <option value="#domestic">Domestic Violence and Sexual Abuse</option>
                                                            <option value="#eating">Eating and Body Image</option>
                                                            <option value="#family">Family Relationships</option>
                                                            <option value="#gender">Gender and Sexuality</option>
                                                            <option value="#mental">Mental Health Conditions</option>
                                                            <option value="#schoolwork">School / Work Environment</option>
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <div class="resource_elements" id="emergency">
                                                        <div class="headings">
                                                            <h2 style="color: white; background: green; font-size: 25px; font-weight: bold; padding: 15px;">Emergency Crisis Hotlines</h2>
                                                        </div>
                                                            <div class="elements_container">
                                                                <div class="elements_row">
                                                                    <div class="cbox-deck">
                                                                        <?php foreach ($emergency_resources as $resources) : ?>
                                                                            <div class="cbox">
                                                                                <div class="cbox-body">
                                                                                    <div class="cbox-content">
                                                                                        <p class="cbox-title"><strong><?php echo $resources['name'];?></strong></p>
                                                                                        <p class="cbox-classification"><strong><?php echo $resources['classification'];?></strong></p>
                                                                                        <p class="cbox-services"><span class="material-icons md-14">info</span> <?php echo $resources['services']; ?></p>
                                                                                        <p class="cbox-setup" style="color: green;"><strong><?php echo $resources['setup']; ?></strong></p>
                                                                                        <p class="cbox-expense"><span class="material-icons md-14">attach_money</span><?php echo $resources['expense']; ?></p>
                                                                                        <?php if (!empty($resources['number'])) : ?>
                                                                                            <p class="cbox-number"><span class="material-icons md-14">call</span> <?php echo $resources['number']; ?></p>
                                                                                        <?php endif; ?>
                                                                                        <?php if (!empty($resources['email'])) : ?>
                                                                                            <p class="cbox-email"><span class="material-icons md-14">email</span> <?php echo $resources['email']; ?></p>
                                                                                        <?php endif; ?>
                                                                                        <?php if (!empty($resources['ref'])) : ?>
                                                                                            <a class="cbox-ref" href="<?php echo $resources['ref'];?>" target="_blank"><span class="material-icons md-14">link</span> <?php echo $resources['ref']; ?></a>
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
                                                    <div class="resource_elements" id="alcohol">
                                                        <div class="headings">
                                                            <h2 style="color: white; background: green; font-size: 25px; font-weight: bold; padding: 15px;">Alcohol and Substance Abuse</h2>
                                                        </div>
                                                        <div class="elements_container">
                                                            <div class="elements_row">
                                                                <div class="cbox-deck">
                                                                    <?php foreach ($alcoholsubtance_resources as $resources) : ?>
                                                                        <div class="cbox">
                                                                            <div class="cbox-body">
                                                                                <div class="cbox-content">
                                                                                    <p class="cbox-title"><strong><?php echo $resources['name'];?></strong></p>
                                                                                    <p class="cbox-classification"><strong><?php echo $resources['classification'];?></strong></p>
                                                                                    <p class="cbox-services"><span class="material-icons md-14">info</span> <?php echo $resources['services']; ?></p>
                                                                                    <p class="cbox-setup" style="color: green;"><strong><?php echo $resources['setup']; ?></strong></p>
                                                                                    <p class="cbox-expense"><span class="material-icons md-14">attach_money</span><?php echo $resources['expense']; ?></p>
                                                                                    <?php if (!empty($resources['number'])) : ?>
                                                                                        <p class="cbox-number"><span class="material-icons md-14">call</span> <?php echo $resources['number']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['email'])) : ?>
                                                                                        <p class="cbox-email"><span class="material-icons md-14">email</span> <?php echo $resources['email']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['ref'])) : ?>
                                                                                        <a class="cbox-ref" href="<?php echo $resources['ref'];?>" target="_blank"><span class="material-icons md-14">link</span> <?php echo $resources['ref']; ?></a>
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
                                                    <hr>
                                                    <div class="resource_elements" id="anxiety">
                                                        <div class="headings">
                                                            <h2 style="color: white; background: green; font-size: 25px; font-weight: bold; padding: 15px;">Anxiety, Depression, and Stress</h2>
                                                        </div>
                                                        <div class="elements_container">
                                                            <div class="elements_row">
                                                                <div class="cbox-deck">
                                                                    <?php foreach ($anxietydepressionstress_resources as $resources) : ?>
                                                                        <div class="cbox">
                                                                            <div class="cbox-body">
                                                                                <div class="cbox-content">
                                                                                    <p class="cbox-title"><strong><?php echo $resources['name'];?></strong></p>
                                                                                    <p class="cbox-classification"><strong><?php echo $resources['classification'];?></strong></p>
                                                                                    <p class="cbox-services"><span class="material-icons md-14">info</span> <?php echo $resources['services']; ?></p>
                                                                                    <p class="cbox-setup" style="color: green;"><strong><?php echo $resources['setup']; ?></strong></p>
                                                                                    <p class="cbox-expense"><span class="material-icons md-14">attach_money</span><?php echo $resources['expense']; ?></p>
                                                                                    <?php if (!empty($resources['number'])) : ?>
                                                                                        <p class="cbox-number"><span class="material-icons md-14">call</span> <?php echo $resources['number']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['email'])) : ?>
                                                                                        <p class="cbox-email"><span class="material-icons md-14">email</span> <?php echo $resources['email']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['ref'])) : ?>
                                                                                        <a class="cbox-ref" href="<?php echo $resources['ref'];?>" target="_blank"><span class="material-icons md-14">link</span> <?php echo $resources['ref']; ?></a>
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
                                                    <hr>
                                                    <div class="resource_elements" id="covid">
                                                        <div class="headings">
                                                            <h2 style="color: white; background: green; font-size: 25px; font-weight: bold; padding: 15px;">COVID Support</h2>
                                                        </div>
                                                        <div class="elements_container">
                                                            <div class="elements_row">
                                                                <div class="cbox-deck">
                                                                    <?php foreach ($covidsupport_resources as $resources) : ?>
                                                                        <div class="cbox">
                                                                            <div class="cbox-body">
                                                                                <div class="cbox-content">
                                                                                    <p class="cbox-title"><strong><?php echo $resources['name'];?></strong></p>
                                                                                    <p class="cbox-classification"><strong><?php echo $resources['classification'];?></strong></p>
                                                                                    <p class="cbox-services"><span class="material-icons md-14">info</span> <?php echo $resources['services']; ?></p>
                                                                                    <p class="cbox-setup" style="color: green;"><strong><?php echo $resources['setup']; ?></strong></p>
                                                                                    <p class="cbox-expense"><span class="material-icons md-14">attach_money</span><?php echo $resources['expense']; ?></p>
                                                                                    <?php if (!empty($resources['number'])) : ?>
                                                                                        <p class="cbox-number"><span class="material-icons md-14">call</span> <?php echo $resources['number']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['email'])) : ?>
                                                                                        <p class="cbox-email"><span class="material-icons md-14">email</span> <?php echo $resources['email']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['ref'])) : ?>
                                                                                        <a class="cbox-ref" href="<?php echo $resources['ref'];?>" target="_blank"><span class="material-icons md-14">link</span> <?php echo $resources['ref']; ?></a>
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
                                                    <hr>
                                                    <div class="resource_elements" id="domestic">
                                                        <div class="headings">
                                                            <h2 style="color: white; background: green; font-size: 25px; font-weight: bold; padding: 15px;">Domestic Violence and Sexual Abuse</h2>
                                                        </div>                                                        
                                                        <div class="elements_container">
                                                            <div class="elements_row">
                                                                <div class="cbox-deck">
                                                                    <?php foreach ($domesticviolence_resources as $resources) : ?>
                                                                        <div class="cbox">
                                                                            <div class="cbox-body">
                                                                                <div class="cbox-content">
                                                                                    <p class="cbox-title"><strong><?php echo $resources['name'];?></strong></p>
                                                                                    <p class="cbox-classification"><strong><?php echo $resources['classification'];?></strong></p>
                                                                                    <p class="cbox-services"><span class="material-icons md-14">info</span> <?php echo $resources['services']; ?></p>
                                                                                    <p class="cbox-setup" style="color: green;"><strong><?php echo $resources['setup']; ?></strong></p>
                                                                                    <p class="cbox-expense"><span class="material-icons md-14">attach_money</span><?php echo $resources['expense']; ?></p>
                                                                                    <?php if (!empty($resources['number'])) : ?>
                                                                                        <p class="cbox-number"><span class="material-icons md-14">call</span> <?php echo $resources['number']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['email'])) : ?>
                                                                                        <p class="cbox-email"><span class="material-icons md-14">email</span> <?php echo $resources['email']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['ref'])) : ?>
                                                                                        <a class="cbox-ref" href="<?php echo $resources['ref'];?>" target="_blank"><span class="material-icons md-14">link</span> <?php echo $resources['ref']; ?></a>
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
                                                    <hr>
                                                    <div class="resource_elements" id="eating">
                                                        <div class="headings">
                                                            <h2 style="color: white; background: green; font-size: 25px; font-weight: bold; padding: 15px;">Eating and Body Image</h2>
                                                        </div>   
                                                        <div class="elements_container">
                                                            <div class="elements_row">
                                                                <div class="cbox-deck">
                                                                    <?php foreach ($eatingandbody_resources as $resources) : ?>
                                                                        <div class="cbox">
                                                                            <div class="cbox-body">
                                                                                <div class="cbox-content">
                                                                                    <p class="cbox-title"><strong><?php echo $resources['name'];?></strong></p>
                                                                                    <p class="cbox-classification"><strong><?php echo $resources['classification'];?></strong></p>
                                                                                    <p class="cbox-services"><span class="material-icons md-14">info</span> <?php echo $resources['services']; ?></p>
                                                                                    <p class="cbox-setup" style="color: green;"><strong><?php echo $resources['setup']; ?></strong></p>
                                                                                    <p class="cbox-expense"><span class="material-icons md-14">attach_money</span><?php echo $resources['expense']; ?></p>
                                                                                    <?php if (!empty($resources['number'])) : ?>
                                                                                        <p class="cbox-number"><span class="material-icons md-14">call</span> <?php echo $resources['number']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['email'])) : ?>
                                                                                        <p class="cbox-email"><span class="material-icons md-14">email</span> <?php echo $resources['email']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['ref'])) : ?>
                                                                                        <a class="cbox-ref" href="<?php echo $resources['ref'];?>" target="_blank"><span class="material-icons md-14">link</span> <?php echo $resources['ref']; ?></a>
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
                                                    <hr>
                                                    <div class="resource_elements" id="family">
                                                        <div class="headings">
                                                            <h2 style="color: white; background: green; font-size: 25px; font-weight: bold; padding: 15px;">Family Relationships</h2>
                                                        </div> 
                                                        <div class="elements_container">
                                                            <div class="elements_row">
                                                                <div class="cbox-deck">
                                                                    <?php foreach ($family_resources as $resources) : ?>
                                                                        <div class="cbox">
                                                                            <div class="cbox-body">
                                                                                <div class="cbox-content">
                                                                                    <p class="cbox-title"><strong><?php echo $resources['name'];?></strong></p>
                                                                                    <p class="cbox-classification"><strong><?php echo $resources['classification'];?></strong></p>
                                                                                    <p class="cbox-services"><span class="material-icons md-14">info</span> <?php echo $resources['services']; ?></p>
                                                                                    <p class="cbox-setup" style="color: green;"><strong><?php echo $resources['setup']; ?></strong></p>
                                                                                    <p class="cbox-expense"><span class="material-icons md-14">attach_money</span><?php echo $resources['expense']; ?></p>
                                                                                    <?php if (!empty($resources['number'])) : ?>
                                                                                        <p class="cbox-number"><span class="material-icons md-14">call</span> <?php echo $resources['number']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['email'])) : ?>
                                                                                        <p class="cbox-email"><span class="material-icons md-14">email</span> <?php echo $resources['email']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['ref'])) : ?>
                                                                                        <a class="cbox-ref" href="<?php echo $resources['ref'];?>" target="_blank"><span class="material-icons md-14">link</span> <?php echo $resources['ref']; ?></a>
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
                                                    <hr>
                                                    <div class="resource_elements" id="gender">
                                                        <div class="headings">
                                                            <h2 style="color: white; background: green; font-size: 25px; font-weight: bold; padding: 15px;">Gender and Sexuality</h2>
                                                        </div> 
                                                        <div class="elements_container">
                                                            <div class="elements_row">
                                                                <div class="cbox-deck">
                                                                    <?php foreach ($genderandsexuality_resources as $resources) : ?>
                                                                        <div class="cbox">
                                                                            <div class="cbox-body">
                                                                                <div class="cbox-content">
                                                                                    <p class="cbox-title"><strong><?php echo $resources['name'];?></strong></p>
                                                                                    <p class="cbox-classification"><strong><?php echo $resources['classification'];?></strong></p>
                                                                                    <p class="cbox-services"><span class="material-icons md-14">info</span> <?php echo $resources['services']; ?></p>
                                                                                    <p class="cbox-setup" style="color: green;"><strong><?php echo $resources['setup']; ?></strong></p>
                                                                                    <p class="cbox-expense"><span class="material-icons md-14">attach_money</span><?php echo $resources['expense']; ?></p>
                                                                                    <?php if (!empty($resources['number'])) : ?>
                                                                                        <p class="cbox-number"><span class="material-icons md-14">call</span> <?php echo $resources['number']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['email'])) : ?>
                                                                                        <p class="cbox-email"><span class="material-icons md-14">email</span> <?php echo $resources['email']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['ref'])) : ?>
                                                                                        <a class="cbox-ref" href="<?php echo $resources['ref'];?>" target="_blank"><span class="material-icons md-14">link</span> <?php echo $resources['ref']; ?></a>
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
                                                    <hr>
                                                    <div class="resource_elements" id="mental">
                                                        <div class="headings">
                                                            <h2 style="color: white; background: green; font-size: 25px; font-weight: bold; padding: 15px;">Mental Health Conditions</h2>
                                                        </div> 
                                                        <div class="elements_container">
                                                            <div class="elements_row">
                                                                <div class="cbox-deck">
                                                                    <?php foreach ($mentalhealth_resources as $resources) : ?>
                                                                        <div class="cbox">
                                                                            <div class="cbox-body">
                                                                                <div class="cbox-content">
                                                                                    <p class="cbox-title"><strong><?php echo $resources['name'];?></strong></p>
                                                                                    <p class="cbox-classification"><strong><?php echo $resources['classification'];?></strong></p>
                                                                                    <p class="cbox-services"><span class="material-icons md-14">info</span> <?php echo $resources['services']; ?></p>
                                                                                    <p class="cbox-setup" style="color: green;"><strong><?php echo $resources['setup']; ?></strong></p>
                                                                                    <p class="cbox-expense"><span class="material-icons md-14">attach_money</span><?php echo $resources['expense']; ?></p>
                                                                                    <?php if (!empty($resources['number'])) : ?>
                                                                                        <p class="cbox-number"><span class="material-icons md-14">call</span> <?php echo $resources['number']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['email'])) : ?>
                                                                                        <p class="cbox-email"><span class="material-icons md-14">email</span> <?php echo $resources['email']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['ref'])) : ?>
                                                                                        <a class="cbox-ref" href="<?php echo $resources['ref'];?>" target="_blank"><span class="material-icons md-14">link</span> <?php echo $resources['ref']; ?></a>
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
                                                    <hr>
                                                    <div class="resource_elements" id="schoolwork">
                                                        <div class="headings">
                                                            <h2 style="color: white; background: green; font-size: 25px; font-weight: bold; padding: 15px;">School and Work Environment</h2>
                                                        </div> 
                                                        <div class="elements_container">
                                                            <div class="elements_row">
                                                                <div class="cbox-deck">
                                                                    <?php foreach ($schoolwork_resources as $resources) : ?>
                                                                        <div class="cbox">
                                                                            <div class="cbox-body">
                                                                                <div class="cbox-content">
                                                                                    <p class="cbox-title"><strong><?php echo $resources['name'];?></strong></p>
                                                                                    <p class="cbox-classification"><strong><?php echo $resources['classification'];?></strong></p>
                                                                                    <p class="cbox-services"><span class="material-icons md-14">info</span> <?php echo $resources['services']; ?></p>
                                                                                    <p class="cbox-setup" style="color: green;"><strong><?php echo $resources['setup']; ?></strong></p>
                                                                                    <p class="cbox-expense"><span class="material-icons md-14">attach_money</span><?php echo $resources['expense']; ?></p>
                                                                                    <?php if (!empty($resources['number'])) : ?>
                                                                                        <p class="cbox-number"><span class="material-icons md-14">call</span> <?php echo $resources['number']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['email'])) : ?>
                                                                                        <p class="cbox-email"><span class="material-icons md-14">email</span> <?php echo $resources['email']; ?></p>
                                                                                    <?php endif; ?>
                                                                                    <?php if (!empty($resources['ref'])) : ?>
                                                                                        <a class="cbox-ref" href="<?php echo $resources['ref'];?>" target="_blank"><span class="material-icons md-14">link</span> <?php echo $resources['ref']; ?></a>
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
                                                    <hr>
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
    <script>
        var x, i, j, l, ll, selElmnt, a, b, c;
        x = document.getElementsByClassName("custom-select");
        l = x.length;

        for (i = 0; i < l; i++) {
            selElmnt = x[i].getElementsByTagName("select")[0];
            ll = selElmnt.length;

            a = document.createElement("DIV");
            a.setAttribute("class", "select-selected");
            a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
            x[i].appendChild(a);

            b = document.createElement("DIV");
            b.setAttribute("class", "select-items select-hide");

            for (j = 1; j < ll; j++) {
                c = document.createElement("DIV");
                c.setAttribute('data-value', selElmnt.options[j].value);

                c.addEventListener("click", function(e) {
                    window.location.href = this.getAttribute('data-value');
                });

                c.innerHTML = selElmnt.options[j].innerHTML;
                b.appendChild(c);
            }
            x[i].appendChild(b);

            a.addEventListener("click", function(e) {
                e.stopPropagation();
                closeAllSelect(this);

                this.nextSibling.classList.toggle("select-hide");
                this.classList.toggle("select-arrow-active");
            });
        }

        function closeAllSelect(elmnt) {
            var x, y, i, xl, yl, arrNo = [];
            x = document.getElementsByClassName("select-items");
            y = document.getElementsByClassName("select-selected");
            xl = x.length;
            yl = y.length;

            for (i = 0; i < yl; i++) {
                if (elmnt == y[i]) {
                    arrNo.push(i)
                } else {
                    y[i].classList.remove("select-arrow-active");
                }
            }
            for (i = 0; i < xl; i++) {
                if (arrNo.indexOf(i)) {
                    x[i].classList.add("select-hide");
                }
            }
        }

        document.addEventListener("click", closeAllSelect);

    </script>
</body>
</html>