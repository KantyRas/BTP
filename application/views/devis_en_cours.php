<link rel="stylesheet" href="<?php echo base_url() ?>/assets/css_perso/output/_table.css">
<table>
    <thead>
        <tr>
            <th scope="col">Nº</th>
            <th scope="col">Nº client</th>
            <th scope="col">Description</th>
            <th scope="col">% paiement effectué</th>
            <th scope="col">Date de creation</th>
            <th scope="col">Montant total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($devis as $d) { ?>
            <?php if ($d['paiement_effectue'] > 50) { ?>
                <tr style="color:green;">
                    <?php if ($d['paiement_effectue'] == 50) { ?>
                    <tr>
                    <?php } ?>
                <?php } else { ?>
                <tr style="color:red;">
                <?php } ?>
                <td scope="row">
                    <a href="<?php echo base_url('BackController/load_detail_devis/' . $d['iddevis']); ?>">
                        <?php echo "DEVIS" . "/" . str_pad($d['iddevis'], 3, '0', STR_PAD_LEFT) ?></a>
                </td>
                <td><?php echo $d['idclient'] ?></td>
                <td><?php echo $d['ref_devis'] ?></td>
                <td><?php echo number_format($d['paiement_effectue'], 2) ?> %</td>
                <td><?php echo $d['datecreation'] ?></td>
                <td><?php echo number_format($d['montant_total'], 2) ?> Ar</td>

            </tr>
        <?php } ?>
    </tbody>
</table>
<ul class="pagination">
    <li><?php echo $this->pagination->create_links(); ?></li>
</ul>
<br>
<h4>Paiements déja effectués:</h4>
<table>
    <thead>

        <tr>
            <th scope="col">Nº facture</th>
            <th scope="col">Nº devis</th>
            <th scope="col">Paiement du</th>
            <th scope="col">Montant payer</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($facture as $d) { ?>
            <tr>
                <td scope="row"><?php echo $d['idfacture'] ?></td>
                <td><?php echo "DEVIS" . "/" . str_pad($d['iddevis'], 3, '0', STR_PAD_LEFT) ?></td>
                <td><?php echo $d['date_paiement'] ?></td>
                <td><?php echo number_format($d['montant_payer'], 2) ?> Ar</td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/pagination.css" />