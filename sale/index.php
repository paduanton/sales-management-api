<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

include_once '../src/controller/SaleController.php';

$saleController = new SaleController();

$jsonRequestData = file_get_contents('php://input');
$parsedRequestData = json_decode($jsonRequestData);

$reponseData = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if(isset($_GET['type']) && isset($_GET['type']) == "preview") {
            $reponseData = $saleController->preview($_GET['productIds']);
        } else {
            $reponseData = $saleController->index();
        }

        header('HTTP/1.1 200 OK');
        break;
    case 'POST':
        $reponseData = $saleController->store($parsedRequestData);

        header('HTTP/1.1 201 CREATED');
        break;
    default:
        $reponseData = [
            'message' => 'Invalid request',
        ];
}

header('Content-Type: application/json');
echo json_encode($reponseData);
