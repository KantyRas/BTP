<?php
require FCPATH . 'vendor/autoload.php';
defined('BASEPATH') or exit('No direct script access allowed');

class FrontController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user'])) {
            redirect("Welcome/index");
        }

        $this->load->database();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('DevisModel');

    }
    public function ajout_facture()
    {
        $iddevis = $this->input->post('iddevise');
        $date = $this->input->post('date_paiement');
        $ref = $this->input->post('ref');
        $montant = $this->input->post('montant');
        if (!empty($iddevis) && !empty($date) && !empty($montant)) {
            $this->DevisModel->ajout_paiement($iddevis, $ref, $date, $montant);
            $this->session->set_flashdata('success_message', 'Payement effectué !');
            redirect('FrontController/load_page_payer/' . $iddevis);
        } else {
            $this->session->set_flashdata('error_message', "Erreur : verifier votre formulaire ");
            redirect('FrontController/load_page_payer/' . $iddevis);
        }
    }
    public function verify_payment_amount()
    {
        $idDevis = $this->input->post('iddevise');
        $datePaiement = $this->input->post('date_paiement');
        $montantPaiement = $this->input->post('montant');

        $resteAPayer = $this->DevisModel->get_remaining_amount_by_id($idDevis);

        if ($montantPaiement > $resteAPayer) {
            echo json_encode(array('status' => 'error', 'message' => 'Le montant du paiement dépasse le montant restant à payer.'));
        } else {
            echo json_encode(array('status' => 'success'));
        }
    }

    public function load_page_payer($iddevis)
    {
        $data = $_SESSION['user'];
        $data['deviss'] = $this->DevisModel->getDevisById($iddevis);
        $this->load->view('template/header', $data);
        $this->load->view('facturer', $data);
        $this->load->view('template/footer', $data);
    }

    public function load_detail_devis_pdf($iddevis)
    {
        $data = $_SESSION['user'];
        $deviss = $this->DevisModel->getDevisDetailById($iddevis);
        $travaux = $this->DevisModel->getDetailTravauxByIdMaison($deviss[0]['idtypemaison']);
        $facturation = $this->DevisModel->getfacturationByIdDevis($iddevis);
        $facture_payer_total = $this->DevisModel->getSumPaiementByIdDevis($iddevis);

        $array['tab'] = array($deviss, $travaux, $data, $facturation, $facture_payer_total);
        $html = $this->load->view('devis_pdf', $array, true);
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_top' => 0,
            'margin_right' => 0,
            'margin_left' => 0,
            'margin_bottom' => 0,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        //$this->load->view('devis_pdf', $array);
    }

    public function traitement_devis()
    {
        try {
            $idclient = $this->input->post('idclient');
            $idtypemaison = $this->input->post('maison');
            $idtypefinition = $this->input->post('finition');
            $datedebut = $this->input->post('datedebut');
            $description = $this->input->post('description');

            $this->DevisModel->ajoutDevis($idclient, $idtypemaison, $idtypefinition, $datedebut, $description);

            $this->session->set_flashdata('success_message', 'Insertion effectué !');
            redirect('FrontController/load_page_ajout_devis');
        } catch (Exception $e) {
            $this->session->set_flashdata('error_message', "Erreur : verifier votre formulaire " . $e->getMessage());
            redirect('FrontController/load_page_ajout_devis');
        }

    }

    public function load_page_ajout_devis()
    {
        $data = $_SESSION['user'];
        $maisons = $this->DevisModel->getTypeMaison();
        $finitions = $this->DevisModel->getTypeFinition();
        //$data['maisons'] = $this->DevisModel->getTypeMaison();
        //$data['finitions'] = $this->DevisModel->getTypeFinition();
        $array['valeurs'] = array($maisons, $finitions, $data);
        $this->load->view('template/header', $data);
        $this->load->view('ajoutdevis', $array);
        $this->load->view('template/footer', $data);
    }

    public function load_page_devis()
    {
        $data = $_SESSION['user'];
        $data['devis'] = $this->DevisModel->getDevisByIdClient($_SESSION['user']['idutilisateur']);
        $this->load->view('template/header', $data);
        $this->load->view('listedevis', $data);
        $this->load->view('template/footer', $data);
    }
}