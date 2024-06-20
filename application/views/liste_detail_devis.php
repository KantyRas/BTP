<link rel="stylesheet" href="<?php echo base_url() ?>/assets/css_perso/output/_table.css">
<?php for ($i = 0; $i < count($tab[0]); $i++) { ?>
    <div class="entete1">
        <h4>Nº Devis : <?php echo "DEVIS" . "/" . str_pad($tab[0][$i]['iddevis'], 3, '0', STR_PAD_LEFT) ?></h4>
        <h4>Client nº : <?php echo $tab[0][$i]['numero'] ?></h4>
        <h5>En date du : <?php echo $tab[0][$i]['datecreation'] ?></h5>
        <h5>Valable jusqu'au : <?php echo $tab[0][$i]['datefin'] ?></h5>
        <h5>Type maison : <?php echo $tab[0][$i]['typemaison'] ?></h5>
        <h5>Description : <?php echo $tab[0][$i]['description_typemaison'] ?></h5>
        <h5>Finition : <?php echo $tab[0][$i]['typefinition'] ?>, augmentaion de
            :+<?php echo $tab[0][$i]['augmentaion_prix'] ?>%</h5>
    </div>
<?php } ?>
<br>
<table>
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