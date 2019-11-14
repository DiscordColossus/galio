<?php
function getNum($val) {
    if(is_numeric($val))
        return $val + 0;
    else
        header('Location: index.php');
}