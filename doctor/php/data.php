<?php
    while($row = mysqli_fetch_assoc($query)){
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['patient_id']}
                OR outgoing_msg_id = {$row['patient_id']}) AND (outgoing_msg_id = {$outgoing_id} 
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
        ($row['chat_status'] == "Offline now") ? $offline = "offline" : $offline = "";
        ($outgoing_id == $row['id']) ? $hid_me = "hide" : $hid_me = "";

        $output .= '<a href="chat.php?patient_id='. $row['patient_id'] .'">
                    <div class="content">
                    <img src="../images/'. $row['patient_photo'] .'" alt="">
                    <div class="details">
                        <span>'. $row['patient_first_name']. ' '. $row['patient_last_name']. '</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';
    }
?>