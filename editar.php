<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit();
}

require_once "db.php";
$db = get_db();

// ACTUALIZAR
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $db->prepare("UPDATE medicamentos SET nombre=?, cantidad=?, precio=? WHERE id=?");
    $stmt->execute([$_POST["nombre"], $_POST["cantidad"], $_POST["precio"], $_POST["id"]]);
    header("Location: inventario.php");
    exit();
}

// OBTENER MEDICAMENTO
$stmt = $db->prepare("SELECT * FROM medicamentos WHERE id = ?");
$stmt->execute([$_GET["id"]]);
$med = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Medicamento - Prover.COM</title>
    <link rel="stylesheet" href="static/color.css">
    <style>
        .contenedor { width: 400px; margin: 80px auto; background: white; padding: 30px; border-radius: 15px; }
        h2 { color: #3779a2; text-align: center; }
        label { display: block; margin-top: 15px; color: #333; font-weight: bold; }
        input { width: 100%; padding: 10px; margin-top: 5px; border: 2px solid #00ffff; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; margin-top: 20px; padding: 12px; background: #00ffff; border: none; border-radius: 8px; font-size: 1em; font-weight: bold; cursor: pointer; }
        .volver { display: block; text-align: center; margin-top: 15px; color: #3779a2; }
    </style>
</head>
<body>
    <div class="contenedor">
        <h2> Editar Medicamento</h2>
        <form action="editar.php" method="POST">
            <input type="hidden" name="id" value="<?= $med["id"] ?>">

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= $med["nombre"] ?>" required>

            <label>Cantidad:</label>
            <input type="number" name="cantidad" value="<?= $med["cantidad"] ?>" required>

            <label>Precio:</label>
            <input type="number" name="precio" value="<?= $med["precio"] ?>" step="0.01" required>

            <button type="submit">Guardar cambios</button>
        </form>
        <a href="inventario.php" class="volver">⬅ Cancelar y volver</a>
    </div>
</body>
</html>