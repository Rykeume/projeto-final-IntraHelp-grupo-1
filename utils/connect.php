<?php 
$GLOBALS['pdo_connection'] = null;

function conectarDB(){
    if($GLOBALS['pdo_connection'] !== null){return $GLOBALS['pdo_connection'];}

    require __DIR__ . '/config.php';
    $dsn = "sqlite:$db";
    try {
        $pdo = new \PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $GLOBALS['pdo_connection'] = $pdo;
        return $pdo;
    } catch (\PDOException $e){
        die("Erro no banco de dados: " . $e->getMessage());
    }
    
}
    
