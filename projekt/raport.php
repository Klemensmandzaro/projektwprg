<?php
session_start();
require('fpdf.php');



$costs = [
    ['name' => 'Rent', 'amount' => 1500],
    ['name' => 'Groceries', 'amount' => 200],
    ['name' => 'Utilities', 'amount' => 100],
];
function generateCostReport($costs) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $cena=0;
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Cost Report', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Dzien', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Miesiac', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Rok', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Cena', 1, 1, 'C');

    $con=mysqli_connect("localhost","root","","projekt");
    $zap="SELECT dzien, miesiac, rok, cena FROM dzien WHERE mail='".$_SESSION['mail']."'";
    $wynik=mysqli_query($con, $zap);
    while($row=mysqli_fetch_array($wynik))
    {
        $pdf->Cell(40, 10, $row['dzien'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['miesiac'], 1, 0, 'C'); // Placeholder for 'Miesiac'
        $pdf->Cell(40, 10, $row['rok'], 1, 0, 'C'); // Placeholder for 'Rok'
        $pdf->Cell(40, 10, $row['cena'], 1, 1, 'C');
        $cena+=$row['cena'];
    }

    $pdf->Cell(40, 10, 'Suma', 1, 0, 'C');
    $pdf->Cell(40, 10, $cena, 1, 1, 'C');

            
            
    mysqli_close($con);

    

    $pdf->Output('D', 'raport.pdf');
}

    generateCostReport($costs);

?>