<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Connexion extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth/Authentification');
        $this->load->library('session');
    }

    public function acceuil($data)
    {
        $this->load->view('template/header', $data);
        $this->load->view('template/init_content', $data);
        $this->load->view('template/footer', $data);
    }
    public function admin($data)
    {
        return '';
    }

    public function login()
    {
        $numero = $this->input->post("numero");
        $user_exists = $this->Authentification->get_user_by_numero($numero);

        if ($user_exists) {
            $user_data = $this->session->userdata('user');
            if ($user_data['idprofil'] != 1) {
                $this->acceuil($user_data);
            } else {
                $this->admin($user_data);
            }
        } else {
            $this->Authentification->insert_user($numero);
            $user_data = $this->Authentification->get_user_by_numero($numero);
            $this->session->set_userdata('user', $user_data);
            $this->acceuil($user_data);
        }
    }


    public function validLogin()
    {
        $email = $this->input->post("email");
        $password = $this->input->post("password");
        $bool = $this->Authentification->checkUser($email, $password);
        if ($bool) {
            $data = $_SESSION['user'];
            if ($data['idprofil'] != 1)
                $this->acceuil($data);
            if ($data['idprofil'] == 1)
                $this->acceuil($data);
        } else if (!$bool) {
            redirect('Welcome/index');
        }
    }

    public function disconnect()
    {
        $this->session->sess_destroy();
        redirect("Welcome/index");
    }

}
