<?php

namespace App\Pdf;

use App\Models\Reservation;
use App\Models\User;
use Codedge\Fpdf\Fpdf\Fpdf;

class TicketIn extends Fpdf{

    private $heighLine = 8;
    private $fontSizeTite = 6;
    private $fontSizeBody = 6;

    /**
     * 
     */
    private $reservation;

    /**
     * 
     */
    private $userPrint;


    public function __construct(Reservation $reservation, User $userPrint)
    {
        parent::__construct($orientation= 'P', $unit='mm', $size=array(45, 70));

        $this->reservation = $reservation;
        $this->userPrint = $userPrint;

        $this->SetMargins(2, 2, 2);
        
        $this->AddPage();

        $this->body();
    }
    
    public function Header()
    {
        $this->SetFont('Arial', 'B', $this->fontSizeTite);
        $this->Cell(0, ($this->heighLine-3), "PARQUEADERO la AVIV", 0, 1, 'C', false);
        
        $this->SetFont('Arial', '', $this->fontSizeBody);
        $this->Cell(0, ($this->heighLine-5), "Nit: 123789-3", 0, 1, 'C', false);
        $this->Cell(0, ($this->heighLine-5), utf8_decode("Teléfono: 3101234567"), 0, 1, 'C', false);
        $this->Cell(0, ($this->heighLine-5), utf8_decode("Carrera 14D Calle 2 N° 15-63"), 0, 1, 'C', false);


    }

    public function body()
    {
        $this->SetFont('Arial', 'B', $this->fontSizeTite);
        $this->Ln(8);
        $this->Cell(0, ($this->heighLine-4), "TICKET DE INGRESO", 0, 1, 'C', false);     
        
        $this->SetFont('Arial', 'B', ($this->fontSizeTite+3));
        $this->Cell(0, ($this->heighLine-4), utf8_decode("N° {$this->reservation->id}"), 0, 1, 'C', false);     
        
        $this->Ln(10);
        $this->SetFont('Arial', '', ($this->fontSizeBody));
        $this->MultiCell(0, 3, "OJO!, Debe presentar este ticket para poder salir", 0, 'L', false);
        
    }

    public function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial', '', ($this->fontSizeBody-2));
        
        $this->Cell(0, ($this->heighLine-6), utf8_decode("Hora de impresión: ".\Carbon\Carbon::now()), 0, 1, 'C', false);
        $this->Cell(0, ($this->heighLine-6), utf8_decode("Impreso por: ".$this->userPrint->fullName), 0, 1, 'C', false);
    }
}