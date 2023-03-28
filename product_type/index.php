<?php
include 'ManipuladorBanco.php';
$banco = new ManipuladorBanco();
$nomeTabela = '';
$json = file_get_contents('php://input');
$data = json_decode($json);

$nomeTabela = 'product_type';

var_dump($data);
$dados = array();

$dadosUsuario = [
    'description' => $data->description,
    'tax_percentage' => $data->tax_percentage,
];
$insert = $banco->inserir($nomeTabela, $dadosUsuario);
if ($insert) {
    $dados['dados'] = $insert;
    $dados['status'] = 'OK';
    $dados['msg'] = 'DADOS CADASTRADOS COM SUCESSO';
} else {
    $dados['status'] = 'ERR';
    $dados['msg'] = 'Algum problema ocorreu, por favor tente novamente.';
}

echo json_encode($dados);
