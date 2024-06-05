<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method=POST>
        Imie:<input type="text" name="imie"><br>
        Nazwisko:<input type="text" name="nazwisko"><br>
        e-mail:<input type="text" name="e-mail"><br>
        Hasło:<input type="text" name="hasło"><br>
        <input type="submit" name="zarejestruj" value="zarejestuj">
    </form>

    <?php
        $plik=fopen("dane.txt", "c+");
        if (isset($_POST['imie']) && isset($_POST['nazwisko']) && isset($_POST['e-mail']) && isset($_POST['hasło']))
        {
            $imie=$_POST['imie'];
            $nazwisko=$_POST['nazwisko'];
            $email=$_POST['e-mail'];
            $haslo=$_POST['hasło'];
            $nie=0;
            
            if (preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/',$haslo))
            {
                
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "Invalid email format";
                }
                else
                {
                    $dane=$imie.";".$nazwisko.";".$email.";".$haslo."\n";
                    //rewind($plik);
                    while(!feof($plik))
                    {
                        
                        $str = fgets($plik);
                        $str = trim($str);
                        
                        
                        if ($str!="")
                        {
                            $tab=explode(";",$str);
                            
                            if ($tab[2]==$email)
                            {
                                echo "Podany e-mail jest juz zajety";
                                $nie=1;
                            }
                        }
                        else
                        {
                            echo "puste";
                        }
                        
                         
                    }
                    if ($nie==0)
                    {
                        fwrite($plik, $dane);
                        echo "gratulacje pomyślnie zarejestrowano<br>";
                        
                    }
                    
                }
            }
            else
            {
                echo "Zle haslo";
            }

            
        }
        
        fclose($plik);
        
        
    ?>
    
</body>
</html>