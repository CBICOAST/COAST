<?php 
/************************************************************************************************
* Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Pak Riza
* Program Id       : RESOURCE_TIMESHEET
* Program Name     : List Timesheet
* Description      : Daftar Timesheet yang belum terisi oleh resource
* Environment      : PHP 5.4.4
* Author           : Abi Sa'ad Dimyati
* Version          : 01.00.00
* Creation Date    : 07-03-2016 11:10:00
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_RESOURCE_TIMESHEET extends MY_Controller {

	
	function __construct()
	{
		parent::__construct();
		$index	= $this->config->item('index_page');
		$host	= $this->config->item('base_url');

		$this->url = empty($index) ? $host : $host . $index . '/';

		$this->load->model('m_resource_timesheet','timesheet');
		$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' =>  465,
				'smtp_user' => 'dimyatiabisaad@gmail.com',
				'smtp_pass' => 'b9818qhasvgmail',
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
				);
		$this->load->library('email', $config);
	}

	function index()
	{
            
	}

	function resource_timesheet()
	{
                $param['periode']=$this->timesheet->list_timesheet_periode();
                $param['employee_id']=$this->user['id'];
               
		$this->load->view('v_resource_timesheet',$param);
	}
	function create_timesheet(){
		$param['periode']=$this->timesheet->list_timesheet_periode();
		$param['employee_id']=$this->user['id'];
		$this->load->view('v_create_timesheet',$param);
	}
        function load_timesheet_periode($periode,$employee,$type){
        	$data['employee_id']=$employee;
        	$data['employee_name']=$this->timesheet->get_employee($employee);
            $data['periode']=$periode;
            $data['approved_by']=$this->user['id'];
            if ($type=='rm'){
         $this->load->view('v_rsc_timesheet_rm',$data);
            }
            elseif ($type=='resource'){
            	$this->load->view('v_rsc_timesheet',$data);
            }
            elseif($type=='pmo'){
            	$this->load->view('v_rsc_timesheet_pmo',$data);
            }
         
     }
     
     function load_data(){
         $hitung=count($this->timesheet->get_timesheet_data($this->input->post('employeeid'),$this->input->post('periode')));
         if($hitung==0){
             $data_timesheet=0;
         }
         else{
             $data_timesheet=$this->timesheet->get_timesheet_data($this->input->post('employeeid'),$this->input->post('periode'));
         }
         
        echo json_encode($data_timesheet);
     }
     function load_data_rm(){
     	$hitung=count($this->timesheet->get_timesheet_data_rm($this->input->post('employeeid'),$this->input->post('periode'),$this->input->post('approvedby')));
     	if($hitung==0){
     		$data_timesheet=0;
     	}
     	else{
     		$data_timesheet=$this->timesheet->get_timesheet_data_rm($this->input->post('employeeid'),$this->input->post('periode'),$this->input->post('approvedby'));
     	}
     	 
     	echo json_encode($data_timesheet);
     }
     function load_data_pmo(){
     	$hitung=count($this->timesheet->get_timesheet_data_pmo($this->input->post('employeeid'),$this->input->post('periode')));
     	if($hitung==0){
     		$data_timesheet=0;
     	}
     	else{
     		$data_timesheet=$this->timesheet->get_timesheet_data_pmo($this->input->post('employeeid'),$this->input->post('periode'));
     	}
     	 
     	echo json_encode($data_timesheet);
     }
     function form_timesheet($periode){
         foreach ($this->timesheet->get_holiday_date($periode) as $key => $value){
             $data[]=$value['holiday_date'];
        }
         $data_array=array(
             'employee_id'=>$this->user['id'],
             'max_date'=>$this->timesheet->get_max_min($periode)[0]['max_date'],
             'min_date'=>$this->timesheet->get_max_min($periode)[0]['min_date'],
             'holiday_date'=>  json_encode($data),
             'employee_names'=>$this->timesheet->get_employee_list($this->user['id']),
             'charge_code'=>$this->timesheet->get_chargecode_list(),
             'act_code'=>$this->timesheet->get_activity_code(),
             'jml_data'=>$this->timesheet->count_sheet_perperiode($this->user['id'],$periode),
             'periode'=>$periode
        );
         $this->load->view('v_form_timesheet',$data_array);
     }
     function form_edit_timesheet($periode,$date_tes,$charge_code,$employee_id,$act_code,$st_approve){
         foreach ($this->timesheet->get_holiday_date($periode) as $key => $value){
             $data[]=$value['holiday_date'];
        }
        $status_approve=!isset($st_approve)?0:$st_approve;
         $data_array=array(
             'employee_id'=>$this->user['id'],
             'max_date'=>$this->timesheet->get_max_min($periode)[0]['max_date'],
             'min_date'=>$this->timesheet->get_max_min($periode)[0]['min_date'],
             'holiday_date'=>  json_encode($data),
             'employee_names'=>$this->timesheet->get_employee_list($this->user['id']),
             'charge_code'=>$this->timesheet->get_chargecode_list(),
             'act_code'=>$this->timesheet->get_activity_code(),
             'edit_data_timesheet'=>$this->timesheet->get_timesheet_edit_data($employee_id,$periode,$date_tes,$charge_code,$act_code),
         	 'st_approve'=>$status_approve
        );
         $this->load->view('v_form_edit_timesheet',$data_array);
     }
     function upload_timesheet(){
         $dat_arr[]=array(
             'employee_id'=>$this->input->post('employee_id'),
             'periode_date'=>$this->input->post('periode'),
             'date_ts'=>$this->input->post('date_ts'),
             'work_desc' => $this->input->post('work'),
             'hours' => $this->input->post('hours'),
             'charge_code' => $this->input->post('charge_code')[0],
             'act_code' => $this->input->post('activity')[0],
             'approved_by' => $this->input->post('approved')[0],
             'holiday'=> $this->input->post('holiday'),
         	 'overtime'=>$this->input->post('overtime'),
             'status'=>0
         );
     echo json_encode($this->timesheet->upload_timesheet($dat_arr,$this->input->post('periode'),$this->input->post('employee_id')));
     
     }
     function edit_timesheet()
     {
         $dat_arr=array(
             'employee_id'=>$this->input->post('employee_id'),
             'periode_date'=>$this->input->post('periode'),
             'date_ts'=>$this->input->post('date_ts'),
             'date_ts2'=>$this->input->post('date_ts2'),
             'work_desc' => $this->input->post('work'),
             'hours' => $this->input->post('hours'),
             'charge_code' => $this->input->post('charge_code')[0],
             'charge_code2' => $this->input->post('charge_code2'),
             'act_code' => $this->input->post('activity')[0],
             'act_code2' => $this->input->post('activity2'),
             'approved_by' => $this->input->post('approved')[0],
         	 'overtime'=>$this->input->post('overtime'),
             'holiday'=>$this->input->post('holiday'),
             'status'=>$this->input->post('jenis')
         );
         echo json_encode($this->timesheet->edit_timesheet($dat_arr));
     }
             function holiday_status()
             {
        		echo json_encode($this->timesheet->set_holiday_date($this->input->post('periode'),$this->input->post('date')));
    		 }
    function delete_timesheet()
    {
        $data_arr=array(
                'date_ts'=>$this->input->post('date'),
                'charge_code'=>$this->input->post('chargecode'),
                'employee_id'=>$this->input->post('employeeid'),
                'act_code'=>$this->input->post('actcode'),
                'periode_date'=>$this->input->post('periode_dates')
                );
        
        $hitung=count($this->timesheet->delete_timesheet($data_arr));
        if($hitung==0){
        	$data_timesheet=0;
        }
        else{
        	$data_timesheet=$this->timesheet->delete_timesheet($data_arr);
        }
         
        echo json_encode($data_timesheet);
    }
    function generate_new_timesheet()
    {
       $data_arr[]=array(
           'create_date'=>date("Y-m-d h:i:s"),
           'periode_date'=>$this->input->post('periode'),
           'expired_date'=>$this->input->post('expired')
       );
       echo json_encode($this->timesheet->generate_new_timesheet($data_arr));
    }
    function form_new_timesheet()
    {
        $this->load->view('v_new_timesheet_periode');
    }
    function max_periode()
    {
    	echo json_encode($this->timesheet->max_periode());
    	
    }
    function approve_rm(){
    	$data=array(
    			'employee_id'=>$this->input->post('employeeid'),
    			'periode'=>$this->input->post('periode_dates')
    	);
    	//$data=array(
    			//'employee_id'=>'CBI.061.150216',
    			//'periode'=>'2016-01-01'
    	//);
    	$this->email->set_newline("\r\n");
    	$this->email->from('dimyatiabisaad@gmail.com', 'COAS');
    	foreach ($this->timesheet->get_email_approval_rm($data) as $key => $value){
    		$this->email->to($value['email']);
    		$this->email->subject('Submit Timesheet'.$value['sender_name']);
    		$this->email->message('Dear '.$value['reciver_name'].'<br> <b>'.$value['sender_name'].'</b> already submit timesheet <br> Please Check by COAS');
    		if($this->email->send()){
    			$status=1;
    		}
    		else{
    			$status=0;
    		}
    	}
    	$after_send=array(
    			'data_sheet'=>$this->timesheet->approve_rm($data),
    			'email_status'=>$status
    	);
    	echo json_encode($after_send);
    }
    function approve_pmo(){
    	foreach ($this->input->post('check_box') as $key => $value){
    		$split=explode("|",$value);
    		$data[]=array(
    				'create_date'=>$split[0],
    				'employee_id'=>$split[1],
    				'approved_by'=>$split[2],
    				'periode_date'=>$split[3],
    		);
    	}
    	$create_date="";
    	$employee_id="";
    	$approved_by="";
    	$periode_date="";
    	foreach ($data as $key => $value){
    		$create_date.="'".$value['create_date']."',";
    		$employee_id.="'".$value['employee_id']."',";
    		$approved_by.="'".$value['approved_by']."',";
    		$periode_date.="'".$value['periode_date']."',";
    	}
    	$last_data=array(
    			'create_date'=>substr($create_date,0,-1),
    			'employee_id'=>substr($employee_id,0,-1),
    			'approved_by'=>substr($approved_by,0,-1),
    			'periode_date'=>substr($periode_date,0,-1)
    	);
    	//$data=array(
    			//'employee_id'=>$this->input->post('employeeid'),
    			//'periode'=>$this->input->post('periode_dates'),
    			//'approvedby'=>$this->input->post('approved_by')
    	//);
    	//$data=array(
    	//'employee_id'=>'CBI.061.150216',
    	//'periode'=>'2016-01-01'
    	//);
    	$this->email->set_newline("\r\n");
    	$this->email->from('dimyatiabisaad@gmail.com', 'COAS');
    	$this->email->to('abi.dimyati@cybertrend-intra.net');
    	foreach ($this->timesheet->get_email_approval_pmo($last_data['create_date'],$last_data['employee_id'],$last_data['approved_by'],$last_data['periode_date']) as $key => $value){
    		$this->email->subject('Submit Timesheet '.$value['resource']);
    		$this->email->message('Dear PMO <br> <b>'.$value['rm'].'</b> already submit timesheet <b>'.$value['resource'].'</b><br> Please Check by COAS');
    	}
    	if($this->email->send()){
    		$status=1;
    	}
    	else{
    		$status=0;
    	}
    	$after_send=array(
    			'data_sheet'=>$this->timesheet->approve_pmo($last_data['create_date'],$last_data['employee_id'],$last_data['approved_by'],$last_data['periode_date']),
    			'email_status'=>$status
    	);
    	echo json_encode($after_send);
    }
    
    function send_back_resource(){
    	$note=$this->input->post('note');
    	foreach ($this->input->post('check_box') as $key => $value){
    		$split=explode("|",$value);
    		$data[]=array(
    				'create_date'=>$split[0],
    				'employee_id'=>$split[1],
    				'approved_by'=>$split[2],
    				'periode_date'=>$split[3],
    		);
    	}
    	$create_date="";
    	$employee_id="";
    	$approved_by="";
    	$periode_date="";
    	foreach ($data as $key => $value){
    		$create_date.="'".$value['create_date']."',";
    		$employee_id.="'".$value['employee_id']."',";
    		$approved_by.="'".$value['approved_by']."',";
    		$periode_date.="'".$value['periode_date']."',";
    	}
    	$last_data=array(
    			'create_date'=>substr($create_date,0,-1),
    			'employee_id'=>substr($employee_id,0,-1),
    			'approved_by'=>substr($approved_by,0,-1),
    			'periode_date'=>substr($periode_date,0,-1)
    	);
    	$this->email->set_newline("\r\n");
    	$this->email->from('dimyatiabisaad@gmail.com', 'COAS');
    	foreach ($this->timesheet->get_email_send_back($last_data['create_date'],$last_data['employee_id'],$last_data['approved_by']) as $key => $value){
    		$this->email->to($value['email']);
    		$this->email->subject('Send Back Timesheet by '.$value['sender_name']);
    		$this->email->message('Dear '.$value['reciver_name'].'<br> <b>'.$value['sender_name'].'</b> Send back your timesheet <br> Please Check COAS <br> <b>Note:</b> '.$note);
    		if($this->email->send()){
    			$status=1;
    		}
    		else{
    			$status=0;
    		}
    	}
    	$count_sheet=count($this->timesheet->send_back_resource($last_data['create_date'],$last_data['employee_id'],$last_data['approved_by'],$last_data['periode_date']));
    	if($count_sheet==0){
    		$after_send=array(
    			'data_sheet'=>0,
    			'email_status'=>$status
    	);
    	}else{
    		$after_send=array(
    			'data_sheet'=>$this->timesheet->send_back_resource($last_data['create_date'],$last_data['employee_id'],$last_data['approved_by'],$last_data['periode_date']),
    			'email_status'=>$status
    	);
    	}
    	
    	echo json_encode($after_send);
    }
    
    function masg_sendback(){
    	$this->load->view('v_form_sendback');
    }
    
    function approve_pmo_accepted(){
    	$data=array(
    			'employee_id'=>$this->input->post('employeeid'),
    			'periode'=>$this->input->post('periode_dates'),
    			'approvedby'=>$this->input->post('approved_by')
    	);
    	//$data=array(
    	//'employee_id'=>'CBI.061.150216',
    	//'periode'=>'2016-01-01'
    	//);
    	
    	$after_send=array(
    			'data_sheet'=>$this->timesheet->approve_pmo_accepted($data)
    	);
    	echo json_encode($after_send);
    }
    function approve_rm_periode(){
    	$param['periode']=$this->timesheet->timesheetlist_resource_send_periode($this->user['id']);
    	$this->load->view('v_approval_periode',$param);
    }
    function approve_pmo_periode(){
    	$param['periode']=$this->timesheet->timesheetlist_resource_send_periode_pmo($this->user['id']);
    	$this->load->view('v_approval_periode_pmo',$param);
    }
    function approve_rm_emp($employee_id,$periode){
    	$param['periode']=$this->timesheet->timesheetlist_resource_send($employee_id,$periode);
    	$param['approve_by']=$this->user['id'];
    	$this->load->view('v_approval_employee',$param);
    }
    function approve_pmo_emp($periode){
    	$param['periode']=$this->timesheet->timesheetlist_resource_send_pmo($periode);
    	$param['approve_by']=$this->user['id'];
    	$this->load->view('v_approval_employee_pmo',$param);
    }
    function delete_periode(){
    	$param['periode']=$this->input->post('periode_dates');
    	$param['employee_id']=$this->input->post('employee_id');
    	echo json_encode($this->timesheet->delete_periode($param));
    }
    function get_prev_overtime(){
    	date_default_timezone_set('Asia/Jakarta');
    	if($this->input->post('holiday')=='Yes'){
    		$data[]=array(
    				'overtime'=>$this->input->post('hours')
    		);
    		echo json_encode($data);
    	}else{
    		
    		echo json_encode($this->timesheet->get_prev_overtime($this->input->post('hours'),$this->input->post('date_ts'),$this->input->post('employee_id')));
    	}
    	
    	
    	
    }
}

/* End of file c_oas021.php */
/* Location: ./application/controllers/c_oas021.php */