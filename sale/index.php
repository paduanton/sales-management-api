<?php
include_once '../request/header.php';

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

echo json_encode($reponseData);
