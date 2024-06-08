<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
            td{
                border: 1px solid black;
                text-align: center;
                width: 9%;
                height: 5%;
            }
    </style>
    <title>Document</title>
</head>
<body>
    
    <div>
    
        <?php
            
            if (isset($_POST['zaloguj']))
            {
                include 'logowanie.php';
                session_destroy();
                if ($_SESSION['logging']==false)
                {
                    echo '<form method="POST">
                
                    <input type="submit" name="zarejestruj" value="zarejestruj">
                    </form>';
                }
                
            }
            else if (isset($_POST['zarejestruj']))
            {
                include 'zarejestruj.php';
                echo '<form method="POST">
                <input type="submit" name="zaloguj" value="zaloguj">
                
            </form>';
                
            }
            else
            {
                
                $_SESSION['logging']=false;
                echo '<form method="POST">
                <input type="submit" name="zaloguj" value="zaloguj">
                <input type="submit" name="zarejestruj" value="zarejestruj">
            </form>';
            }
            

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
            <script>

            var aMonths = new Array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
            var date    = new Date();
            var date1    = new Date();

            Calendar();

            document.querySelector('#prev').addEventListener('click',PrevMonth);
            document.querySelector('#next').addEventListener('click',NextMonth);
            

            function PrevMonth(){
            
                document.getElementById("prev").disabled=false;
                date = new Date(date.getFullYear(), date.getMonth() - 1, 1);
                Calendar();
                
            }
            
            

            function NextMonth(){
            document.getElementById("prev").disabled=false;
            date = new Date(date.getFullYear(), date.getMonth() + 1, 1);
            Calendar();
            }

            function Calendar(){
            if (date.getFullYear()==date1.getFullYear() && date.getMonth()==date1.getMonth())
            {
                document.getElementById("prev").disabled=true;
            }
            const   td       = document.querySelectorAll('#calendar tbody td');
            const   firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            const   lastDay  = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            const   day      = firstDay.getDay() ? firstDay.getDay()-1 : 6;
            const dnizaj=[];
            const zajeteInput = document.querySelectorAll('#zajete');
            for (let i = 0; i < zajeteInput.length; i++)
            {
                const zajete = zajeteInput[i].value.split(",");
            
            
                console.log(zajete);
                
                for (let j = 0; j < zajete.length; j++) 
                {
                    const tab = zajete[j].split(":");
                    console.log(tab);
                    const mon = parseInt(tab[1]);
                    
                    if (mon==(date.getMonth()+1))
                    {
                        dnizaj.push(parseInt(tab[0]));
                        
                    }

                }
            }
            console.log(date1.getDate());
            

            document.querySelector('#calendar_top').innerHTML = aMonths[date.getMonth()] + ' ' + date.getFullYear();
            
            let dzien = 1;
            for (let i = 0; i < td.length; i++) {
            td[i].innerHTML = (i >= day && dzien <= lastDay.getDate())
                ? '<button id="btnDzien-' + i + '" value="' + dzien + '" onclick="getSelectedDay(this)">' + (dzien++) + '</button>' // Use dzien+1 to display actual day
                : '';
                if (dnizaj.includes(dzien-1)) {
                            document.getElementById("btnDzien-"+i).style.backgroundColor = "red";
                        }
                if (dzien-1<=date1.getDate() && i>=day && date.getFullYear()==date1.getFullYear() && date.getMonth()==date1.getMonth())
                {
                    
                    document.getElementById("btnDzien-"+i).disabled=true;
                    document.getElementById("btnDzien-"+i).style.backgroundColor = "lightgrey";
                    
                }
            if (i >= 35) td[i].style.display = (day + dzien - 1 < 36) ? 'none' : ''; // hiding last row
            }
            }

                function getSelectedDay(button) {
                    const selectedDay = parseInt(button.value);
                    const kolor = button.style.backgroundColor;
                    const selectedMonth = date.getMonth();
                    const selectedYear = date.getFullYear();
                    const email=document.getElementById("mail").innerHTML;
                    if (kolor=="red")
                    {
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'główna.php');
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            if (xhr.status === 200) 
                            {
                                console.log('Day and month sent to server:', selectedDay, selectedMonth+1, kolor);
                            } 
                            else 
                            {
                                console.error('Error sending day and month:', xhr.statusText);
                            }
                        };
                        xhr.send('selectedDay=' + selectedDay + '&selectedMonth=' + (selectedMonth+1) + '&selectedYear=' + selectedYear + '&email=' + encodeURIComponent(email));
                        
                        setTimeout("location.reload()",150);
                    }
                    else
                    {
                        // You can now use the selectedDay variable for further processing
                        console.log("Selected Day:", selectedDay);
                        
                        console.log(email);
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'główna.php');
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            if (xhr.status === 200) 
                            {
                                console.log('Day and month sent to server:', selectedDay, selectedMonth+1);
                            } 
                            else 
                            {
                                console.error('Error sending day and month:', xhr.statusText);
                            }
                        };

                        const promocje = document.querySelectorAll('#promocje');
                        let promo = prompt("Podaj kod promocyjny (jeśli posiadasz):");
                        let czypromo = 0;
                        
                        if (promo != null && promo!="")
                        {
                            for (let i=0; i< promocje.length; i++)
                            {
                                const promo2 = promocje[i].value;
                                const promo3 = promo2.split(";");
                                console.log(promo3[0]);
                                if (promo3[0]==promo)
                                {
                                    czypromo=promo3[1];
                                }
                            }
                        }
                        
                        const cena=100-czypromo;
                        const zapłata = prompt("Twoja zapłata wynosi "+cena+" złotych, zgadzasz się?(Wpisz tak lub nie)");
                        if (zapłata=="tak")
                        {
                            xhr.send('selectedDay=' + selectedDay + '&selectedMonth=' + (selectedMonth+1) + '&selectedYear=' + selectedYear + '&email=' + encodeURIComponent(email) + '&cena=' + cena);
                        
                            setTimeout("location.reload()",150);
                        }
                    }
                    
                    
                


                
                
            }
                    
                    
            function deleteDay(id) {
            
            
            const xhr = new XMLHttpRequest();
                xhr.open('POST', 'główna.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log('Day and month sent to server:', id);
                    } else {
                        console.error('Error sending day and month:', xhr.statusText);
                    }
                };
                xhr.send('delete_person_id=' + id);
                setTimeout("location.reload()",150);
        }

        function editDay(id) {
            const innydzien = prompt("Podaj inny dzień:");
            const innymiesiac = prompt("Podaj inny miesiąc:");

            if (innydzien && innymiesiac) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'główna.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        console.log('Day edited successfully');
                        location.reload();
                    } else {
                        console.error('Error editing day:', xhr.statusText);
                    }
                };
                xhr.send('edit_person_id=' + id + '&innydzien=' + innydzien + '&innymiesiac=' + innymiesiac);
                setTimeout("location.reload()",150);
            }
        }
                
                

            </script>
            <?php
                
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
                        $sql = "INSERT INTO dzien (dzien, miesiac, rok, mail, cena) VALUES ($selectedDay, $selectedMonth, $selectedYear, '$email', $cena)";
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

            <table>
            <?php

            
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
                            $message = "Zwolnił się termin: $dzien-$miesiac-$rok. Prosimy o ponowne zarezerwowanie.";
                            $headers = "From: no-reply@klemiato.com";
                
                            mail($to, $subject, $message, $headers);
                            
                        }
                    }
                    //nie działa ale jakbym dał hosting to by działało, ważne żeby wiedział że wiem co jest 5
                
                    
                
                    $db->close();
                }

            if ($_SESSION['logging']==true)
            {
                $mail= $_SESSION['mail'];
                $con=mysqli_connect("localhost","root","","projekt");
                if ($mail="kamil.klemiato@wp.pl")
                {
                    $zap="SELECT id, dzien, miesiac, rok, mail, cena FROM dzien";
                    $wynik=mysqli_query($con, $zap);
                    while($row=mysqli_fetch_array($wynik))
                    {
                        echo "<tr><td>";
                        echo("$row[id](id) $row[dzien] - $row[miesiac] - $row[rok] - $row[mail] - $row[cena]</td>");
                        echo "<td><button onclick='deleteDay({$row['id']})'>usun</button></td>";
                        echo "<td><button onclick='editDay({$row['id']})'>edytuj</button></td></tr>";

                    }
                }
                else
                {
                    $zap="SELECT id, dzien, miesiac, rok FROM dzien WHERE mail='".$mail."'";
                    $wynik=mysqli_query($con, $zap);
                    while($row=mysqli_fetch_array($wynik))
                    {
                        echo "<tr><td>";
                        echo("$row[dzien] - $row[miesiac] - $row[rok] - $row[mail]</td>");
                        echo "<td><button onclick='deleteDay({$row['id']})'>usun</button></td>";
                        echo "<td><button onclick='editDay({$row['id']})'>edytuj</button></td></tr>";

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
                    echo 'ppp';
                    $PersonIdToEdit = (int)$_POST['edit_person_id'];
                    $innydzien = (int)$_POST['innydzien'];
                    $innymiesiac = (int)$_POST['innymiesiac'];
                    $con = mysqli_connect("localhost", "root", "", "projekt");
                    $zap2 = "UPDATE dzien SET dzien='$innydzien', miesiac='$innymiesiac' WHERE id='$PersonIdToEdit'";
                    if (mysqli_query($con, $zap2)) {
                        echo "Day edited successfully";
                    } else {
                        echo "Error editing day: " . mysqli_error($con);
                    }
                
                
                }

                
            ?>
            </table>
</body>
</html>