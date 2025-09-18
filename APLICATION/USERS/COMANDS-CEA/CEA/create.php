



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $fecha = $_POST['fecha'];
    $valorTotalSinIVA = $_POST['valorTotalSinIVA'];
    $ivaTotal = $_POST['ivaTotal'];
    $valorTotalConIVA = $_POST['valorTotalConIVA'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $lugar = $_POST['lugar'];
    $descripcion = $_POST['descripcion'];
    
    $sql = "INSERT INTO gastos (fecha, valorTotalSinIVA, ivaTotal, valorTotalConIVA, nombreUsuario, lugar, descripcion)
            VALUES ('$fecha', $valorTotalSinIVA, $ivaTotal, $valorTotalConIVA, '$nombreUsuario', '$lugar', '$descripcion')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Gasto creado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}