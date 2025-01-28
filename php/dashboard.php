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

$sql_itens = "SELECT id, nome, descricao FROM itens";
$result_itens = $conn->query($sql_itens);

$sql_desenhos = "SELECT id, nome FROM desenhos";
$result_desenhos = $conn->query($sql_desenhos);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
            color: #4a4a4a;
            line-height: 1.6;
            text-align: center;  /* Alinhando todo o texto do body ao centro */
        }
    
        h1, h2 {
            color: #007bff;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }
    
        h2 {
            font-size: 1.6em;
        }
    
        .container {
            max-width: 800px;  /* Ajustando o tamanho da container */
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
    
        table {
            width: 80%;  /* Tabela menor */
            margin: 0 auto 20px;  /* Centralizando a tabela */
            border-collapse: collapse;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }
    
        table, th, td {
            border: 1px solid #e3e3e3;
        }
    
        th, td {
            padding: 12px 15px;  /* Ajustando o espaçamento */
            text-align: center;  /* Centralizando o conteúdo nas células */
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }
    
        th {
            background-color: #007bff;
            color: white;
            font-size: 1.1em;
            font-weight: 600;
        }
    
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    
        tr:hover {
            background-color: #e9ecef;
        }
    
        .logout-btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
    
        .logout-btn:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
    
        .logout-btn:active {
            transform: translateY(2px);
        }
    
        form select {
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1em;
            width: 100%;
            max-width: 300px;
            margin-top: 15px;
            transition: border-color 0.3s ease;
        }
    
        form select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    
        .container h2, .container table, .container form {
            margin-bottom: 40px;
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
        </tr>
    </thead>
    <tbody>
        <?php if ($result_itens->num_rows > 0): ?>
            <?php while ($row = $result_itens->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= htmlspecialchars($row['descricao']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Nenhum item encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<h2>Selecione um Desenho</h2>
<form>
    <select name="desenho" id="desenho">
        <?php if ($result_desenhos->num_rows > 0): ?>
            <?php while ($row = $result_desenhos->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($row['id']) ?>">
                    <?= htmlspecialchars($row['nome']) ?>
                </option>
            <?php endwhile; ?>
        <?php else: ?>
            <option value="">Nenhum desenho disponível</option>
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
