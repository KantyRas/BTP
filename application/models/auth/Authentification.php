<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentification extends CI_Model
{

	public function checkUser($email, $password)
	{
		$query = $this->db->query("select * from utilisateur where email='$email' and password='$password'");
		$row = $query->row_array();
		if ($row) {
			$_SESSION['user'] = $row;
			return true;
		}
		return false;
	}
	public function get_user_by_numero($numero)
	{
		$query = $this->db->get_where('utilisateur', array('numero' => $numero));
		$row = $query->row_array();
		if ($row) {
			$_SESSION['user'] = $row;
			return true;
		}
		return false;
		//return $query->row_array();
	}

	public function insert_user($numero)
	{
		$data = array(
			'numero' => $numero
		);
		$this->db->insert('utilisateur', $data);
		return $this->db->insert_id();
	}

}