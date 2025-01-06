<?php
// buscar_agendamentos_disponiveis.php

// Função para conectar ao banco de dados
function conectarDB() {
    include 'login/painel/conn.php';
    return $conn;
}

// Função para buscar datas excluídas do banco de dados
function buscarDatasExcluidas($id_profissional) {
    $conn = conectarDB();
    
    $sql_datas_excluidas = "SELECT data_excluida FROM datas_excluidas WHERE id_profissional = ? OR id_profissional IS NULL";
    $stmt = mysqli_prepare($conn, $sql_datas_excluidas);
    mysqli_stmt_bind_param($stmt, "i", $id_profissional);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $datas_excluidas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $datas_excluidas[] = $row['data_excluida'];
    }
    
    return $datas_excluidas;
}

// Função para buscar os horários disponíveis para um profissional em um dia da semana específico nos próximos X dias
function buscarAgendamentosDisponiveis($id_profissional, $dia_semana, $dias_futuros = 30) {
    $conn = conectarDB();

    // Obter os horários que o profissional trabalha nesse dia da semana
    $sql_agenda = "SELECT horario FROM agenda_padrao WHERE id_profissional = ? AND dia = ?";
    $stmt = mysqli_prepare($conn, $sql_agenda);
    mysqli_stmt_bind_param($stmt, "is", $id_profissional, $dia_semana);
    mysqli_stmt_execute($stmt);
    $result_agenda = mysqli_stmt_get_result($stmt);

    $horarios_trabalho = [];
    while ($row = mysqli_fetch_assoc($result_agenda)) {
        $horarios_trabalho[] = $row['horario'];
    }

    if (empty($horarios_trabalho)) {
        return [];
    }

    // Mapear nomes de dia da semana para números
    $dias_semana_portugues = array(
        'domingo' => 0,
        'segunda' => 1,
        'terca' => 2,
        'quarta' => 3,
        'quinta' => 4,
        'sexta' => 5,
        'sabado' => 6
    );

    $dia_numero = $dias_semana_portugues[strtolower($dia_semana)];

    // Buscar datas excluídas do banco de dados
    $datas_excluidas = buscarDatasExcluidas($id_profissional);

    // Gerar as próximas datas correspondentes ao dia da semana selecionado
    $datas_disponiveis = [];
    for ($i = 0; $i <= $dias_futuros; $i++) {
        $timestamp = strtotime("+$i days");
        $data_verificada = date('Y-m-d', $timestamp);
        
        // Verificar se o dia corresponde ao dia da semana desejado e não está na lista de datas excluídas
        if (date('w', $timestamp) == $dia_numero && !in_array($data_verificada, $datas_excluidas)) {
            $datas_disponiveis[] = $data_verificada;
        }
    }

    // Obter os horários já ocupados nessas datas
    $placeholders = implode(',', array_fill(0, count($datas_disponiveis), '?'));
    $types = str_repeat('s', count($datas_disponiveis));
    $params = array_merge([$id_profissional], $datas_disponiveis);

    $sql_ocupados = "SELECT data, horario FROM agendamento WHERE id_profissional = ? AND data IN ($placeholders)";
    $stmt_ocupados = mysqli_prepare($conn, $sql_ocupados);

    // Vincular parâmetros dinamicamente
    mysqli_stmt_bind_param($stmt_ocupados, 'i' . $types, ...$params);
    mysqli_stmt_execute($stmt_ocupados);
    $result_ocupados = mysqli_stmt_get_result($stmt_ocupados);

    $horarios_ocupados = [];
    while ($row = mysqli_fetch_assoc($result_ocupados)) {
        $horarios_ocupados[$row['data']][] = $row['horario'];
    }

    // Montar a lista de datas e horários disponíveis
    $agendamentos_disponiveis = [];
    foreach ($datas_disponiveis as $data) {
        foreach ($horarios_trabalho as $horario) {
            // Verificar se o horário está ocupado nessa data
            if (isset($horarios_ocupados[$data]) && in_array($horario, $horarios_ocupados[$data])) {
                continue;
            }
            $agendamentos_disponiveis[] = [
                'data' => $data,
                'horario' => $horario
            ];
        }
    }

    return $agendamentos_disponiveis;
}

// Recebe o id do profissional e o dia da semana via POST
if (isset($_POST['profissional_id']) && isset($_POST['dia_semana'])) {
    $id_profissional = intval($_POST['profissional_id']);
    $dia_semana = $_POST['dia_semana'];

    $agendamentos_disponiveis = buscarAgendamentosDisponiveis($id_profissional, $dia_semana, 30); // Buscar nos próximos 30 dias

    if (!empty($agendamentos_disponiveis)) {
        echo '<option value="">Escolha uma data e horário disponível</option>';
        foreach ($agendamentos_disponiveis as $agendamento) {
            $data_formatada = date('d/m/Y', strtotime($agendamento['data']));
            $label = $data_formatada . ' - ' . $agendamento['horario'];
            $value = $agendamento['data'] . '|' . $agendamento['horario'];
            echo '<option value="' . $value . '">' . $label . '</option>';
        }
    } else {
        echo '<option value="">Nenhuma data e horário disponível</option>';
    }
} else {
    echo '<option value="">Escolha uma data e horário disponível</option>';
}
?>
