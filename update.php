<?php
 header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods:POST,GET,PUT,DELETE');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: content-type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

// Importing DBConfig.php file.
include 'db.php';
 // Getting the received JSON into $json variable.
 $json = file_get_contents('php://input');
 // decoding the received JSON and store into $obj variable.
 $obj = json_decode($json,true);
//`id`, `firstname`, `lastname`, `age`
$id = $obj['id'];
$firstname = $obj['firstname'];
$lastname = $obj['lastname'];
$age = $obj['age'];

if (empty($firstname) || empty($lastname) || empty($age) || empty($id)) {
    echo json_encode(array("message" => "Some fields are missing","status"=> "missingdata"));
   }else{
        // Creating SQL query and insert the record into MySQL database table.
        $Sql_Query = "UPDATE crud SET firstname = '$firstname', lastname = '$lastname', age = '$age' WHERE id = '$id'";
        if(mysqli_query($con,$Sql_Query)){
         // If the record inserted successfully then show the message.
            $response = array(
                'status' => 'success', 'message' => 'Record Successfully updated Into MySQL Database.');
             http_response_code(200);
            echo json_encode($response);
         }
         else{
         $response = array(
                'status' => 'invalid', 'message' => 'Something is missing');
          http_response_code(201);
            echo json_encode($response);
         }

   }
 mysqli_close($con);
?>