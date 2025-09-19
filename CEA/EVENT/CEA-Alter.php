
  <?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CEA-Alter'])) {
    $id = $_POST['id'];
    $fecha = $_POST['fecha'];
    $valorTotalSinIVA = $_POST['valorTotalSinIVA'];
    $ivaTotal = $_POST['ivaTotal'];
    $valorTotalConIVA = $_POST['valorTotalConIVA'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $lugar = $_POST['lugar'];
    $descripcion = $_POST['descripcion'];
    
    $sql = "UPDATE gastos SET fecha='$fecha', valorTotalSinIVA=$valorTotalSinIVA, 
            ivaTotal=$ivaTotal, valorTotalConIVA=$valorTotalConIVA, 
            nombreUsuario='$nombreUsuario', lugar='$lugar', descripcion='$descripcion' 
            WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Gasto actualizado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>