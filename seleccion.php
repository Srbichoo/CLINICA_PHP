<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Selección - Prover.COM</title>
    <link rel="stylesheet" href="static/color.css">
    <style>
        body {
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .sel-layout {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 860px;
            padding: 40px 32px;
            gap: 40px;
        }

        .sel-left { flex: 1; }

        .sel-title {
            color: var(--blue-main);
            font-size: 2.4rem;
            font-weight: 900;
            margin-bottom: 40px;
            letter-spacing: -0.5px;
        }

        .nav-btn {
            display: block;
            width: 100%;
            max-width: 340px;
            margin-bottom: 18px;
            text-decoration: none;
            color: var(--blue-main);
            font-weight: 700;
            font-size: 1rem;
            padding: 14px 28px;
            border-radius: 999px;
            border: 2px solid var(--blue-light);
            background: white;
            text-align: center;
            transition: background .2s, color .2s, transform .15s, box-shadow .15s;
        }
        .nav-btn:hover {
            background: var(--blue-main);
            color: white;
            border-color: var(--blue-main);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(55,121,162,.25);
        }

        .sel-right {
            flex-shrink: 0;
        }

        .big-logo {
            background: var(--blue-main);
            border-radius: 22px;
            width: 220px;
            height: 220px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 8px 32px rgba(55,121,162,.3);
        }

        .big-logo svg {
            width: 80px;
            height: 80px;
        }

        .big-logo-text {
            color: white;
            font-weight: 900;
            font-size: 1.2rem;
            letter-spacing: 0.3px;
        }

        @media (max-width: 640px) {
            .sel-layout { flex-direction: column; text-align: center; }
            .nav-btn { max-width: 100%; }
        }
    </style>
</head>
<body>
    <div class="sel-layout">
        <div class="sel-left">
            <h1 class="sel-title">SELECIONE</h1>

            <a href="inventario.php" class="nav-btn">inventario de medicamentos</a>
            <a href="proveedores.php" class="nav-btn">gestion de proveedores</a>
            <a href="reportes.php" class="nav-btn">reportes</a>
        </div>

        <div class="sel-right">
            <div class="big-logo">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Face / smile -->
                    <circle cx="58" cy="20" r="12" fill="#e8866e"/>
                    <path d="M12 52 Q40 72 68 52" stroke="#e8866e" stroke-width="8" stroke-linecap="round" fill="none"/>
                </svg>
                <span class="big-logo-text">Prover.COM</span>
            </div>
        </div>
    </div>
</body>
</html>
