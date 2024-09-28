<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE,OPTIONS");
header("Access-Control-Allow-HEADERS: X-Requested-With, Origin, Content-Type*");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 86400");
date_default_timezone_set("Asia/Manila");
set_time_limit(1000);

$rootPath = $_SERVER["DOCUMENT_ROOT"];
$apiPath = $rootPath . "/";
require_once($apiPath . 'configs/connection.php');

require_once($apiPath . 'model/try.models.php');
require_once($apiPath . 'model/Global.models.php');


$db = new Connection();
$pdo = $db->connect();


$global = new GlobalMethods();
$try = new Try_models($pdo, $global);

$req = [];
if (isset($_REQUEST['request']))
    $req = explode('/', rtrim($_REQUEST['request'], '/'));
else $req = array("errorcatcher");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if($req[0]== 'getAllData') {echo json_encode($try->getAll()); return;}
        break;
    
    case 'POST':
        $data_input = json_decode(file_get_contents("php://input"));
        if($req[0] == 'insertData'){echo json_encode($try->insertData($data_input)); return;}
        break;

    case 'DELETE':
        $data_input = json_decode(file_get_contents("php://input"));
        if($req[0]== 'deleteData'){echo json_encode($try->deleteData($data_input)); return;} 
        break;

    default:
        echo "Invalid URL Request";
        http_response_code(404);
        break;
}