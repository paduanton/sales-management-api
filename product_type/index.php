<?php

include '../src/controller/ProductTypeController.php';

$productTypeController = new ProductTypeController();

$jsonRequestData = file_get_contents('php://input');
$parsedRequestData = json_decode($jsonRequestData);

$reponseData = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $reponseData = $productTypeController->index();

        header('HTTP/1.1 200 OK');
        break;
    case 'POST':
        $reponseData = $productTypeController->store($parsedRequestData);

        header('HTTP/1.1 201 CREATED');
        break;
    default:
        $reponseData = [
            'message' => 'Ïnvalid request',
        ];
}

header('Content-Type: application/json');
echo json_encode($reponseData);
