<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
<style>
    .dropdown-list-image {
        position: relative;
        height: 2.5rem;
        width: 2.5rem;
    }

    .dropdown-list-image img {
        height: 2.5rem;
        width: 2.5rem;
    }

    .btn-light {
        color: #2cdd9b;
        background-color: #e5f7f0;
        border-color: #d8f7eb;
    }
</style>

<br>
<div class="container">
    <!-- <div class="row"> -->
    <div class="col-lg-10 right">
        <div class="box shadow-sm rounded bg-white mb-3">
            <div class="box-title border-bottom p-3">
                <h6 class="m-0">Notifications</h6>
            </div>
            <div class="box-body p-0">

                <?php

                /**
                 * Truncate a string to a specified length and append an ellipsis if necessary.
                 *
                 * @param string $text The string to be truncated.
                 * @param int $limit The maximum number of characters to display.
                 * @return string The truncated string with ellipsis appended if truncated.
                 */
                function truncateString($text, $limit) {
                    if (strlen($text) > $limit) {
                        return substr($text, 0, $limit) . "...";
                    } else {
                        return $text;
                    }
                }

                /**
                 * Calculate the number of days from the current date to the specified date.
                 *
                 * @param string $datetime The target datetime in the format "YYYY-MM-DD HH:MM:SS".
                 * @return int The number of days between the current date and the specified date.
                 */
                function daysFromCurrentDate($datetime) {
                    // Create DateTime objects for the current date and the specified date
                    $currentDate = new DateTime();
                    $targetDate = new DateTime($datetime);

                    // Calculate the difference between the two dates
                    $interval = $currentDate->diff($targetDate);

                    // Return the number of days (use abs to get the absolute value)
                    return $interval->days * ($interval->invert ? -1 : 1);
                }

                // CHECKING CONTENTS OF SESSION
                // echo "<h3> PHP List All Session Variables</h3>";
                // foreach ($_SESSION as $key=>$val)
                // echo $key." ".$val."<br/>";


                include "db_connect.php";
                // SQL query to select data based on ID
                $sql = "SELECT id, description, user_email, counselor_name, time, event_start, location,
                               event_end, event_date FROM event_notifications WHERE id=?;";
                $stmt = $conn->prepare($sql);

                $id = $_SESSION['login_id'];
                $stmt->bind_param("i", $id); // "i" indicates the type (integer)
                
                // Execute the query
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();

                // Check if there is a result and process it
                if ($result->num_rows > 0) {
                    // Output data of the row
                    // while ($row = $result->fetch_assoc()) {
                    //     echo "id: " . $row["id"] . " - Name: " . $row["firstname"] . " " . $row["lastname"] . "<br>";
                    // }
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header">
                            <div class="dropdown-list-image mr-3">
                                <img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="" />
                            </div>
                            <div class="font-weight-bold mr-3">
                                <div class="text-truncate"><?php echo truncateString($row['description'], 100)?></div>
                                <div class="small"><?php echo truncateString($row["message"], 100)?></div>
                            </div>
                            <span class="ml-auto mb-auto">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                        <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                                    </div>
                                </div>
                                <br />
                                <div class="text-right text-muted pt-1"><?php echo daysFromCurrentDate($row['time']) ?>d</div>
                            </span>
                        </div>

                    <?php
                    }
                } else {
                    echo "0 results";
                }

                // Close the statement and connection
                $stmt->close();
                $conn->close();

                ?>
                <div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="" />
                    </div>
                    <div class="font-weight-bold mr-3">
                        <div class="text-truncate">DAILY RUNDOWN: WEDNESDAY</div>
                        <div class="small">Income tax sops on the cards, The bias in VC funding, and other top news for you</div>
                    </div>
                    <span class="ml-auto mb-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                            </div>
                        </div>
                        <br />
                        <div class="text-right text-muted pt-1">3d</div>
                    </span>
                </div>
                <div class="p-3 d-flex align-items-center osahan-post-header">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" />
                    </div>
                    <div class="font-weight-bold mr-3">
                        <div class="mb-2">We found a job at askbootstrap Ltd that you may be interested in Vivamus imperdiet venenatis est...</div>
                        <button type="button" class="btn btn-outline-success btn-sm">View Jobs</button>
                    </div>
                    <span class="ml-auto mb-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                            </div>
                        </div>
                        <br />
                        <div class="text-right text-muted pt-1">4d</div>
                    </span>
                </div>
            </div>
        </div>
        <div class="box shadow-sm rounded bg-white mb-3">
            <div class="box-title border-bottom p-3">
                <h6 class="m-0">Earlier</h6>
            </div>
            <div class="box-body p-0">
                <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                    <div class="dropdown-list-image mr-3 d-flex align-items-center bg-danger justify-content-center rounded-circle text-white">DRM</div>
                    <div class="font-weight-bold mr-3">
                        <div class="text-truncate">DAILY RUNDOWN: MONDAY</div>
                        <div class="small">Nunc purus metus, aliquam vitae venenatis sit amet, porta non est.</div>
                    </div>
                    <span class="ml-auto mb-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" style="">
                                <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                            </div>
                        </div>
                        <br />
                        <div class="text-right text-muted pt-1">3d</div>
                    </span>
                </div>
                <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                    <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="" /></div>
                    <div class="font-weight-bold mr-3">
                        <div class="text-truncate">DAILY RUNDOWN: SATURDAY</div>
                        <div class="small">Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper</div>
                    </div>
                    <span class="ml-auto mb-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                            </div>
                        </div>
                        <br />
                        <div class="text-right text-muted pt-1">3d</div>
                    </span>
                </div>
                <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="" />
                    </div>
                    <div class="font-weight-bold mr-3">
                        <div class="mb-2"><span class="font-weight-normal">Congratulate Gurdeep Singh Osahan (iamgurdeeposahan)</span> for 5 years at Askbootsrap Pvt.</div>
                        <button type="button" class="btn btn-outline-success btn-sm">Say congrats</button>
                    </div>
                    <span class="ml-auto mb-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                            </div>
                        </div>
                        <br />
                        <div class="text-right text-muted pt-1">4d</div>
                    </span>
                </div>
                <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar4.png" alt="" />
                    </div>
                    <div class="font-weight-bold mr-3">
                        <div>
                            <span class="font-weight-normal">Congratulate Mnadeep singh (iamgurdeeposahan)</span> for 4 years at Askbootsrap Pvt.
                            <div class="small text-success"><i class="fa fa-check-circle"></i> You sent Mandeep a message</div>
                        </div>
                    </div>
                    <span class="ml-auto mb-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                            </div>
                        </div>
                        <br />
                        <div class="text-right text-muted pt-1">4d</div>
                    </span>
                </div>
                <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                    <div class="dropdown-list-image mr-3 d-flex align-items-center bg-success justify-content-center rounded-circle text-white">M</div>
                    <div class="font-weight-bold mr-3">
                        <div class="text-truncate">DAILY RUNDOWN: MONDAY</div>
                        <div class="small">Nunc purus metus, aliquam vitae venenatis sit amet, porta non est.</div>
                    </div>
                    <span class="ml-auto mb-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                            </div>
                        </div>
                        <br />
                        <div class="text-right text-muted pt-1">3d</div>
                    </span>
                </div>
                <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                    <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="" /></div>
                    <div class="font-weight-bold mr-3">
                        <div class="text-truncate">DAILY RUNDOWN: SATURDAY</div>
                        <div class="small">Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper</div>
                    </div>
                    <span class="ml-auto mb-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                            </div>
                        </div>
                        <br />
                        <div class="text-right text-muted pt-1">3d</div>
                    </span>
                </div>
                <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" />
                    </div>
                    <div class="font-weight-bold mr-3">
                        <div class="mb-2"><span class="font-weight-normal">Congratulate Gurdeep Singh Osahan (iamgurdeeposahan)</span> for 5 years at Askbootsrap Pvt.</div>
                        <button type="button" class="btn btn-outline-success btn-sm">Say congrats</button>
                    </div>
                    <span class="ml-auto mb-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                            </div>
                        </div>
                        <br />
                        <div class="text-right text-muted pt-1">4d</div>
                    </span>
                </div>
                <div class="p-3 d-flex align-items-center osahan-post-header">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="" />
                    </div>
                    <div class="font-weight-bold mr-3">
                        <div>
                            <span class="font-weight-normal">Congratulate Mnadeep singh (iamgurdeeposahan)</span> for 4 years at Askbootsrap Pvt.
                            <div class="small text-success"><i class="fa fa-check-circle"></i> You sent Mandeep a message</div>
                        </div>
                    </div>
                    <span class="ml-auto mb-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                            </div>
                        </div>
                        <br />
                        <div class="text-right text-muted pt-1">4d</div>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>