<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: cadastro.php");
    exit();
}
$host = 'localhost';
$user = 'root'; 
$password = ''; 
$database = 'sistema_login';
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql_itens = "SELECT id, nome, descricao, preco FROM itens";
$result_itens = $conn->query($sql_itens);

$sql_produtos = "SELECT id, nome FROM produtos";
$result_produtos = $conn->query($sql_produtos);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<h1>Bem-vindo!</h1>

<h2>Lista de Itens</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result_itens->num_rows > 0): ?>
            <?php while ($row = $result_itens->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= htmlspecialchars($row['descricao']) ?></td>
                    <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Nenhum item encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<h2>Selecione um Produto</h2>
<form>
    <select name="produto" id="produto">
        <?php if ($result_produtos->num_rows > 0): ?>
            <?php while ($row = $result_produtos->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($row['id']) ?>">
                    <?= htmlspecialchars($row['nome']) ?>
                </option>
            <?php endwhile; ?>
        <?php else: ?>
            <option value="">Nenhum produto disponível</option>
        <?php endif; ?>
    </select>
</form>

<br>
<a href="logout.php" class="logout-btn">Logout</a>

</body>
</html>
<?php
$conn->close();
?>
