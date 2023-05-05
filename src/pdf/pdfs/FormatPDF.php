<?php
require('code128.php');

class FormatPDF extends PDF_Code128{
	
	function Header()
	{
		$data['empresa'] = 'LENITOX';
		$data['nit'] = '12574455';
	    $data['direccion'] = 'Mz C6 Lote 18';
		$data['telefono'] = '3228858439';
		$data['ciudad'] = 'Cucuta - Norte de Santander';
		$data['correo'] = 'oigonzalezp@gmail.com';
		
		$this->Image('../images/logo.png',10,8,33);
		$this->SetFont('Arial','B',12);
		$this->Cell(35,6,'','LT',0,'C');
		$this->Cell(120,6,$data['empresa'],'T',0,'C');
		$this->Cell(120,6,'','RT',0,'C');
		$this->Ln();
		$this->Cell(35,6,'',0,0,'C');
		$this->Cell(120,6,'Nit: '.$data['nit'],0,0,'C');
		$this->Cell(120,6,'','R',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','L',0,'C');
		$this->Cell(120,6,$data['direccion'],'L',0,'C');
		$this->Cell(120,6,'Factura','LRT',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','L',0,'C');
		$this->Cell(120,6,$data['telefono'],'L',0,'C');
		$this->Cell(120,6,'Nro:556665','LRB',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','L',0,'C');
		$this->Cell(120,6,$data['ciudad'],'',0,'C');
		$this->Cell(120,6,'','R',0,'C');
		$this->Ln();
		$this->Cell(35,6,'','LB',0,'C');
		$this->Cell(120,6,$data['correo'],'B',0,'C');
		$this->Cell(120,6,'','RB',0,'C');
		$this->Ln(20);
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
			$this->Cell(40,7,$col,1);
		}
		$this->Ln();
		foreach($data as $row)
		{
			foreach($row as $col)
			{
				$this->Cell(40,6,$col,1);
		    }
			$this->Ln();
		}
		$this->Ln();
	}

	function ImprovedTable($header, $data)
	{
		$w = array(25, 70, 50, 50);
		for($i=0;$i<count($header);$i++)
		{
			$this->Cell($w[$i],7,$header[$i],1,0,'C');
        }
		$this->Ln();
		foreach($data as $row)
		{
			$this->Cell($w[0],6,number_format($row[0]),'LRT',0,'R');
			$this->Cell($w[1],6,$row[1],'LRT');
			$this->Cell($w[2],6,number_format($row[2]),'LRT',0,'R');
			$this->Cell($w[3],6,number_format($row[3]),'LRT',0,'R');
			$this->Ln();
		}
		$this->Cell(array_sum($w),0,'','T');
		$this->Ln(5);
	}
	
	function totalizacion($header, $data)
	{
		$w = array(175, 50, 50);
		$this->Cell($w[0], 6,'' , 0, 0, 'R');
		$this->Cell($w[1], 6,'Total:' , 1, 0, 'R');
		$this->Cell($w[2], 6,number_format(555555),1 ,0,'R');
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
		$w = array(40, 35, 45, 40);
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
