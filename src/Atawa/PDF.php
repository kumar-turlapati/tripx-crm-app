<?php

namespace Atawa;

use Atawa\Utilities;

include_once __DIR__.'../../../libraries/fpdf181/fpdf.php';

class PDF extends FPDF {

  private static $pdf = null;
  private static $client_details = null;

  public static function getInstance() {
    if(self::$pdf == null) {
      self::$pdf = new PDF;
    }
    return self::$pdf;
  }

  public function get_client_details() {
    return Utilities::get_client_details();
  }

  public function Header() {

    $client_details = $this->get_client_details();
    if($client_details['logoName'] !== '') {
      // var_dump($_SERVER);
      // exit;
      $site_abs_path = 'http://'.$_SERVER['HTTP_HOST'];
      $logo_path = $site_abs_path.'/bassets/'.$client_details['logoName'];
      $this->Image($logo_path,10,6,50);
    }

    // Logo
    //$this->Image('http://apex.trixstaging.in/sites/all/bassets/apex-logo.jpg',10,6,50);
    // $this->Image('http://apex.atawahms.local/sites/all/bassets/apex-logo.jpg',10,6,50);

    // Arial bold 15
    $this->SetFont('Arial','B',15);

    // Move to the right
    $this->Cell(70);

    // Title
    $this->Cell(30,-5,$client_details['businessName'],'',2,'L');

    $this->SetFont('Arial','B',8);    
    $this->Cell(100,14,$client_details['addr1'],'',2,'L');
    $this->Cell(100,-8,$client_details['addr2'],'',2,'L');
    $this->Cell(100,15,'Phone(s):'.$client_details['phones'],'',2,'L');
    if(isset($client_details['businessCategory']) && $client_details['businessCategory'] === 1) {
      $this->Cell(100,-8,'DL No.:'.$client_details['dlNo'],'',1,'L');
    }
    if(isset($client_details['gstNo']) && $client_details['gstNo'] !== '') {
      $this->Cell(100,-8,'GSTIN:'.$client_details['gstNo'],'',1,'L');      
    }
    $this->Ln(5);
    $this->Cell(0,0,'','B',1);
    $this->Ln(5);   
  }

  // Page footer
  public function Footer() {
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
  }  

}