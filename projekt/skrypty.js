                

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
                try {
                    if (dnizaj.includes(dzien-1) ) {
                    document.getElementById("btnDzien-" + i).style.backgroundColor = "red";
                    }
                }
                catch (err){
                    
                }
                                              
                if (dzien-1<=date1.getDate() && i>=day && date.getFullYear()==date1.getFullYear() && date.getMonth()==date1.getMonth())
                {
                    
                    document.getElementById("btnDzien-"+i).disabled=true;
                    document.getElementById("btnDzien-"+i).style.backgroundColor = "lightgrey";
                    
                }
            if (i >= 35) td[i].style.display = (day + dzien-1  < 36) ? 'none' : ''; // hiding last row
            }
            }

                function getSelectedDay(button) {
                    const selectedDay = parseInt(button.value);
                    const imie = document.getElementById("imie").innerHTML;
                    const nazwisko = document.getElementById("nazwisko").innerHTML;
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
                        const ceny=[100,100,200,200,300,600,100,500,200,200,100,100];
                        const cena=ceny[selectedMonth]-czypromo;
                        const zapłata = confirm("Twoja zapłata wynosi "+cena+" złotych, zgadzasz się?");
                        if (zapłata==true)
                        {
                            xhr.send('selectedDay=' + selectedDay + '&selectedMonth=' + (selectedMonth+1) + '&selectedYear=' + selectedYear + '&email=' + encodeURIComponent(email) + '&cena=' + cena + '&imie=' + encodeURIComponent(imie) + '&nazwisko=' + encodeURIComponent(nazwisko));
                        
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
            const ceny=[0,100,100,200,200,300,600,100,500,200,200,100,100];
            
                        
            const cena=ceny[innymiesiac];
            const zapłata = confirm("Twoja zapłata za nowy termin wynosi "+cena+" złotych, zgadzasz się?");
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
                if (zapłata==true)
                    {
                        xhr.send('edit_person_id=' + id + '&innydzien=' + innydzien + '&innymiesiac=' + innymiesiac + '&innacena=' + cena);
                        setTimeout("location.reload()",150);
                    }
                
            }
        }

        function Ocena(id) {
            const Ocena = prompt("Podaj w skali od 1 do 10 jak bardzo ci się podobało");
            while (!(Ocena <=10 && Ocena>=1))
            {
                const Ocena = prompt("Podaj w skali od 1 do 10 jak bardzo ci się podobało (ale tym razem w skali)");
            }
            const Opinia = prompt("Podziel się swoją opinią");

            
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
                xhr.send('Ocena_id=' + id + '&Ocena=' + Ocena + '&Opinia=' + encodeURIComponent(Opinia));
                setTimeout("location.reload()",150);
            
        }

        function editcena(id) {
            const innacena = prompt("Podaj inną cene:");

            while (!(innacena >=0 && innacena<999))
                {
                    const innacena = prompt("Podaj zmiane ceny(poprawną 0-999): ");
                }
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
                xhr.send('edit_cena_id=' + id + '&innacena=' + innacena);
                setTimeout("location.reload()",150);
            
        }
                
                

           