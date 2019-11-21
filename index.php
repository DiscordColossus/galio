<?php
/*
Plik wymagany.
Jeśli nie istnieje, wystąpi bład krytyczny.
Serwer przerwie ładowanie strony.
*/
require_once('database.php');
include('functions.php');
if(isset($_GET['send']))
    ${$_GET['send']} = getSend($_GET['send']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
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
$db_conn = dbConnect();
$db_query = $db_conn->query('select * from nauczyciele');
foreach($db_query as $row) {
?>
        <div class="content">
            <div><?= $row['imie'] ?></div>
            <div><?= $row['nazwisko'] ?></div>
            <div><?= $row['pesel'] ?></div>
            <div>
                <a href="index.php?send=teacher&amp;cmd=update&amp;id=<?= $row['id'] ?>">Edytuj</a>
                <a href="index.php?send=teacher&amp;cmd=delete&amp;id=<?= $row['id'] ?>">Usuń</a>
            </div>
        </div>
<?php
$db_conn = null;
}
?>
    </div>
    <div class="list" id="klasy">
        <div class="title">Klasy</div>
        <form action="index.php?send=educator" method="post">
            <input name="pelna_nazwa" value="<?= (isset($educator[0]['pelna_nazwa'])) ? ($educator[0]['pelna_nazwa']) : ('') ?>" type="text">
            <input name="skrot" value="<?= (isset($educator[0]['skrot'])) ? ($educator[0]['skrot']) : ('') ?>" type="text">
            <input name="rocznik" value="<?= (isset($educator[0]['rocznik'])) ? ($educator[0]['rocznik']) : ('') ?>" type="text">
            <select name="wychowawca" id="wychowawca">
                <option value=""></option>
<?php
$db_conn = dbConnect();
$db_query = $db_conn->query('select n.id, n.imie, n.nazwisko from nauczyciele n where n.id not in (select nauczyciel from wychowawcy)');
foreach($db_query as $row) {
?>
                <option value="<?= $row['id'] ?>"><?= $row['imie'].' '.$row['nazwisko'] ?></option>
<?php
$db_conn = null;
}
?>
            </select>
            <input type="submit" value="Zapisz">
        </form>
<?php
$db_conn = dbConnect();
$db_query = $db_conn->query('select k.*, n.imie, n.nazwisko from klasy k, nauczyciele n where n.id = k.wychowawca');
foreach($db_query as $row) {
?>
        <div class="content">
            <div><?= $row['pelna_nazwa'] ?></div>
            <div><?= $row['skrot'] ?></div>
            <div><?= $row['rocznik'] ?></div>
            <div><?= $row['imie'].' '.$row['nazwisko'] ?></div>
            <div>
                <a href="index.php?send=educator&amp;cmd=update&amp;id=<?= $row['id'] ?>">Edytuj</a>
                <a href="index.php?send=educator&amp;cmd=delete&amp;id=<?= $row['id'] ?>">Usuń</a>
            </div>
        </div>
<?php
$db_conn = null;
}
?>
    </div>
</body>
</html>