<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['login_id'];

    $sql0 = "SELECT * 
             FROM cap2233.users
             WHERE id = $outgoing_id;";

    $query0 = mysqli_query($conn, $sql0);

    while($row = mysqli_fetch_assoc($query0)){
        if($row['type'] == 3){
            $_SESSION['type'] = 3;
            $sql = "SELECT *
                    FROM assigned_counselors
                    JOIN users ON (
                                    users.id = assigned_counselors.counselor_id
                                )
                    WHERE counselor_id = $outgoing_id;";
        } elseif($row['type'] == 5){
            $_SESSION['type'] = 5;
            $sql = "SELECT *
                    FROM assigned_counselors
                    JOIN users ON (
                                    users.id = assigned_counselors.counselor_id
                                )
                    WHERE client_id = $outgoing_id;";
        } elseif($row['type'] == 6){
            $_SESSION['type'] = 6;
            $sql = "SELECT users.*, messages.*
                    FROM users
                    JOIN messages ON (users.id = messages.incoming_msg_id OR users.id = messages.outgoing_msg_id)
                    WHERE messages.msg_id IN (
                        SELECT MAX(msg_id)
                        FROM messages
                        WHERE (incoming_msg_id = $outgoing_id OR outgoing_msg_id = $outgoing_id)
                        GROUP BY LEAST(incoming_msg_id, outgoing_msg_id), GREATEST(incoming_msg_id, outgoing_msg_id)
                    )
                    AND users.id != $outgoing_id
                    AND type = 5
                    ORDER BY messages.msg_id DESC;
                    ";
        }
    }  

            
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        // $output .= "No users are available to chat";
        include_once "data.php";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    

    echo $output;
?>