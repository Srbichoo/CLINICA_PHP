<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit();
}

require_once "db.php";
$db = get_db();

$poco_stock = $db->query("SELECT * FROM medicamentos WHERE cantidad < 10 ORDER BY cantidad ASC")->fetchAll();
$todos      = $db->query("SELECT * FROM medicamentos ORDER BY cantidad DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes - Prover.COM</title>
    <link rel="stylesheet" href="static/color.css">
    <style>
        body { background: var(--bg); }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 24px 32px 0;
        }

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
        .banner-icon { font-size: 3.8rem; flex-shrink: 0; }
        .banner-text {
            color: white;
            font-size: 1.85rem;
            font-weight: 900;
            line-height: 1.2;
            letter-spacing: -0.3px;
        }

        .back-link {
            display: inline-block; color: var(--blue-main);
            font-weight: 700; text-decoration: none;
            border: 2px solid var(--blue-light); border-radius: 999px;
            padding: 7px 22px; font-size: 0.95rem;
            transition: background .2s, color .2s;
            margin-bottom: 24px;
        }
        .back-link:hover { background: var(--blue-main); color: white; border-color: var(--blue-main); }

        .alert-banner {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 24px;
            border-radius: 12px;
            margin-bottom: 22px;
            font-weight: 700;
            font-size: 1rem;
        }
        .alert-danger { background: #fdecea; color: var(--danger); border: 2px solid #f5c6c1; }
        .alert-ok     { background: #eafaf1; color: #1e8449;        border: 2px solid #a9dfbf; }

        .table-wrap {
            background: white; border-radius: 14px;
            overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,.07);
            margin-bottom: 32px;
        }

        .section-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--blue-main);
            margin-bottom: 10px;
        }

        .low-qty { color: var(--danger); font-weight: 800; }

        .qty-badge-ok  { background: #dff0e8; color: #1e8449; display:inline-block; padding:3px 14px; border-radius:999px; font-weight:700; font-size:0.88rem; }
        .qty-badge-low { background: #fdecea; color: var(--danger); display:inline-block; padding:3px 14px; border-radius:999px; font-weight:700; font-size:0.88rem; }

        .page-wrap { padding: 0 32px 48px; }
        .img{
            margin: 10%;
            width: 10%;
            height: 10%;
           
            
        }
        .page-banner{
            width:100%;
            height:100px; 
            object-fit:contain;
            flex-shrink:0;

        }
    </style>
</head>
<body>

    <div class="top-bar">
        <div></div>
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
         <div class= img><img src="static/imgprover/reportes.png" alt="reportes"></div>

         <div class="page-banner">
            
            
            <div class="banner-text">Reportes</div>
        </div>
       

        <a href="seleccion.php" class="back-link">← atras</a>

        <!-- Alert -->
        <?php if (count($poco_stock) > 0): ?>
            <div class="alert-banner alert-danger">
                ⚠️ Hay <?= count($poco_stock) ?> medicamento(s) con inventario bajo (menos de 10 unidades)
            </div>
        <?php else: ?>
            <div class="alert-banner alert-ok">
                ✅ ¡Todo bien! Todos los medicamentos tienen stock suficiente.
            </div>
        <?php endif; ?>

        <!-- Full inventory report table -->
        <p class="section-title">Reporte general de inventario</p>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Medicamento</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Inventario bajo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($todos as $med): ?>
                    <tr>
                        <td><?= $med["id"] ?></td>
                        <td><?= htmlspecialchars($med["nombre"]) ?></td>
                        <td>
                            <?php if ($med["cantidad"] < 10): ?>
                                <span class="qty-badge-low">⚠️ <?= $med["cantidad"] ?></span>
                            <?php else: ?>
                                <span class="qty-badge-ok"><?= $med["cantidad"] ?></span>
                            <?php endif; ?>
                        </td>
                        <td>$<?= number_format($med["precio"], 2) ?></td>
                        <td>
                            <?php if ($med["cantidad"] < 10): ?>
                                <span style="color:var(--danger);font-weight:800;">⚠️ Sí</span>
                            <?php else: ?>
                                <span style="color:#1e8449;font-weight:700;">✔ No</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($todos)): ?>
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
