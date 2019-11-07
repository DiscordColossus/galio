<?php
    require_once('database.php');
    
$send = 'a'.$_GET['send'];
switch($send) {
    case 'ateacher':
        $db_conn = dbConnect($db_server,$db_name,$db_user,$db_pass);
    break;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="index.php?send=teacher" method="post" name="addTeacher"id="addTeacher">
        <input type="text" name="imie" id="">
        <input type="text" name="nazwisko" id="">
        <input type="text" name="pesel" id="">
        <input type="submit" value="">
        
    </form>
</body>
</html>
<?php
$db_server = 'localhost';
$db_user = 'zsht';
$db_pass = '1234';
$db_name = 'zsht';

function dbConnect($db_server,$db_name,$db_user,$db_pass){
try {
    $db_conn = new PDO('mysql:host='.$db_server.';dbname='.$db_name, $db_user, $db_pass);
    $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo $e->getMessage();
}
return $db_conn;
}
    
    $db_query = $db_conn->query('select * from uczniowie');
    foreach($db_query as $row){
        echo'<div>';
        echo $row['ID'];
        echo ' - ';
        echo $row['imie'];
        echo ' ';
        echo $row['nazwisko'];
        echo '(';
        echo $row['pesel'];
        echo ')';
        echo '</div>';
    }


?>