

  <?php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['CEA-Search'])) {
    $sql = "SELECT * FROM gastos ORDER BY fecha DESC";
    $result = $conn->query($sql);

    

   
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"]. " - Fecha: " . $row["fecha"]. 
                 " - Valor: " . $row["valorTotalConIVA"]. " - Usuario: " . 
                 $row["nombreUsuario"]. "<br>";
        }
    } else {
        echo "0 resultados";
    }
}
    
    $conn->close();

    ?>