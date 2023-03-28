<?php

include '../src/controller/SaleController.php';

$saleController = new SaleController();

$jsonRequestData = file_get_contents('php://input');
$parsedRequestData = json_decode($jsonRequestData);

$reponseData = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $reponseData = $saleController->index();

        header('HTTP/1.1 200 OK');
        break;
    case 'POST':
        $reponseData = $saleController->store($parsedRequestData);

        header('HTTP/1.1 201 CREATED');
        break;
    default:
        $reponseData = [
            'message' => 'Ïnvalid request',
        ];
}

header('Content-Type: application/json');
echo json_encode($reponseData);
