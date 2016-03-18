<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TEST_MAIL extends MY_Controller  {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    function __construct()
	{
		parent::__construct();
		$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => 'dimyatiabisaad@gmail.com',
    'smtp_pass' => 'b9818qhasvgmail',
    'mailtype'  => 'html', 
    'charset'   => 'utf-8'
);
$this->load->library('email', $config);
	}

function kirim_email(){

$this->email->set_newline("\r\n");
$this->email->from('dimyatiabisaad@gmail.com', 'Abi Saad Dimyati');
$this->email->to('rider_ghost47@yahoo.co.id'); 
 

$this->email->subject('Email Test2');
$this->email->message('<H1 style="color:red;">GW ABI</H1>');	

$this->email->send();

echo $this->email->print_debugger();
}
}
?>
