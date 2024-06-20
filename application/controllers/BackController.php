<?php
require FCPATH . 'vendor/autoload.php';
defined('BASEPATH') or exit('No direct script access allowed');

class BackController extends CI_Controller
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
        $this->load->model('util/Traitement');
    }
    public function update_type_finition($id)
    {
        $data = array(
            'typefinition' => $this->input->post('typefinition'),
            'augmentaion_prix' => $this->input->post('augmentation')
        );

        $affected_rows = $this->Traitement->update_finition($id, $data);

        if ($affected_rows > 0) {
            $this->session->set_flashdata('success_message', 'Modification apporté, vous pouvez retourné à votre page.');
            redirect('BackController/load_page_edit_finition/' . $id);
        } else {
            $this->session->set_flashdata('error_message', 'Erreur lors de la modification, veuillez vérifier votre formulaire');
            redirect('BackController/load_page_edit_finition/' . $id);
        }
    }
    public function load_page_edit_finition($id)
    {
        $data = $_SESSION['user'];
        $data['finitions'] = $this->DevisModel->getFinitionById($id);
        $this->load->view('template/header', $data);
        $this->load->view('edit_finition', $data);
        $this->load->view('template/footer', $data);
    }
    public function load_liste_finition()
    {
        $data = $_SESSION['user'];
        $data['finitions'] = $this->DevisModel->getAllTypeFinition();

        $this->load->view('template/header', $data);
        $this->load->view('liste_type_finition', $data);
        $this->load->view('template/footer', $data);
    }
    public function update($id)
    {
        $data = array(
            'designation' => $this->input->post('designation'),
            'idunite' => $this->input->post('idunite'),
            'quantite' => $this->input->post('quantite'),
            'prixunitaire' => $this->input->post('prixunitaire')
        );
        $idtravaux = $this->input->post('idtr');

        $affected_rows = $this->Traitement->update_travaux($id, $data);

        if ($affected_rows > 0) {
            $this->Traitement->ajout_historique_devis($idtravaux);
            $this->session->set_flashdata('success_message', 'Modification apporté, vous pouvez retourné à votre page.');
            redirect('BackController/load_page_update_travaux/' . $id);
        } else {
            $this->session->set_flashdata('error_message', 'Erreur lors de la modification, veuillez vérifier votre formulaire');
            redirect('BackController/load_page_update_travaux/' . $id);
        }
    }
    public function load_page_update_travaux($id)
    {
        $data = $_SESSION['user'];
        $data['travaux'] = $this->DevisModel->getAllTravauxByIdTravaux($id);
        $data['unites'] = $this->DevisModel->getAllUnite();
        $this->load->view('template/header', $data);
        $this->load->view('edit_travaux', $data);
        $this->load->view('template/footer', $data);
    }
    public function load_page_liste_travaux()
    {
        $data = $_SESSION['user'];
        $data['travaux'] = $this->DevisModel->getAllTravaux();
        $this->load->view('template/header', $data);
        $this->load->view('liste_travaux', $data);
        $this->load->view('template/footer', $data);
    }
    public function import_csv_paiement()
    {
        try {
            $file = $_FILES['csv_file']['tmp_name'];
            $table = $this->input->post('table');

            $this->Traitement->import_paie_to_csv($file, $table, ',');

            $this->session->set_flashdata('success_message', 'Importation réussie !');
            redirect('BackController/load_page_import_paie');
            // echo "Importation réussie !";
        } catch (Exception $e) {
            $this->session->set_flashdata('error_message', "Erreur : " . $e->getMessage());
            redirect('BackController/load_page_import_paie');
        }
    }
    public function load_page_import_paie()
    {
        $data = $_SESSION['user'];
        $this->load->view('template/header', $data);
        $this->load->view('import_paiement', $data);
        $this->load->view('template/footer', $data);
    }
    public function import_csv_travaux_devis()
    {
        try {
            $file1 = $_FILES['csv_file']['tmp_name'];
            $table1 = $this->input->post('table1');

            $file2 = $_FILES['csv_file2']['tmp_name'];
            $table2 = $this->input->post('table2');
            $this->Traitement->import_travaux_to_csv($file1, $table1, ',');
            $this->Traitement->import_devis_to_csv($file2, $table2, ',');

            $this->session->set_flashdata('success_message', 'Importation réussie !');
            redirect('BackController/load_page_import_travaux');
            // echo "Importation réussie !";
        } catch (Exception $e) {
            $this->session->set_flashdata('error_message', "Erreur : " . $e->getMessage());
            redirect('BackController/load_page_import_travaux');
        }
    }
    public function load_page_import_travaux()
    {
        $data = $_SESSION['user'];
        $this->load->view('template/header', $data);
        $this->load->view('import_maison_travaux', $data);
        $this->load->view('template/footer', $data);
    }

    public function load_page_tableau_de_bord()
    {
        $data = $_SESSION['user'];
        $data['total'] = $this->DevisModel->getTotalDevis();
        $data['paies'] = $this->DevisModel->getTotalPaiementEffectue();

        $data['choixAnnee'] = $this->input->post('choixAnnee');
        if ($data['choixAnnee'] == null) {
            $data['choixAnnee'] = 0;
        }

        $data['montant_total'] = $this->DevisModel->get_montant_total();
        $data['effectue_total'] = $this->DevisModel->get_effectue_total();
        $data['devis'] = $this->DevisModel->get_devis();
        $data['anneeExistant'] = $this->DevisModel->get_annee_existant();
        $data['mois'] = $this->DevisModel->get_mois($data['choixAnnee']);
        $data['annee'] = $this->DevisModel->get_annee();

        $this->load->view('template/header', $data);
        $this->load->view('bord', $data);
        $this->load->view('template/footer', $data);
    }
    public function load_detail_devis($iddevis)
    {
        $data = $_SESSION['user'];
        $deviss = $this->DevisModel->getDevisDetailById($iddevis);
        $travaux = $this->DevisModel->getDetailTravauxByIdMaison($deviss[0]['idtypemaison']);

        $array['tab'] = array($deviss, $travaux, $data);
        $this->load->view('template/header', $data);
        $this->load->view('liste_detail_devis', $array);
        $this->load->view('template/footer', $data);
    }

    public function load_page_devis_encours()
    {
        $data = $_SESSION['user'];
        $data['devis'] = $this->DevisModel->getDevisEnCours();
        $data['facture'] = $this->DevisModel->getFacturation();
        $this->load->view('template/header', $data);
        $this->load->view('devis_en_cours', $data);
        $this->load->view('template/footer', $data);
    }
    /*public function truncate_tables() {
        
        $sql = "TRUNCATE TABLE typemaison, travauxmaison, typefinition, devis, facturation, v_travaux, v_devis, v_paiement";
        $sql2 = "delete from utilisateur where idprofil = 2";
        if ($this->db->query($sql) ) {
            echo "huhu";
        } else {
            echo "!!";
        }
    }*/
}