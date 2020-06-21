<?php
header("Content-type: text/html; charset=utf-8");
require_once("config.php");
try {

    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $id='';
    //username login
    $sql = "select * from traveluser where UserName=:user and Pass=:pass";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user', $_POST['username']);
    $statement->bindValue(':pass', $_POST['password']);
    $statement->execute();

    //email login
    $sql2 = "select * from traveluser where Email=:user and Pass=:pass";
    $statement2 = $pdo->prepare($sql2);
    $statement2->bindValue(':user', $_POST['username']);
    $statement2->bindValue(':pass', $_POST['password']);
    $statement2->execute();

    if ($statement->rowCount() > 0 || $statement2->rowCount() > 0) {
        //if($statement->execute()){$row=$statement->fetch();$id=$row['UID'];}
        //if($statement2->execute()){$row=$statement2->fetch();$id=$row['UID'];}
        setcookie("username", $_POST['username'], time()+60*60*24);
        //setcookie("id",$id, time()+60*60*24);//有误
        header("Location:index.php");
        //echo '<script>window.location="../Home.php";</script>';
    } else {
        echo '<script>alert("Incorrect username or password.");history.go(-1);</script>';
    }
}catch (PDOException $e){
    die($e -> getMessage());
}

?>

