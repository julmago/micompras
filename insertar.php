<?php
$archivo_csv = 'ventas.csv';

// Datos del cliente (ejemplo, ajusta según tu formulario)
$cliente_nombre = $_POST['nombre'];
$cliente_email = $_POST['email'];
$cliente_telefono = $_POST['telefono'];

// Datos del pedido (formato: "producto:cantidad:precio|producto2:cantidad:precio")
$productos = "Producto1:1:100|Producto2:2:50"; // Ajusta esto según tu lógica
$total = 200.00; // Calcula el total real

// Crear línea CSV
$nueva_venta = [
    uniqid(), // ID único
    date('Y-m-d H:i:s'),
    $cliente_nombre,
    $cliente_email,
    $cliente_telefono,
    $productos,
    $total,
    'pendiente'
];

// Guardar en CSV
if (!file_exists($archivo_csv)) {
    $header = "id_pedido,fecha,cliente_nombre,cliente_email,cliente_telefono,productos,total,estado\n";
    file_put_contents($archivo_csv, $header);
}

$file = fopen($archivo_csv, 'a');
fputcsv($file, $nueva_venta);
fclose($file);

echo "Pedido registrado exitosamente!";
?>