<?php
function getNum($val) {
    if(is_numeric($val))
        return $val + 0;
    else
        header('Location: index.php');
}

function getSend($send) {
    if(isset($send)) {
        $send = 'a'.$send;
        switch($send) {
            case 'ateacher':
                if(isset($_GET['cmd']))
                    return aTeacher($_GET['cmd']);
                else {
                    $data = [
                        'imie' => $_POST['imie'],
                        'nazwisko' => $_POST['nazwisko'],
                        'pesel' => $_POST['pesel']
                    ];
                    $db_conn = dbConnect();
                    $sql = 'insert into nauczyciele values (NULL, :imie, :nazwisko, :pesel)';
                    $db_stmt = $db_conn->prepare($sql);
                    $db_stmt->execute($data);
                    $db_conn = null;
                    header('Location: index.php');
                }
            break;
            case 'aeducator':
                if(isset($_GET['cmd']))
                    return aEducator($_GET['cmd']);
                else {
                    $data = [
                        'nauczyciel' => $_POST['wychowawca']
                    ];
                    $db_conn = dbConnect();
                    $sql = 'select * from wychowawcy where nauczyciel = :nauczyciel';
                    $db_stmt = $db_conn->prepare($sql);
                    $db_stmt->execute($data);
                    $wych = $db_stmt->fetchAll();
                    $db_conn = null;
                    if(count($wych) == 0) {
                        $data = [
                            'pelna_nazwa' => $_POST['pelna_nazwa'],
                            'skrot' => $_POST['skrot'],
                            'rocznik' => $_POST['rocznik'],
                            'wychowawca' => $_POST['wychowawca']
                        ];
                        $db_conn = dbConnect();
                        $sql = 'insert into klasy values (NULL, :pelna_nazwa, :skrot, :rocznik, :wychowawca)';
                        $db_stmt = $db_conn->prepare($sql);
                        $db_stmt->execute($data);
                        $id = $db_conn->lastInsertId();
                        $data = [
                            'nauczyciel' => $_POST['wychowawca'],
                            'klasa' => $id
                        ];
                        $sql = 'insert into wychowawcy values(NULL, :nauczyciel, :klasa)';
                        $db_stmt = $db_conn->prepare($sql);
                        $db_stmt->execute($data);
                        $db_conn = null;
                        header('Location: index.php');
                    }
                }
            break;
            case 'astudent':
                if(isset($_GET['cmd']))
                    return aStudent($_GET['cmd']);
                else {
                    $data = [
                        'nauczyciel' => $_POST['wychowawca'],
                        'skrot' => $_POST['klasa']
                    ];
                    $db_conn = dbConnect();
                    $sql = 'select * from klasy where wychowawca = :nauczyciel';
                    $db_stmt = $db_conn->prepare($sql);
                    $db_stmt->execute($data);
                    $class = $db_stmt->fetchAll();
                    $db_conn = null;
                    if(count($class) == 0) {
                        $data = [
                            'imie' => $_POST['imie'],
                            'nazwisko' => $_POST['nazwisko'],
                            'pesel' => $_POST['pesel'],
                            'klasa' => $_POST['klasa'],
                            'wychowawca' => $_POST['wychowawca']
                        ];
                        $db_conn = dbConnect();
                        $sql = 'insert into uczniowie values (NULL, :imie, :nazwisko, :pesel, :klasa, :wychowawca)';
                        $db_stmt = $db_conn->prepare($sql);
                        $db_stmt->execute($data);
                        $db_conn = null;
                        header('Location: index.php');
                    }
                }
            break;
            default:
                echo 'Co robisz dzbanie!';
        }
    }
}
function aTeacher($cmd) {
    if(isset($cmd)) {
        $cmd = 'c'.$cmd;
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
                    $db_conn = dbConnect();
                    $sql = 'update nauczyciele set imie = :imie, nazwisko = :nazwisko, pesel = :pesel where id = :id';
                    $db_stmt = $db_conn->prepare($sql);
                    $db_stmt->execute($data);
                    $db_conn = null;
                    //header('Location: index.php');
                }
                else {
                    $data = [
                        'id' => $_GET['id']
                    ];
                    $db_conn = dbConnect();
                    $sql = 'select imie, nazwisko, pesel from nauczyciele where id = :id';
                    $db_stmt = $db_conn->prepare($sql);
                    $db_stmt->execute($data);
                    return $db_stmt->fetchAll();
                    $db_conn = null;
                    header('Location: index.php');
                }
            break;
            case 'cdelete':
                $data = [
                    'id' => $_GET['id']
                ];
                $db_conn = dbConnect();
                $sql = 'delete from nauczyciele where id = :id';
                $db_stmt = $db_conn->prepare($sql);
                $db_stmt->execute($data);
                $db_conn = null;
                header('Location: index.php');
            break;
            default:
                echo 'Co robisz dzbanie!';
        }
    }
}

function aEducator($cmd) {
    if(isset($cmd)) {
        $cmd = 'c'.$cmd;
        switch($cmd) {
            case 'cupdate':
                $method = $_SERVER['REQUEST_METHOD'];
                if($method == 'POST') {
                    $data = [
                        'pelna_nazwa' => $_POST['pelna_nazwa'],
                        'skrot' => $_POST['skrot'],
                        'rocznik' => $_POST['rocznik'],
                        'wychowawca' => $_POST['wychowawca'],
                        'id' => $_GET['id']
                    ];
                    $db_conn = dbConnect();
                    $sql = 'update klasy set pelna_nazwa = :pelna_nazwa, skrot = :skrot, rocznik = :rocznik, wychowawca = :wychowawca where id = :id';
                    $db_stmt = $db_conn->prepare($sql);
                    $db_stmt->execute($data);
                    $db_conn = null;
                }
                else {
                    $data = [
                        'id' => $_GET['id']
                    ];
                    $db_conn = dbConnect();
                    $sql = 'select pelna_nazwa, skrot, rocznik, wychowawca from klasy where id = :id';
                    $db_stmt = $db_conn->prepare($sql);
                    $db_stmt->execute($data);
                    return $db_stmt->fetchAll();
                    $db_conn = null;
                    header('Location: index.php');
                }
            break;
            case 'cdelete':
                $data = [
                    'id' => $_GET['id']
                ];
                $db_conn = dbConnect();
                $sql = 'delete from klasy where id = :id';
                $db_stmt = $db_conn->prepare($sql);
                $db_stmt->execute($data);

                $sql = 'delete from wychowawcy where klasa = :id';
                $db_stmt = $db_conn->prepare($sql);
                $db_stmt->execute($data);
                $db_conn = null;
                header('Location: index.php');
            break;
            default:
                echo 'Co robisz dzbanie!';
        }
    }
}


function aStudent($cmd) {
    if(isset($cmd)) {
        $cmd = 'c'.$cmd;
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
                    $db_conn = dbConnect();
                    $sql = 'update uczniowie set imie = :imie, nazwisko = :nazwisko, pesel = :pesel, where id = :id';
                    $db_stmt = $db_conn->prepare($sql);
                    $db_stmt->execute($data);
                    $db_conn = null;
                }
                else {
                    $data = [
                        'id' => $_GET['id']
                    ];
                    $db_conn = dbConnect();
                    $sql = 'select imie, nazwisko, pesel from uczniowie where id = :id';
                    $db_stmt = $db_conn->prepare($sql);
                    $db_stmt->execute($data);
                    return $db_stmt->fetchAll();
                    $db_conn = null;
                    header('Location: index.php');
                }
            break;
            case 'cdelete':
                $data = [
                    'id' => $_GET['id']
                ];
                $db_conn = dbConnect();
                $sql = 'delete from uczniowie where id = :id';
                $db_stmt = $db_conn->prepare($sql);
                $db_stmt->execute($data);
                $db_conn = null;
                header('Location: index.php');
            break;
            default:
                echo 'Co robisz dzbanie!';
        }
    }
}
