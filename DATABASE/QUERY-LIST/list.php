<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'todos';
    $parametro = isset($_GET['parametro']) ? $_GET['parametro'] : '';

    switch ($tipo) {
        case 'usuario':
            $query = "SELECT * FROM gastos WHERE nombreUsuario = :parametro ORDER BY fecha DESC";
            break;
        
        case 'fecha':
            $query = "SELECT * FROM gastos WHERE fecha = :parametro ORDER BY fecha DESC";
            break;
        
        case 'rango_fechas':
            $fechas = explode(',', $parametro);
            if (count($fechas) === 2) {
                $query = "SELECT * FROM gastos WHERE fecha BETWEEN :fecha_inicio AND :fecha_fin ORDER BY fecha DESC";
            } else {
                throw new Exception("Formato de rango de fechas incorrecto. Use fecha_inicio,fecha_fin");
            }
            break;
        
        case 'lugar':
            $query = "SELECT * FROM gastos WHERE lugar LIKE :parametro ORDER BY fecha DESC";
            $parametro = "%$parametro%";
            break;
        
        default:
            $query = "SELECT * FROM gastos ORDER BY fecha DESC";
            break;
    }

    $stmt = $db->prepare($query);
    
    if ($tipo === 'rango_fechas' && count($fechas) === 2) {
        $stmt->bindParam(":fecha_inicio", $fechas[0]);
        $stmt->bindParam(":fecha_fin", $fechas[1]);
    } elseif ($tipo !== 'todos') {
        $stmt->bindParam(":parametro", $parametro);
    }
    
    $stmt->execute();

    $gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        "success" => true,
        "count" => count($gastos),
        "data" => $gastos
    ];

    http_response_code(200);
    echo json_encode($response);


    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error al obtener los gastos: " . $e->getMessage()
    ]);

?>