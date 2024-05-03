<?php
include '../db_connect.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    if($_GET['type'] == 1){ // approved post
        $sql = "SELECT n.*, t.title FROM notifications n JOIN topics t ON  n.topic_id=t.id WHERE n.id=$id LIMIT 1;";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "We are pleased to inform you that your recent post titled '<i>" . $row['title'] . "</i>'  on our discussion forum has been approved by our moderators. Your contribution to the community is greatly appreciated.
                <br>
                <br>
                Thank you for adhering to our community guidelines and policies. We encourage you to continue engaging with our platform and sharing your insights.";
        } 
    }
    if($_GET['type'] == 2){ // declined post
        $sql = "SELECT n.*, t.title FROM notifications n JOIN topics t ON  n.topic_id=t.id WHERE n.id=$id LIMIT 1;";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "We regret to inform you that your recent post titled '<i>" . $row['title'] . "</i>'  on our discussion forum has been rejected by our moderators.";
        } 
    }
    if($_GET['type'] == 3){ // approve comment
        $sql = "SELECT t.title, c.comment FROM notifications n JOIN comments c ON n.comment_id=c.id JOIN topics t ON c.topic_id=t.id WHERE n.id=$id LIMIT 1;";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "Your comment '<i>" . $row['comment'] . "</i>'  on Forum '" . $row['title'] . "' has been accepted.";
        } 
    }
    if($_GET['type'] == 4){ // declined comment
        $sql = "SELECT t.title, c.comment FROM notifications n JOIN comments c ON n.comment_id=c.id JOIN topics t ON c.topic_id=t.id WHERE n.id=$id LIMIT 1;";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "Your comment '<i>" . $row['comment'] . "</i>'  on Forum '" . $row['title'] . "' is rejected.";
        } 
    }
    if($_GET['type'] == 5){ // commented on post
        $sql = "SELECT t.title, c.comment, u.name FROM notifications n JOIN comments c ON n.comment_id=c.id JOIN topics t ON n.topic_id=t.id JOIN users u ON u.id=c.user_id WHERE n.id=$id LIMIT 1;";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h4><b>In reply to: " . $row['title'] . "</b></h4>"; 
            echo "".$row['name']. ": <br>";
            echo "<i>".$row['comment']. "</i>";
        } 
    }

}
?>
