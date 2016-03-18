 <?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS077
* Program Name     : Detail Purchase Request
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 24-02-2015 16:09:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_OAS082 extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('m_oas092', 'ca_form_model');
		$this->load->model('m_oas072', 'listpr_form_model');
		
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';
		
	}

	function index()
	{
		
		$this->load->view('v_oas082');
	}

	function load_form ($form_id)
	{
		$param['this_id'] = $this->user['id'];
		$param['form_detail'] = $this->ca_form_model->get_form_detail($form_id);
		$param['list_pr'] = $this->ca_form_model->get_list_tmppr($form_id);	
		$param['list_doc'] = $this->ca_form_model->get_list_doc($form_id);	
		$param['detail_rm'] = $this->_get_employee_rm($param['form_detail']['employee_id']);
		$param['detail_group'] = $this->_get_employee_group($param['form_detail']['employee_id']);
		$param['detail_division'] = $this->_get_employee_division($param['form_detail']['employee_id']);
		$param['detail_role'] = $this->_get_employee_role($param['form_detail']['employee_id']);
		
		$param['detail_dir'] = $this->_get_employee_dir($param['form_detail']['employee_id']);
		$param['detail_pur'] = $this->_get_employee_pur($param['form_detail']['employee_id']);
		$param['detail_akun'] = $this->_get_employee_akun($param['form_detail']['employee_id']);
		
		$this->load->view('v_oas082', $param);
	}
	
	
	function submit_approval()
	{
		if($this->input->post('ajax') == '1')
		{
			$sbmt['this_id'] = $this->user['id'];
			$sbmt['this_name'] = $this->user['name'];
			$sbmt['FORM_TYPE_ID']  	  = $this->input->post('form_type_id');
			$sbmt['ACTIVITY_TYPE_ID']  	  = $this->input->post('activity');
			$sbmt['FORM_ID']     	  = $this->input->post('form_id');
			$sbmt['FINAL_APPROVE'] 	 		  = $this->input->post('akuntan');
			$sbmt['DIR_APPROVE'] 	 		  = $this->input->post('dir');
			$sbmt['PURCHASE'] 	 		  = $this->input->post('pur');
			$sbmt['STATUS']  	 	  = $this->input->post('approval');
			$sbmt['REQUESTER']		  = $this->input->post('requesterid');
			$sbmt['SENDER_EMPLOYEE_ID']	= $this->input->post('aprove');
			
			$sbmt['rm']		  = $this->input->post('rm');
			$sbmt['approvalgr']		  = $this->input->post('approvalgr');
			$sbmt['status_id']		  = $this->input->post('status_id');
			$sbmt['status_po']		  = $this->input->post('status_po');
			$sbmt['AMOUNT']			  = $this->input->post('amount');
			$sbmt['LIMIT']			  = $this->input->post('limit');
			$sbmt['TYPECC']			  = $this->input->post('typecc');
			$sbmt['DIVID']			  = $this->input->post('divid');
			$sbmt['ref_no']			  = $this->input->post('refno');
			$sbmt['this_email'] 	  = $this->user['email'];
			$response = $this->ca_form_model->save_confirmation($sbmt);
			
			
			$employeeID					= $this->user['id'];
			$param['employeeGroup']		= $this->user['group'];
			$param['this_id']			= $this->user['id'];
			$param['submission_list']	= $this->listpr_form_model->get_list($param);
			$param['detail_admin']		= $this->_get_employee_admin($employeeID);
			$param['detail_akun'] 		= $this->_get_employee_akun($employeeID);
			$param['detail_dir'] 		= $this->_get_employee_dir($employeeID);
			$param['detail_pur'] 		= $this->_get_employee_pur($employeeID);
			$param['list_group']		= $this->listpr_form_model->get_group_list();
			$param['list_chargecodetype']		= $this->listpr_form_model->get_chargecodetype_list();
			$param['month_list']		= $this->month_list;	
			$param['employee_list']		= $this->listpr_form_model->get_employee_list();
		
			$this->load->view('v_oas074', $param);
		}
	}
	
	
function cetak($form_id) {
$this->load->helper('path');
$font_dir = './font/';
set_realpath($font_dir);
$this->load->library('fpdf');
define('FPDF_FONTPATH', $font_dir);
$this->fpdf->AddPage();
$query = $this->db->query("SELECT  
        pr.REF_NO no_ref,
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
        DATE_FORMAT (pr.CREATED_DT, '%d %M %Y') submitted_dt,
		pr.AMOUNT_ITEM amount,
		cc.TYPE cctype,
	  (SELECT CASE WHEN pr.CURRENCY = '1' then 'Rp. ' WHEN pr.CURRENCY = '2' then 'US$ ' WHEN pr.CURRENCY = '3' then 'S$ ' END) kode_curs, 
        (select pos.VALUE from tb_m_system pos  where pos.SYS_CAT= '11' and  pos.SYS_CD = cc.TYPE )  categorycc_name,
		cc.PROJECT_DESCRIPTION ccdes,
        fs.TARGET_EMPLOYEE_ID approval,  
        (select pos.EMPLOYEE_NAME from tb_m_employee pos where pos.EMPLOYEE_ID = fs.TARGET_EMPLOYEE_ID )  approve_name,          
		pr.CURRENCY currency,
        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '16' and sys.SYS_CD = pr.CURRENCY )  currency_name,		
        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '17' and sys.SYS_CD = pr.B_STATUS )  pay_method_name,
		fs.DIR_APPROVE dir_approve,
		fs.FINAL_APPROVE finance,
        sys.VALUE status,
        pr.REMARK remarks,
		fs.REMARKS remarksrm,
		fs.CREATED_DT approverm_dt,
		fs.CREATED_BY approverm_by,
		fs.APPROVEGR_DT approvegr_dt,
		fs.APPROVEGR_BY approvegr_by,
		fs.REMARKS_GR remarksgr,
		fs.REMARKS_DIR remarksdir,
		fs.APPROVEPUR_DT approvepur_dt,
		fs.APPROVEPUR_BY approvepur_dy,
		fs.REMARKS_PUR remarkspur,
		fs.APPROVEDIR_DT approvedir_dt,
		fs.APPROVEDIR_BY approvedir_dy,
		fs.REMARKS_REVISE remarksfinance,
		fs.UPDATED_DT accepted_dt,
		fs.UPDATED_BY accepted_by,
		pr.DIBUAT_PO buat_po,
		fs.STATUS status_id,
        pr.C_TYPE c_type,
        pr.B_STATUS b_status,
        pr.DOCUMENTSUPPORT supdoc,
        (select vn.COMPANY from tb_r_vendor vn  where  vn.ID_VENDOR = pr.VENDOR )  vendor,
        (select st.S_COMPANY from tb_r_shipto st  where  st.SHIPTO_ID = pr.SHIP_TO)  companyst,
        (select st.S_CP from tb_r_shipto st  where  st.SHIPTO_ID = pr.SHIP_TO)  cpst,
        (select st.S_ADDRESS from tb_r_shipto st  where  st.SHIPTO_ID = pr.SHIP_TO)  alamatst,
        (select st.S_TELP from tb_r_shipto st  where  st.SHIPTO_ID = pr.SHIP_TO)  telpst,
        (select st.S_EMAIL from tb_r_shipto st  where  st.SHIPTO_ID = pr.SHIP_TO)  emailst,
        (select st.S_NPWP from tb_r_shipto st  where  st.SHIPTO_ID = pr.SHIP_TO)  npwpst, 
        (select sys.VALUE from tb_m_system sys  where sys.SYS_CAT= '28' and sys.SYS_CD = pr.DIBUAT_PO )  dibuat_po,
        pr.Q_NO q_no,
        pr.DOWN_PAYMENT downpay,
		pr.REMARK_P1 remarkp1,
		pr.REMARK_P2 remarkp2,
		pr.REMARK_P3 remarkp3,
		pr.REMARK_P4 remarkp4,		
        pr.2ND_PAYMENT secondpay,
        pr.3RD_PAYMENT thirdpay,
        pr.FINAL_PAYMENT finalpay,	
		DATE_FORMAT (pr.DATE_1PAYMENT, '%d %M %Y') date1pay,
		DATE_FORMAT (pr.DATE_2PAYMENT, '%d %M %Y') date2pay,
		DATE_FORMAT (pr.DATE_3PAYMENT, '%d %M %Y') date3pay,
		DATE_FORMAT (pr.DATE_4PAYMENT, '%d %M %Y') date4pay
FROM 
		tb_r_form_status fs,
		tb_m_employee empl,
		tb_r_pr pr,
        tb_m_charge_code cc, 
		tb_m_user usr,
		tb_m_system sys
WHERE 
        pr.PR_ID = '$form_id' AND
		pr.CHARGE_CODE = cc.CHARGE_CODE AND
		pr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		empl.EMPLOYEE_ID = usr.EMPLOYEE_ID AND
		sys.SYS_CAT = '25' AND
		usr.EMPLOYEE_ID = empl.EMPLOYEE_ID AND
		sys.SYS_CD = fs.STATUS AND
		fs.FORM_ID = pr.PR_ID AND
		fs.FORM_TYPE_ID = '4'
ORDER BY 
         pr.PR_ID desc		")->result();
		 
$tabel = $this->db->query("SELECT 	
					pr.NO no,
					pr.QTY qty,
					pr.SATUAN satuan,
	  (SELECT CASE WHEN rpr.CURRENCY = '1' then 'Rp. ' WHEN rpr.CURRENCY = '2' then 'US$ ' WHEN rpr.CURRENCY = '3' then 'S$ ' END) kode_curs, 
					pr.NAMA nama,
					pr.HARGA harga,
					pr.TOTAL total,
					pr.KETERANGAN keterangan
			FROM tmp_item_pr pr, tb_r_pr rpr
			where pr.PR_ID = rpr.PR_ID AND
			pr.PR_ID = '$form_id'")->result();

$this->fpdf->Image('images/logo.png', 12,8,60,20, 'PNG');	  
$this->fpdf->SetFont('Arial', 'B', 14);
$this->fpdf->Ln(10);
$this->fpdf->Cell(0, 15, 'PURCHASE REQUEST DETAIL', 0,1, 'C');
$this->fpdf->Line(11,31,198,31);
$this->fpdf->Line(11,32,198,32);
$this->fpdf->Line(11,33,198,33);
$this->fpdf->SetFont('Arial', '', 12);
$this->fpdf->SetTextColor(0, 0, 0);
foreach($query as $data)
{
$this->fpdf->Cell(45, 7, 'Employee Name', 0, 'L');
$this->fpdf->Cell(5, 7, ':', 0, 'L');
$this->fpdf->Cell(70, 7, $data->employee_name, 0, 'L');
$this->fpdf->Ln();
$this->fpdf->Cell(45, 7, 'NIK', 0, 'L');
$this->fpdf->Cell(5, 7, ':', 0, 'L');
$this->fpdf->Cell(70, 7, $data->employee_id, 0, 'L');
$this->fpdf->Ln();
$this->fpdf->Cell(45, 7, 'Group/Division', 0, 'L');
$this->fpdf->Cell(5, 7, ':', 0, 'L');
$this->fpdf->Cell(70, 7, $data->employee_group.' / '.$data->employee_division , 0, 'L');
$this->fpdf->Ln();
$this->fpdf->Cell(45, 7, 'No. Ref', 0, 'L');
$this->fpdf->Cell(5, 7, ':', 0, 'L');
$this->fpdf->Cell(70, 7, $data->no_ref, 0, 'L');
$this->fpdf->Ln();
$this->fpdf->Cell(45, 7, 'Submitted Date', 0, 'L');
$this->fpdf->Cell(5, 7, ':', 0, 'L');
$this->fpdf->Cell(70, 7, $data->submitted_dt, 0, 'L');
$this->fpdf->Ln();
$this->fpdf->Cell(45, 7, 'Charge Code', 0, 'L');
$this->fpdf->Cell(5, 7, ':', 0, 'L');
$this->fpdf->Cell(70, 7, $data->chargecode.' / '.$data->categorycc_name, 0, 'L');
$this->fpdf->Ln();
$this->fpdf->Cell(45, 7, 'Description', 0, 'L');
$this->fpdf->Cell(5, 7, ':', 0, 'L');
$this->fpdf->Cell(70, 7, $data->ccdes, 0, 'L');
$this->fpdf->Ln();
$this->fpdf->Cell(45, 7, 'Currency', 0, 'L');
$this->fpdf->Cell(5, 7, ':', 0, 'L');
$this->fpdf->Cell(70, 7, $data->currency_name, 0, 'L');
$this->fpdf->Ln();
}

//setting header tabel
$this->fpdf->Ln(3);
$this->fpdf->SetFont('Times','B',12);
$this->fpdf->Cell(10, 7, 'NO', 1, '0','C');
$this->fpdf->Cell(15, 7, 'QTY', 1, '0','C');
$this->fpdf->Cell(15, 7, 'UOM', 1, '0','C');
$this->fpdf->Cell(45, 7, 'Description', 1, '0','C');
$this->fpdf->Cell(30, 7, 'PRICE', 1, '0','C');
$this->fpdf->Cell(30, 7, 'TOTAL', 1, '0','C');
$this->fpdf->Cell(30, 7, 'REMARK', 1, '0','C');

//hasil query
$no = 1;
foreach($tabel as $data)
{
$this->fpdf->ln();
$this->fpdf->SetFont('Times','B',12);
$this->fpdf->Cell(10, 7, $no++, 1, '0','C');
$this->fpdf->Cell(15, 7, number_format($data->qty,0,',','.'), 1, '0','C');
$this->fpdf->Cell(15, 7, $data->satuan, 1, '0','C');
$this->fpdf->Cell(45, 7, $data->nama, 1, '0','C');
$this->fpdf->Cell(30, 7,$data->kode_curs.'  '.number_format($data->harga,0,',','.'), 1, '0','C');
$this->fpdf->Cell(30, 7,$data->kode_curs.'  '.number_format($data->total,0,',','.'), 1, '0','C');
$this->fpdf->Cell(30, 7, $data->keterangan, 1, '0','C');
}
$this->fpdf->Ln(15);


//tabel top
$this->fpdf->SetFont('Times','B',12);
$this->fpdf->Cell(0,10,'Term Of Payment',0,0,'C');
$this->fpdf->Ln(10);

$this->fpdf->SetFont('Times','B',12);
$this->fpdf->Cell(41,7,'Term Of Payment',1,0,'C');
$this->fpdf->Cell(32,7,'Date',1,0,'C');
$this->fpdf->Cell(38,7,'Amount',1,0,'C');
$this->fpdf->Cell(66,7,'Remarks',1,0,'C');
$this->fpdf->Ln();
foreach($query as $data)
{
$this->fpdf->SetFont('Times','B',12);
$this->fpdf->Cell(41,7,'Down Payment',1,0,'C');
$this->fpdf->Cell(32,7,$data->date1pay,1,0,'C');
$this->fpdf->Cell(38,7,$data->kode_curs.'  '.$data->downpay,1,0,'C');
$this->fpdf->Cell(66,7,$data->remarkp1,1,0,'C');
$this->fpdf->Ln();
$this->fpdf->Cell(41,7,'2nd Instalament',1,0,'C');
$this->fpdf->Cell(32,7,$data->date2pay,1,0,'C');
$this->fpdf->Cell(38,7,$data->kode_curs.'  '.$data->secondpay,1,0,'C');
$this->fpdf->Cell(66,7,$data->remarkp2,1,0,'C');
$this->fpdf->Ln();
$this->fpdf->Cell(41,7,'3rd Instalament',1,0,'C');
$this->fpdf->Cell(32,7,$data->date3pay,1,0,'C');
$this->fpdf->Cell(38,7,$data->kode_curs.'  '.$data->thirdpay,1,0,'C');
$this->fpdf->Cell(66,7,$data->remarkp3,1,0,'C');
$this->fpdf->Ln();
$this->fpdf->Cell(41,10,'Final Instalament',1,0,'C');
$this->fpdf->Cell(32,10,$data->date4pay,1,0,'C');
$this->fpdf->Cell(38,10,$data->kode_curs.'  '.$data->finalpay,1,0,'C');
$this->fpdf->Cell(66,10,$data->remarkp4,1,0,'C');
$this->fpdf->Ln();
$this->fpdf->Ln(8);
}

$this->fpdf->Output("Purchase Request Detail.pdf","I");


} 
}
