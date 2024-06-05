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
                
                //$_SESSION['logging']=false;
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

            Calendar();

            document.querySelector('#prev').addEventListener('click',PrevMonth);
            document.querySelector('#next').addEventListener('click',NextMonth);

            function PrevMonth(){
            date = new Date(date.getFullYear(), date.getMonth() - 1, 1);
            Calendar();
            }

            function NextMonth(){
            date = new Date(date.getFullYear(), date.getMonth() + 1, 1);
            Calendar();
            }

            function Calendar(){

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
            console.log(dnizaj);
            

            document.querySelector('#calendar_top').innerHTML = aMonths[date.getMonth()] + ' ' + date.getFullYear();
            
            let dzien = 1;
            for (let i = 0; i < td.length; i++) {
            td[i].innerHTML = (i >= day && dzien <= lastDay.getDate())
                ? '<button id="btnDzien-' + i + '" value="' + dzien + '" onclick="getSelectedDay(this)">' + (dzien++) + '</button>' // Use dzien+1 to display actual day
                : '';
                if (dnizaj.includes(dzien-1)) {
                            document.getElementById("btnDzien-"+i).disabled=true;
                        }
            if (i >= 35) td[i].style.display = (day + dzien - 1 < 36) ? 'none' : ''; // hiding last row
            }
            }

                function getSelectedDay(button) {
                    const selectedDay = parseInt(button.value);
                    const selectedMonth = date.getMonth();
                    const selectedYear = date.getFullYear();
                    
                    // You can now use the selectedDay variable for further processing
                    console.log("Selected Day:", selectedDay);
                    const email=document.getElementById("mail").innerHTML;
                    console.log(email);
                    const xhr = new XMLHttpRequest();
                xhr.open('POST', 'główna.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log('Day and month sent to server:', selectedDay, selectedMonth+1);
                    } else {
                        console.error('Error sending day and month:', xhr.statusText);
                    }
                };
                xhr.send('selectedDay=' + selectedDay + '&selectedMonth=' + (selectedMonth+1) + '&selectedYear=' + selectedYear + '&email=' + encodeURIComponent(email));
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

                // Get selected day from POST request
                $selectedDay = $_POST['selectedDay'];
                $selectedMonth = $_POST['selectedMonth'];
                $selectedYear = $_POST['selectedYear'];
                $email = $db->real_escape_string($_POST['email']);
                

                // Insert selected day into the database
                $sql = "INSERT INTO dzien (dzien, miesiac, rok, mail) VALUES ($selectedDay, $selectedMonth, $selectedYear, '$email')";
                if ($db->query($sql) === TRUE) {
                echo "Day inserted successfully";
                } else {
                echo "Error inserting day: " . $db->error;
                }

                // Close database connection
                $db->close();
            }                
                ?>
            
        
    
</body>
</html>