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
$json = file_get_contents('php://input');
// decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);
$id = $obj['id'];
$result = $con->query("DELETE FROM crud WHERE id = '$id' ");
if ($result) {
   http_response_code(200);
   // tell the user no products found
   echo json_encode(
   array("status" => "deleted", "message" => "User deleted successfully."));
}
else{
   // set response code - 404 Not found
   http_response_code(404);
   // tell the user no products found
   echo json_encode(
      array("message" => "No data.")
   );
}
mysqli_close($con);
?>