<link rel="stylesheet" href="<?php echo base_url() ?>/assets/css_perso/output/_table.css">
<br>
<table>
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Finition</th>
            <th scope="col">% augmentation</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($finitions as $d) { ?>
            <tr>
                <td><?php echo $d['idtypefinition'] ?></td>
                <td><?php echo $d['typefinition'] ?></td>
                <td><?php echo $d['augmentaion_prix'] ?> %</td>
                <td>
                    <a
                        href="<?php echo base_url('BackController/load_page_edit_finition/' . $d['idtypefinition']) ?>">Modifier</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<ul class="pagination">
    <li><?php echo $this->pagination->create_links(); ?></li>
</ul>

<link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/pagination.css" />