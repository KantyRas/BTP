<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DevisModel extends CI_Model
{
    public function getTotalPaiementEffectue()
    {
        $sql = "SELECT SUM(montant_payer) AS total
        FROM facturation";
        $query = $this->db->query($sql);
        $data = array();
        $result = $query->result_array();

        if ($query) {
            foreach ($result as $results) {
                array_push($data, $results);
            }
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $this->db->error();
        }
        return $data;
    }
    public function getFinitionById($id)
    {
        $query = $this->db->get_where('typefinition', array('idtypefinition' => $id));
        return $query->result_array();
    }
    public function getAllTypeFinition()
    {
        $this->db->order_by('idtypefinition');
        $query = $this->db->get('typefinition');
        return $query->result_array();
    }
    public function getAllUnite()
    {
        $query = $this->db->get('unite');
        return $query->result_array();
    }
    public function getAllTravauxByIdTravaux($id)
    {
        $sql = "SELECT idtravaux,idtypemaison,designation,t.idunite,u.unite,quantite,prixunitaire,total FROM travauxmaison t JOIN unite u on t.idunite = u.idunite where t.idtravaux = '$id' GROUP BY t.idtravaux,u.unite ORDER BY t.idtravaux";
        $query = $this->db->query($sql);
        $data = array();
        $result = $query->result_array();

        if ($query) {
            foreach ($result as $results) {
                array_push($data, $results);
            }
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $this->db->error();
        }
        return $data;
    }
    public function getAllTravaux()
    {
        $sql = "SELECT idtravaux,idtypemaison,designation,t.idunite,u.unite,quantite,prixunitaire,total FROM travauxmaison t JOIN unite u on t.idunite = u.idunite GROUP BY t.idtravaux,u.unite ORDER BY t.idtravaux";
        $query = $this->db->query($sql);
        $data = array();
        $result = $query->result_array();

        if ($query) {
            foreach ($result as $results) {
                array_push($data, $results);
            }
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $this->db->error();
        }
        return $data;
    }
    public function get_total_devis_by_month($year)
    {
        $this->db->select('MONTH(datecreation) as month, SUM(montant_total) as total');
        $this->db->where('YEAR(datecreation)', $year);
        $this->db->group_by('MONTH(datecreation)');
        $query = $this->db->get('devis');
        return $query->result();
    }
    public function getMontantsDevisParMoisAnnee()
    {
        $this->db->select("TO_CHAR(datecreation, 'YYYY-MM') AS mois_annee, SUM(montant_total) AS montant_total");
        $this->db->from("devis");
        $this->db->group_by("TO_CHAR(datecreation, 'YYYY-MM')");
        $this->db->order_by("TO_CHAR(datecreation, 'YYYY-MM')");
        $this->db->order_by("mois_annee", "ASC");

        $query = $this->db->get();

        return $query->result_array();
    }
    public function getTotalDevis()
    {
        $sql = "SELECT SUM(montant_total) AS total
        FROM devis";
        $query = $this->db->query($sql);
        $data = array();
        $result = $query->result_array();

        if ($query) {
            foreach ($result as $results) {
                array_push($data, $results);
            }
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $this->db->error();
        }
        return $data;
    }
    public function getfacturationByIdDevis($id)
    {
        $sql = "select * from facturation where iddevis='$id'";
        $query = $this->db->query($sql);
        $data = array();
        $result = $query->result_array();

        if ($query) {
            foreach ($result as $results) {
                array_push($data, $results);
            }
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $this->db->error();
        }
        return $data;
    }
    public function getSumPaiementByIdDevis($id)
    {
        $sql = "select sum(montant_payer) as total from facturation where iddevis = '$id'";
        $query = $this->db->query($sql);
        $data = array();
        $result = $query->result_array();

        if ($query) {
            foreach ($result as $results) {
                array_push($data, $results);
            }
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $this->db->error();
        }
        return $data;
    }
    public function getFacturation()
    {
        $query = $this->db->get('facturation');
        return $query->result_array();
    }
    public function ajout_paiement($iddevis, $ref, $date, $montant)
    {
        $sql = "insert into facturation (iddevis,ref_paiement,date_paiement,montant_payer) values ('$iddevis','$ref','$date','$montant')";
        $this->db->query($sql);
    }

    public function getDetailTravauxByIdMaison($id)
    {
        $sql = "SELECT 
        idtravaux,
        idtypemaison,
        designation,
        t.idunite,
        u.unite,
        quantite,
        prixunitaire,
        total
        FROM 
            travauxmaison t
        JOIN 
        unite u on t.idunite = u.idunite
        WHERE 
            idtypemaison = '$id' GROUP BY t.idtravaux,u.unite";
        $query = $this->db->query($sql);
        $data = array();
        $result = $query->result_array();

        if ($query) {
            foreach ($result as $results) {
                array_push($data, $results);
            }
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $this->db->error();
        }
        return $data;
    }
    public function getDevisDetailById($id)
    {
        $sql = "SELECT u.numero,d.iddevis,d.idclient,d.ref_devis AS description_devis,t.typemaison,t.description AS description_typemaison,d.idtypemaison,f.typefinition,f.augmentaion_prix,d.idtypefinition,d.datedebut,d.datefin,d.datecreation,d.montant_total
    FROM 
        devis d
    JOIN 
        typemaison t ON d.idtypemaison = t.idtypemaison
    JOIN 
        typefinition f ON d.idtypefinition = f.idtypefinition
    JOIN
        utilisateur u on d.idclient = u.idutilisateur
    WHERE 
        d.iddevis = '$id'";
        $query = $this->db->query($sql);
        $data = array();
        $result = $query->result_array();

        if ($query) {
            foreach ($result as $results) {
                array_push($data, $results);
            }
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $this->db->error();
        }
        return $data;
    }
    public function ajoutDevis($idclient, $idtypemaison, $idtypefinition, $datedebut, $description)
    {
        $prix_maison = $this->getPrixMaisonById($idtypemaison);
        $augmentation = $this->getAugmentationFinitionById($idtypefinition);
        $montant = $prix_maison + (($prix_maison * $augmentation) / 100);
        $duree = $this->getDureeMaisonById($idtypemaison);
        $datefin = date("Y-m-d", strtotime($datedebut . " +$duree days"));

        $sql = "insert into devis (idclient,ref_devis,idtypemaison,idtypefinition,datedebut,datefin,montant_total) values ('$idclient','$description','$idtypemaison','$idtypefinition','$datedebut','$datefin','$montant')";
        $this->db->query($sql);
    }
    public function getAugmentationFinitionById($id)
    {
        $sql = "select augmentaion_prix from typefinition where idtypefinition='$id'";
        //echo $sql;
        $query = $this->db->query($sql);
        $row = $query->row();
        if ($row) {
            //var_dump($row);
            return $row->augmentaion_prix;
        } else {
            return null;
        }
    }
    public function getDureeMaisonById($id)
    {
        $sql = "select dureeconstruction from typemaison where idtypemaison='$id'";
        //echo $sql;
        $query = $this->db->query($sql);
        $row = $query->row();
        if ($row) {
            //var_dump($row);
            return $row->dureeconstruction;
        } else {
            return null;
        }
    }
    public function getPrixMaisonById($id)
    {
        $sql = "select prix from typemaison where idtypemaison='$id'";
        //echo $sql;
        $query = $this->db->query($sql);
        $row = $query->row();
        if ($row) {
            //var_dump($row);
            return $row->prix;
        } else {
            return null;
        }
    }
    public function getTypeFinition()
    {
        $query = $this->db->get('typefinition');
        return $query->result_array();
    }
    public function getTypeMaison()
    {
        $query = $this->db->get('typemaison');
        return $query->result_array();
    }
    public function getDevisById($id)
    {
        $query = $this->db->get_where('reste_a_payer_devis', array('iddevis' => $id));
        return $query->result_array();
    }
    public function getDevisEnCours()
    {
        $sql = "SELECT *
        FROM devis order by paiement_effectue ASC";
        $query = $this->db->query($sql);
        $data = array();
        $result = $query->result_array();

        if ($query) {
            foreach ($result as $results) {
                array_push($data, $results);
            }
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $this->db->error();
        }
        return $data;
    }
    public function getDevisByIdClient($id)
    {
        $query = $this->db->get_where('devis', array('idclient' => $id));
        return $query->result_array();
    }
    public function getDevis()
    {
        $query = $this->db->get('devis');
        return $query->result_array();
    }
    public function get_remaining_amount_by_id($idDevis)
    {
        $query = $this->db->select('reste_a_payer')
            ->from('reste_a_payer_devis')
            ->where('iddevis', $idDevis)
            ->get();

        $row = $query->row();
        return $row->reste_a_payer;
    }
    public function get_montant_total()
    {
        $query = $this->db->select('SUM(montant_total) AS montant_total')
            ->get('devis');
        return $query->row()->montant_total;
    }

    public function get_effectue_total()
    {
        $query = $this->db->select('SUM(montant_payer) AS effectue_total')
            ->get('facturation');
        return $query->row()->effectue_total;
    }

    public function get_devis()
    {
        $query = $this->db->order_by('datecreation', 'asc')
            ->get('devis');
        return $query->result();
    }

    public function get_annee_existant()
    {
        $query = $this->db->select('EXTRACT(YEAR FROM datecreation) AS annee')
            ->group_by('EXTRACT(YEAR FROM datecreation)')
            ->order_by('annee')
            ->get('devis');
        return $query->result();
    }

    public function get_mois($annee)
    {
        $query = $this->db->query("SELECT EXTRACT(MONTH FROM datecreation) AS mois, SUM(montant_total) AS total_mensuel FROM devis WHERE EXTRACT(YEAR FROM datecreation)='$annee' GROUP BY EXTRACT(MONTH FROM datecreation) ORDER BY mois");
        return $query->result();
    }

    public function get_annee()
    {
        $query = $this->db->select('EXTRACT(YEAR FROM datecreation) AS annee, SUM(montant_total) AS total_annuel')
            ->group_by('EXTRACT(YEAR FROM datecreation)')
            ->order_by('annee')
            ->get('devis');
        return $query->result();
    }
}