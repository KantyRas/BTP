<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<br>
<?php foreach ($deviss as $key) { ?>

    <h4>Montant total à payer : <?php echo number_format($key['montant_initial'], 2) ?> Ar</h4>
    <h4>Montant restant à payer : <?php echo number_format($key['reste_a_payer'], 2) ?> Ar</h4>
<?php } ?>
<form id="paiement-form" class="row g-3" action="<?php echo base_url('FrontController/ajout_facture') ?>" method="POST">
    <?php foreach ($deviss as $key) { ?>
        <input type="hidden" name="iddevise" value="<?php echo $key['iddevis'] ?>">
    <?php } ?>
    <div class="col-md-3 mt-3">
        <label for="date_paiement" class="form-label">Date paiement</label>
        <input type="date" class="form-control" name="date_paiement">
    </div>
    <div class="col-md-3 mt-3">
        <label for="ref" class="form-label">Ref. Paiement</label>
        <input type="text" class="form-control" name="ref">
    </div>
    <div class="col-md-3 mt-3">
        <label for="montant" class="form-label">Montant à payer</label>
        <input type="number" class="form-control" name="montant" min="0">
    </div>
    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Payer</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#paiement-form').submit(function (event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url("FrontController/verify_payment_amount") ?>',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'success') {
                        $('#paiement-form')[0].submit();
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert('Une erreur s\'est produite lors de la validation.');
                }
            });
        });
    });
</script>