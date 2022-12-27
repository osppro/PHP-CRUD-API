<?php
ob_start();
session_start(); 
error_reporting(0);
date_default_timezone_set('Africa/Kampala');
$dtime = date("Y-m-d h:i:s A", time());
$today = date("Y-m-d");
// require_once 'mailer.php';
// require_once('AfricasTalkingGateway.php');
$username   = "";
$apikey     = "";

defined ("DB_URL") or define("DB_URL", $_SERVER['HTTP_HOST']);
defined ("DS") or define("DS", DIRECTORY_SEPARATOR);
defined ("BASE_URL") or define("BASE_URL", $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME']);
switch(DB_URL){
	case 'localhost':
		defined ("DB_SERVER") or define("DB_SERVER", 'localhost');
		defined ("DB_USER") or define("DB_USER", "root");
		defined ("DB_PASS") or define("DB_PASS", "");
		defined ("DB_NAME") or define("DB_NAME", "test");
	break;
	case 'onlinegraphicsltd.com':
		defined ("DB_SERVER") or define("DB_SERVER", "localhost");
		defined ("DB_USER") or define("DB_USER", "onlinegraphicslt_career");
		defined ("DB_PASS") or define("DB_PASS", "w_U{tdUD]w9A");
		defined ("DB_NAME") or define("DB_NAME", "onlinegraphicslt_cia");
	break;
	default:
		defined ("DB_SERVER") or define("DB_SERVER", 'localhost');
		defined ("DB_USER") or define("DB_USER", "root");
		defined ("DB_PASS") or define("DB_PASS", "");
		defined ("DB_NAME") or define("DB_NAME", "test");
}
 try { 
	$con = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$dbh = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_PERSISTENT => true)); 
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	}
catch(PDOException $e) 
{
	echo $e->getMessage(); 
	
}

function log_message($msg=NULL){
	if(!empty($msg)){
		$_SESSION['message'] = $msg;
	} else {
		$val = $_SESSION['message'];
		$_SESSION['message'] = '';
		return $val;
	}
}

function redirect_page($url)
{
	header("Location: {$url}");
	exit();
}

function Batch($numAlpha=8,$numNonAlpha=2)
{
   $listAlpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
   
   return str_shuffle(
      substr(str_shuffle($listAlpha),0,$numAlpha)
    );
}

function getCode(){
	//$st = Batch($num=5,$alt=2);
	$st = rand(1000000,99999999);
	return $st;
}

function getWeek(){
	$result = date('Y-m-d',strtotime("-7 days"));
	return $result;
}


function dbDelete ($tbl='',$field='',$id='')
{
	global $dbh;
	if($tbl!='' && $field!='' && $id!=''){
		$sql = 'DELETE FROM '.$tbl.' WHERE '.$field.' = '.$id. '';
		return $dbh->exec($sql);
	} else {
		return NULL;
	}
}

function dbCreate($sql='')
{
	//print_r($sql);exit;
	global $dbh;
	if($sql ==''){
		return -9;
	}else {
		$q = $dbh->prepare($sql);
		return  $q->execute();
	}
}

function dbSQL($q='')
{
	global $dbh;
	if(empty($q)) return FALSE;
	$r = $dbh->prepare($q);
	$r->execute();
	$results = array();
	while($row = $r->fetch(PDO::FETCH_OBJ)){
		$results[] = $row;
	}
	return $results;
}

function dbRow($query='')
{
	global $dbh;
	$r = $dbh->prepare($query);
	$r->execute();
	return $r->fetch(PDO::FETCH_OBJ);
}

function dbOne($query='', $field='')
{
	global $dbh;
	$r = dbRow($query);
	return $r? $r->$field:NULL;
}


