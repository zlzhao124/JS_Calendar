<?php
require 'database.php';

header("Content-Type: application/json");

session_start();
$username = $_SESSION['username'];

$title = $_POST['title'];
$time = $_POST['time'];
$notes = $_POST['notes'];
$eventid = $_POST['original_id'];

$eventdate = substr($eventid, 5, 15);
//echo($eventdate);
$eventitle = substr($eventid, 16);
//echo($eventitle);

$stmt = $mysqli->prepare("update events set title = ?, time = ?, description = ? WHERE title = ? AND date = ? AND user = ?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
  // Check the username that was entered to make sure that it is not a duplicate, and that both the username and password are nonempty string

if (strlen($title)>0){
    $stmt->bind_param('ssssss', $title, $time, $notes, $eventitle, $eventdate, $username);

    if (!$stmt->execute()){
    echo json_encode(array(
      "success" => false,
      "message" => "Unable to edit event!"
    ));

}
else{
   echo json_encode(array("success" => true));
}

    $stmt->close();
    exit;
}

else{
 echo json_encode(array(
      "success" => false,
      "message" => "Event edit invalid"
    ));
$stmt->close();
    exit;
}
?>