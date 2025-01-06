<?php
$idd = $_GET['id'];
if($idd){

include 'login/painel/conn.php';
include 'login/painel/estilo.php';
include 'login/painel/css_de_icones.php';
include 'login/painel/config_dados.php';
include 'login/painel/funcoes.php';
include 'login/painel/menu.php';

$sql_busca_clientes = "SELECT * FROM clientes WHERE id_agendamento = '$idd'";
$query_busca_clientes = mysqli_query($conn, $sql_busca_clientes);
$total_busca_clientes = mysqli_num_rows($query_busca_clientes);

while($rows_clientes = mysqli_fetch_array($query_busca_clientes)) {
    
    $nome = $rows_clientes['nome'];
    $telefone = $rows_clientes['telefone'];
    $usuario_api = $rows_clientes['usuario_api'];

}
 $icon = 'login/painel/'.$icon; 
$logo = 'login/painel/'.$logo; 
  
  ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?=$titulo;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?=$icon;?>" type="image/png" sizes="16x16">
    <link href="assets\css\bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="assets\css\style.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>
    <div class="wrapper animsition">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light navbar-default navbar-fixed-top" role="navigation">
                <div class="container">
                    
                                                <img class="img-fluid" src="<?=$logo;?>" alt="Theme-Logo" style="width: 150px; height: 30px;">

                   
                   
                </div>
            </nav>
        </div>
      
<?php
// Função para conectar ao banco de dados
function conectarDB() {
include 'login/painel/conn.php';
    return $conn;
}
?>
<br>
<br>

<!-- Formulário para solicitar confirmação de agendamento -->
<div class="container mt-5">
    <h2 class="text-center">Agendamento Online</h2>





<?php

if($nome == Null){

?>
  <style>
 

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 0.9em;
            color: #555;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-save {
            padding: 10px;
            font-size: 1em;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .btn-save:hover {
            background-color: #218838;
        }
           h2 {
            font-size: 1.5em;
            color: #5a5a5a;
            margin-bottom: 1em;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Por favor, diga-nos o seu nome para começar</h2>
        <form action="processar_nome.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
                    <input type="hidden" name="idd" value="<?=$idd;?>">

            </div>
            <button type="submit" class="btn-save">Salvar Nome</button>
        </form>
    </div>

<?php
}else{
    
?>
    <!-- Formulário de Agendamento -->
    <form action="processar_agendamento.php" method="POST">
        <!-- Campo Nome -->
        <div class="form-group">
            <br>
        </div>

       

        <!-- Seleção do Profissional -->
        <div class="form-group">
            <label for="profissional">Selecione o Profissional</label>
            <select class="form-control" id="profissional" name="profissional" required onchange="carregarDiasSemana()">
               <option value=''>Escolha um profissional</option>
                <?php
                // Conexão com o banco de dados
                $conn = conectarDB();

                // Consulta para obter os profissionais
                #$sql = "SELECT * FROM profissional";
                 $sql = "SELECT * FROM profissional WHERE usuario_api = '$usuario_api'";
                $result = mysqli_query($conn, $sql);
                $total = mysqli_num_rows($result);

           
                // Preencher o campo options com os profissionais
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'. $row['id'].'">'.$row['profissional_nome'] .' - '. $row['profissional_cargo'] .'</option>';
                }
             

                // Fechar a conexão
                mysqli_close($conn);
                ?>
            </select>
        </div>

        <!-- Seleção do Dia da Semana -->
        <div class="form-group">
            <label for="dia_semana">Selecione o Dia da Semana</label>
            <select class="form-control" id="dia_semana" name="dia_semana" required onchange="carregarAgendamentosDisponiveis()">
                <option value="">Escolha um dia da semana</option>
            </select>
        </div>

        <!-- Seleção do Horário Disponível -->
        <div class="form-group">
            <label for="agendamento">Selecione uma Data e Horário Disponível</label>
            <select class="form-control" id="agendamento" name="agendamento" required>
                <option value="">Escolha uma data e horário disponível</option>
            </select>
        </div>
    <input type="hidden" name="usuario_api" value="<?=$usuario_api;?>">
    <input type="hidden" name="idd" value="<?=$idd;?>">

        <!-- Botão para Agendar -->
        <button type="submit" class="btn btn-success btn-block">Agendar</button>
    </form>
</div>







 <style>
        .alerta-visitas {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px;
            border: 1px solid #ffeeba;
            border-radius: 4px;
            font-size: 1em;
            text-align: center;
            margin: 15px 0;
        }
        .contador-visitas {
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="alerta-visitas" id="alerta-visitas">
        <span class="contador-visitas" id="contador-visitas">3</span> pessoas estão online agora. Reserve seu horário antes que acabe!
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    // Inicializa o contador de visitantes
    let visitas = 3;

    function atualizarVisitas() {
        // Aumenta o número de visitantes de forma leve, adicionando 1 a 2 visitantes
        visitas += Math.floor(Math.random() * 2) + 1;
        document.getElementById("contador-visitas").textContent = visitas;
    }

    // Atualiza o número de visitas a cada 4 segundos
    setInterval(atualizarVisitas, 9000);
</script>












<!-- Incluir jQuery e Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Scripts AJAX para carregar agendamentos disponíveis dinamicamente -->
<script>
    // Carregar os dias da semana disponíveis ao selecionar um profissional
    function carregarDiasSemana() {
        var profissionalId = $('#profissional').val();
        if (profissionalId !== '') {
            $.ajax({
                url: 'buscar_dias_semana.php',
                type: 'POST',
                data: { profissional_id: profissionalId },
                success: function(response) {
                    $('#dia_semana').html(response);
                    $('#agendamento').html('<option value="">Escolha uma data e horário disponível</option>');
                }
            });
        } else {
            $('#dia_semana').html('<option value="">Escolha um dia da semana</option>');
            $('#agendamento').html('<option value="">Escolha uma data e horário disponível</option>');
        }
    }

    // Carregar as datas e horários disponíveis ao selecionar um dia da semana
    function carregarAgendamentosDisponiveis() {
        var profissionalId = $('#profissional').val();
        var diaSemana = $('#dia_semana').val();
        if (profissionalId !== '' && diaSemana !== '') {
            $.ajax({
                url: 'buscar_agendamentos_disponiveis.php',
                type: 'POST',
                data: { profissional_id: profissionalId, dia_semana: diaSemana },
                success: function(response) {
                    $('#agendamento').html(response);
                }
            });
        } else {
            $('#agendamento').html('<option value="">Escolha uma data e horário disponível</option>');
        }
    }
</script>



<?php

}
include 'login/painel/erro.php';



?>

</body>
<?php



}
?>
</html>
