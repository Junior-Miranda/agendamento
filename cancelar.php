<?php
$idd = $_GET['id'];

if ($idd) {
    include 'login/painel/conn.php';
    include 'login/painel/estilo.php';
    include 'login/painel/css_de_icones.php';
    include 'login/painel/config_dados.php';
    include 'login/painel/funcoes.php';
    include 'login/painel/menu.php';

    // Busca os dados do cliente com base no id_agendamento
    $sql_busca_clientes = "SELECT * FROM clientes WHERE id_agendamento = '$idd'";
    $query_busca_clientes = mysqli_query($conn, $sql_busca_clientes);
    $total_busca_clientes = mysqli_num_rows($query_busca_clientes);

    if ($total_busca_clientes > 0) {
        while ($rows_clientes = mysqli_fetch_array($query_busca_clientes)) {
            $nome = $rows_clientes['nome'];
            $telefone = $rows_clientes['telefone'];
            $usuario_api = $rows_clientes['usuario_api'];
        }
    } else {
        die("Cliente não encontrado.");
    }

    // Usa o telefone e o usuário_api para buscar os agendamentos na tabela agendamento
    $sql_busca_agendamentos = "SELECT * FROM agendamento WHERE cliente_telefone = '$telefone' AND usuario_api = '$usuario_api'";
    $query_busca_agendamentos = mysqli_query($conn, $sql_busca_agendamentos);
    $total_busca_agendamentos = mysqli_num_rows($query_busca_agendamentos);

    $icon = 'login/painel/' . $icon;
    $logo = 'login/painel/' . $logo;
    ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cancelar Agendamento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= $icon; ?>" type="image/png" sizes="16x16">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all">
    <style>
        /* Estiliza a exibição vertical no celular */
        .agendamento-detalhe {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            text-align: center;
        }

        @media (min-width: 768px) {
            .agendamento-detalhe {
                display: none;
            }

            .agendamento-tabela {
                display: table;
            }
        }

        @media (max-width: 767px) {
            .agendamento-detalhe {
                display: block;
            }

            .agendamento-tabela {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper animsition">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light navbar-default navbar-fixed-top" role="navigation">
                <div class="container">
                    <img class="img-fluid" src="<?= $logo; ?>" alt="Theme-Logo" style="width: 150px; height: 30px;">
                </div>
            </nav>
        </div>

        <div class="container mt-5">
            <h2 class="text-center">Detalhes do Cliente e Agendamentos</h2>

            <!-- Exibe os dados do cliente -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Cliente: <?= $nome; ?></h5>
                    <p class="card-text">Telefone: <?= $telefone; ?></p>
                </div>
            </div>

            <h3 class="text-center mt-4">Agendamentos do Cliente</h3>

            <!-- Exibe os agendamentos associados -->
            <?php if ($total_busca_agendamentos > 0) { ?>
                <!-- Exibição Horizontal (Desktop) -->
                <div class="table-responsive agendamento-tabela">
                    <table class="table table-striped table-bordered mt-3">
                        <thead>
                           <tr>
        <th style="font-weight: bold; text-align: center;">Dia</th>
        <th style="font-weight: bold; text-align: center;">Horário</th>
        <th style="font-weight: bold; text-align: center;">Profissional</th>
        <th style="font-weight: bold; text-align: center;">Data</th>
        <th style="font-weight: bold; text-align: center;">Ação</th>
    </tr>
                        </thead>
                        <tbody>
                            <?php while ($row_agendamento = mysqli_fetch_array($query_busca_agendamentos)) { ?>
                                <tr class="text-center">
                                    <td><?= $row_agendamento['dia']; ?></td>
                                    <td><?= $row_agendamento['horario']; ?></td>
                                    <td><?= $row_agendamento['profissional_nome']; ?> (<?= $row_agendamento['profissional_cargo']; ?>)</td>
                                    <td><?= date('d/m/Y', strtotime($row_agendamento['data'])); ?></td>
                                    <td>
                                        <form action="processar_cancelamento.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $row_agendamento['id']; ?>">
                                            <input type="hidden" name="idd" value="<?= $_GET['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Exibição Vertical (Celular) -->
                <?php mysqli_data_seek($query_busca_agendamentos, 0); // Resetar o ponteiro do resultado ?>
               <div class="agendamento-detalhe">
    <?php
    $index = 0; // Índice para alternar cores
    while ($row_agendamento = mysqli_fetch_array($query_busca_agendamentos)) {
        $linhaCor = ($index % 2 == 0) ? '#f9f9f9' : '#ffffff'; // Alterna entre branco e cinza claro
        $index++;
    ?>
        <div style="background-color: <?= $linhaCor; ?>; padding: 15px; border-radius: 5px; border: 1px solid #ccc; margin-bottom: 10px;">
            <div style="display: flex; flex-direction: column;">
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e0e0e0;">
        <th style="font-weight: bold; text-align: center;">Dia</th>
                    <span><?= $row_agendamento['dia']; ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e0e0e0;">
                    <span><strong>Horário:</strong></span>
                    <span><?= $row_agendamento['horario']; ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e0e0e0;">
                    <span><strong>Profissional:</strong></span>
                    <span><?= $row_agendamento['profissional_nome']; ?> (<?= $row_agendamento['profissional_cargo']; ?>)</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e0e0e0;">
                    <span><strong>Data:</strong></span>
                    <span><?= date('d/m/Y', strtotime($row_agendamento['data'])); ?></span>
                </div>
                <div style="text-align: right; margin-top: 10px;">
                    <form action="processar_cancelamento.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $row_agendamento['id']; ?>">
                        <input type="hidden" name="idd" value="<?= $_GET['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

            <?php } else { ?>
                <p class="text-center text-muted mt-4">Nenhum agendamento encontrado para este cliente.</p>
            <?php } ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>

















<?php
} else {
    echo "ID do agendamento não foi informado.";
}
?>
