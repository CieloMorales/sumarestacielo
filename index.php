<?php

//TODAS LAS OPERACIONES (SUMA, RESTA MULTIPLICAICÓN Y DIVISÓN) listas para subir a la rama develop

// Validación de datos
function validateInput($data) {
    if (!is_numeric($data)) {
        throw new Exception("Entrada inválida. Solo se permiten números.");
    }
    return floatval($data);
}

// Gestión de errores y registros
function logError($message) {
    error_log($message, 3, 'errors.log');
}

// Protección de datos
function sanitizeOutput($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

$result = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $num1 = validateInput($_POST['num1']);
        $num2 = validateInput($_POST['num2']);
        $operation = $_POST['operation'];
        
        if ($operation == "sum") {
            $result = $num1 + $num2;
        } elseif ($operation == "subtract") {
            $result = $num1 - $num2;
        } elseif ($operation == "multiply") {
            $result = $num1 * $num2;
        } elseif ($operation == "divide") {
            if ($num2 == 0) {
                throw new Exception("No se puede dividir por cero.");
            }
            $result = $num1 / $num2;
        } else {
            throw new Exception("Operación inválida.");
        }
    } catch (Exception $e) {
        $error = sanitizeOutput($e->getMessage());
        logError($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Calculadora</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .form-select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .result, .error {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }
        .result {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Calculadora</h1>
        <form method="post" action="">
            <label for="num1" class="form-label">Número 1:</label>
            <input type="text" id="num1" name="num1" class="form-control" required>
            
            <label for="num2" class="form-label">Número 2:</label>
            <input type="text" id="num2" name="num2" class="form-control" required>
            
            <label for="operation" class="form-label">Operación:</label>
            <select id="operation" name="operation" class="form-select">
                <option value="sum">Suma</option>
                <option value="subtract">Resta</option>
                <option value="multiply">Multiplicación</option>
                <option value="divide">División</option>
            </select>
            
            <button type="submit" class="btn">Calcular</button>
        </form>
        <?php if ($result !== ""): ?>
            <div class="result">Resultado: <?php echo sanitizeOutput($result); ?></div>
        <?php endif; ?>
        <?php if ($error !== ""): ?>
            <div class="error">Error: <?php echo sanitizeOutput($error); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
