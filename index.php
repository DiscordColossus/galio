<?php
/*
Plik wymagany.
Jeśli nie istnieje, wystąpi bład krytyczny.
Serwer przerwie ładowanie strony.
*/
require_once('database.php');
include('functions.php');

if(isset($_GET['send'])) {
    $send = 'a'.$_GET['send'];
    switch($send) {
        case 'ateacher':
            $data = [
                'imie' => $_POST['imie'],
                'nazwisko' => $_POST['nazwisko'],
                'pesel' => $_POST['pesel']
            ];
            $db_conn = dbConnect($db_server, $db_name, $db_user,$db_pass);
            $sql = 'insert into nauczyciele values (NULL, :imie, :nazwisko, :pesel)';
            $db_stmt = $db_conn->prepare($sql);
            $db_stmt->execute($data);
            $db_conn = null;
            header('Location: index.php');
        break;
        case 'aeducator':
            $data = [
                'nauczyciel' => $_POST['wychowawca']
            ];
            $db_conn = dbConnect($db_server, $db_name, $db_user,$db_pass);
            $sql = 'select * from wychowawcy where nauczyciel = :nauczyciel';
            $db_stmt = $db_conn->prepare($sql);
            $db_stmt->execute($data);
            $wych = $db_stmt->fetchAll();
            var_dump($wych);
            $db_conn = null;
            if(count($wych) == 0) {
                $data = [
                    'pelna_nazwa' => $_POST['pelna_nazwa'],
                    'skrot' => $_POST['skrot'],
                    'rocznik' => $_POST['rocznik'],
                    'wychowawca' => $_POST['wychowawca']
                ];
                $db_conn = dbConnect($db_server, $db_name, $db_user,$db_pass);
                $sql = 'insert into klasy values(NULL, :pelna_nazwa, :skrot, :rocznik, :wychowawca)';
                $db_stmt = $db_conn->prepare($sql);
                $db_stmt->execute($data);
                $id = $db_conn->lastInsertId();
                $data = [
                    'nauczyciel' => $_POST['wychowawca'],
                    'klasa' => $id
                ];
                $sql = 'insert into wychowawcy values(NULL, :nauczyciel, :klasa)';
                $db_conn = null;
                //header('Location: index.php');
            }
        break;
        default:
            echo 'Co robisz dzbanie!';
    }
}

if(isset($_GET['cmd'])) {
    $cmd = 'c'.$_GET['cmd'];
    switch($cmd) {
        case 'cupdate':
            $method = $_SERVER['REQUEST_METHOD'];
            if($method == 'POST') {
                $data = [
                    'imie' => $_POST['imie'],
                    'nazwisko' => $_POST['nazwisko'],
                    'pesel' => $_POST['pesel'],
                    'id' => $_GET['id']
                ];
                $db_conn = dbConnect($db_server, $db_name, $db_user,$db_pass);
                $sql = 'update nauczyciele set imie = :imie, nazwisko = :nazwisko, pesel = :pesel where id = :id';
                $db_stmt = $db_conn->prepare($sql);
                $db_stmt->execute($data);
                $db_conn = null;
                header('Location: index.php');
            }
            else {
                $data = [
                    'id' => $_GET['id']
                ];
                $db_conn = dbConnect($db_server, $db_name, $db_user,$db_pass);
                $sql = 'select imie, nazwisko, pesel from nauczyciele where id = :id';
                $db_stmt = $db_conn->prepare($sql);
                $db_stmt->execute($data);
                $teacher = $db_stmt->fetchAll();
                $db_conn = null;
            }
        break;
        case 'cdelete':
            $data = [
                'id' => $_GET['id']
            ];
            $db_conn = dbConnect($db_server, $db_name, $db_user,$db_pass);
            $sql = 'delete from nauczyciele where id = :id';
            $db_stmt = $db_conn->prepare($sql);
            $db_stmt->execute($data);
            $db_conn = null;
        break;
        default:
            echo 'Co robisz dzbanie!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    .list .title {
        font-weight: bold;
        padding: 15px;
    }
    .content div {
        display: inline-block;
        width: 15%;
        padding: 15px;
    }
    .content:hover {
        background-color: #ddd;
    }
    .content div a {
        text-decoration: none;
        color: #000;
        cursor: default;
        border: 1px solid #eee;
        border-radius: 5px;
        padding: 10px;
        margin: 0 5px;
    }
    .content div a:hover {
        background-color: #fcc;
    }
    </style>
</head>
<body>
    <div class="list" id="nauczyciele">
        <div class="title">Nauczyciele</div>
            <form action="<?= (isset($_GET['cmd']) && $_GET['cmd'] == 'update') ? ('index.php?cmd=update&amp;id='.getNum($_GET['id'])) : ('index.php?send=teacher') ?>" method="post" name="addTeacher" id="addTeacher">
                <input type="text" name="imie" value="<?= (isset($teacher[0]['imie'])) ? ($teacher[0]['imie']) : ('') ?>" id="">
                <input type="text" name="nazwisko" value="<?= (isset($teacher[0]['nazwisko'])) ? ($teacher[0]['nazwisko']) : ('') ?>" id="">
                <input type="text" name="pesel" value="<?= (isset($teacher[0]['pesel'])) ? ($teacher[0]['pesel']) : ('') ?>" id="">
                <input type="submit" value="Zapisz">
            </form>
<?php
$db_conn = dbConnect($db_server, $db_name, $db_user,$db_pass);
$db_query = $db_conn->query('select * from nauczyciele');
foreach($db_query as $row) {
?>
        <div class="content">
            <div><?= $row['imie'] ?></div>
            <div><?= $row['nazwisko'] ?></div>
            <div><?= $row['pesel'] ?></div>
            <div>
                <a href="index.php?cmd=update&amp;id=<?= $row['id'] ?>">Edytuj</a>
                <a href="index.php?cmd=delete&amp;id=<?= $row['id'] ?>">Usuń</a>
            </div>
        </div>
<?php
}
?>
    </div>
    <div class="list" id="klasy">
        <div class="title">Klasy</div>
        <form action="index.php?send=educator" method="post">
            <input name="pelna_nazwa" type="text">
            <input name="skrot" type="text">
            <input name="rocznik" type="text">
            <select name="wychowawca" id="wychowawca">
                <option value=""></option>
<?php
$db_conn = dbConnect($db_server, $db_name, $db_user,$db_pass);
$db_query = $db_conn->query('select * from nauczyciele n, wychowawcy w where n.id != w.nauczyciel');
foreach($db_query as $row) {
?>
                <option value="<?= $row['id'] ?>"><?= $row['imie'].' '.$row['nazwisko'] ?></option>
<?php
}
?>
            </select>
            <input type="submit" value="Zapisz">
        </form>
<?php
$db_conn = dbConnect($db_server, $db_name, $db_user,$db_pass);
$db_query = $db_conn->query('select * from klasy k, nauczyciele n where n.id = k.wychowawca');
foreach($db_query as $row) {
?>
        <div class="content">
            <div><?= $row['pelna_nazwa'] ?></div>
            <div><?= $row['skrot'] ?></div>
            <div><?= $row['rocznik'] ?></div>
            <div><?= $row['imie'].' '.$row['nazwisko'] ?></div>
            <div>
                <a href="index.php?cmd=update&amp;id=<?= $row['id'] ?>">Edytuj</a>
                <a href="index.php?cmd=delete&amp;id=<?= $row['id'] ?>">Usuń</a>
            </div>
        </div>
<?php
}
?>
    </div>
</body>
</html>