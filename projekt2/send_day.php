<?php
            
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
                $mail=$_SESSION['mail'];
                echo 'ssssssssssssssssssssss';
                var_dump($mail);
                // Insert selected day into the database
                $sql = "INSERT INTO dzien (dzien, miesiac, rok, mail) VALUES ($selectedDay, $selectedMonth, $selectedYear,$mail)";
                if ($db->query($sql) === TRUE) {
                echo "Day inserted successfully";
                } else {
                echo "Error inserting day: " . $db->error;
                }

                // Close database connection
                $db->close();
                            
                ?>