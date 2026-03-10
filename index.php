<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula   = $_POST["cedula"];
    $password = $_POST["password"];
    $nombre   = $_POST["nombre"];

    if ($cedula == "1027662591" && $password == "admin") {
        $_SESSION["usuario"] = $nombre;
        header("Location: seleccion.php");
        exit();
    } else {
        $error = "Datos incorrectos, intenta de nuevo.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prover.COM</title>
    <link rel="stylesheet" href="static/color.css">
    <style>
        body {
            background: var(--bg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .page-logo {
            position: absolute;
            top: 28px;
            left: 32px;
        }
        .login-card {
            background: white;
            border-radius: 24px;
            padding: 48px 52px 52px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 8px 40px rgba(187, 192, 196, 0.13);
        }
        .login-title {
            text-align: center;
            color: var(--blue-light);
            font-size: 1.85rem;
            font-weight: 800;
            margin-bottom: 34px;
        }
        .field-group { margin-bottom: 20px; }
        .field-label {
            display: block;
            color: var(--blue-light);
            font-weight: 800;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 9px;
        }
        .error-msg {
            background: #fdecea; color: var(--danger);
            border-radius: 999px; text-align: center;
            padding: 10px 20px; margin-bottom: 18px; font-weight: 700;
        }
        .btn-row { display: flex; justify-content: flex-end; margin-top: 28px; }
        .btn-cargar {
            background: var(--blue-main); color: white;
            font-family: 'Nunito', sans-serif; font-size: 1.1rem;
            font-weight: 800; padding: 13px 40px; border-radius: 999px;
            border: none; cursor: pointer; letter-spacing: 0.5px;
            transition: background .2s, transform .15s, box-shadow .15s;
        }
        .btn-cargar:hover { background: var(--blue-dark); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(55,121,162,.35); }
    </style>
</head>
<body>

    <div class="page-logo">
        <div class="logo-badge">
            <div>
                <img src="static/imgprover/prover.png.png" alt="../static/imgprover/prover2.png">
            </div>
            <style>
                img{
                    width: 90px;
                    height: 90px;
                    padding: 0;
                }
                
            </style>
           
            Prover.COM
        </div>
    </div>

    <div class="login-card">
        <h1 class="login-title">Ingrese Usuario</h1>
        <form action="index.php" method="POST">
            <?php if (isset($error)): ?>
                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <div class="field-group">
                <label class="field-label">Ingrese Usuario</label>
                <input class="pill-input" type="text" name="nombre" placeholder="Tu nombre completo" required>
            </div>
            <div class="field-group">
                <label class="field-label">Ingrese C.C</label>
                <input class="pill-input" type="text" name="cedula" placeholder="Número de identificación" required>
            </div>
            <div class="field-group">
                <label class="field-label">Ingrese Contraseña</label>
                <input class="pill-input" type="password" name="password" placeholder="••••••••" required>
            </div>
            <div class="btn-row">
                <button type="submit" class="btn-cargar">CARGAR</button>
            </div>
        </form>
    </div>
</body>
</html>
