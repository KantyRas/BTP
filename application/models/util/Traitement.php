<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Traitement extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function ajout_historique_devis($idtravaux)
    {
        $sql = "insert into historique_devis(iddevis,idclient,ref_devis,idtypemaison,idtypefinition,taux_finition,lieu,datedebut,datecreation,montant_total) 
        SELECT v.iddevis,v.idclient, v.ref_devis, v.idtypemaison, v.idtypefinition, v.taux_finition, v.lieu, v.datedebut, v.datecreation,v.montant_total
        FROM devis v where v.idtypemaison = (select idtypemaison from travauxmaison tm where tm.idtravaux='$idtravaux')";
        $this->db->query($sql);
    }
    public function update_finition($id, $data)
    {
        $this->db->where('idtypefinition', $id);
        $this->db->update('typefinition', $data);

        return $this->db->affected_rows();
    }
    public function update_travaux($id, $data)
    {
        $this->db->where('idtravaux', $id);
        $this->db->update('travauxmaison', $data);
        return $this->db->affected_rows();
    }
    public function count_fields_table($table = '')
    {
        return $this->db->count_all($table);
    }

    public function get_table_paginate($table, $limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $query = $this->db->get($table);
        return $query->result_array();
    }
    public function get_data_table($table)
    {
        $query = $this->db->get($table);
        return $query->result_array();
    }
    public function import_travaux_to_csv($file, $table, $separateur = ',')
    {
        $fields = $this->db->list_fields($table);

        if (empty($fields)) {
            throw new Exception("Erreur: Table ou attributs, colonnes invalides");
        }

        $lines = file($file);

        $sql = array();
        foreach ($lines as $index => $line) {
            if ($index == 0) {
                continue;
            }

            $values = str_getcsv(trim($line), $separateur);
            if (count($values) != count($fields)) {
                throw new Exception("Erreur: Le nombre de colonnes est différent de celui de la table");
            }

            $cleanedValues = array();
            foreach ($values as $index => $value) {
                if ($fields[$index] == 'surface' || $fields[$index] == 'prix_unitaire' || $fields[$index] == 'quantite' || $fields[$index] == 'duree_travaux') {
                    // Conversion en double
                    $cleanedValues[] = (double) str_replace(',', '.', $value);
                } else {
                    $cleanedValues[] = $this->db->escape_str($value);
                }
            }

            $sql[] = "INSERT INTO " . $table . " (" . implode(", ", $fields) . ") VALUES ('" . implode("', '", $cleanedValues) . "')";
        }

        if (!empty($sql)) {
            $this->db->trans_start();
            foreach ($sql as $query) {
                $this->db->query($query);
            }
            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                throw new Exception("Erreur: Échec de l'exécution des requêtes SQL");
            }
        }

        $this->db->query("INSERT INTO typemaison (typemaison, description, surface, dureeconstruction)
        SELECT DISTINCT type_maison, description, surface, duree_travaux FROM $table");

        $this->db->query("INSERT INTO travauxmaison (idtypemaison, designation, codetravaux, idunite, quantite, prixunitaire, total)
        SELECT tm.idtypemaison, t.type_travaux, t.code_travaux, u.idunite, t.quantite, t.prix_unitaire, t.quantite * t.prix_unitaire AS total
        FROM $table t
        INNER JOIN typemaison tm ON t.type_maison = tm.typemaison
        LEFT JOIN unite u ON t.unite = u.unite");

        $this->db->query("UPDATE typemaison tm
        SET prix = (
            SELECT COALESCE(SUM(total), 0) 
            FROM travauxmaison 
            WHERE travauxmaison.idtypemaison = tm.idtypemaison
        )");
    }

    public function import_devis_to_csv($file, $table, $separateur = ';')
    {
        $fields = $this->db->list_fields($table);

        if (empty($fields)) {
            throw new Exception("Erreur: Table ou attributs,colonnes invalides");
        }

        $lines = file($file);

        $sql = array();
        foreach ($lines as $index => $line) {
            if ($index == 0) {
                continue;
            }

            $values = str_getcsv(trim($line), $separateur);
            if (count($values) != count($fields)) {
                throw new Exception("Erreur: Le nombre de colonnes est différent de celui de la table");
            }

            $values[4] = str_replace(',', '.', str_replace('%', '', $values[4]));

            // Conversion du format de date_devis et date_debut (de '22/12/2023' à '2023-12-22')
            $values[5] = date('Y-m-d', strtotime(str_replace('/', '-', $values[5])));
            $values[6] = date('Y-m-d', strtotime(str_replace('/', '-', $values[6])));

            $sql[] = "INSERT INTO " . $table . " (" . implode(", ", $fields) . ") VALUES ('" . implode("', '", $values) . "')";
        }

        if (!empty($sql)) {
            $this->db->trans_start();
            foreach ($sql as $query) {
                $this->db->query($query);
            }
            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                throw new Exception("Erreur: Échec de l'exécution des requêtes SQL");
            }
        }
        $this->db->query("INSERT INTO utilisateur (numero) 
        SELECT DISTINCT client FROM v_devis
        ");

        $this->db->query("INSERT INTO typefinition (typefinition, augmentaion_prix) 
        SELECT DISTINCT finition, taux_finition FROM v_devis
        ");
        $this->db->query("INSERT INTO devis (idclient, ref_devis, idtypemaison, idtypefinition, taux_finition, lieu, datedebut,datecreation) 
        SELECT u.idutilisateur, v.ref_devis, tm.idtypemaison, tf.idtypefinition, v.taux_finition, v.lieu, v.date_debut, v.date_devis
        FROM v_devis v 
        INNER JOIN utilisateur u ON v.client = u.numero 
        INNER JOIN typemaison tm ON v.type_maison = tm.typemaison 
        INNER JOIN typefinition tf ON v.finition = tf.typefinition
        ");

        $this->db->query("UPDATE devis d
        SET montant_total = tm.prix +((tm.prix * d.taux_finition) / 100)
        FROM typemaison tm
        WHERE d.idtypemaison = tm.idtypemaison");

    }

    public function import_paie_to_csv($file, $table, $separateur = ';')
    {
        $fields = $this->db->list_fields($table);

        if (empty($fields)) {
            throw new Exception("Erreur: Table ou attributs, colonnes invalides");
        }

        $lines = file($file);

        $sql = array();
        foreach ($lines as $index => $line) {
            if ($index == 0) {
                continue;
            }

            $values = str_getcsv(trim($line), $separateur);
            if (count($values) != count($fields)) {
                throw new Exception("Erreur: Le nombre de colonnes est différent de celui de la table");
            }

            $values[2] = date('Y-m-d', strtotime(str_replace('/', '-', $values[2])));

            // verification ref_paiement hoe miexiste sa tsy mbola
            $this->db->where('ref_paiement', $values[1]);
            $query = $this->db->get('facturation');
            if ($query->num_rows() > 0) {
                continue; // raha efa miexiste
            }

            $sql[] = "INSERT INTO " . $table . " (" . implode(", ", $fields) . ") VALUES ('" . implode("', '", $values) . "')";
        }

        if (!empty($sql)) {
            $this->db->trans_start();
            foreach ($sql as $query) {
                $this->db->query($query);
            }
            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                throw new Exception("Erreur: Échec de l'exécution des requêtes SQL");
            }
        }

        $this->db->query("INSERT INTO facturation (iddevis, ref_paiement, date_paiement, montant_payer)
        SELECT d.iddevis, vp.ref_paiement, vp.date_paiement, vp.montant 
        FROM v_paiement vp 
        INNER JOIN devis d ON vp.ref_devis = d.ref_devis
        WHERE NOT EXISTS (SELECT 1 FROM facturation f WHERE f.ref_paiement = vp.ref_paiement)
    ");

        $this->db->query("UPDATE devis d
        SET paiement_effectue = (
            SELECT COALESCE(SUM(f.montant_payer), 0) * 100 / d.montant_total
            FROM facturation f
            WHERE f.iddevis = d.iddevis
        )");
    }

    public function export_to_csv($file = '', $table = '', $separateur = '')
    {
        $data = $this->get_data_table($table);

        $fields = $this->db->list_fields($table);

        $fp = fopen($file, 'w');

        fputcsv($fp, $fields, $separateur);

        foreach ($data as $row) {
            fputcsv($fp, $row, $separateur);
        }

        fclose($fp);
    }

}