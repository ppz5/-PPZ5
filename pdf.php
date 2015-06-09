<?php
require('fpdf17/fpdf.php');

function pobierz_obrazek($source) {
    // pobiera obraz 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $source);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    
    $ext=end(explode(".", $source));

    $destination = "tmp/".  uniqid().".".$ext;
    $file = fopen($destination, "w+");
    fputs($file, $data);
    fclose($file);
    
    return $destination;
}

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->Image('image/header.png',10,10,190);
$pdf->SetY($pdf->y + 25);



if (isset($_GET['xml']) && trim($_GET['xml']) != "" && file_exists("uploads/xml/" . $_GET['xml'])) {
	$use_errors = libxml_use_internal_errors(true);
	$xml = simplexml_load_file("uploads/xml/".$_GET['xml']);
	if(!$xml){
		$pdf->SetFillColor(100,100,100);
		$pdf->Cell(190,8,'No valid xml file were uploaded!',0,1,'L',true);
		$xml = array();
	}
	foreach($xml as $product){
		foreach($product as $info){
                    if($pdf->GetY()>200) $pdf->AddPage ();
			$pdf->SetY($pdf->y+6);
			
			$pdf->SetFillColor(150,150,150);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(190,5,"Nazwa Produktu: ". $product['name'],0,1,'L',true);
			
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(100,5,"Kod Producenta: " . $info['kod_prod'],0,1,'L');
			$pdf->Cell(80,5,"Symbol NTT: " . $info['symbol'],0,1,'L');
			
			$pdf->SetX(150);
			$pdf->SetFillColor(210,4,4);
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFont('Arial','i',20);
			$price = explode(".", $info['price']);
			$pdf->Cell(25,6,$price[0],0,1,'R', true);
			$pdf->SetFont('Arial','i',10);
			$pdf->SetXY(175,$pdf->y - 6);
			$pdf->Cell(15,3,$price[1],0,1,'L', true);
			$pdf->SetX(175);
			$pdf->Cell(15,3,"netto",0,1,'L', true);
			
		
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(190,5,"Opis: " . iconv('UTF-8','iso-8859-2', $info['desc']),0,'L');
                     
                        $pdf->Image(pobierz_obrazek($info['pict']));
		}
	}	
}else{
	$pdf->Cell(100,10,'No valid xml file were uploaded!',0,1,'C');
}
$pdf->Image('image/footer.png',$pdf->x,$pdf->y + 20,190);
//$pdf->Image('image/header.png',100,10,0);
$pdf->Output();

/*

	?>
	<div class="product">
		<h3></h3>
		<div>
			<div class="info">
				<p><strong></strong> <?php echo  ?></p>
				<p><strong></strong> <?php echo  ?></p>
				<p class="opis"><strong>Opis:</strong> <?php echo $info['desc'] ?></p>
			</div>
			<div class="price">
				<?php
					$price = explode(".", $info['price']);
					echo "<p>".$price[0]."</p>";
					echo "<p>".$price[1]."</p>";
					echo "<p>netto</p>";
				?>
			</div>
		</div>
	</div>
	<?php
	}
}
*/
?>