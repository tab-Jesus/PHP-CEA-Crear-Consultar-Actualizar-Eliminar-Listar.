<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");



   
    $query1 = "SELECT SUM(valorTotalConIVA) as total_gastado FROM gastos";
    $stmt1 = $db->prepare($query1);
    $stmt1->execute();
    $total_gastado = $stmt1->fetch(PDO::FETCH_ASSOC);

    
    $query2 = "SELECT 
                YEAR(fecha) as año, 
                MONTH(fecha) as mes, 
                SUM(valorTotalConIVA) as total_mes 
               FROM gastos 
               GROUP BY YEAR(fecha), MONTH(fecha) 
               ORDER BY año DESC, mes DESC 
               LIMIT 6";
    $stmt2 = $db->prepare($query2);
    $stmt2->execute();
    $gastos_por_mes = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    
    $query3 = "SELECT 
                lugar, 
                SUM(valorTotalConIVA) as total_lugar,
                COUNT(*) as cantidad_gastos
               FROM gastos 
               GROUP BY lugar 
               ORDER BY total_lugar DESC 
               LIMIT 5";
    $stmt3 = $db->prepare($query3);
    $stmt3->execute();
    $top_lugares = $stmt3->fetchAll(PDO::FETCH_ASSOC);

   
    $query4 = "SELECT 
                nombreUsuario, 
                SUM(valorTotalConIVA) as total_usuario,
                COUNT(*) as cantidad_gastos
               FROM gastos 
               GROUP BY nombreUsuario 
               ORDER BY total_usuario DESC 
               LIMIT 5";
    $stmt4 = $db->prepare($query4);
    $stmt4->execute();
    $top_usuarios = $stmt4->fetchAll(PDO::FETCH_ASSOC);

    
    $response = [
        "success" => true,
        "estadisticas" => [
            "total_gastado" => $total_gastado['total_gastado'] ?? 0,
            "gastos_por_mes" => $gastos_por_mes,
            "top_lugares" => $top_lugares,
            "top_usuarios" => $top_usuarios
        ]
    ];

    http_response_code(200);
    echo json_encode($response);


    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error al obtener estadísticas: " . $e->getMessage()
    ]);

?>