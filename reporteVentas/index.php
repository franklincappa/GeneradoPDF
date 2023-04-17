<?php
require("pdfClase.php");
require("data.php");

$reporte= new pdf();
$reporte->AddPage('PORTRAIT','letter');
$reporte->SetMargins(10,30,20,30);

//Mostramos datos de pedido
$reporte->SetTextColor(255,255,255);
$reporte->SetFont('Arial','B',12);
$reporte->SetY(15);
$reporte->SetX(120);
$reporte->Cell(100,5,"DATOS DE PEDIDO");
$reporte->Ln();
$reporte->SetFont('Arial','',12);
$reporte->SetX(120);
$reporte->Cell(30,5,"Nro");
$reporte->Write(5,": ".$dataPedido["numero"]);
$reporte->Ln();
$reporte->SetX(120);
$reporte->Cell(30,5,"Lugar Entrega");
$reporte->Write(5,": ".utf8_decode($dataPedido["direccion"]));
$reporte->Ln();
$reporte->SetX(120);
$reporte->Cell(30,5,"Fecha");
$reporte->Write(5,": ".$dataPedido["fecha"]);
$reporte->Ln();
$reporte->SetX(120);
$reporte->Cell(30,5,"Monto S/.");
$reporte->Write(5,": ".$dataPedido["total"]);

//Imagen Express
//Image(ruta, posicionX, posicionY, ancho, alto, tipo, link)
$reporte->Image('img/express.png',20,60,80,40,'png');

//Datos del cliente
$reporte->SetFont('Arial','B',12);
$reporte->SetTextColor(0,0,0);
$reporte->SetY(65);
$reporte->SetX(120);
$reporte->Write(7,$dataCliente["nombre"]);
$reporte->Ln();
$reporte->SetFont('Arial','',12);
$reporte->SetX(120);
$reporte->Write(7,utf8_decode($dataCliente["direccion"]));
$reporte->Ln();
$reporte->SetX(120);
$reporte->Write(7,$dataCliente["email"]);
$reporte->Ln();
$reporte->SetX(120);
$reporte->Write(7,$dataCliente["ciudad"]);

//Datos de detalle de pedido
$reporte->SetY(110);
//$reporte->SetX(15);
$reporte->SetFontSize(11);
$reporte->SetTextColor(255,255,255);
$reporte->SetFillColor(78,78,78);
//Cell(ancho, alto, texto, bordes, ?, alineación[C,R,L], rellenar, link)
$reporte->Cell(10,8,"NRO",0,0,'C',true);
$reporte->Cell(40,8,"PRODUCTO",0,0,'C',true);
$reporte->Cell(60,8,utf8_decode("DESCRIPCIÓN"),0,0,'C',true);
$reporte->Cell(25,8,"P. UNIT.",0,0,'C',true);
$reporte->Cell(25,8,"CANT.",0,0,'C',true);
$reporte->Cell(25,8,"SUBTOTAL",0,0,'C',true);
$reporte->Ln();

$rellenar=false;
$reporte->SetFont('Arial','',10);
$reporte->SetTextColor(0,0,0);
$nro=0;
$total=0;
$igv=0.18;
$moneda='S/. ';
foreach($dataDetalleVenta as $detalle){
    //$rellenar=($rellenar==true)?false:true;
    $reporte->Cell(10,8,$nro,'B',0,'C',$rellenar);
    $reporte->Cell(40,8,utf8_decode($detalle["producto"]),'B',0,'L',$rellenar);
    $reporte->Cell(60,8,utf8_decode($detalle['descripcion']),'B',0,'L',$rellenar);
    $reporte->Cell(25,8,$moneda.number_format($detalle['precio'],2,'.'),'B',0,'C',$rellenar);
    $reporte->Cell(25,8,$detalle['cantidad'],'B',0,'C',$rellenar);
    $reporte->Cell(25,8,$moneda.number_format($detalle["precio"]*$detalle["cantidad"],2,'.'),'B',0,'R',$rellenar);
    $total+=$detalle["precio"]*$detalle["cantidad"];
    $nro+=1;
    $reporte->Ln();
}
$reporte->SetFontSize(12);

$reporte->Cell(110,8,'Observaciones',0,0,'L',$rellenar);
$reporte->Cell(25,8,'Subtotal',0,0,'C',$rellenar);
$reporte->Cell(25,8,'',0,0,'',$rellenar);
$reporte->Cell(25,8,$moneda.number_format($total,2,'.'),0,0,'R',$rellenar);
$reporte->Ln();
$reporte->Cell(110,8,'',0,0,'L',$rellenar);
$reporte->Cell(25,8,'IGV',0,0,'C',$rellenar);
$reporte->Cell(25,8,'',0,0,'',$rellenar);
$reporte->Cell(25,8,$moneda.number_format($total*$igv,2,'.'),0,0,'R',$rellenar);
$reporte->Ln();

$reporte->SetFont('','B');
$reporte->SetTextColor(255,255,255);
$reporte->SetFillColor(78,78,78);
//Cell(ancho, alto, texto, bordes, ?, alineación[C,R,L], rellenar, link)
$reporte->Cell(110,10,"",0,0,'C',true);
$reporte->Cell(25,10,"Total",0,0,'C',true);
$reporte->Cell(25,10,"",0,0,'C',true);
$reporte->Cell(25,10,$moneda.number_format($total+$total*$igv,2,'.'),0,0,'R',true);
$reporte->Ln();

/*
$dataEmpresa;
$dataCliente;
$dataPedido;
$dataDetalleVenta;
*/
/*
print_r($dataEmpresa);
print_r($dataCliente);
print_r($dataPedido);
print_r($dataDetalleVenta);*/
$reporte->Close();
$reporte->OutPut('I','detallePedido'.$dataPedido["numero"].'.pdf');