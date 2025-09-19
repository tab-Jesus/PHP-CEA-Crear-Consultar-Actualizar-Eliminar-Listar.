  <?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CEA-Delete'])) {
    $id = $_POST['id'];
    
    $sql = "DELETE FROM gastos WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Gasto eliminado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$conn->close();
?>