<?php
    while($row = mysqli_fetch_assoc($query)){

        if($_SESSION['type'] == 3){ // COUNSELOR
            $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['client_id']}
            OR outgoing_msg_id = {$row['client_id']}) AND (outgoing_msg_id = {$outgoing_id} 
            OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";

            $query2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($query2);
            (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No message available";
            (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
            if(isset($row2['outgoing_msg_id'])){
                ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
            }else{
                $you = "";
            }
            ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
            ($outgoing_id == $row['id']) ? $hid_me = "hide" : $hid_me = "";

            $output .= '<a href="index.php?page=social_interaction/chat/chat&user_id='. $row['client_id'] .'">
                        <div class="content">
                        <div class="details">
                            <span>'.$row['client_name'].'</span><span style="color:blue"> - STUDENT</span>
                            <p>'. $you . $msg .'</p>
                        </div>
                        </div>
                        <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                    </a>';
        } elseif($_SESSION['type'] == 5){ // STUDENT
            $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['counselor_id']}
            OR outgoing_msg_id = {$row['counselor_id']}) AND (outgoing_msg_id = {$outgoing_id} 
            OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";

            $query2 = mysqli_query($conn, $sql2);

            $row2 = mysqli_fetch_assoc($query2);
            (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No message available";
            (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
            if(isset($row2['outgoing_msg_id'])){
                ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
            }else{
                $you = "";
            }

            $volSql = "SELECT * FROM users where type = 6;";
            $volQuery = mysqli_query($conn, $volSql);

            $volData = mysqli_fetch_assoc($volQuery);

            $sql4 = "SELECT * FROM messages WHERE (incoming_msg_id = {$volData['id']}
            OR outgoing_msg_id = {$volData['id']}) AND (outgoing_msg_id = {$outgoing_id} 
            OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        
            $query4 = mysqli_query($conn, $sql4);
        
            $row3 = mysqli_fetch_assoc($query4);
            (mysqli_num_rows($query4) > 0) ? $result = $row3['msg'] : $result = "No message available";
            (strlen($result) > 28) ? $msg1 = substr($result, 0, 28) . '...' : $msg1 = $result;
        
            if (isset($row3['outgoing_msg_id'])) {
                ($outgoing_id == $row3['outgoing_msg_id']) ? $you = "You: " : $you = "";
            } else {
                $you = "";
            }

            ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
            ($outgoing_id == $row['id']) ? $hid_me = "hide" : $hid_me = "";

            $output .= '<a href="index.php?page=social_interaction/chat/chat&user_id='. $volData['id'] .'">
                        <div class="content">
                        <div class="details">
                            <span>'.$volData['name'].'</span><span style="color:red"> - EMERGENCY VOLUNTEER</span>
                            <p>'. $you . $msg1 .'</p>
                        </div>
                        </div>
                        <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                    </a>';

            $output .= '<a href="index.php?page=social_interaction/chat/chat&user_id='. $row['counselor_id'] .'">
                        <div class="content">
                        <div class="details">
                            <span>'.$row['counselor_name'].'</span><span style="color:green"> - Counselor</span>
                            <p>'. $you . $msg .'</p>
                        </div>
                        </div>
                        <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                    </a>';
        } elseif($_SESSION['type'] == 6){ // LIVE CHAT VOLUNTEER
            $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['id']}
            OR outgoing_msg_id = {$row['id']}) AND (outgoing_msg_id = {$outgoing_id} 
            OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";

            $query2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($query2);
            (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No message available";
            (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
            if(isset($row2['outgoing_msg_id'])){
                ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
            }else{
                $you = "";
            }
            ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
            ($outgoing_id == $row['id']) ? $hid_me = "hide" : $hid_me = "";

            $output .= '<a href="index.php?page=social_interaction/chat/chat&user_id='. $row['id'] .'">
                        <div class="content">
                        <div class="details">
                            <span>'.$row['name'].'</span><span style="color:blue"> - STUDENT</span>
                            <p>'. $you . $msg .'</p>
                        </div>
                        </div>
                        <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                    </a>';
        }

    } 

    if(mysqli_num_rows($query) == 0 && $_SESSION['type'] == 5) {

        $volSql = "SELECT * FROM users where type = 6;";
        $volQuery = mysqli_query($conn, $volSql);

        $data = $volQuery->fetch_assoc();

        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$data['id']}
        OR outgoing_msg_id = {$data['id']}) AND (outgoing_msg_id = {$outgoing_id} 
        OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";

        $query2 = mysqli_query($conn, $sql2);

        $row2 = mysqli_fetch_assoc($query2);
        (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No message available";
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
        if(isset($row2['outgoing_msg_id'])){
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        }else{
            $you = "";
        }
        ($data['status'] == "Offline now") ? $offline = "offline" : $offline = "";
        ($outgoing_id == $data['id']) ? $hid_me = "hide" : $hid_me = "";

        $output .= '<a href="index.php?page=social_interaction/chat/chat&user_id='. $data['id'] .'">
                    <div class="content">
                    <div class="details">
                        <span>'.$data['name'].'</span><span style="color:red"> - EMERGENCY VOLUNTEER</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';

    }
?>