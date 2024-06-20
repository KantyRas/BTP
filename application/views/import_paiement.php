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

<form action="<?php echo base_url('BackController/import_csv_paiement') ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="table" value="v_paiement">
    <div>
        <label for="csv_file">Importation paiement</label>
        <input type="file" name="csv_file" required>
    </div>

    <div>
        <button type="submit">Importer</button>
    </div>
</form>