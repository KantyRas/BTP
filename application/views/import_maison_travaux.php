<link rel="stylesheet" href="<?php echo base_url() ?>/assets/css_perso/output/_formulaire.css">
<?php if ($this->session->flashdata('success_message')): ?>
    <div class="alert alert-success mt-3" role="alert">
        <?php echo $this->session->flashdata('success_message'); ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error_message')): ?>
    <div class="alert alert-danger mt-3" role="alert">
        <?php echo $this->session->flashdata('error_message'); ?>
    </div>
<?php endif; ?>

<form action="<?php echo base_url('BackController/import_csv_travaux_devis') ?>" method="POST"
    enctype="multipart/form-data">
    <input type="hidden" name="table1" value="v_travaux">
    <div>
        <label for="csv_file">Maison & Travaux</label>
        <input type="file" name="csv_file" required>
    </div>

    <input type="hidden" name="table2" value="v_devis">
    <div>
        <label for="csv_file2">Devis</label>
        <input type="file" name="csv_file2" required>
    </div>

    <div class="col-12 mt-3">
        <button type="submit">Importer</button>
    </div>
</form>