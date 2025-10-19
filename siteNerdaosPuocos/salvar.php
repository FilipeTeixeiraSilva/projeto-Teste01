<?php
// 1. Configurações do Banco de Dados (SUBSTITUA PELOS SEUS DADOS!)
$servername = "myshared2229"; // Ex: mysql.seudominio.com.br
$username = "nerd_nome";      // Ex: user_jardim
$password = "Zoro13@";        // Ex: JaRdIm@2025!
$dbname = "nerd_nome";        // Ex: blog_jardinagem_db

// 2. Conexão com o Banco de Dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("<div class='mensagem erro'>Erro de conexão: " . $conn->connect_error . "</div>");
}

// 3. Verifica se o formulário foi enviado e pega o nome
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nome'])) {
    $nome = $_POST['nome']; // Pega o nome enviado pelo formulário

    // Proteção contra SQL Injection (muito importante!)
    $nome = $conn->real_escape_string($nome);

    // --- NOVA LÓGICA: VERIFICAÇÃO DE NOME DUPLICADO ---
    
    // 4. Primeiro, verifica se o nome já existe no banco
    $sql_check = "SELECT id FROM pessoas WHERE nome = '$nome'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        // Se num_rows for maior que 0, o nome já existe
        echo "<div class='mensagem erro'>Erro: O nome '$nome' já foi cadastrado. Por favor, escolha outro.</div>";
    } else {
        // Se o nome não existe, prossegue com a inserção
        // 5. Prepara e Executa a Inserção no Banco de Dados
        $sql_insert = "INSERT INTO pessoas (nome) VALUES ('$nome')";

        if ($conn->query($sql_insert) === TRUE) {
            echo "<div class='mensagem sucesso'>Nome '$nome' salvo com sucesso!</div>";
        } else {
            echo "<div class='mensagem erro'>Erro ao salvar o nome: " . $conn->error . "</div>";
        }
    }
    // --- FIM DA NOVA LÓGICA ---

} else {
    // Caso a página seja acessada diretamente sem o formulário
    echo "<div class='mensagem erro'>Nenhum nome foi enviado. Por favor, use o formulário.</div>";
}

// 6. Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .mensagem { margin-top: 20px; padding: 10px; border-radius: 5px; max-width: 400px; margin-left: auto; margin-right: auto; }
        .sucesso { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .erro { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        a { display: block; margin-top: 20px; text-align: center; text-decoration: none; color: #007bff; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <a href="cadastro.html">Voltar ao formulário</a>
</body>
</html>