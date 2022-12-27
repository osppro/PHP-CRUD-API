<?php
 header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods:POST,GET,PUT,DELETE');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: content-type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

// Importing DBConfig.php file.
include 'db.php';
//fetching all students...
$result = $con->query("SELECT * FROM crud ORDER BY id DESC ");
if ($result->num_rows > 0) {
   $user_err = array();
   while ($row = $result->fetch_assoc()){
      extract($row);
        $student = array(
         "id" => $id,
         "firstname" => $firstname,
         "lastname" => $lastname,
         "age" => $age
        );
        array_push($user_err, $student);
    }
    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    echo json_encode($user_err);
}else{
   // set response code - 404 Not found
   http_response_code(404);
   // tell the user no products found
   echo json_encode(
      array("message" => "No user found.")
   );
}

   
 mysqli_close($con);
?>