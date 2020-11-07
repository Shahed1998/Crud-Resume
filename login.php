<?php
    require_once "pdo.php";
    session_start();

    if(isset($_POST['login'])){
        $salt =  'XyZzy12*_';
        $check = hash('md5', $salt.$_POST['pass']);
        $stmt = $pdo->prepare('SELECT user_id, name FROM users
                    WHERE email = :em AND password = :pw');
        $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
   

        if ( $row !== false ) {
          $_SESSION['name'] = $row['name'];
          $_SESSION['user_id'] = $row['user_id'];
          // Redirect the browser to index.php
          header("Location: index.php");
          return;
        }else{
            $_SESSION['error'] = "Incorrect Password";
            header('Location: login.php');
            return;
        }
    }
    

    if(isset($_POST['cancel'])){
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
    <?php
        if(isset($_SESSION['error'])){
            echo "<p style=color:red>";
            print_r($_SESSION['error']);
            unset($_SESSION['error']);
            echo "</p>";
        }
        
    ?>
    <form method="POST">
        <label for="email">Email:</label><br>
        <input type="text" name="email" id="email"><p></p>
        <label for="password">Password:</label><br>
        <input type="password" name="pass" id="pass"><p></p>
        <input type="submit" name="login" value="Log In" onclick="return doValidate()">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <script>
        function doValidate(){
            var email = document.getElementById('email').value;
            var pass = document.getElementById('pass').value;
            if(email.length<1 || pass.length<1){
                alert('All fields are required');
                return false;
            }else{
                var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                if(email.match(mailformat)){
                    return true;
                }else{
                    alert('Invalid email address');
                    return false;
                }

            }
            
        }
    </script>
</body>
</html>
