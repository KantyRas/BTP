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

<?php foreach ($finitions as $t) { ?>
    <form action="<?php echo base_url('BackController/update_type_finition/' . $t['idtypefinition']); ?>"
        method="POST">
        <div>
            <label for="typefinition">Type finition</label>
            <input type="text" name="typefinition"  value="<?php echo $t['typefinition']; ?>" required>
        </div>

        <div >
            <label for="augmentation" class="form-label">% Finition</label>
            <input type="text"  name="augmentation" value="<?php echo $t['augmentaion_prix']; ?>"
                required>
        </div>

        <div >
            <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
    </form>
<?php } ?>