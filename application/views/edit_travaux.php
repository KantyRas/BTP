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

<?php foreach ($travaux as $t) { ?>
    <form action="<?php echo base_url('BackController/update/' . $t['idtravaux']); ?>" method="POST">
        <input type="hidden" name="idtr" value="<?php echo $t['idtravaux'] ?>">
        <div>
            <label for="designation">Type travaux</label>
            <input type="text" name="designation" value="<?php echo $t['designation']; ?>" required>
        </div>

        <div>
            <label for="quantite">Quantité</label>
            <input type="text" name="quantite" value="<?php echo $t['quantite']; ?>" required>
        </div>

        <div>
            <label for="id">Unité</label>
            <select name="idunite">
                <?php foreach ($unites as $u) { ?>
                    <option value="<?php echo $u['idunite'] ?>"><?php echo $u['unite'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label for="prixunitaire">Prix Unitaire</label>
            <input type="text" name="prixunitaire" value="<?php echo $t['prixunitaire']; ?>" required>
        </div>

        <div class="col-12 mt-3">
            <button type="submit">Modifier</button>
        </div>
    </form>
<?php } ?>