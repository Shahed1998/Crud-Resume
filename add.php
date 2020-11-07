<?php
    session_start();
    require_once 'pdo.php';

    if(! isset($_SESSION['name'])){
        die('Name parameter missing');
        header('Location:index.php');
        return;
    }else{
        $name = $_SESSION['name'];
    }

    if(isset($_POST['cancel'])){
        header("Location: index.php");
        return;
    }

    if(isset($_POST['add'])){
        if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['headline']) || empty($_POST['summary'])){
            $_SESSION['error']="All fields are required";
            header('Location: add.php');
            return;
        }else{
             $email = $_POST['email'];
             if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Email must have an at-sign (@)";
                header("Location:add.php");
                return;
            }

            $stmt = $pdo->prepare('INSERT INTO Profile
            (user_id, first_name, last_name, email, headline, summary)
            VALUES ( :uid, :fn, :ln, :em, :he, :su)');
            $stmt->execute(array(
                ':uid' => $_SESSION['user_id'],
                ':fn' => $_POST['first_name'],
                ':ln' => $_POST['last_name'],
                ':em' => $_POST['email'],
                ':he' => $_POST['headline'],
                ':su' => $_POST['summary'])
            );
            $_SESSION['success'] = "added";
            header('Location: index.php');
            return;
        }
    }else{
        echo "";
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

    <?php
        if(isset($_SESSION['error'])){
            echo "<p style=color:red>";
            print_r($_SESSION['error']);
            unset($_SESSION['error']);
            echo "</p>";
        }else{
            echo "";
        }
    ?>

    <h1>Adding Profile for <?=$name?> </h1>
    <p>
        <form method="POST">
        <label for="fname">First name :</label><br>
        <input type="text" name="first_name" id="fname"><br><br>
        <label for="lname">Last name :</label><br>
        <input type="text" name="last_name" id="lname"><br><br>
        <label for="email">Email :</label><br>
        <input type="text" name="email" id="email"><br><br>
        <label for="headline">Headline :</label><br>
        <input type="text" name="headline" id="headline" size=50><br><br>
        <label for="comment">Comment :</label><br>
        <textarea name="summary" id="summary" cols="80" rows="8"></textarea><br><br>
        <input type="submit" value="Add" name="add">
        <input type="submit" value="Cancel" name="cancel">
        </form>
    </p>

    
</body>
</html>