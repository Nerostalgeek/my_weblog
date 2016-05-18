<?php

/*function PDOConnector($dbname, $unix, $user, $pass = '')
{
    try
    {
        $db = new PDO('mysql:unix_socket=/home/' . $unix . '/.mysql/mysql.sock;dbname=' . $dbname, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
    }

    catch (Exception $e)
    {
        die($e->getMessage());

    }
}

$DB = PDOConnector('weblog', 'delpue_m', 'root'); //Pour Blinux a mettre en commentaire quand tu testes NE PAS EFFACER FUNCTION AU DESSUS*/
$DB = new PDO('mysql:host=localhost;dbname=weblog', 'root', 'root');

?>