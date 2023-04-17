<?php
require("pdfClase.php");
require("data.php");

$reporte= new pdf();
$reporte->SetMargins(5,5,5,5);
$reporte->AddPage('PORTRAIT',array(100,125));

//Datos de Cliente
$reporte->SetY(5);
$reporte->SetFont('Arial','B',6);
$reporte->SetTextColor(0,0,0);
$reporte->Write(3,$dataCliente["nombre"]);
$reporte->Ln();
$reporte->SetFont('Arial','',6);
$reporte->Write(3,utf8_decode($dataCliente["direccion"]));
$reporte->Ln();
$reporte->Write(3,$dataCliente["email"]);
$reporte->Ln();
$reporte->Write(3,$dataCliente["ciudad"]);

//Nro de Factura
$reporte->SetFont('Arial','BI',14);
$reporte->SetY(20);
$reporte->Write(15,"FACTURA ");
$reporte->SetTextColor(144,12,65);
$reporte->Write(15,"#".$dataPedido["numero"]);

//Mostramos datos de pedido
$reporte->SetTextColor(0,0,0);
$reporte->SetFont('Arial','B',6);
$reporte->SetY(20);
$reporte->SetX(55);
$reporte->Cell(30,3,"DATOS DE PEDIDO");
$reporte->Ln();
$reporte->SetFont('Arial','',6);
$reporte->SetX(55);
$reporte->Cell(15,3,"Nro");
$reporte->Write(3,": ".$dataPedido["numero"]);
$reporte->Ln();
$reporte->SetX(55);
$reporte->Cell(15,3,"Lugar Entrega");
$reporte->Write(3,": ".utf8_decode($dataPedido["direccion"]));
$reporte->Ln();
$reporte->SetX(55);
$reporte->Cell(15,3,"Fecha");
$reporte->Write(3,": ".$dataPedido["fecha"]);
$reporte->Ln();
$reporte->SetX(55);
$reporte->Cell(15,3,"Monto S/.");
$reporte->Write(3,": ".$dataPedido["total"]);

//Datos de detalle de pedido
$reporte->SetDrawColor(144,12,65); //Color de Dibujo
$reporte->SetLineWidth(0.5); //Grosor de linea
$reporte->Line(5,39,93,39);

$reporte->SetY(40);
//$reporte->SetX(15);
$reporte->SetFont('','B',5);
$reporte->SetTextColor(144,12,65);
$reporte->SetFillColor(78,78,78);
//Cell(ancho, alto, texto, bordes, ?, alineación[C,R,L], rellenar, link)
$reporte->Cell(4,3,"NRO",0,0,'C',false);
$reporte->Cell(25,3,"PRODUCTO",0,0,'C',false);
$reporte->Cell(30,3,utf8_decode("DESCRIPCIÓN"),0,0,'C',false);
$reporte->Cell(10,3,"P. UNIT.",0,0,'C',false);
$reporte->Cell(8,3,"CANT.",0,0,'C',false);
$reporte->Cell(12,3,"SUBTOTAL",0,0,'C',false);
$reporte->Ln();

$rellenar=true;
$reporte->SetFont('Arial','',6);
$reporte->SetTextColor(0,0,0);
$nro=0;
$total=0;
$igv=0.18;
$moneda='S/. ';
foreach($dataDetalleVenta as $detalle){
    if($nro % 2==0){ $reporte->SetFillColor(250,250,250);} 
    else{$reporte->SetFillColor(230,230,230);}

    //$rellenar=($rellenar==true)?false:true;
    $reporte->Cell(4,3,$nro,0,0,'C',$rellenar);
    $reporte->Cell(25,3,utf8_decode($detalle["producto"]),0,0,'L',$rellenar);
    $reporte->Cell(30,3,utf8_decode($detalle['descripcion']),0,0,'L',$rellenar);
    $reporte->Cell(10,3,$moneda.number_format($detalle['precio'],2,'.'),0,0,'C',$rellenar);
    $reporte->Cell(8,3,$detalle['cantidad'],0,0,'C',$rellenar);
    $reporte->Cell(12,3,$moneda.number_format($detalle["precio"]*$detalle["cantidad"],2,'.'),0,0,'R',$rellenar);
    $total+=$detalle["precio"]*$detalle["cantidad"];
    $nro+=1;
    $reporte->Ln();
}

$reporte->SetFontSize(6);
$reporte->SetTextColor(144,12,65);
$reporte->Cell(59,3,'Observaciones',0,0,'L',$rellenar);
$reporte->Cell(10,3,'Subtotal',0,0,'C',$rellenar);
$reporte->Cell(8,3,'',0,0,'',$rellenar);
$reporte->Cell(12,3,$moneda.number_format($total,2,'.'),0,0,'R',$rellenar);
$reporte->Ln();
$reporte->Cell(59,3,'',0,0,'L',$rellenar);
$reporte->Cell(10,3,'IGV',0,0,'C',$rellenar);
$reporte->Cell(8,3,'',0,0,'',$rellenar);
$reporte->Cell(12,3,$moneda.number_format($total*$igv,2,'.'),0,0,'R',$rellenar);
$reporte->Ln();

$reporte->SetFont('','B');
$reporte->SetTextColor(255,255,255);
$reporte->SetFillColor(144,12,65);
//Cell(ancho, alto, texto, bordes, ?, alineación[C,R,L], rellenar, link)
$reporte->Cell(59,3,"",0,0,'C',true);
$reporte->Cell(10,3,"Total",0,0,'C',true);
$reporte->Cell(8,3,"",0,0,'C',true);
$reporte->Cell(12,3,$moneda.number_format($total+$total*$igv,2,'.'),0,0,'R',true);
$reporte->Ln();

/*
print_r($dataEmpresa);
print_r($dataCliente);
print_r($dataPedido);
print_r($dataDetalleVenta);*/
$reporte->Close();
$reporte->OutPut('I','detallePedido'.$dataPedido["numero"].'.pdf');