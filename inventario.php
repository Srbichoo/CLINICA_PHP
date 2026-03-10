<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit();
}

require_once "db.php";
$db = get_db();

// CREAR
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar"])) {
    $stmt = $db->prepare("INSERT INTO medicamentos (nombre, cantidad, precio) VALUES (?, ?, ?)");
    $stmt->execute([$_POST["nombre"], $_POST["cantidad"], $_POST["precio"]]);
    header("Location: inventario.php");
    exit();
}

// ELIMINAR
if (isset($_GET["eliminar"])) {
    $stmt = $db->prepare("DELETE FROM medicamentos WHERE id = ?");
    $stmt->execute([$_GET["eliminar"]]);
    header("Location: inventario.php");
    exit();
}

// LEER
$lista = $db->query("SELECT * FROM medicamentos")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - Prover.COM</title>
    <link rel="stylesheet" href="static/color.css">
    <style>
        body { background: var(--bg); }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 24px 32px 0;
        }

        /* Banner */
        .page-banner {
            display: flex;
            align-items: center;
            background: var(--blue-main);
            clip-path: polygon(0 0, 90% 0, 100% 50%, 90% 100%, 0 100%);
            padding: 14px 120px 14px 20px;
            margin: 22px 0 28px 0;
            gap: 16px;
            max-width: 640px;
        }
        .banner-icon {
            font-size: 3.8rem;
            flex-shrink: 0;
        }
        .banner-text {
            color: white;
            font-size: 1.6rem;
            font-weight: 900;
            line-height: 1.2;
            letter-spacing: -0.3px;
        }

        /* Add form */
        .add-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }
        .add-form input {
            flex: 1;
            min-width: 160px;
            padding: 11px 18px;
            border-radius: 999px;
            border: 2px solid var(--blue-light);
            font-family: 'Nunito', sans-serif;
            font-size: 0.95rem;
            background: white;
            outline: none;
            transition: border-color .2s;
        }
        .add-form input:focus { border-color: var(--blue-main); }
        .add-form button {
            background: var(--blue-main);
            color: white;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 11px 26px;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            transition: background .2s, transform .15s;
            white-space: nowrap;
        }
        .add-form button:hover { background: var(--blue-dark); transform: translateY(-1px); }

        /* Table action buttons */
        .btn-edit {
            background: var(--blue-main);
            color: white;
            padding: 5px 14px;
            border-radius: 999px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 700;
            transition: background .2s;
        }
        .btn-edit:hover { background: var(--blue-dark); }

        .btn-del {
            background: var(--danger);
            color: white;
            padding: 5px 14px;
            border-radius: 999px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 700;
            transition: background .2s;
        }
        .btn-del:hover { background: #c0392b; }

        .back-link {
            display: inline-block;
            color: var(--blue-main);
            font-weight: 700;
            text-decoration: none;
            border: 2px solid var(--blue-light);
            border-radius: 999px;
            padding: 7px 22px;
            font-size: 0.95rem;
            transition: background .2s, color .2s;
        }
        .back-link:hover { background: var(--blue-main); color: white; border-color: var(--blue-main); }

        .page-wrap { padding: 0 32px 48px; }

        .table-wrap {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0,0,0,.07);
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <div></div>
        <!-- Logo top-right -->
        <div class="logo-badge">
            <div class="smiley">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="24" height="24" rx="5" fill="#3779a2"/>
                    <circle cx="16" cy="7" r="3" fill="#e8866e"/>
                    <path d="M5 14 Q12 20 19 14" stroke="#e8866e" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                </svg>
            </div>
            Prover.COM
        </div>
    </div>

    <div class="page-wrap">

        <!-- Banner -->
        <div class="page-banner">
            <img src="static/imgprover/medicamentos.png" alt="medicamentos" style="width:110px;height:100px;object-fit:contain;flex-shrink:0;">
            <div class="banner-text">INVENTARIO<br>DE MEDICAMENTOS</div>
        </div>

        <!-- Back -->
        <a href="seleccion.php" class="back-link" style="margin-bottom:22px;display:inline-block;">← atras</a>

        <!-- Add form -->
        <form class="add-form" action="inventario.php" method="POST">
            <input type="text"   name="nombre"   placeholder="Nombre del medicamento" required>
            <input type="number" name="cantidad" placeholder="Cantidad" required min="0">
            <input type="number" name="precio"   placeholder="Precio" step="0.01" required min="0">
            <button type="submit" name="agregar">➕ Agregar</button>
        </form>

        <!-- Table -->
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Medicamento</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $med): ?>
                    <tr>
                        <td><?= $med["id"] ?></td>
                        <td><?= htmlspecialchars($med["nombre"]) ?></td>
                        <td><span class="qty-badge"><?= $med["cantidad"] ?></span></td>
                        <td>$<?= number_format($med["precio"], 2) ?></td>
                        <td style="display:flex;gap:8px;align-items:center;">
                            <a href="editar.php?id=<?= $med["id"] ?>" class="btn-edit">✏️ Editar</a>
                            <a href="inventario.php?eliminar=<?= $med["id"] ?>" class="btn-del"
                               onclick="return confirm('¿Seguro que deseas eliminar?')">🗑️ Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($lista)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;color:#aaa;padding:30px;">
                            No hay medicamentos registrados aún.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
