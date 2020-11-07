<?php
    session_start();
    require_once 'pdo.php';

    $newEntry = "";
    if(! isset($_SESSION['name'])){
          $anchor =  "<a href='login.php'>Please log in</a>";
    }else{
          $anchor = "<a href='logout.php'>Logout</a>";
          $newEntry = '<a href="add.php">Add New Entry</a>';
          
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
  
    <h1>Shahed Chowdhury's resume registry</h1>

      <p style='color:green'>
        <?php 
            if(isset($_SESSION['success'])){
                print_r($_SESSION['success']);
                unset($_SESSION['success']);
            }
        ?>
    </p>

    <p>
      <?=$anchor ?>
    </p>
    <p>
        <?=$newEntry?>
    </p>

    <?php 
        echo "<table border='1'>";
            echo "<tr><th>Name</th><th>Headline</th>";
            if(isset($_SESSION['name'])){
                echo "<th>Action</th></tr>";
            }
            
            $stmt = $pdo->query('SELECT profile_id,user_id,first_name,last_name,headline FROM profile ');
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $profile_id = $row['profile_id'];
                echo "<tr><td><a href='view.php?profile_id=$profile_id'".$row['profile_id'].">".htmlspecialchars($row['first_name'])." ".htmlspecialchars($row['last_name'])."</a></td>" ;
                echo "<td>".htmlspecialchars($row['headline'])."</td>";
               if(isset($_SESSION['name']) && isset($_SESSION['user_id'])){
                   if($_SESSION['user_id'] == $row['user_id']){
                        echo "<td><a href='edit.php?profile_id=$profile_id'>Edit/</a>";
                        echo "<a href='delete.php?profile_id=$profile_id'>Delete</a>";
                   }
                    
               }
               echo "</tr>";
            }
            

        echo "</table>";


    ?>
    
   
</body>
</html>
