<?php
    session_start();
    require_once 'pdo.php';

    if(isset($_POST['cancel'])){
        header('Location:index.php');
        return;
    }
   
    if(empty($_SESSION['name'])){
        die('Name parameter missing');
        header('Location:index.php');
        return;
    }else{
        $name = $_SESSION['name'];
    }

    $stmt = $pdo->prepare("SELECT * FROM profile WHERE profile_id = :xyz");
    $stmt->execute(array(':xyz'=>$_GET['profile_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $fname = $row['first_name'];
    $lname = $row['last_name'];
    $email = $row['email'];
    $headline = $row['headline'];
    $summary = $row['summary'];

    if(isset($_POST['save'])){
        $stmt = $pdo->prepare('UPDATE profile SET first_name = :fname,last_name = :lname,
                email = :email,headline=:headline,summary=:summary WHERE profile_id=:xyz');
        $stmt->execute(array(
            ':xyz'=>$_GET['profile_id'],
            ':fname'=>$_POST['first_name'],
            ':lname'=>$_POST['last_name'],
            ':email'=>$_POST['email'],
            ':headline'=>$_POST['headline'],
            ':summary'=>$_POST['summary']

        ));
        $_SESSION['success']="Profile updated successfully ";
        header('Location:index.php');
        return;
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>78a01b29</title>
</head>
<body>
    <h1>Editing profile for <?=$name ?></h1>
    <p>
        <form method="POST">
        <label for="fname">First name :</label><br>
        <input type="text" name="first_name" id="fname" value="<?=$fname?>"><br><br>
        <label for="lname">Last name :</label><br>
        <input type="text" name="last_name" id="lname" value="<?=$lname?>"><br><br>
        <label for="email">Email :</label><br>
        <input type="text" name="email" id="email" value="<?=$email?>"><br><br>
        <label for="headline">Headline :</label><br>
        <input type="text" name="headline" id="headline" size=50 value="<?=$headline?>"><br><br>
        <label for="comment">Comment :</label><br>
        <textarea name="summary" id="summary" cols="80" rows="8" ><?=$summary?></textarea><br><br>
        <input type="submit" value="Save" name="save">
        <input type="submit" value="Cancel" name="cancel">
        </form>
    </p>
    
</body>
</html>
