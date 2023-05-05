<?php
require('code128.php');

class FormatPDF extends PDF_Code128{

	function Header()
	{
		$empresa = $this->empresa;
		$factura = $this->factura;
		$this->Image('../images/logo.png',10,8,33);
		$this->SetFont('Arial','B',12);
		$this->Cell(35,6,'','',0,'C');
		$this->Cell(65,6,$empresa['empresa'],'',0,'C');
		$this->Cell(50,6,'','TLR',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','',0,'C');
		$this->Cell(65,6,$empresa['nit'],'',0,'C');
		$this->Cell(50,6,'','LR',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','',0,'C');
		$this->Cell(65,6,$empresa['direccion'],'',0,'C');
		$this->Cell(50,6,'Factura','LR',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','',0,'C');
		$this->Cell(65,6,$empresa['ciudad'],'',0,'C');
		$this->Cell(50,6,'Nro: '.$factura['id_factura'],'LR',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','',0,'C');
		$this->Cell(65,6,$empresa['correo'],'',0,'C');
		$this->Cell(50,6,'','LR',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','',0,'C');
		$this->Cell(65,6,$empresa['telefono'],'',0,'C');
		$this->Cell(50,6,'','LRB',0,'C');
		$this->Ln(15);
	}
	
	function dataEmpresa($data)
	{
		$this->empresa = $data['empresa'];
	}
	
	function dataFactura($data)
	{
		$this->factura = $data['factura'];
	}
	
	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function LoadData($file)
	{
		$lines = file($file);
		$data = array();
		foreach($lines as $line)
		{
			$data[] = explode(';',trim($line));
		}	
		return $data;
	}

	function BasicTable($header, $data)
	{
		foreach($header as $col)
		{
			$this->Cell(50,7,$col,1);
		}
		$this->Ln();
		foreach($data as $row)
		{
			foreach($row as $col)
			{
				$this->Cell(50,6,$col,1);
		    }
			$this->Ln();
		}
		$this->Ln();
	}

        function cliente($data)
        {
			$cliente = $data['cliente'];
			$w = array(25, 70);
			$this->Cell(95,6,'Datos del Cliente:',1,0,'L');
			$this->Ln();
			$this->Cell($w[0],6,'Nombre:','TLR',0,'L');
			$this->Cell($w[1],6,utf8_decode($cliente['nombre']),'TR',0,'L');
			$this->Ln();
			$this->Cell($w[0],6,'Nit / C.C:','LR',0,'L');
			$this->Cell($w[1],6,$cliente['nit'],'R',0,'L');
			$this->Ln();
			$this->Cell($w[0],6,utf8_decode('dirección:'),'LR',0,'L');
			$this->Cell($w[1],6,utf8_decode($cliente['direccion']),'R',0,'L');
			$this->Ln();
			$this->Cell($w[0],6,utf8_decode('teléfono:'),'LR',0,'L');
			$this->Cell($w[1],6,$cliente['telefono'],'R',0,'L');
			$this->Ln();
			$this->Cell(array_sum($w),0,'','T');
			$this->Ln(6);
        }

	function detalle($data)
	{
		$header = ['Cant.', 'Descripción','Precio', 'IVA','Total'];
	    $detalle = $data['detalle'];
		$w = array(20, 75, 34, 33, 33);
		for($i=0;$i<count($header);$i++)
		{
			$this->Cell($w[$i], 6, utf8_decode($header[$i]),1,0,'C');
                }
		$this->Ln();
                $this->total = 0;
		foreach($detalle as $row)
		{
			$cantidad = $row['cantidad'];
			$descripcion = $row['descripcion'];
			$precio = $row['precio'];
			$iva = $row['iva'];
			$impuestos = ($cantidad * $precio) * $iva / 100;
			$subtotal = ($cantidad * $precio) + $impuestos;
			$this->total += $subtotal;
			$this->Cell($w[0],6,number_format($cantidad),'LRT',0,'R');
			$this->Cell($w[1],6,utf8_decode($descripcion),'LRT');
			$this->Cell($w[2],6,number_format($precio),'LRT',0,'R');
			$this->Cell($w[3],6,$iva.'%','LRT',0,'C');
			$this->Cell($w[4],6,number_format($subtotal),'LRT',0,'R');
			$this->Ln();
		}
		$this->Cell(array_sum($w),0,'','T');
		$this->Ln(5);
	}

	function totalizacion()
	{
		$w = array(129, 33, 33);
		$this->Cell($w[0], 6,'' , 0, 0, 'R');
		$this->Cell($w[1], 6,'Total:' , 1, 0, 'C');
		$this->Cell($w[2], 6,number_format($this->total),1 ,0,'R');
		$this->Ln();
		$this->Ln(5);
	}

	function FancyTable($header, $data)
	{
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		$w = array(50, 35, 50, 50);
		for($i=0;$i<count($header);$i++)
		{
			$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		}
		$this->Ln();
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		$fill = false;
		foreach($data as $row)
		{
			$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
			$this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
			$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
			$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
			$this->Ln();
			$fill = !$fill;
		}
		$this->Cell(array_sum($w),0,'','T');
		$this->Ln(5);
	}
}
