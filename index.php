<?php
    
require_once('database.php');

if(isset($_GET['send'])) {
    $send = 'a'.$_GET['send'];
    switch($send) {
        case 'ateacher':
            $data = [
                'imie' => $_POST['imie'],
                'nazwisko' => $_POST['nazwisko'],
                'pesel' => $_POST['pesel']
            ];
            $db_conn = dbConnect($db_server, $db_name, $db_pass, $db_user);
            $sql = 'insert into nauczyciele values (NULL, :imie, :nazwisko, :pesel)';
            $db_stmt = $db_conn->prepare($sql);
            $sb_stmt->execute($data);
            $db_conn = null;
            header('Location: index.php');
        break;
    }
} 
else {
    echo 'index send nie istnieje!';
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
    <form action="index.php?send=teacher" method="post" name="addTeacher">
        <input type="text" name="imie">
        <input type="text" name="nazwisko">
        <input type="text" name="pesel">
        <input type="submit" value="Dodaj">
    </form>
    <div id="nauczyciele">
<?php
$db_conn = dbConnect($db_server, $db_name, $db_pass, $db_user);
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
    </div>
</body>
</html>