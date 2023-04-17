<?php
require("../fpdf/fpdf.php");

Class pdf extends FPDF
{
    public function header()
    {
        $this->SetX(38);
        $this->SetFont("Arial",'',6);
        //$this->SetTextColor(0,255,255);
        //Cell(ancho, alto, texto, bordes, ?, alineación[C,R,L], rellenar, link)
        $this->Cell(20,3,"Reporte Design",0); 
        $this->Cell(20,3,"Ventas",0); 
        $this->Ln();
        $this->SetX(38);
        $this->Cell(20,3,"tkstore@gmail.com",0); 
        $this->Cell(20,3,"Urb Los Angeles",0); 
        $this->Ln();
        $this->SetX(38);
        $this->Cell(20,3,"+51-053454620",0); 
        $this->Cell(20,3,utf8_decode("Moquegua -Perú"),0); 

        //Image(ruta, posicionX, posicionY, ancho, alto, tipo, link)
        $this->Image('img/logostore.png',78,5,12,12,'png');

    }
    /*
    public function footer(){        
        $this->SetFillColor(255,135,39);
        $this->Rect(0,250,220,40,'F');
        $this->SetY(-25);
        $this->SetX(120);
        $this->SetFont("Arial",'',12);
        $this->SetTextColor(255,255,255);
        //Cell(ancho, alto, texto, bordes, ?, alineación[C,R,L], rellenar, link)
        $this->Cell(45,6,"Reporte Design",0); 
        $this->Cell(40,6,"Ventas",0); 
        $this->Ln();
        $this->SetX(120);
        $this->Cell(45,6,"tkstore@gmail.com",0); 
        $this->Cell(40,6,"Urb Los Angeles",0); 
        $this->Ln();
        $this->SetX(120);
        $this->Cell(45,6,"+51-053454620",0); 
        $this->Cell(40,6,utf8_decode("Moquegua -Perú"),0); 
    }
    */

}