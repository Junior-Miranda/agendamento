<?php
// Recebe os dados do formulário
$host = $_POST['host'];
$user = $_POST['user'];
$password = $_POST['password'];
$dbname = $_POST['dbname'];

// Define o nome do arquivo zip
$zipFile = __DIR__ . '/site.zip';
$extractPath = __DIR__; // Diretório atual

// Função para extrair o arquivo zip
function extractZip($zipFile, $extractPath) {
    $zip = new ZipArchive;
    if ($zip->open($zipFile) === TRUE) {
        $zip->extractTo($extractPath);
        $zip->close();
        echo 'Arquivos extraídos com sucesso.<br>';
    } else {
        echo 'Falha ao extrair o arquivo zip.<br>';
    }
}

// Função para configurar o banco de dados
function setupDatabase($host, $user, $password, $dbname) {
    // Conectar ao banco de dados
    $conn = new mysqli($host, $user, $password, $dbname);

    // Verificar a conexão
    if ($conn->connect_error) {
        die('Conexão falhou: ' . $conn->connect_error);
    }

    // Caminho para o arquivo SQL
    $sqlFile = __DIR__ . '/login/painel/banco.sql';
    
    // Verificar se o arquivo SQL existe
    if (!file_exists($sqlFile)) {
        die('Arquivo banco.sql não encontrado.<br>');
    }

    // Ler o conteúdo do arquivo SQL
    $sql = file_get_contents($sqlFile);

    // Executar o comando SQL
    if ($conn->multi_query($sql) === TRUE) {
        echo 'Banco de dados configurado com sucesso.<br>';
    } else {
        echo 'Erro ao configurar o banco de dados: ' . $conn->error . '<br>';
    }

    // Fechar a conexão
    $conn->close();
}

// Função para criar o arquivo conn.php
function createConnectionFile($host, $user, $password, $dbname) {
    $content = "<?php\n";
    $content .= "\$servidor = '$host';\n";
    $content .= "\$usuario = '$user';\n";
    $content .= "\$senha = '$password';\n";
    $content .= "\$banco = '$dbname';\n\n";
    $content .= "// Estabelece a conexão\n";
    $content .= "\$conn = mysqli_connect(\$servidor, \$usuario, \$senha, \$banco);\n\n";
    $content .= "// Verifica se a conexão foi bem-sucedida\n";
    $content .= "if(!\$conn) {\n";
    $content .= "    // echo \"Erro ao conectar ao banco de dados\";\n";
    $content .= "} else {\n";
    $content .= "    // echo \"Conexão estabelecida com sucesso!\";\n\n";
    $content .= "    // Define o charset da conexão para utf8mb4\n";
    $content .= "    mysqli_set_charset(\$conn, \"utf8mb4\");\n";
    $content .= "}\n\n";
    $content .= "// Restante do seu código...\n";
    $content .= "?>";

    file_put_contents(__DIR__ . '/login/painel/conn.php', $content);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['host'], $_POST['user'], $_POST['password'], $_POST['dbname'])) {
        // Extrair o arquivo zip
        extractZip($zipFile, $extractPath);

        // Configurar o banco de dados
        setupDatabase($host, $user, $password, $dbname);

        // Criar o arquivo de conexão
        createConnectionFile($host, $user, $password, $dbname);

        echo 'Instalação concluída com sucesso.';
        echo "<meta http-equiv='refresh' content='2;url=index.php'>";

        // Opcional: remover arquivos de instalação para segurança
        // unlink(__DIR__ . '/install.php');
        // unlink(__DIR__ . '/process_install.php');
        // unlink($zipFile);
    } else {
        echo 'Todos os campos do formulário são obrigatórios.';
    }
} else {
    echo 'Método de solicitação inválido.';
}
?>
