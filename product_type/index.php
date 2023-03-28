<?php
include '../src/controller/ProductTypeController.php';

// include 'ManipuladorBanco.php';
// $banco = new ManipuladorBanco();
// $nomeTabela = '';
// $json = file_get_contents('php://input');
// $data = json_decode($json);

// $nomeTabela = 'product_type';

// var_dump($data);
// $dados = array();

// $dadosUsuario = [
//     'description' => $data->description,
//     'tax_percentage' => $data->tax_percentage,
// ];
// $insert = $banco->inserir($nomeTabela, $dadosUsuario);
// if ($insert) {
//     $dados['dados'] = $insert;
//     $dados['status'] = 'OK';
//     $dados['msg'] = 'DADOS CADASTRADOS COM SUCESSO';
// } else {
//     $dados['status'] = 'ERR';
//     $dados['msg'] = 'Algum problema ocorreu, por favor tente novamente.';
// }

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
