<?php

require 'banco.php';

// Inicialize variáveis e mensagens de erro
$nome = $endereco = $telefone = $email = $sexo = "";
$nomeErro = $enderecoErro = $telefoneErro = $emailErro = $sexoErro = "";

// Processa o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // Validação de Nome
    if (empty($_POST["nome"])) {
        $nomeErro = "O nome é obrigatório.";
        $isValid = false;
    } else {
        $nome = trim($_POST["nome"]);
    }

    // Validação de Endereço
    if (empty($_POST["endereco"])) {
        $enderecoErro = "O endereço é obrigatório.";
        $isValid = false;
    } else {
        $endereco = trim($_POST["endereco"]);
    }

    // Validação de Telefone
    if (empty($_POST["telefone"])) {
        $telefoneErro = "O telefone é obrigatório.";
        $isValid = false;
    } else {
        $telefone = trim($_POST["telefone"]);
    }

    // Validação de Email
    if (empty($_POST["email"])) {
        $emailErro = "O email é obrigatório.";
        $isValid = false;
    } else {
        $email = trim($_POST["email"]);
        // Verifica se o email é válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErro = "Formato de email inválido.";
            $isValid = false;
        }
    }

    // Validação de Sexo
    if (empty($_POST["sexo"])) {
        $sexoErro = "O sexo é obrigatório.";
        $isValid = false;
    } else {
        $sexo = trim($_POST["sexo"]);
    }

    // Se todos os dados forem válidos, insira-os no banco de dados
    if ($isValid) {
        try {
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO aluno (nome, endereco, telefone, email, sexo) VALUES (?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($nome, $endereco, $telefone, $email, $sexo));

            Banco::desconectar();

            // Redireciona para a página de sucesso (ou onde for apropriado)
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            exit;
        }
    }
}

?>
