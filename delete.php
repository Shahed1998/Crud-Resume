<?php
    session_start();
    require_once 'pdo.php';

    if(empty($_SESSION['name'])){
        die('Name parameter missing');
        header('Location:index.php');
        return;
    }

    if(isset($_POST['cancel'])){
        header('Location:index.php');
        return;
    }

    $stmt = $pdo->prepare("SELECT * FROM profile WHERE profile_id = :xyz");
    $stmt->execute(array(':xyz'=>$_GET['profile_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $fname = $row['first_name'];
    $lname = $row['last_name'];

    if(isset($_POST['delete'])){

        $stmt = $pdo->prepare('DELETE FROM profile WHERE profile_id=:xyz');
        $stmt->execute(array(
            ':xyz'=>$_GET['profile_id']
        ));
        $_SESSION['success']="Deleted successfully";
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
    <h1>Deleting profile</h1>
    <p>
        First name : <?=$fname?>
    </p>
    <p>
        Last name : <?=$lname?>
    </p>
    <form method="POST">
        <input type="submit" value="Delete" name="delete">
        <input type="submit" value="Cancel" name="cancel">
    </form>
</body>
</html>