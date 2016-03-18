  <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS075
* Program Name     : Form Purchase Order
* Description      :
* Environment      : PHP 5.4.4
* Author           : Annisa Intan Fadila
* Version          : 01.00.00
* Creation Date    : 12-02-2015 08:05:00 ICT 2015
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_OAS075 extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}
	
	//mengambil data 
	function getFormID($form_id)
	{
		$sql = "SELECT 
                tv.ID_VENDOR id_vendor,
                tv.COMPANY company,
                tv.ATTN attn,
                tv.ADDRESS address,
                tv.CITY city,
                tv.PHONE phone,
                tv.ZIP zip,
                tv.FAX fax
                
			FROM 
                 tb_r_pr pr,
                 tb_r_vendor tv        
            
			where 
                  pr.VENDOR = tv.ID_VENDOR AND
				  pr.PR_ID = '$form_id'";
	return fetchArray($sql, 'all');
	}
	
	function submitPOform($data)
	{
	$ack = 0;
	$year = date("Y");
	$monthly = DATE("m");
	$formID = null;
	$refno = null;

		$month['01'] = 'I';
		$month['02'] = 'II';
		$month['03'] = 'III';
		$month['04'] = 'IV';
		$month['05'] = 'V';
		$month['06'] = 'VI';
		$month['07'] = 'VII';
		$month['08'] = 'VIII';
		$month['09'] = 'IX';
		$month['10'] = 'X';
		$month['11'] = 'XI';
		$month['12'] = 'XII';
	$sql = "INSERT INTO tb_r_po (	REF_NO,
									PR_ID,
								   V_COMPANY, 
								   V_ATTN, 
								   V_ADDRESS, 
								   V_CITY, 
								   V_PHONE, 
								   V_ZIP, 
								   V_FAX, 
									ST_COMPANY, 
									ST_CP, 
									ST_ADDRESS, 
									ST_MPHONE, 
									ST_EMAIL,
									ST_NPWP,
									REMARK,
									AMOUNT_PPN,
									AMOUNT_TOTAL,
									CREATED_BY, 
									CREATED_DT
									) 
			VALUES 
		 
							(CONCAT(
									RIGHT(1000+(SELECT COUNT(*) FROM tb_r_po po WHERE YEAR(po.CREATED_DT) = '$year') +1,3),
				                    '/$data[KODE]-PO/',
								    '$month[$monthly]/',
				                    '$year'),
					 '$data[PR_ID]',
					 '$data[V_COMPANY]',
					 '$data[V_ATTN]',
					 '$data[V_ADDRESS]',
					 '$data[V_CITY]',
					 '$data[V_PHONE]',
					 '$data[V_ZIP]',
					 '$data[V_FAX]',
					 '$data[ST_COMPANY]',
					 '$data[ST_CP]',
					 '$data[ST_ADDRESS]',
					 '$data[ST_MPHONE]',
					 '$data[ST_EMAIL]',
					 '$data[ST_NPWP]',
					 '$data[REMARK]',
					 '$data[AMOUNT_PPN]',
					 '$data[AMOUNT_TOTAL]',
					 'user: $data[this_email]',
					 '".date("Y-m-d H:i:s")."')";
					 
		if($this->db->query($sql))
		{
			$ack = 1;
		}
		
		if($ack == 1){
			$formID = $this->getFormIdPO($data['PR_ID']);
			$formIDPR = $this->getFormIdPR($data['PR_ID']);
			$refno = $this->getRefNo($formID);
			$sql = "INSERT INTO
							  tb_r_form_status(FORM_TYPE_ID,
												FORM_ID,
												TARGET_EMPLOYEE_ID,
												STATUS
												)
					VALUES
								('7',
								 '$formIDPR',
								 '$data[EMPLOYEE_RM_ID]',
						         '0')";
			if($this->db->query($sql))
			{
				$ack = 2;
			}
		}
		if($ack == 2){
			$sql = "UPDATE 
						tb_r_pr
					SET 
						STATUS='10'
						
					WHERE 
						PR_ID = '$data[PR_ID]'";
			if($this->db->query($sql))
			{
				$ack = 3;
			}
		}
		if($ack == 3){
			$sql = "UPDATE 
						tb_r_form_status
					SET 
						STATUS='10'
												
					WHERE 
						FORM_TYPE_ID = '4' AND
						FORM_ID = '$data[PR_ID]'";
			if($this->db->query($sql))
			{
				$ack = 4;
			}
		}
		if($ack == 4){
		$tujuan = $data['PURCHASE_EMAIL']; //mengambil email requester
        $judul = "Purchase Order"; //Judul email
        //isi email
		$isi = "<div style='width:600px;font-family:arial;font-size:12px'>
				<p>Dear <b>".$data['PURCHASE_NAME']."</b>, <br><br>
                 ".$data['this_name']." <b> Submitted </b> an application for Purchase Order.</p>
                <br><br>
				<a href='http://intranet.cybertrend-intra.com/'>Visit COAST for Approve Purchase Order</a><br><br>
                *Do not reply this email. <br><br>
                </div>";
				//header email
		$headers = "MIME-Version: 1.0"."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
        $headers .= "From: COAST - Purchase Order \r\n";
        
        //send email
        if(mail($tujuan,$judul,$isi,$headers)){
            echo  "<br>Sending notifikasi to ".$tujuan." success";//jika terkirim
        }else{
            echo "<br>Sending notifikasi to ".$tujuan." failed";//jika tidak terkirim
        }
			{
				$ack = 5;
			}
		}
		if($ack == 5){
			$sql = "INSERT INTO
							  tb_r_notification (RECIPIENT_EMPLOYEE_ID,
							  					SENDER_EMPLOYEE_ID,
							  					ACTIVITY_TYPE_ID,
							  					FORM_TYPE_ID,
												FORM_ID,
												NOTIFICATION_INFORMATION,
												NOTIFICATION_STATUS_ID,
												NOTIFICATION_TIME,
												CREATED_BY,
												CREATED_DT)
					VALUES
								('$data[EMPLOYEE_RM_ID]',
								 '$data[EMPLOYEE_ID]',
								 '0',
						         '7',
						         '$formIDPR',
						         'No. Ref: $refno',
						         '1',
						         '".date("Y-m-d H:i:s")."',
						         '$data[this_name]',
					         	 '".date("Y-m-d H:i:s")."')";
			if($this->db->query($sql))
		
		return $ack;
		
	}	
	}
	

function cek_no_ref(){	
		$sql = "SELECT 
					rpr.PR_ID id,
					rpr.REF_NO no_ref
				FROM
					tb_r_pr rpr,
                  tb_r_form_status fs
				WHERE
                     rpr.PR_ID = fs.FORM_ID AND
                     rpr.DIBUAT_PO ='1' AND
					 rpr.STATUS !=10 AND
                     fs.FORM_TYPE_ID = '4' AND
                     fs.STATUS ='18'";
		return fetchArray($sql, 'all');
	}	
	
	
	function get_detail($form_id)
	{
		$sql = "SELECT  
		pr.DIBUAT_PO status_po,  
        year(pr.DATE_1PAYMENT) y1,
        year(pr.DATE_2PAYMENT) y2,
        year(pr.DATE_3PAYMENT) y3,
        year(pr.DATE_4PAYMENT) y4,
        po.REF_NO no_ref,
        po.PR_ID po_id,
		pr.REF_NO no_ref_pr,
        pr.PR_ID pr_id,
        empl.EMPLOYEE_NAME employee_name,
		empl.EMPLOYEE_ID employee_id,
		empl.GROUP_ID employee_group,
		usr.USER_EMAIL employee_email,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.GROUP_ID ) employee_group_name,
		empl.DIVISION_ID employee_division,
		(select pos.POSITION_NAME from tb_m_position pos where pos.POSITION_ID = empl.DIVISION_ID ) employee_division_name,
		usr.USER_EMAIL employee_email,
        pr.CHARGE_CODE chargecode,
        pr.CREATED_DT submitted_dt, 
		pr.AMOUNT_ITEM amount,
		cc.TYPE cctype,
        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
		cc.PROJECT_DESCRIPTION ccdes,
        fs.TARGET_EMPLOYEE_ID approval,  
        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,          
		pr.CURRENCY currency,
        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = pr.CURRENCY )  currency_name,
		fs.DIR_APPROVE dir_approve,
		fs.FINAL_APPROVE finance,
		fs.PUR_APPROVE pur_approve,
        sys.VALUE status,
        pr.REMARK remarks,
		fs.REMARKS remarksrm,
		fs.CREATED_DT approverm_dt,
		fs.CREATED_BY approverm_by,
		fs.APPROVEGR_DT approvegr_dt,
		fs.APPROVEGR_BY approvegr_by,
		fs.REMARKS_GR remarksgr,
		fs.REMARKS_DIR remarksdir,
		fs.APPROVEDIR_DT approvedir_dt,
		fs.APPROVEDIR_BY approvedir_dy,
		fs.REMARKS_REVISE remarksfinance,
		fs.APPROVEPUR_DT approvepur_dt,
		fs.APPROVEPUR_BY approvepur_dy,
		fs.REMARKS_PUR remarkspur,
		fs.UPDATED_DT accepted_dt,
		fs.UPDATED_BY accepted_by,
		fs.STATUS status_id,
		(select sys.VALUE from tb_m_system sys where sys.SYS_CAT = '26' AND sys.SYS_CD = fs.STATUS) status_name,
        pr.C_TYPE c_type,
        pr.B_STATUS b_status,  
        pr.Q_NO q_no,
        pr.DOWN_PAYMENT k1_pay,
        pr.DATE_1PAYMENT tgl1,
		pr.REMARK_P1 r1,
        pr.2ND_PAYMENT k2_pay,
		pr.DATE_2PAYMENT tgl2,
		pr.REMARK_P2 r2,
        pr.3RD_PAYMENT k3_pay,
        pr.DATE_3PAYMENT tgl3,
		pr.REMARK_P3 r3,
        pr.FINAL_PAYMENT k4_pay,
        pr.DATE_4PAYMENT tgl4,
		pr.REMARK_P4 r4
FROM 
		tb_r_form_status fs,
		tb_m_employee empl,
		tb_r_po po,
		tb_r_pr pr,
        tb_m_charge_code cc, 
		tb_m_user usr,
		tb_m_system sys
WHERE 
        po.PR_ID = '$form_id' AND
		po.PR_ID = pr.PR_ID AND
		pr.CHARGE_CODE = cc.CHARGE_CODE AND
		pr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
		sys.SYS_CAT = '26' AND
		usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		sys.SYS_CD = fs.STATUS AND
		fs.FORM_ID = po.PR_ID AND
		fs.FORM_TYPE_ID = '7'
ORDER BY 
         po.PR_ID desc";	
		return fetchArray($sql, 'row');
	}
	
	function get_form_detail($form_id)
	{
		$sql = "SELECT
	  rpr.PR_ID id,
      rpr.REF_NO no_ref,
      pr.QTY jumlah,
      pr.SATUAN unit,
      pr.NAMA namabarang,
      pr.HARGA price,
	  pr.KETERANGAN keterangan,
      pr.TOTAL total,
      sys.VALUE curs,
	  rpr.AMOUNT_ITEM cupcup
      
      from tmp_item_pr pr,
	  tb_r_pr rpr,
	  tb_m_system sys
      
WHERE

     pr.PR_ID = '$form_id' AND
	 rpr.PR_ID = pr.PR_ID AND
     rpr.CURRENCY = sys.SYS_CD AND
      sys.SYS_CAT = 16 ";
      
		return fetchArray($sql, 'all');
	}
	
	function getFormIdPO( $prid)
	{
		$sql = "SELECT
						po.PO_ID
				FROM
						tb_r_po po
				WHERE
						po.PR_ID = '$prid' ";
		return fetchArray($sql, 'one');
	}
	
	function getFormIdPR( $prid)
	{
		$sql = "SELECT
						po.PR_ID
				FROM
						tb_r_po po
				WHERE
						po.PR_ID = '$prid' ";
		return fetchArray($sql, 'one');
	}
	
	function get_form_RM()
	{
	$sql = "SELECT
						EMPLOYEE_ID id
				FROM
						tb_m_employee
				WHERE
						DIVISION_ID = 'FA' AND
                        POSITION_DEPTH_ID = '4' AND
                        LEVEL_ID = '5'" ;
		
		return fetchArray($sql, 'row');				
	}
	
	function getRefNo( $formid)
	{
		$sql = "SELECT
						po.REF_NO refno
				FROM
						tb_r_po po
				WHERE
						po.PO_ID = '$formid'  ";
		return fetchArray($sql, 'one');
	}
	
	function get_ship_to($form_id)
	{
		$sql = "SELECT
						st.SHIPTO_ID id_shipto, 
                        st.S_COMPANY scompany, 
                        st.S_ADDRESS saddress, 
                        st.S_CP scp, 
                        st.S_TELP stelp, 
                        st.S_EMAIL semail, 
                        st.S_NPWP snpwp 
                        					
				FROM
						tb_r_shipto st,
                        tb_r_pr pr
      
      WHERE
      st.SHIPTO_ID = pr.SHIP_TO AND
      pr.PR_ID ='$form_id'";
	  return fetchArray($sql, 'all');
	}
	
	
	function get_form_referensi($form_id)
	{
	$sql = "SELECT

      rpr.REF_NO no_ref,
      pr.QTY jumlah,
      pr.SATUAN unit,
      pr.NAMA namabarang,
      pr.HARGA price,
      pr.TOTAL total,
	  sys.VALUE curs
      
     FROM tmp_item_pr pr,
	  tb_r_pr rpr,
      tb_m_system sys
	  
WHERE

	 pr.PR_ID = '$form_id' AND
	 rpr.PR_ID = pr.PR_ID AND
     rpr.CURRENCY = sys.SYS_CD AND
      sys.SYS_CAT = 16 ";
      
		return fetchArray($sql, 'row');
	}

}