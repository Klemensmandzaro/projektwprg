<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        session_start();
        $_SESSION['logging']=false;
        unset($_SESSION['logging']);
         session_destroy();
         setcookie(session_name(),"",time()-360);
         header ("location:główna.php");
         
    ?>
</body>
</html>