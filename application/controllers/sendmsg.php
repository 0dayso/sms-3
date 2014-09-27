<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * sendmsg
 * 
 * @package     sendmsg
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Sendmsg extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('date');
		
		$this->load->model('Msms');
		
		$this->load->config('sms');
		
		#error_reporting(E_ERROR);
				
		#$this->output->enable_profiler(TRUE);
	}
	
	//�豸���Ӳ���
	function conn_test()
	{
		//����OCX�����
		$dllsms = new COM("szhto.SzhtoDLL") or die("Unable to instanciate Word");
		//��ͨѶ�˿�
		$open=$dllsms->YhOpenModem($this->config->item('port'),"9600,N,8,1",$this->config->item('register'));

		//�ر�ͨѶ�˿�
		$dllsms->YhCloseModem();

		echo $open;
	}
	
	//���Ͷ���
	function send_msg()
	{
		$data['tel']     = $this->input->get('tel',TRUE);        //�绰
		$data['content'] = iconv("UTF-8", "GBK//IGNORE", $this->input->get('content',TRUE));    //����
		//����OCX�����
		$dllsms = new COM("szhto.SzhtoDLL") or die("Unable to instanciate Word");
		//��ͨѶ�˿�
		$open=$dllsms->YhOpenModem($this->config->item('port'),"9600,N,8,1",$this->config->item('register'));

		if (substr($open,0,2) != '-1'){
			$dllsms->Waittime = $this->config->item('waittime');      //�ȴ�ʱ��30s
			//���ؽ��
			$data['result'] = $dllsms->YhSendSms($this->config->item('mytel'),$data['tel'],$data['content'],8);
			if ($data['result'] == '-1'){
				$data['valid'] = 0;
			}else{
				$data['valid'] = 1;
			}
			$data['sendtime'] = mdate("%Y-%m-%d %H:%i:%s");           //����ʱ��
			
			$res = $this->Msms->add_sms($data);
		}else {
			$data['result'] = '-2';
		}
		//�ر�ͨѶ�˿�
		$dllsms->YhCloseModem();

		echo $data['result'];
	}

}

