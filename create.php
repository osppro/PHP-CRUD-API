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
$firstname = $obj['firstname'];
$lastname = $obj['lastname'];
$age = $obj['age'];

if (empty($firstname) || empty($lastname) || empty($age)) {
    echo json_encode(array("message" => "Some fields are missing","status"=> "missingdata"));
   }else{
        //Applying User Login query with email and password match.
        $Sql_Query = "SELECT * FROM crud WHERE firstname = '$firstname' ";
        // Executing SQL Query.
        // $check = mysqli_fetch_array(mysqli_query($con,$Sql_Query));
        $check = mysqli_fetch_assoc(mysqli_query($con,$Sql_Query));
        if ($check) {
            http_response_code(201);
            echo json_encode(array("message" => "User Already exist","status"=> "exist"));
        }else{
            //data -> firstname,lastname,phone, password
            $insert = mysqli_query($con,"INSERT INTO crud VALUES (NULL,'$firstname','$lastname','$age') ");
            if($insert){
                http_response_code(200);
                echo json_encode(array("message" => "User Registered successfully","status"=> "success"));
         }
         else{
            http_response_code(400);
            echo json_encode(array("message" => "Invalid User","status"=> "false"));
         }
        }
   }

 mysqli_close($con);
?>