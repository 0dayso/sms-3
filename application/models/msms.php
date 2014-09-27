<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msms extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * ��Ӷ�����Ϣ
	 */
	function add_sms($data)
	{
		return $this->db->insert('sms', $data);
	}
	
	/**
	 * ����
	 */
	function locktable()
	{
		return $this->db->query("LOCK TABLES sms WRITE");
	}

	/**
	 * ����
	 */
	function unlocktable()
	{
		return $this->db->query("UNLOCK TABLES");
	}
	
}

/* End of file madmin.php */
/* Location: ./application/models/madmin.php */
?>
