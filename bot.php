<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
<title>BOT</title>
</head>
<body>

<?php

$servername = "";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

/* change character set to utf8 */
if (!$conn->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $conn->error);
} else {
    printf("Current character set: %s\n", $conn->character_set_name());
}

$sql = "SELECT nombre FROM bot ORDER BY rand() LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        $muerto = $row["nombre"];
    }

} else {
    echo "0 results";
}

$sql = "DELETE FROM bot WHERE nombre= '$muerto'";

if ($conn->query($sql) === TRUE) {
    echo "Muerto eliminado";
} else {
    echo "Error deleting record: " . $conn->error;
}

$sql = "SELECT nombre FROM bot";
$result = $conn->query($sql);

$restantes = $result->num_rows;

$sql = "SELECT nombre FROM bot ORDER BY rand() LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        $vivo = $row["nombre"];
    }

} else {
    echo "0 results";
}

$conn->close();

echo "$vivo $muerto";
echo "$restantes";

//// BOT TWITTER ////

    require_once __DIR__ . "/src/codebird.php";

    $apiKey = "";
    $apiSecret = "";
    $accessToken = "";
    $accessTokenSecret = "";
            
    \Codebird\Codebird::setConsumerKey($apiKey, $apiSecret);
    $codebird = \Codebird\Codebird::getInstance();
    $codebird->setToken($accessToken, $accessTokenSecret);

    $hora = (date("d") . " del " . date("m") . " de " . date("Y"));

    $params = array(
        "status" => "".$hora.".\n".$vivo." ha asesinado a ".$muerto.".\n".$restantes." copleros restantes. \n#CoplaWar"
    );
    
    $codebird->statuses_update($params);
    
    ?>

</body>
</html>