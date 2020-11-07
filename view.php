<?php
    require_once 'pdo.php';
    $stmt = $pdo->prepare("SELECT * FROM profile WHERE profile_id = :xyz");
    $stmt->execute(array(':xyz'=>$_GET['profile_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $fname = $row['first_name'];
    $lname = $row['last_name'];
    $email = $row['email'];
    $headline = $row['headline'];
    $summary = $row['summary'];

    if(isset($_POST['done'])){
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
     <p>
        First name : <?=$fname?>
    </p>
    <p>
        Last name : <?=$lname?>
    </p>
    <p>
        Email : <?=$email?>
    </p>
    <p>
        Headline : <?=$headline?>
    </p>
    <p>
        Summary : <?=$summary?>
    </p>

    <form method="POST">
        <input type="submit" value="Done" name="done">
    </form>
    
</body>
</html>