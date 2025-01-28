<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #d9d9d9;
        color: #333;
    }

    #container {
        max-width: 400px;   
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-top: 100px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }

    #container:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    form {
        margin-top: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }

    h1 {
        text-align: center;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        outline: none;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
        transform: scale(1.05);
    }

    input[type="submit"]:active {
        background-color: #3e8e41;
        transform: scale(1);
    }

    @media screen and (max-width: 600px) {
        #container {
            max-width: 90%;
            padding: 15px;
        }

        input[type="submit"] {
            font-size: 14px;
            padding: 10px 16px;
        }
    }
</style>

<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = $_POST["password"];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $passwordHash);

    if ($stmt->execute()) {
        $_SESSION['showAlert'] = 'success';
    } else {
        $_SESSION['showAlert'] = 'error';
        $_SESSION['errorMessage'] = $stmt->error;
    }

    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_SESSION['showAlert'])) {
    $alertType = $_SESSION['showAlert'];
    $alertMessage = ($alertType === 'success') ? 'Você foi cadastrado com sucesso!' : 'Erro ao cadastrar: ' . htmlspecialchars($_SESSION['errorMessage'] ?? 'Erro desconhecido.');
    $alertIcon = ($alertType === 'success') ? 'success' : 'error';
    $alertTitle = ($alertType === 'success') ? 'Sucesso!' : 'Erro!';
    echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '$alertTitle',
                text: '$alertMessage',
                icon: '$alertIcon',
                confirmButtonText: 'Ok',
                background: '#f9f9f9',
                color: '#333',
                confirmButtonColor: '#4CAF50'
            }).then(() => {
                window.location.href = '" . $_SERVER['PHP_SELF'] . "';
            });
        }
    </script>";
}

unset($_SESSION['showAlert']);
unset($_SESSION['errorMessage']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
<?php
    $nomePlaceholder = "Digite seu nome completo";
    $emailPlaceholder = "Digite seu email";
    $mensagemPlaceholder = "Digite sua senha";
    ?>
    <div id="container">
        <h1>Cadastro</h1>
        <form id="registerForm" action="" method="post">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" placeholder="<?php echo $nomePlaceholder; ?>" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="<?php echo $emailPlaceholder; ?>"  required><br><br>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password"placeholder="<?php echo $mensagemPlaceholder; ?>" required><br><br>
            <input type="submit" value="Cadastrar">
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
