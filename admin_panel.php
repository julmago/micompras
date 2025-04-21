<?php
session_start();
if (!$_SESSION['admin']) header('Location: admin_login.php'); // Redirigir si no hay sesión

$archivo_csv = 'ventas.csv';

// Leer el archivo CSV
$ventas = [];
if (file_exists($archivo_csv)) {
    $file = fopen($archivo_csv, 'r');
    fgetcsv($file); // Saltar la primera línea (encabezados)
    while (($linea = fgetcsv($file)) !== false) {
        $ventas[] = [
            'id' => $linea[0],
            'fecha' => $linea[1],
            'cliente' => $linea[2],
            'email' => $linea[3],
            'telefono' => $linea[4],
            'productos' => $linea[5],
            'total' => $linea[6],
            'estado' => $linea[7]
        ];
    }
    fclose($file);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Ventas Recientes</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Productos</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta): ?>
                <tr>
                    <td><?= $venta['id'] ?></td>
                    <td><?= $venta['fecha'] ?></td>
                    <td><?= $venta['cliente'] ?><br><small><?= $venta['email'] ?></small></td>
                    <td>
                        <?php 
                        $productos = explode('|', $venta['productos']);
                        foreach ($productos as $prod) {
                            list($nombre, $cantidad, $precio) = explode(':', $prod);
                            echo "$nombre (x$cantidad): $$precio<br>";
                        }
                        ?>
                    </td>
                    <td>$<?= $venta['total'] ?></td>
                    <td><?= ucfirst($venta['estado']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="cerrar_sesion.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</body>
</html>