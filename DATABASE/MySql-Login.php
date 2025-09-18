  <?php
    $servername = "Localhost";
    $username = "";
    $password = "";
    $database = "";

   
    $conn = new mysqli($servername, $username, $password, $database);

   
    if ($conn->connect_error) {
        die("NO SE PUEDE CONECTAR! " . $conn->connect_error);
    }
    echo "SE CONECTO!";


    $conn->close();
    ?>