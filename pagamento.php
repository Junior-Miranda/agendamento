<?php
include 'login/painel/conn.php';
// Configura o cabeçalho para receber dados JSON
header("Content-Type: application/json");

// Lê os dados JSON enviados no corpo da requisição
$dadosJson = file_get_contents("php://input");

// Decodifica o JSON para um array associativo
$dados = json_decode($dadosJson, true);

// Verifica se os dados foram recebidos corretamente
if ($dados === null) {
    http_response_code(400);
    echo json_encode(["erro" => "JSON inválido ou nenhum dado recebido."]);
    exit;
}





function dataDeVencimento() {
    // Obter a data atual
    $dataAtual = new DateTime();
    
    // Adicionar 30 dias
    $dataAtual->modify('+30 days');
    
    // Retornar a data formatada (formato: YYYY-MM-DD)
    return $dataAtual->format('Y-m-d');
}

// Exemplo de uso
$data_vencimento = dataDeVencimento();
$vencimento = $data_vencimento ;


if (isset($dados['webhook_event_type']) && $dados['webhook_event_type'] === 'order_approved') {
// Exemplo de como acessar os dados
$idPedido = $dados['order_id'] ?? null;
$statusPedido = $dados['order_status'] ?? null;
$nomeProduto = $dados['Product']['product_name'] ?? null;
$nomeCliente = $dados['Customer']['full_name'] ?? null;
$emailCliente = $dados['Customer']['email'] ?? null;
$telefoneCliente = $dados['Customer']['mobile'] ?? null;
$cpfCliente = $dados['Customer']['CPF'] ?? null;
$statusAssinatura = $dados['Subscription']['status'] ?? null;
$subscriptionId = $dados['subscription_id'] ?? null;
$dataAprovacao = $dados['approved_date'] ?? null;
$valorCobrado = $dados['Commissions']['charge_amount'] ?? null;


// Função para salvar os dados em um arquivo TXT
function salvarDadosEmTxt($dados) {
    $arquivo = 'dados_pagamento.txt';
    $conteudo = "ID do Pedido: " . $dados['order_id'] . "\n" .
                "Status do Pedido: " . $dados['order_status'] . "\n" .
                "Nome do Produto: " . $dados['Product']['product_name'] . "\n" .
                "Nome do Cliente: " . $dados['Customer']['full_name'] . "\n" .
                "Email do Cliente: " . $dados['Customer']['email'] . "\n" .
                "Telefone do Cliente: " . $dados['Customer']['mobile'] . "\n" .
                "CPF do Cliente: " . $dados['Customer']['CPF'] . "\n" .
                "Status da Assinatura: " . $dados['Subscription']['status'] . "\n" .
                "ID da Assinatura: " . $dados['subscription_id'] . "\n" .
                "Data de Aprovação: " . $dados['approved_date'] . "\n" .
                "Valor Cobrado: " . $dados['Commissions']['charge_amount'] . "\n\n";

    file_put_contents($arquivo, $conteudo, FILE_APPEND);
}

// Salvar os dados em um arquivo TXT
#salvarDadosEmTxt($dados);

// Conexão com o banco de dados
$sql = "SELECT * FROM login WHERE email = '$emailCliente'";
$query = mysqli_query($conn, $sql);
$total_ = mysqli_num_rows($query);



$sql_busca_usuario = "SELECT * FROM login WHERE email = '$emailCliente'";
$query_busca_usuario = mysqli_query($conn, $sql_busca_usuario);
$total_busca_usuario = mysqli_num_rows($query_busca_usuario);

while($rows_usuarios = mysqli_fetch_array($query_busca_usuario)) {
    $nome  = $rows_usuarios['nome'];
    $usuario_api  = $rows_usuarios['usuario_api'];
    $situacao  = $rows_usuarios['situacao'];
    $email = $rows_usuarios['email'];
    $login = $rows_usuarios['login'];
    
    
}

$vencimento = $data_vencimento ;
// Inserir o pagamento na tabela de pagamentos de forma estruturada
#$sql = "INSERT INTO pagamentos (email, data_pagamento, id_pedido, nome_produto, nome_completo, telefone, cpf, status, id_assinatura,vencimento) 
        #VALUES ('$emailCliente', '$dataAprovacao', '$idPedido', '$nomeProduto', '$nomeCliente', '$telefoneCliente', '$cpfCliente', 'aprovado', '$subscriptionId','$vencimento')";
#$query = mysqli_query($conn, $sql);

$sql = "UPDATE login SET vencimento = '$vencimento',id_assinatura = '$subscriptionId',situacao='ativado',tipo='2'  WHERE email = '$emailCliente'";
$query = mysqli_query($conn,$sql);

$comando_final = 'criar_conta';
    
$sql_inserir_gerenciador = "INSERT INTO gerenciador (usuario_api, comando) VALUES ('$usuario_api', '$comando_final')";
$resultado_inserir_gerenciador = mysqli_query($conn, $sql_inserir_gerenciador);


if ($conn->query($sql) === TRUE) {
    http_response_code(201);
    echo json_encode(["mensagem" => "Pagamento inserido com sucesso."]);
  ;
} else {
    http_response_code(500);
    echo json_encode(["erro" => "Erro ao inserir pagamento: " . $conn->error]);
}
}



#####################################################################################
#####################################################################################
#####################################################################################
#### ASSINATURA RENOVADA


// Verificar se a assinatura foi renovada
if (isset($dados['webhook_event_type']) && $dados['webhook_event_type'] === 'subscription_renewed') {
    $emailCliente = $dados['Customer']['email'];
    $data_renovacao = $dados['updated_at'];
    $id_assinatura = $dados['subscription_id'];
    
    
 $sql_busca_usuario = "SELECT * FROM login WHERE email = '$emailCliente'";
$query_busca_usuario = mysqli_query($conn, $sql_busca_usuario);
$total_busca_usuario = mysqli_num_rows($query_busca_usuario);

while($rows_usuarios = mysqli_fetch_array($query_busca_usuario)) {
    $nome  = $rows_usuarios['nome'];
    $usuario_api  = $rows_usuarios['usuario_api'];
    $situacao  = $rows_usuarios['situacao'];
    $email = $rows_usuarios['email'];
    $login = $rows_usuarios['login'];
    $tempo_code = $rows_usuarios['tempo_code'];
    
    
}    
    
    
    
    
    
    
    
    
    
$sql = "UPDATE login SET vencimento = '$vencimento',id_assinatura = '$subscriptionId',situacao='ativado',tipo='2'  WHERE email = '$emailCliente'";
$query = mysqli_query($conn,$sql);
    // Atualizar o status da assinatura para renovada de forma estruturada
   # $sql = "UPDATE login SET vencimento = '$vencimento',id_assinatura = '$id_assinatura',tipo='2'  WHERE email = '$emailCliente'";
    #$query = mysqli_query($conn,$sql);
    
 
 $comando_final = 'reset_conta';
    
$sql_inserir_gerenciador = "INSERT INTO gerenciador (usuario_api, comando) VALUES ('$usuario_api', '$comando_final')";
$resultado_inserir_gerenciador = mysqli_query($conn, $sql_inserir_gerenciador);
 
 
 $sql_busca_usuario = "SELECT * FROM login WHERE email = '$emailCliente'";
$query_busca_usuario = mysqli_query($conn, $sql_busca_usuario);
$total_busca_usuario = mysqli_num_rows($query_busca_usuario);

while($rows_usuarios = mysqli_fetch_array($query_busca_usuario)) {
    $nome  = $rows_usuarios['nome'];
    $usuario_api  = $rows_usuarios['usuario_api'];
    $situacao  = $rows_usuarios['situacao'];
    $email = $rows_usuarios['email'];
    $login = $rows_usuarios['login'];
    $tempo_code = $rows_usuarios['tempo_code'];
    
    
}
 
 if($tempo_code > 0){
     
 }else{
     
 
$comando_final = 'criar_conta';
    
$sql_inserir_gerenciador = "INSERT INTO gerenciador (usuario_api, comando) VALUES ('$usuario_api', '$comando_final')";
$resultado_inserir_gerenciador = mysqli_query($conn, $sql_inserir_gerenciador);
}
 
    

    if ($query) {
        echo "Assinatura renovada com sucesso para o cliente: $email";
    } else {
        echo "Erro ao atualizar a assinatura: " . mysqli_error($conexao);
    }
}




// Verificar se a assinatura está atrasada
if (isset($dados['webhook_event_type']) && $dados['webhook_event_type'] === 'subscription_late') {
        $emailCliente = $dados['Customer']['email'];

    $data_atraso = $dados['updated_at'];
    $id_assinatura = $dados['subscription_id'];

    // Atualizar o status da assinatura para atrasada de forma estruturada
    $sql = "UPDATE login SET tipo='3' ,id_assinatura='bloqueado' WHERE email = '$emailCliente'";
    $query = mysqli_query($conn,$sql);
    
$sql_busca_usuario = "SELECT * FROM login WHERE email = '$emailCliente'";
$query_busca_usuario = mysqli_query($conn, $sql_busca_usuario);
$total_busca_usuario = mysqli_num_rows($query_busca_usuario);

while($rows_usuarios = mysqli_fetch_array($query_busca_usuario)) {
    $nome  = $rows_usuarios['nome'];
    $usuario_api  = $rows_usuarios['usuario_api'];
    $situacao  = $rows_usuarios['situacao'];
    $email = $rows_usuarios['email'];
    $login = $rows_usuarios['login'];
    
    
}
    

$comando_final = 'stop_conta';
    
$sql_inserir_gerenciador = "INSERT INTO gerenciador (usuario_api, comando) VALUES ('$usuario_api', '$comando_final')";
$resultado_inserir_gerenciador = mysqli_query($conn, $sql_inserir_gerenciador);

    if ($query) {
        echo "Assinatura marcada como atrasada para o cliente: $email";
    } else {
        echo "Erro ao atualizar a assinatura: " . mysqli_error($conexao);
    }
}


// Verificar se a assinatura foi cancelada
if (isset($dados['webhook_event_type']) && $dados['webhook_event_type'] === 'subscription_canceled') {
    $emailCliente = $dados['Customer']['email'];
    $data_cancelamento = $dados['updated_at'];
    $id_assinatura = $dados['subscription_id'];

    // Atualizar o status da assinatura para cancelada de forma estruturada
    #$sql = "UPDATE assinaturas SET status = 'cancelada', data_cancelamento = '$data_cancelamento' WHERE email = '$email' AND id_assinatura = '$id_assinatura'";
    #$query = mysqli_query($conexao, $sql);
    
$sql_busca_usuario = "SELECT * FROM login WHERE email = '$emailCliente'";
$query_busca_usuario = mysqli_query($conn, $sql_busca_usuario);
$total_busca_usuario = mysqli_num_rows($query_busca_usuario);

while($rows_usuarios = mysqli_fetch_array($query_busca_usuario)) {
    $nome  = $rows_usuarios['nome'];
    $usuario_api  = $rows_usuarios['usuario_api'];
    $situacao  = $rows_usuarios['situacao'];
    $email = $rows_usuarios['email'];
    $login = $rows_usuarios['login'];
    
    
}    
       

$comando_final = 'deletar_conta';
    
$sql_inserir_gerenciador = "INSERT INTO gerenciador (usuario_api, comando) VALUES ('$usuario_api', '$comando_final')";
$resultado_inserir_gerenciador = mysqli_query($conn, $sql_inserir_gerenciador);



      $sql_deletar = "DELETE FROM login WHERE usuario_api = '$usuario_api'";
        $resultado_deletar = mysqli_query($conn, $sql_deletar);

    if ($query) {
        echo "Assinatura cancelada com sucesso para o cliente: $email";
    } else {
        echo "Erro ao atualizar a assinatura: " . mysqli_error($conexao);
    }
}

#$conn->close();
?>