<?php
require('../pdfs/code128.php');

class FormatPDF extends PDF_Code128{

	function Header()
	{
		$data['empresa'] = utf8_decode('Oscar González');
		$data['nit'] = 'To. ADSI - SENA';
          	$data['direccion'] = 'Mz C4 Casa 21 Torcoroma 2';
		$data['telefono'] = '(57) 322-8858439';
		$data['ciudad'] = utf8_decode('Cúcuta - Norte de Santander');
		$data['correo'] = 'oigonzalezp@gmail.com';
		$this->Image('../images/logo.png',10,8,33);
		$this->SetFont('Arial','B',12);
		$this->Cell(35,6,'','',0,'C');
		$this->Cell(65,6,$data['empresa'],'',0,'C');
		$this->Cell(50,6,'','TLR',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','',0,'C');
		$this->Cell(65,6,$data['nit'],'',0,'C');
		$this->Cell(50,6,'','LR',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','',0,'C');
		$this->Cell(65,6,$data['direccion'],'',0,'C');
		$this->Cell(50,6,'Factura','LR',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','',0,'C');
		$this->Cell(65,6,$data['ciudad'],'',0,'C');
		$this->Cell(50,6,'Nro:556650','LR',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','',0,'C');
		$this->Cell(65,6,$data['correo'],'',0,'C');
		$this->Cell(50,6,'','LR',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','',0,'C');
		$this->Cell(65,6,$data['telefono'],'',0,'C');
		$this->Cell(50,6,'','LRB',0,'C');
		$this->Ln(15);
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

        function cliente($header, $data)
        {
                $w = array(25, 70);
                $this->Cell(95,6,'Datos del Cliente:',1,0,'L');
                $this->Ln();
                $this->Cell($w[0],6,'Nombre:','TLR',0,'L');
                $this->Cell($w[1],6,utf8_decode('oscar ivan gonzalez peña'),'TR',0,'L');
                $this->Ln();
                $this->Cell($w[0],6,'Nit / C.C:','LR',0,'L');
                $this->Cell($w[1],6,'1090384538','R',0,'L');
                $this->Ln();
                $this->Cell($w[0],6,utf8_decode('dirección:'),'LR',0,'L');
                $this->Cell($w[1],6,utf8_decode('mzC4 torcoroma 2'),'R',0,'L');
                $this->Ln();
                $this->Cell($w[0],6,utf8_decode('teléfono:'),'LR',0,'L');
                $this->Cell($w[1],6,'3228858439','R',0,'L');
                $this->Ln();
                $this->Cell(array_sum($w),0,'','T');
                $this->Ln(6);
        }

	function ImprovedTable($header, $data)
	{
		$w = array(20, 75, 34, 33, 33);
		for($i=0;$i<count($header);$i++)
		{
			$this->Cell($w[$i], 6, utf8_decode($header[$i]),1,0,'C');
                }
		$this->Ln();
                $this->total = 0;
		foreach($data as $row)
		{
                        $cantidad = $row[0];
                        $descripcion = $row[1];
                        $precio = $row[2];
                        $iva = $row[3];
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

	function totalizacion($header, $data)
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
