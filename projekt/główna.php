<!DOCTYPE html>
<?php session_start();
    if (!isset($_SESSION['logging']))
    {
        
        echo '<div class="user-info">';
        include "logowanie.html";
        
        echo "<form method='POST' action='zarejestruj.php'>
                 <input type='submit' value='zarejestruj' name='zarejestruj'>
             </form>";
             echo '</div>';
    }
     else{
        
            echo '<div class="user-info">';
            echo '<a id="mail" value='.$_SESSION["mail"].'>'.$_SESSION["mail"]."<a><br>";
            echo '<a id="imie" value='.$_SESSION['imie'].'>'.$_SESSION['imie']."<a> ";
            echo '<a id="nazwisko" value='.$_SESSION['nazwisko'].'>'.$_SESSION['nazwisko']."<a>";
            $_SESSION['logging']=false;
        echo "<form method='POST' action='wyloguj.php'>
                 <input type='submit' value='wyloguj' name='wyloguj'>
             </form>"; 
             include "raport.html"; 
            echo '</div>';
          
              echo '<div class="flexible">';
              include "wyszukiwanie.html";
             if (isset($_SESSION['termin']))
             {
                 echo "Nabliższy możliwy termin zarezerwowania: ".$_SESSION['termin'];
             }
              echo '</div>';
             
                  
     }
     
     
     ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Document</title>
</head>
<body>
    
<div id="container">
    <div id="header">
        <h1>Witamy w naszym wspaniałym ogrodzie!</h1>
    </div>
        <?php
            $con=mysqli_connect("localhost","root","","projekt");
            $zap="SELECT dzien, miesiac, rok, mail FROM dzien";
            $wynik=mysqli_query($con, $zap);
            while($row=mysqli_fetch_array($wynik))
            {
                $dni=$row['dzien'].":".$row['miesiac'].":".$row['rok'];
                echo("<input type='hidden' value=".$dni." id='zajete'>");
            }
            
            
            mysqli_close($con);

            $plik2=fopen("promocje.txt", "c+");      
            
                while(!feof($plik2))
                {                
                    $str2 = fgets($plik2);
                    $str2 = trim($str2);
                                            
                    if ($str2!="")
                    {                                                                                    
                        echo("<input type='hidden' value=".$str2." id='promocje'>");                                                                                                        
                    }                    
                }
             
            
        ?>
        <table id="calendar">
            <thead>
            <tr>
            <td><button id="prev">←</button></td>
            <td colspan="5" id="calendar_top"></td>
            <td><button id="next">→</button></td>
            </tr><tr><td>pon</td><td>wto</td><td>śr</td><td>czw</td><td>pią</td><td>sob</td><td>nie</td></tr></thead>
            <tbody>
            <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr>
            </tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr>
            </tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr>
            </tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr>
            </tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr>
            </tr><tr><td style="display: none;"></td><td style="display: none;"></td><td style="display: none;"></td><td style="display: none;"></td><td style="display: none;"></td><td style="display: none;"></td><td style="display: none;"></td></tr><tr>
            </tr></tbody>
            </table>
            
            <script src="skrypty.js">

            </script>
            <?php

                $con=mysqli_connect("localhost","root","","projekt");
                $zap="SELECT AVG(ocena) as srednia FROM dzien WHERE ocena BETWEEN 1 AND 10";
                $wynik=mysqli_query($con, $zap);
                $row=mysqli_fetch_array($wynik);
                $srednia=round($row['srednia'],2);
                echo("<a>Średnia ocena naszych usług w skali od 1 do 10 to: $srednia</a><br>");
                echo ("<a href='opinie.php'>Wiecej opinii</a>");
                mysqli_close($con);


                if(isset($_POST['selectedMonth']))
                {
                    // Connect to MySQL database
                    $db = new mysqli('localhost', 'root', '', 'projekt');
                    
                    // Check connection
                    if ($db->connect_error) {
                    die('Connection failed: ' . $db->connect_error);
                    }
                    $selectedDay = $_POST['selectedDay'];
                    $selectedMonth = $_POST['selectedMonth'];
                    $selectedYear = $_POST['selectedYear'];
                    $email = $db->real_escape_string($_POST['email']);
                    $imie = $db->real_escape_string($_POST['imie']);
                    $nazwisko =$db->real_escape_string($_POST['nazwisko']);

                    if (!isset($_POST['cena']))
                    {
                        $sql = "INSERT INTO kolejka (dzien, miesiac, rok, mail) VALUES ($selectedDay, $selectedMonth, $selectedYear, '$email')";
                        if ($db->query($sql) === TRUE) 
                        {
                            echo "Added to queue successfully";
                        } else 
                        {
                            echo "Error adding to queue: " . $db->error;
                        }
                    }
                    else
                    {
                        

                        // Get selected day from POST request
                        
                        $cena = $_POST['cena'];
                        

                        // Insert selected day into the database
                        $sql = "INSERT INTO dzien (dzien, miesiac, rok, mail, imie, nazwisko, cena) VALUES ($selectedDay, $selectedMonth, $selectedYear, '$email', '$imie', '$nazwisko', $cena)";
                        if ($db->query($sql) === TRUE) {
                        echo "Day inserted successfully";
                        } else {
                        echo "Error inserting day: " . $db->error;
                        }
                        
                    }
                    

                    // Close database connection
                    $db->close();
                    
                } 
         
            ?>
    <div class="overflow-container">
            <table>
            <?php
            abstract class mail {
                abstract function getmail();
            }
            trait sprawdz_czy_widac{
                function sprawdzam(){
                    echo "widoczny";
                }
            }
        
            interface dostan{
                function setmail($mail);
                function getimie();
                function getnazwisko();
            }
        
            class User extends mail implements dostan{
                use sprawdz_czy_widac;
                public $imie="";
                public $nazwisko="";
                public $mail="";
                function __construct($imie, $nazwisko, $mail){
                    $this->imie=$imie;
                    $this->nazwisko=$nazwisko;
                    $this->mail=$mail;
                }
                function setmail($mail){
                    $this->mail=$mail;
                }
                function setimie($imie){
                    $this->imie=$imie;
                }
                function setnazwisko($nazwisko){
                    $this->nazwisko=$nazwisko;
                }
                function getimie(){
                    return $this->imie;
                }
                function getnazwisko(){
                    return $this->nazwisko;
                }
                function getmail(){
                    return $this->mail;
                }
            }
        
            $user = new User("", "", "");
            

                function notifyQueue($id) {
                    $db = new mysqli('localhost', 'root', '', 'projekt');
                    
                    if ($db->connect_error) {
                        die('Connection failed: ' . $db->connect_error);
                    }
                    $zap9 = "SELECT dzien, miesiac, rok FROM dzien WHERE id='$id'";
                    $result = $db->query($zap9);
                    $row = $result->fetch_assoc();
                    $dzien = $row['dzien'];
                    $miesiac = $row['miesiac'];
                    $rok = $row['rok'];
                
                    $sql = "SELECT mail FROM kolejka WHERE dzien='$dzien' AND miesiac='$miesiac' AND rok='$rok'";
                    $result = $db->query($sql);
                    $sql = "DELETE FROM kolejka WHERE dzien=$dzien AND miesiac=$miesiac AND rok=$rok";
                    $db->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $to = $row['mail'];
                            $subject = "Termin zwolniony";
                            $message = "Zwolnił się termin: $dzien-$miesiac-$rok.";
                            $headers = "From: klemensmandzaro@gmail.com";
                
                            mail($to, $subject, $message, $headers);
                            
                        }
                    }
                    //nie działa ale jakbym dał hosting to by działało, ważne żeby wiedział że wiem co jest 5
                
                    
                
                    $db->close();
                }

            if (isset($_SESSION['logging']))
            {
                $user->setmail($_SESSION['mail']);
                $user->setimie($_SESSION['imie']);
                $user->setnazwisko($_SESSION['nazwisko']);
                $mail= $user->getmail();
                $con=mysqli_connect("localhost","root","","projekt");
                if ($mail=="kamil.klemiato@wp.pl")
                {
                    $zap="SELECT id, dzien, miesiac, rok, mail, cena, ocena, opinia FROM dzien";
                    $wynik=mysqli_query($con, $zap);
                    while($row=mysqli_fetch_array($wynik))
                    {
                        if (!((date("d")>$row['dzien'] && date("m")==$row['miesiac'] && date("Y")==$row['rok']) || (date("m")>$row['miesiac'] && date("Y")==$row['rok']) || date("Y")>$row['rok']))
                        {
                            echo "<tr><td>";
                            echo("$row[id](id) $row[dzien].$row[miesiac].$row[rok] - $row[mail] - $row[cena]zł</td>");
                            echo "<td><button onclick='deleteDay({$row['id']})'>usun</button></td>";
                            echo "<td><button onclick='editDay({$row['id']})'>edytuj</button></td>";
                            echo "<td><button onclick='editcena({$row['id']})'>zmien_cene</button></td></tr>";
                            
                        }
                        else
                        {
                            echo "<tr><td>";
                            echo("$row[id](id) $row[dzien].$row[miesiac].$row[rok] - $row[mail] - $row[cena]zł - $row[ocena] - $row[opinia]</td>");
                            echo "<td><button onclick='deleteDay({$row['id']})'>usun</button></td>";
                            echo "<td><button onclick='editDay({$row['id']})'>edytuj</button></td>";
                            echo "<td><button onclick='editcena({$row['id']})'>zmien_cene</button></td>";
                            echo "<td><button onclick='Ocena({$row['id']})'>oceń</button></td></tr>";
                            
                        }   
                        

                    }
                }
                else
                {
                    $zap="SELECT id, dzien, miesiac, rok, mail, cena, ocena, opinia FROM dzien WHERE mail='".$mail."'";
                    $wynik=mysqli_query($con, $zap);
                    while($row=mysqli_fetch_array($wynik))
                    {
                        if (!((date("d")>$row['dzien'] && date("m")==$row['miesiac'] && date("Y")==$row['rok']) || (date("m")>$row['miesiac'] && date("Y")==$row['rok']) || date("Y")>$row['rok']))
                        {
                            echo "<tr><td>";
                            echo("$row[dzien].$row[miesiac].$row[rok] - $row[cena]zł</td>");
                            echo "<td><button onclick='deleteDay({$row['id']})'>usun</button></td>";
                            echo "<td><button onclick='editDay({$row['id']})'>edytuj</button></td></tr>";
                            
                        }
                        else
                        {
                            echo "<tr><td>";
                            echo("$row[dzien].$row[miesiac].$row[rok] - $row[cena]zł - $row[ocena] - $row[opinia]</td>");
                            echo "<td><button onclick='deleteDay({$row['id']})'>usun</button></td>";
                            echo "<td><button onclick='editDay({$row['id']})'>edytuj</button></td>";
                            echo "<td><button onclick='Ocena({$row['id']})'>oceń</button></td></tr>";
                        } 

                    }
                }
                
            }
            if (isset($_POST['delete_person_id']))
                {
                    $db = new mysqli('localhost', 'root', '', 'projekt');
                    echo 'ppp';
                    // Check connection
                    if ($db->connect_error) {
                    die('Connection failed: ' . $db->connect_error);
                    }

                    // Get selected day from POST request
                    
                    $PersonIdToDelete = $db->real_escape_string($_POST['delete_person_id']);
                    
                    notifyQueue($PersonIdToDelete);
                    // Insert selected day into the database
                    $zap9="DELETE FROM dzien WHERE id='$PersonIdToDelete'";
                    if ($db->query($zap9) === TRUE) {
                    echo "Day inserted successfully";
                    } else {
                    echo "Error inserting day: " . $db->error;
                    }

                    // Close database connection
                    $db->close();
                }

            

                if (isset($_POST['edit_person_id']) && isset($_POST['innydzien']) && isset($_POST['innymiesiac'])) {
                    $PersonIdToEdit = (int)$_POST['edit_person_id'];
                    $innydzien = (int)$_POST['innydzien'];
                    $innymiesiac = (int)$_POST['innymiesiac'];
                    $cena = (int)$_POST['innacena'];
                    $con = mysqli_connect("localhost", "root", "", "projekt");

                    $zap = "SELECT COUNT(dzien) as ile FROM dzien WHERE miesiac='$innymiesiac' AND dzien='$innydzien'";
                    $wynik=mysqli_query($con, $zap);

                    while($row=mysqli_fetch_array($wynik))
                    {
                        if ($row['ile']>0)
                        {
                            echo '<script>alert("Termin zajęty nie możesz na niego zmienić")</script>';
                        }  
                        else
                        {
                            $zap2 = "UPDATE dzien SET dzien='$innydzien', miesiac='$innymiesiac', cena='$cena' WHERE id='$PersonIdToEdit'";
                            if (mysqli_query($con, $zap2)) {
                                echo "Day edited successfully";
                            } else {
                                echo "Error editing day: " . mysqli_error($con);
                            }
                        }                     
                    }

                    
                
                
                }

                if (isset($_POST['Ocena_id']))
                {
                    $id=$_POST['Ocena_id'];
                    $ocena=$_POST['Ocena'];
                    $opinia=$_POST['Opinia'];
                    $con = mysqli_connect("localhost", "root", "", "projekt");
                    $zap2 = "UPDATE dzien SET ocena='$ocena', opinia='$opinia' WHERE id='$id'";
                    if (mysqli_query($con, $zap2)) {
                        echo "Day edited successfully";
                    } else {
                        echo "Error editing day: " . mysqli_error($con);
                    }

                }

                if (isset($_POST["edit_cena_id"]))
                {
                    $id = $_POST["edit_cena_id"];
                    $cena = $_POST["innacena"];
                    $con = mysqli_connect("localhost", "root", "", "projekt");
                    $zap2 = "UPDATE dzien SET cena='$cena' WHERE id='$id'";
                    if (mysqli_query($con, $zap2)) {
                        echo "Day edited successfully";
                    } else {
                        echo "Error editing day: " . mysqli_error($con);
                    }
                }


                
                

                //dodac inne ceny w innych okresach zeby dodac kryteria wyszukiwania oraz np przedzialy czasowe
                // raport to zeby dostawal uzytkownik np pdf albo na stronie 
            ?>
            </table>
            </div>
            <a>Kontakt telefoniczny: 123-456-789</a><br>
            <a>Adres e-mail: 0FtZI@example.com</a>
</div>  
</body>
</html>