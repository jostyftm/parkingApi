<?php

namespace App\Pdf;

use App\Models\Reservation;
use App\Models\User;
use Codedge\Fpdf\Fpdf\Fpdf;

class TicketReservation extends Fpdf{

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
        parent::__construct($orientation= 'P', $unit='mm', $size=array(45, 140));
    
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
        $this->Cell(0, ($this->heighLine-4), "TICKET DE SALIDA", 0, 1, 'C', false);     
        
        $this->SetFont('Arial', 'B', ($this->fontSizeTite+3));
        $this->Cell(0, ($this->heighLine-4), utf8_decode("N° {$this->reservation->id}"), 0, 1, 'C', false);     

        $this->Ln(10);
        $this->SetFont('Arial', '', $this->fontSizeBody);
        $this->Cell(0, ($this->heighLine-4), "Tipo de vehiculo: {$this->reservation->vehicleType->name}", 0, 1, 'L', false);
        $this->Cell(0, ($this->heighLine-4), "Placa: {$this->reservation->license_plate}", 0, 1, 'L', false);
        $this->Cell(0, ($this->heighLine-4), "Hora de ingreso: {$this->reservation->started_at}", 0, 1, 'L', false);
        $this->Cell(0, ($this->heighLine-4), "Hora de salida: {$this->reservation->finished_at}", 0, 1, 'L', false);
        $this->Cell(0, ($this->heighLine-4), "Lugar de parqueo: {$this->reservation->parkingPlace->number}", 0, 1, 'L', false);
        $this->Cell(0, ($this->heighLine-4), "Valor por hora: $ {$this->reservation->hour_price}", 0, 1, 'L', false);
        $this->Cell(0, ($this->heighLine-4), "Valor a pagar: $ {$this->reservation->getTotalPay()}", 0, 1, 'L', false);
        
        
        // Section QR
        $this->Ln(10);
        $this->Cell(0, ($this->heighLine-4), "Gracias por utilizar nuestro servicios", 0, 1, 'L', false);
        
        $y = $this->GetY();

        $this->Image(public_path('img/qr_code.png'), 2, $y, 40, 40);
        $this->Ln(40);
    }

    public function Footer()
    {
        // $this->SetY(-10);
        $this->SetFont('Arial', '', ($this->fontSizeBody-2));
        
        $this->Cell(0, ($this->heighLine-6), utf8_decode("Hora de impresión: ".\Carbon\Carbon::now()), 0, 1, 'C', false);
        $this->Cell(0, ($this->heighLine-6), utf8_decode("Impreso por: ".$this->userPrint->fullName), 0, 1, 'C', false);
    }
}