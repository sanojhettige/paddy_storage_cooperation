<?php
ob_start();
class MYPDF extends TCPDF {

    public $app_data;
    public $record;
    
    public function setData($app_data, $record){
    $this->app_data = $app_data;
    $this->record = $record;
    }

    public function Header() {
        // Logo

        $this->SetY(10);
        $this->SetXY(5,10);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 15, strtoupper($this->app_data['app_name']), 0, false, 'L', 0, 'B', 0, false, 'M', 'M');
        $this->SetY(10);
        $this->SetXY(80,10);
        $this->SetFont('helvetica', '', 11);
        $this->Cell(0, 15, strtoupper($this->record['to_center']), 0, false, 'L', 0, 'B', 0, false, 'M', 'M');
        $this->SetXY(80,15);
        $this->SetFont('helvetica', '', 8);
        $this->Cell(0, 15, 'Address - '.strip_tags($this->app_data['address']), 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->SetXY(80,20);
        $this->Cell(0, 15, 'Phone Number - '.($this->app_data['phone_number']), 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->SetXY(80,25);
        $this->Cell(0, 15, 'Email - '.($this->app_data['email']), 0, false, 'L', 0, '', 0, false, 'M', 'M');

        $this->SetXY(160,9);
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 15, 'TRANSFER ORDER', 0, false, 'R', 0, 'B', 0, false, 'M', 'M');

        $xVal = 5;
        $yVal = 13;
        $this->SetFont(PDF_FONT_NAME_MAIN, 'R', 9);

        $this->SetXY($xVal, $yVal);
        $this->Write(0, 'From ', '', 0, 'L', true, 0, false, false, 0);
        $this->SetXY($xVal+24, $yVal);
        $this->Write(0, ': '.$this->record['to_center'], '', 0, 'L', true, 0, false, false, 0);
        $this->SetXY($xVal, $yVal+5);
        $this->Write(0, 'To ', '', 0, 'L', true, 0, false, false, 0);
        $this->SetXY($xVal+24, $yVal+5);
        $this->MultiCell(50, 1, ": ".$this->record['to_center'], 0, 'L', 0, 1, '', '', true);
    
        $this->SetXY($xVal, $yVal+10);
        $this->Write(0, 'Assigned Vehicle', '', 0, 'L', true, 0, false, false, 0);
        $this->SetXY($xVal+24, $yVal+10);
        $this->Write(0, ': '.$this->record['registration_number'], '', 0, 'L', true, 0, false, false, 0);
        $this->SetXY($xVal, $yVal+20);
    
    
        $this->SetXY($xVal+150, $yVal);
        $this->Write(0, 'Reference No ', '', 0, 'L', true, 0, false, false, 0);
        $this->SetXY($xVal+180, $yVal);
        $this->Write(0, ': '.TRANSFER_ORDER_PREFIX."0".$this->record['id'], '', 0, 'L', true, 0, false, false, 0);
        
        $this->SetXY($xVal+150, $yVal+4);
        $this->Write(0, 'Date ', '', 0, 'L', true, 0, false, false, 0);
        $this->SetXY($xVal+180, $yVal+4);
        $this->Write(0, ': '.date("Y-m-d", strtotime($this->record['transfer_date'])), '', 0, 'L', true, 0, false, false, 0);

        
    }

    // Page footer
    public function Footer() {
        $this->SetFont('helvetica', 'I', 8);

        $this->SetXY(5,120);
        $this->Cell(16, 10, 'Approved By', 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->SetXY(30,120);
        $this->Cell(16, 10, '...........................................................', 0, false, 'L', 0, '', 0, false, 'T', 'M');
           
        $this->SetXY(5,120);
        $this->Cell(170, 10, 'Issued By', 0, false, 'R', 0, '', 0, false, 'T', 'M');
        $this->SetXY(180,120);
        $this->Cell(16, 10, '...........................................................', 0, false, 'L', 0, '', 0, false, 'T', 'M');
           
        $this->SetXY(5,130);
        $this->Cell(16, 10, 'This is a computer generated copy', 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->SetXY(80,130);
        $this->Cell(10, 10, 'Printed Date : '.date("Y-m-d h:i A"), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        // $this->SetXY(162,130);
        // $this->Cell(10, 10, 'Printed By : '.date("Y-m-d h:i A"), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        
    }
}

$rowperPage =10;
$pageTemplate = 1;
$tableStartYAx = 45;
$orientation = "P";
$width = 241.3;  
$height = 139.7; 
$orientation = ($height>$width) ? 'P' : 'L'; 
$itemsPerHalfPage = $rowperPage;


$totalItems = count($record['items']);


$totalPages = count($record['items'])%$rowperPage;
$page_num = intval(count($record['items'])/$rowperPage);

if($totalPages == 0) {
    $pages = $page_num;
} else {
    $pages = $page_num + 1;
}



// $pdf->addFormat("custom", $width, $height);  
// $pdf->reFormat("custom", $orientation); 
$pageLayout = array($width, $height);

// $pdf = new MYPDF($orientation, PDF_UNIT, $pageLayout, true, 'UTF-8', false);
$pdf = new MYPDF($orientation, PDF_UNIT, $pageLayout, true, 'UTF-8', false, $record);
$pdf->setData($app_data, $record);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PSC');
$pdf->SetTitle('Transfer Order');
$pdf->SetSubject('Transfer Order');
$pdf->SetKeywords('TransferOrder');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(10);
$pdf->SetPrintHeader(true);
$pdf->SetPrintFooter(true);

// set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Add a page
// This method has several options, check the source code documentation for more information.
// echo $pages;  exit;
for ($i=0; $i < $pages; $i++) { 

    $pdf->AddPage();

    $pdf->Ln(4);

// $txt = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';

// // Multicell test
// $pdf->MultiCell(55, 5, '[LEFT] '.$txt, 1, 'L', 1, 0, '', '', true);

    // header row

    $xVal = 5;
    $yVal = $tableStartYAx;
    $pdf->SetFont('helvetica', 'R', 8);
    $pdf->SetXY($xVal, $yVal);
    $r = 1; 

    $table = <<<EOD
    <table cellspacing="0" cellpadding="1" border="0.5">
    <tr style="font-size:12px; height: 20px;">
        <td border="0.5" style="text-align:left;height: 20px; width: 80%">Item Name</td>
        <td border="0.5" style="text-align:right; width: 20%">Qty</td>
    </tr>
EOD;

    $total = 0;
    foreach ($record['items'] as $key=>$row):
        $name = $row['paddy_name'];
        $qty = $row['transfer_amount'];
        $total += $qty;
    $table .= <<<EOD
    <tr>
        <td style="text-align:left;">$name</td>
        <td style="text-align:right;">$qty</td>
    </tr>
EOD;

    $yVal += 5;
    $r++; endforeach;

    $table .= <<<EOD
</table>
EOD;
    $table .= <<<EOD
    <table cellspacing="0" cellpadding="1">
EOD;
    $table .= <<<EOD
    <tr style="font-size:12px;">
        <td border="0.5" style="text-align:left; width:80%">Sub Total</td>
        <td border="0.5" style="text-align:right; width:20%">$total</td>
    </tr>
EOD;



$table .= <<<EOD
</table>
EOD;

    $pdf->writeHTML($table, true, false, false, false, '');

}


// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('transfer.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+