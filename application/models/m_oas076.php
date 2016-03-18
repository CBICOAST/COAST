 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS076
* Program Name     : Form Print PDF Purchase Order
* Description      :
* Environment      : PHP 5.4.4
* Author           : Annisa Intan Fadila
* Version          : 01.00.00
* Creation Date    : 12-03-2015 08:05:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>

<?php
class m_oas076 extends CI_Model{



function alldata($form_id){
$query2= $this->db->query("SELECT
		po.PO_ID po_id,
		po.REF_NO no_ref_po,
	  rpr.REF_NO no_ref,
	  rpr.AMOUNT_ITEM subtotal,
	  rpr.CURRENCY curs_pr,
	  (SELECT CASE WHEN rpr.CURRENCY = '1' then 'Rp. ' WHEN rpr.CURRENCY = '2' then 'US$ ' WHEN rpr.CURRENCY = '3' then 'S$ ' END) kode_curs, 
	  po.AMOUNT_PPN ppn,
	  po.AMOUNT_TOTAL totalfinal,
	  pr.NO no,
      pr.QTY jumlah,
      pr.SATUAN unit,
      pr.KETERANGAN namabarang,
      pr.HARGA price,
      pr.TOTAL total
	  
     FROM 
	 
	 tmp_item_pr pr,
	 tb_r_po po,
	 tb_r_pr rpr,
     tb_m_system sys
	  
WHERE

	po.PO_ID = '$form_id' AND
	 po.PR_ID = pr.PR_ID AND
	 rpr.DIBUAT_PO = 1 AND
	 rpr.PR_ID = pr.PR_ID AND
     rpr.CURRENCY = sys.SYS_CD AND
      sys.SYS_CAT = 16");
	  
return $query2;
                }
				
function alldata2($form_id){
$query3= $this->db->query ("SELECT
		po.PO_ID po_id,
	  rpr.CURRENCY curs_pr,
	  (SELECT CASE WHEN rpr.CURRENCY = '1' then 'Rp. ' WHEN rpr.CURRENCY > '1' then '$ ' END) kode_curs, 
	  po.REMARK remarks,
	  DATE_FORMAT (rpr.DATE_1PAYMENT, '%d %M %Y') date1pay,
	  DATE_FORMAT (rpr.DATE_2PAYMENT, '%d %M %Y') date2pay,
	  DATE_FORMAT (rpr.DATE_3PAYMENT, '%d %M %Y') date3pay,
	  DATE_FORMAT (rpr.DATE_4PAYMENT, '%d %M %Y') date4pay,
	  rpr.DOWN_PAYMENT downpay,
	  rpr.2ND_PAYMENT secondpay,
	  rpr.3RD_PAYMENT thirdpay,
	  rpr.FINAL_PAYMENT finalpay,
	  rpr.REMARK_P1 remarkp1,
	  rpr.REMARK_P2 remarkp2,
	  rpr.REMARK_P3 remarkp3,
	  rpr.REMARK_P4 remarkp4,
	  sys.VALUE curs,
	  fs.PUR_APPROVE pur_approve,
	  fcl.CREATED_BY createdby,
	  (SELECT CASE WHEN emp.POSITION_DEPTH_ID = '5' AND emp.LEVEL_ID = '6' AND emp.DIVISION_ID = 'FA'  then 'Purchasing ' WHEN emp.POSITION_DEPTH_ID = '4' AND emp.LEVEL_ID = '5' AND emp.DIVISION_ID = 'FA' then 'Purchasing Head ' END) position_name
	  
      
     FROM 
	 
	 
	 tb_r_po po,
	  tb_r_pr rpr,
      tb_m_system sys,
	  tb_r_form_status fs,
     tb_r_form_confirmation_list fcl,
	 tb_m_employee emp
	  
WHERE

	 po.PO_ID = '$form_id' AND
	 rpr.DIBUAT_PO = 1 AND
	 fs.FORM_ID = po.PR_ID AND
     po.PR_ID = rpr.PR_ID AND
     (fs.STATUS = 1 OR fs.STATUS = 3) AND
     fs.FORM_TYPE_ID = 7 AND
     fcl.FORM_TYPE_ID = fs.FORM_TYPE_ID AND
     fcl.FORM_ID = fs.FORM_ID AND
     fcl.CONFIRMATION_ID = 1 AND
     rpr.CURRENCY = sys.SYS_CD AND
      sys.SYS_CAT = 16 AND
	   emp.EMPLOYEE_NAME = fcl.CREATED_BY");	
return $query3;	  
}
}
?>


