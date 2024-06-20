<a class="btn btn-primary" href="<?php echo base_url('FrontController/load_page_ajout_devis') ?>">Nouveau devis</a>
<br>
<br>
<table class="table table-bordered" id="myTable">
    <thead>
        <tr>
            <th scope="col">Nº</th>
            <th scope="col">Nº client</th>
            <th scope="col">Description</th>
            <th scope="col">Date de creation</th>
            <th scope="col">Montant total</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($devis as $d) { ?>
            <tr>
                <td scope="row"><?php echo $d['iddevis'] ?></td>
                <td><?php echo $d['idclient'] ?></td>
                <td><?php echo $d['ref_devis'] ?></td>
                <td><?php echo $d['datecreation'] ?></td>
                <td><?php echo number_format($d['montant_total'], 2) ?> Ar</td>
                <td>
                    <a href="<?php echo base_url('FrontController/load_detail_devis_pdf/' . $d['iddevis']); ?>">PDF</a>
                    |
                    <?php if ($d['montant_total'] >= 0) { ?>
                        <a href="<?php echo base_url('FrontController/load_page_payer/' . $d['iddevis']); ?>">FACTURER</a>
                    <?php } else { ?>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<ul class="pagination">
    <li><?php echo $this->pagination->create_links(); ?></li>
</ul>

<link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/pagination.css" />