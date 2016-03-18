<?php
header('Content-type: application/pdf');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class c_oas076 extends MY_Controller {

		
function __construct()
	{
		parent::__construct();

		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');
		$this->url = empty($index) ? $host : $host . $index . '/';
		$this->load->model('m_oas076');
		
		
	}
function cetak($form_id) {

$this->load->helper('path');
$font_dir = './font/';
set_realpath($font_dir);
$this->load->library('fpdf');
define('FPDF_FONTPATH', $font_dir);
$this->fpdf->AddPage();
$this->fpdf->SetMargins(15,15,5,5);
$query = $this->db->query("SELECT
		po.PO_ID po_id,
		po.REF_NO no_ref_po,
	  rpr.REF_NO no_ref,
	  DATE_FORMAT (po.CREATED_DT, '%d %M %Y') datepo,
	  rpr.CURRENCY curs_pr,
	  (SELECT CASE WHEN rpr.CURRENCY = '1' then 'Rp. ' WHEN rpr.CURRENCY > '1' then '$ ' END) kode_curs, 
	  po.REMARK remarks,
	  sys.VALUE curs,
	  vd.ID_VENDOR vendor_id,
	  vd.COMPANY company,
	  vd.ATTN attn,
	  vd.ADDRESS address,
	  vd.CITY city,
	  vd.PHONE phone,
	  vd.ZIP zip,
	  vd.FAX fax,
	  st.SHIPTO_ID id_ship,
	  st.S_COMPANY scompany,
	  st.S_ADDRESS saddress,
	  st.S_CP scp,
	  st.S_TELP stelp,
	  st.S_EMAIL semail,
	  st.S_NPWP snpwp,
	  fs.PUR_APPROVE pur_approve,
	  fcl.CREATED_BY createdby,
	  po.REMARK remarks
	  
      
     FROM 
	 
	 
	 tb_r_po po,
	  tb_r_pr rpr,
	  tb_r_vendor vd,
	  tb_r_shipto st,
      tb_m_system sys,
	  tb_r_form_status fs,
     tb_r_form_confirmation_list fcl
	  
WHERE

	 po.PO_ID = '$form_id' AND
	 rpr.DIBUAT_PO = 1 AND
     st.SHIPTO_ID = rpr.SHIP_TO AND
	 vd.ID_VENDOR = rpr.VENDOR AND
	 po.PR_ID = rpr.PR_ID AND
	 fs.FORM_ID = po.PR_ID AND
     (fs.STATUS = 1 OR fs.STATUS = 3) AND
     fs.FORM_TYPE_ID = 7 AND
     fcl.FORM_TYPE_ID = fs.FORM_TYPE_ID AND
     fcl.FORM_ID = fs.FORM_ID AND
     fcl.CONFIRMATION_ID = 1 AND
     rpr.CURRENCY = sys.SYS_CD AND
      sys.SYS_CAT = 16")->result();


$this->fpdf->Image('images/logo.png', 12,8,60,20, 'PNG');	   
$this->fpdf->SetFont('Arial', 'B', 14);
$this->fpdf->Ln(10);
$this->fpdf->Cell(0, 10, 'PURCHASE ORDER', 0,1, 'C');
$this->fpdf->Line(15,28,198,28);
$this->fpdf->Ln(4);

foreach($query as $data)
{
$this->fpdf->SetFont('Arial',  '', 10);
$this->fpdf->Cell(45, 7, 'Purchase Order No ', 0, 'R');
 $this->fpdf->Cell(5, 7, ':', 0, 'R');
$this->fpdf->Cell(45, 7,  $data->no_ref_po, 0, 'R');
$this->fpdf->Cell(50, 7, 'Ref No', 0, '');
 $this->fpdf->Cell(5, 7, ':', 0, 'R');
$this->fpdf->Cell(50, 7, $data->no_ref, 0, 'R');
$this->fpdf->Ln();

$this->fpdf->Cell(45, 7, 'Date', 0, 'R');
 $this->fpdf->Cell(5, 7, ':', 0, 'R');
$this->fpdf->Cell(45, 7, $data->datepo, 0, 'R');
$this->fpdf->Cell(50, 7, 'Currency', 0, 'R');
 $this->fpdf->Cell(5, 7, ':', 0, 'R');
$this->fpdf->Cell(50, 7, $data->curs, 0, 'R');
$this->fpdf->Ln();

$this->fpdf->Line(15,50,198,50);
$this->fpdf->Line(15,51,198,51);
$this->fpdf->Line(15,52,198,52);
$this->fpdf->Ln(5);

$this->fpdf->SetFont('Arial', 'B', 12);
$this->fpdf->Cell(90,10,'Vendor',0,0,'C');
$this->fpdf->Cell(90,10,'Ship to',0,0,'C');
$this->fpdf->Ln(10);

$this->fpdf->SetFont('Arial', '', 10);
$this->fpdf->Cell(40,5, 'Company',0, 'R');
$this->fpdf->Cell(5, 5, ':', 0, 'R');
$this->fpdf->Cell(60,5, $data->scompany, 0, 'R');
$this->fpdf->Cell(30,5, 'Company', 0, 'R');
$this->fpdf->Cell(5, 5, ':',  0, 'R');
$this->fpdf->Cell(30,5, $data->company, 0,'R');
$this->fpdf->Ln();

$this->fpdf->Cell(40,5, 'Address', 0, 'R');
$this->fpdf->Cell(5, 5, ':', 0, 'R');
$this->fpdf->Cell(60,5, $data->saddress, 0, 'R');
$this->fpdf->Cell(30,5, 'Attn', 0,  'R');
$this->fpdf->Cell(5, 5, ':', 0, 'R');
$this->fpdf->Cell(30,5, $data->attn, 0, 'R');
$this->fpdf->Ln();

$this->fpdf->Cell(40,5, 'Contact Person', 0, 'R');
$this->fpdf->Cell(5, 5, ':', 0, 'R');
$this->fpdf->Cell(60,5, $data->scp, 0, 'R');
$this->fpdf->Cell(30,5, 'Address', 0, 'R');
$this->fpdf->Cell(5, 5, ':', 0, 'R');
$this->fpdf->Cell(30,5, $data->address, 0, 'R');
$this->fpdf->Ln();

$this->fpdf->Cell(40,5, 'Phone', 0, 'R');
$this->fpdf->Cell(5, 5, ':', 0, 'R');
$this->fpdf->Cell(60,5, $data->stelp, 0, 'R');
$this->fpdf->Cell(30,5, 'City', 0, 'R');
$this->fpdf->Cell(5, 5, ':', 0, 'R');
$this->fpdf->Cell(30,5, $data->city, 0,'R');
$this->fpdf->Ln();

$this->fpdf->Cell(40,5, 'Email', 0, 'R');
$this->fpdf->Cell(5, 5, ':', 0, 'R');
$this->fpdf->Cell(60,5, $data->semail, 0, 'R');
$this->fpdf->Cell(30,5, 'Phone', 0, 'R');
$this->fpdf->Cell(5, 5, ':', 0,'R');
$this->fpdf->Cell(30,5, $data->phone, 0,'R');
$this->fpdf->Ln();

$this->fpdf->Cell(40,5, 'NPWP', 0, 'R');
$this->fpdf->Cell(5, 5, ':', 0, 'R');
$this->fpdf->Cell(60,5, $data->snpwp, 0, 'R');
$this->fpdf->Cell(30,5, 'Zip', 0,'R');
$this->fpdf->Cell(5, 5, ':', 0,'R');
$this->fpdf->Cell(30,5, $data->zip, 0, 'R');
$this->fpdf->Ln();

$this->fpdf->Cell(40,5, '', 0, 'R');
$this->fpdf->Cell(5, 5, '', 0, 'R');
$this->fpdf->Cell(60,5, '', 0, 'R');
$this->fpdf->Cell(30,5, 'Fax', 0,'R');
$this->fpdf->Cell(5, 5, ':', 0,'R');
$this->fpdf->Cell(30,5, $data->fax, 0,'R');
$this->fpdf->Ln(10);}


//tabel item
$this->fpdf->SetFont('Arial',  'B', 10);
$this->fpdf->Ln(1);
$this->fpdf->Cell(20,5,'No',1,0,'C');
$this->fpdf->Cell(20,5,'Qty',1,0,'C');
$this->fpdf->Cell(30,5,'Unit',1,0,'C');
$this->fpdf->Cell(30,5,'Description',1,0,'C');
$this->fpdf->Cell(40,5,'Price',1,0,'C');
$this->fpdf->Cell(40,5,'Total',1,0,'C');
$this->fpdf->Ln();

$this->load->model('m_oas076','',TRUE);
$query=$this->m_oas076->alldata($form_id);
$no = 1;
foreach ($query->result() as $column){
$this->fpdf->SetFont('Arial',  '', 10);		
$this->fpdf->Cell(20,6,$no++,1,0,'C');
$this->fpdf->Cell(20,6,$column->jumlah,1,0,'C');
$this->fpdf->Cell(30,6,$column->unit,1,0,'C');
$this->fpdf->Cell(30,6,$column->namabarang,1,0,'C');
$this->fpdf->Cell(40,6,$column->kode_curs.'  '.number_format($column->price,0,",","."),1,0,'C');
$this->fpdf->Cell(40,6,$column->kode_curs.'  '.number_format($column->total,0,",","."),1,0,'C');
$this->fpdf->Ln();
$this->fpdf->SetFont('Arial',  'B', 10);	
$this->fpdf->Cell(140,6,'Sub Total',1,0,'R');
$this->fpdf->Cell(40,6,$column->kode_curs.'  '.number_format($column->subtotal,0,",","."),1,0,'C');
$this->fpdf->Ln();
$this->fpdf->SetFont('Arial',  'B', 10);	
$this->fpdf->Cell(140,6,'VAT 10%',1,0,'R');
$this->fpdf->Cell(40,6,$column->kode_curs.'  '.number_format($column->ppn,0,",","."),1,0,'C');
$this->fpdf->Ln();
$this->fpdf->SetFont('Arial',  'B', 10);	
$this->fpdf->Cell(140,6,'Total (Sub Total + VAT 10%)',1,0,'R');
$this->fpdf->Cell(40,6,$column->kode_curs.'  '.number_format($column->totalfinal,0,",","."),1,0,'C');
$this->fpdf->Ln();
$this->fpdf->Ln(5);}



$this->fpdf->Ln(8);

$this->load->model('m_oas076','',TRUE);
$query=$this->m_oas076->alldata2($form_id);
foreach ($query->result() as $column){
$this->fpdf->MultiCell(70, 7, 'Note :', 0, 'L');
$this->fpdf->MultiCell(150, 50, $data->remarks, 0,'L');
$this->fpdf->Ln(10);


$this->fpdf->Cell(60, 7, 'Approved by,', 0, 0,'L');
$this->fpdf->Cell(100, 7, 'Supplier to Sign below', 0, 0,'R');
$this->fpdf->Ln();

$this->fpdf->Cell(60, 50, '', 0, 0,'L');
$this->fpdf->Cell(100, 7, 'Acknowledge by:', 0, 0,'R');

$this->fpdf->Ln(35);


$this->fpdf->Cell(50, 7, $column->createdby, 0, 'L');
$this->fpdf->Line(134,260,172,260);
$this->fpdf->Ln();

$this->fpdf->Line(15,260,60,260);



$this->fpdf->Cell(60, 7, $column->position_name, 0, 0,'L');

}

$this->fpdf->Output();


}
}?>