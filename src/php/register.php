<?php
header("Content-type: text/html; charset=utf-8");
$username = $_POST['username'];
$password = $_POST['password'];
$repassword = $_POST['repassword'];
$email = $_POST['email'];
if(!preg_match("/^[a-zA-Z][a-zA-Z0-9_\.]{4,20}$/",$username)){
    echo '<script>alert("Illegal username. Username should start with a character and limited within 5-15 characters.");
    history.go(-1);
    document.getElementById("username").value=" ";</script>';
    exit(0);
}
if(!preg_match("/^[a-zA-Z0-9]*[\w\.-]*[a-zA-Z0-9]*@([a-zA-Z0-9]*\.)+[a-zA-Z]{2,4}$/",$email)){
    echo '<script>alert("Invalid email.");history.go(-1);</script>';
    exit(0);
}
if (preg_match("/^[0-9]{0,6}$/",$password) || preg_match("/^[a-zA-Z]{0-6}$/",$password)){
    echo '<script>alert("The password is too weak.");history.go(-1);</script>';
    exit(0);
}
if ($password != $repassword){
    echo '<script>alert("The password confirmed doesn‘t match.");history.go(-1);</script>';
    exit(0);
}
if($password == $repassword){
    $conn = new mysqli('localhost','Elaine','IamElaineee','travel');
    if ($conn->connect_error){
        echo 'Failed database connection.';
        exit(0);
    }else {
        $sql = "select UserName from traveluser where UserName = '$_POST[username]'";
        $result = $conn->query($sql);
        $number = mysqli_num_rows($result);
        if ($number) {
            echo '<script>alert("The username already exists.");history.go(-1);</script>';
        } else {
            $sql_insert = "insert into traveluser (Email,UserName,Pass) values('$_POST[email]','$_POST[username]','$_POST[password]')";
            $res_insert = $conn->query($sql_insert);
            if ($res_insert) {
                echo '<script>window.location="../login.html";</script>';
            } else {
                echo "<script>alert('Loading...Please wait.');</script>";
            }
        }
    }
}else{
    echo "<script>alert('Register unsuccessful.'); history.go(-1);</script>";
}
?>

