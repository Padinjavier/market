<?php

class Ticket extends Controllers {
    public function __construct() {
        parent::__construct();
        session_start();
        if(empty($_SESSION['login'])) {
            header('Location: '.base_url().'/login');
            die();
        }
        getPermisos(MEMPLEADOS);
    }

    public function getVenta($cod_venta) {
        if($_SESSION['permisosMod']['r']) {
            $datos_venta = $this->model->seleccionarDatos($cod_venta);
            
            // Verificar si hay resultados
            if(!empty($datos_venta)) {
                // Generar PDF
                // Convertir el array a JSON
                // $json_datos_venta = json_encode($datos_venta);
                // Mostrar el JSON
                // echo $json_datos_venta;
                // echo($datos_venta['codigo_venta']);
                $this->generarPDF($datos_venta);
                // $this->errorView($datos_venta);

            } else {
                $this->errorView();
            }
        }
    }

    private function generarPDF($datos_venta) {
        require "./Libraries/code128.php";
        
        // Obtener datos de la empresa
        $nombre_empresa = NOMBRE_EMPESA;
        $direccion_empresa = DIRECCION;
        $telefono_empresa = TELEMPRESA;
        $email_empresa = EMAIL_EMPRESA;
    
        $pdf = new PDF_Code128('P', 'mm', array(80, 258));
        $pdf->SetMargins(4, 10, 4);
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',10);
        $pdf->SetTextColor(0,0,0);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper($nombre_empresa)),0,'C',false);
        $pdf->SetFont('Arial','',9);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",$direccion_empresa),0,'C',false);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$telefono_empresa),0,'C',false);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Email: ".$email_empresa),0,'C',false);
    

        $pdf->Ln(1);
        $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial','B',10);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper("No. Orden: ".$datos_venta['venta_codigo'])),0,'C',false);
        $pdf->SetFont('Arial','',9);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Fecha: ".$datos_venta['venta_fecha_hora']),0,'C',false);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",("Método Pago: ".$datos_venta['tipopago'])),0,'C',false);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cajero: ".$datos_venta['usuario_nombre']." ".$datos_venta['usuario_apellido']),0,'C',false);

        $pdf->Ln(1);
        $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
        $pdf->Ln(5);
    
        if($datos_venta['cliente_id']==1){
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","DNI: N/A"),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Nombre: N/A"),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: N/A"),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Correo: N/A"),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Dirección: N/A"),0,'C',false);
        }else{
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","DNI: ".$datos_venta['cliente_numero_documento']),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Nombre: ".$datos_venta['cliente_nombre']." ".$datos_venta['cliente_apellido']),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$datos_venta['cliente_telefono']),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Correo: ".$datos_venta['cliente_email']),0,'C',false);
            $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Dirección: ".$datos_venta['cliente_hotel']),0,'C',false);
        }

        $pdf->Ln(1);
        $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
        $pdf->Ln(3);

        $totalWidth = 75; // Total width of the combined cells (5 + 18 + 22 + 32)
        $margin = ($pdf->GetPageWidth() - $totalWidth) / 2; // Calculate the margin to center the cells
        
        $pdf->Cell($margin, 1, '', 0, 0); // Add left margin to center the cells
        $pdf->Cell(5,5,iconv("UTF-8", "ISO-8859-1","#"),0,0,'C');
        $pdf->Cell(10,5,iconv("UTF-8", "ISO-8859-1","Cant."),0,0,'C');
        $pdf->Cell(15,5,iconv("UTF-8", "ISO-8859-1","Precio"),0,0,'C');
        $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1","Descuento"),0,0,'C');
        $pdf->Cell(25,5,iconv("UTF-8", "ISO-8859-1","Total"),0,0,'C');
        
        $pdf->Ln(3);
        $pdf->Cell(0,5,iconv("UTF-8","ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
        $pdf->Ln(3);
        // /----------  Seleccionando detalles de la venta  ----------/
        $venta_detalle = $this->model->seleccionarDetalleDatos($datos_venta['venta_codigo']);
        $lineNumber = 1; // Initialize line number
    
            foreach($venta_detalle as $detalle){
                $pdf->MultiCell(0,4,iconv("UTF-8", "ISO-8859-1",$detalle['venta_nombre_servicio']),0,'C',false);
                $pdf->Cell($margin, 4, '', 0, 0); // Add left margin to center the cells
                $pdf->Cell(5, 4, iconv("UTF-8", "ISO-8859-1", $lineNumber), 0, 0, 'C');
                $pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",$detalle['detalle_venta_cantidad']),0,0,'C');
                $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",SMONEY.number_format($detalle['detalle_venta_precio_uni'],MONEDA_DECIMALES,SPD,SPM)),0,0,'C');
                $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",SMONEY.number_format($detalle['detalle_venta_descuento'],MONEDA_DECIMALES,SPD,SPM)),0,0,'C');
                $pdf->Cell(25,4,iconv("UTF-8", "ISO-8859-1",SMONEY.number_format($detalle['detalle_venta_precio_total'],MONEDA_DECIMALES,SPD,SPM)),0,0,'C');
                $pdf->Ln(4);
                $pdf->Ln(3);
                $lineNumber++; // Increment line number
            }

        $pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');

        $pdf->Ln(5);


        $subtotal = 0;
        $descuentototal = 0;
        
        
        foreach ($venta_detalle as $detalle) {
            $importe = $detalle['detalle_venta_precio_uni'] * $detalle['detalle_venta_cantidad'];
            $subtotal += $importe;
        
            $importe2 = $detalle['detalle_venta_descuento'] * $detalle['detalle_venta_cantidad'];
            $descuentototal += $importe2;
        }



        $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
        $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","Sub Total:"),0,0,'C');
        $pdf->Cell(32, 5, iconv("UTF-8", "ISO-8859-1", SMONEY . number_format($subtotal, MONEDA_DECIMALES, SPD, SPM) . ' ' . CURRENCY), 0, 0, 'C');

        $pdf->Ln(5);
        
        $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
        $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","Descuento:"),0,0,'C');
        $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1",SMONEY.number_format($descuentototal,MONEDA_DECIMALES,SPD,SPM).' '.CURRENCY),0,0,'C');

        $pdf->Ln(5);

        $pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
        $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","TOTAL:"),0,0,'C');
        $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1",SMONEY.number_format($datos_venta['venta_total'],MONEDA_DECIMALES,SPD,SPM).' '.CURRENCY),0,0,'C');

        $pdf->Ln(10);
        $pdf->SetFont('Arial','I',7);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","*Esta guía de boleta sirve para el control interno de la agencia*"),0,'C',false);

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(0,7,iconv("UTF-8", "ISO-8859-1","Gracias por su compra"),'',0,'C');

        $pdf->Ln(9);

        $pdf->Code128(5,$pdf->GetY(),$datos_venta['venta_codigo'],70,20);
        $pdf->SetXY(0,$pdf->GetY()+21);
        $pdf->SetFont('Arial','',14);
        $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",$datos_venta['venta_codigo']),0,'C',false);
        
		$pdf->Output("I","Ticket_Nro".$datos_venta['venta_codigo'].".pdf",true);

    }

    private function errorView($datos_venta) {
        echo '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <title>'.NOMBRE_EMPESA.'</title>
            <?php     headerAdmin($data);  ?>
        </head>
        <body>
            <div class="main-container">
                <section class="hero-body">
                    <div class="hero-body">
                        <p class="has-text-centered has-text-white pb-3">
                            <i class="fas fa-rocket fa-5x"></i>
                        </p>
                        <p class="title has-text-white">¡Ocurrió un error!'.$datos_venta['cliente_email'].'</p>
                        <p class="subtitle has-text-white">No hemos encontrado datos de la venta</p>
                    </div>
                </section>
                <button onclick="imprimir()">Imprimir</button>
<script>
function imprimir() {
    window.print();
}
</script>

            </div>
             <?php footerAdmin($data); ?>
        </body>
        </html>';
    }
}
?>
