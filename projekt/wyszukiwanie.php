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
    $cena=array(0,100,100,200,200,100,600,100,500,200,200,100,100);
    $tyle=0;
    $ile=$_POST['wyszukiwanie'];
    
    if (gettype($ile)=="text")
    {
        $_SESSION['termin']="blad";
                header ("location:główna.php");
                exit();
    }
    
    $con = mysqli_connect("localhost", "root", "", "projekt");  
    $data=date("Y-m-d");
    $data=date( 'Y-m-d', strtotime( $data .' +1 day' ));
    $dzien=date("j", strtotime($data));
    $miesiac=date("n", strtotime($data));
    
    if ($_POST['opcja']==1)
    {
        while($tyle!=$ile)
        {
            $zap = "SELECT COUNT(dzien) as ile FROM dzien WHERE miesiac=$miesiac AND dzien=$dzien";
            $wynik=mysqli_query($con, $zap);
            while($row=mysqli_fetch_array($wynik))
            {
                if ($row['ile']>0 || $row['ile']==NULL)
                {
                    
                    $tyle=0;
                    $data=date( 'Y-m-d', strtotime( $data .' +1 day' ));
                    $dzien=date("d", strtotime($data));
                    $miesiac=date("m", strtotime($data));
                    //var_dump($row['ile']);
                }  
                else
                {
                    $tyle++;
                    $data=date( 'Y-m-d', strtotime( $data .' +1 day' ));
                    $dzien=date("d", strtotime($data));
                    $miesiac=date("m", strtotime($data));
                    //var_dump($row['ile']);
                }
            } 
        }
        $data=date( 'Y-m-d', strtotime( $data .' -'.$ile.' day' ));
        echo "Nabliższy możliwy termin zarezerwowania: ".$data;
        $_SESSION['termin']=$data;
        header ("location:główna.php");
    }
    else
    {   
        if($ile<100)
            {
                $_SESSION['termin']="nie ma w takiej cenie";
                header ("location:główna.php");
                exit();
            }
        

        while($tyle==0)
        {
            while($ile<$cena[$miesiac])
        {
            $data=date( 'Y-m-d', strtotime( $data .' +1 month' ));
            var_dump($dzien);
            var_dump($data);
            
            $dzien=date("j", strtotime($data));
            
            if ($dzien!=1)
            {
                $data=date('Y-m-j', strtotime($data .' -'.($dzien-1).' day' ));
            }
            $miesiac=date("n", strtotime($data));
            
        }
            $zap = "SELECT COUNT(dzien) as ile FROM dzien WHERE miesiac=$miesiac AND dzien=$dzien";
            $wynik=mysqli_query($con, $zap);
            while($row=mysqli_fetch_array($wynik))
            {
                if ($row['ile']>0 || $row['ile']==NULL)
                {
                    
                    $tyle=0;
                    $data=date( 'Y-m-d', strtotime( $data .' +1 day' ));
                    $dzien=date("d", strtotime($data));
                    $miesiac=date("m", strtotime($data));
                    //var_dump($row['ile']);
                }  
                else
                {
                    $tyle++;
                    $data=date( 'Y-m-d', strtotime( $data .' +1 day' ));
                    $dzien=date("d", strtotime($data));
                    $miesiac=date("m", strtotime($data));
                    //var_dump($row['ile']);
                }
            } 
        }
        
        $data=date( 'Y-m-d', strtotime( $data .' -1 day' ));
        echo "Nabliższy możliwy termin zarezerwowania: ".$data;
        $_SESSION['termin']=$data;
        header ("location:główna.php");
    }
    ?>
</body>
</html>