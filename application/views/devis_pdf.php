<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/styles.min.css" />
    <title>Devis-pdf</title>
    <style>
        * {
            font-family: "Poppins", sans-esrif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #1820c6;
            color: white;
        }
    </style>
</head>

<body>
    <?php for ($i = 0; $i < count($tab[0]); $i++) { ?>
        <div class="entete1">
            <h4>Nº Devis : <?php echo "DEVIS" . "/" . str_pad($tab[0][$i]['iddevis'], 3, '0', STR_PAD_LEFT) ?></h4>
            <h5>En date du : <?php echo $tab[0][$i]['datecreation'] ?></h5>
            <h5><?php echo $tab[0][$i]['datefin'] ?></h5>
            <h5>Type maison : <?php echo $tab[0][$i]['typemaison'] ?></h5>
            <h5>Description : <?php echo $tab[0][$i]['description_typemaison'] ?></h5>
            <h5>Finition : <?php echo $tab[0][$i]['typefinition'] ?>, augmentaion de
                :+<?php echo $tab[0][$i]['augmentaion_prix'] ?>%</h5>
        </div>
    <?php } ?>
    <br>
    <table class="table table-hover" id="myTable">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Designations</th>
                <th scope="col">Qté</th>
                <th scope="col">P.U</th>
                <th scope="col">Total</th>
            </tr>

        </thead>
        <tbody>
            <?php for ($j = 0; $j < count($tab[1]); $j++) { ?>
                <tr>
                    <td><?php echo $tab[1][$j]['idtravaux'] ?></td>
                    <td><?php echo $tab[1][$j]['designation'] ?></td>
                    <td><?php echo $tab[1][$j]['quantite'] . " " . $tab[1][$j]['unite'] ?></td>
                    <td><?php echo number_format($tab[1][$j]['prixunitaire'], 2) ?> Ar</td>
                    <td><?php echo number_format($tab[1][$j]['quantite'] * $tab[1][$j]['prixunitaire'], 2) ?> Ar
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <?php for ($i = 0; $i < count($tab[0]); $i++) { ?>
        <h3>Montant total devis: <?php echo number_format($tab[0][$i]['montant_total'], 2) ?> Ar</h3>
    <?php } ?>
    <br>
    <br>
    <center>
        <h1>DETAIL PAIEMENT</h1>
    </center>
    <table class="table table-hover" id="myTable">
        <thead>
            <tr>
                <th scope="col">Nº facture</th>
                <th scope="col">Ref. devis</th>
                <th scope="col">Paiement du</th>
                <th scope="col">Montant payer</th>
            </tr>

        </thead>
        <tbody>
            <?php for ($z = 0; $z < count($tab[3]); $z++) { ?>
                <tr>
                    <td><?php echo $tab[3][$z]['idfacture'] ?></td>
                    <td><?php echo $tab[3][$z]['ref_paiement'] ?></td>
                    <td><?php echo $tab[3][$z]['date_paiement'] ?></td>
                    <td><?php echo number_format($tab[3][$z]['montant_payer'], 2) ?> Ar</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <br>
    <?php for ($z = 0; $z < count($tab[4]); $z++) { ?>
        <h3>Montan total Paiement effectué : <?php echo number_format($tab[4][$z]['total'], 2) ?>Ar</h3>
    <?php } ?>
</body>

</html>