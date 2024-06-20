<link rel="stylesheet" href="<?php echo base_url() ?>/assets/css_perso/output/_table.css">
<br>
<table>
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Designations</th>
            <th scope="col">Qté</th>
            <th scope="col">P.U</th>
            <th scope="col">Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($travaux as $d) { ?>
            <tr>
                <td><?php echo $d['idtravaux'] ?></td>
                <td><?php echo $d['designation'] ?></td>
                <td><?php echo $d['quantite'] . " " . $d['unite'] ?></td>
                <td><?php echo number_format($d['prixunitaire'], 2) ?> Ar</td>
                <td><?php echo number_format($d['quantite'] * $d['prixunitaire'], 2) ?> Ar
                </td>
                <td>
                    <a
                        href="<?php echo base_url('BackController/load_page_update_travaux/' . $d['idtravaux']); ?>">Modifier</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<ul class="pagination">
    <li><?php echo $this->pagination->create_links(); ?></li>
</ul>

<link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/pagination.css" />