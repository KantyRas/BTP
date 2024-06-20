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
<style>
    .scroller {
        width: 500px;
        height: 350px;
        overflow-x: auto;
        overflow-y: hidden;
        scrollbar-color: rebeccapurple;
        scrollbar-width: thin;
    }
</style>
<br>
<form class="row g-3" action="<?php echo base_url('FrontController/traitement_devis') ?>" method="POST">

    <input type="hidden" name="idclient" value="<?php echo $valeurs[2]['idutilisateur'] ?>">
    <label>Type de maison</label>
    <div class="col-sm-12">
        <div class="scroller">
            <div class="row">
                <?php for ($i = 0; $i < count($valeurs[0]); $i++) { ?>
                    <div class="col-md-4">
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $valeurs[0][$i]['typemaison'] ?></h5>
                                <p class="card-text"><b><?php echo $valeurs[0][$i]['dureeconstruction'] ?> jours</b></p>
                                <p class="card-text"><?php echo $valeurs[0][$i]['description'] ?></p>
                                <p class="card-text"><?php echo $valeurs[0][$i]['prix'] ?> Ar</p>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="maison" id="option<?php echo $i; ?>"
                                        value="<?php echo $valeurs[0][$i]['idtypemaison'] ?>">
                                    <label class=" form-check-label">
                                        Choix
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <label>Type de finition</label>
    <div class="col-sm-12">
        <div class="scroller">
            <div class="row">
                <?php for ($j = 0; $j < count($valeurs[1]); $j++) { ?>
                    <div class="col-md-4">
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $valeurs[1][$j]['typefinition'] ?></h5>
                                <p class="card-text"><b>+ <?php echo $valeurs[1][$j]['augmentaion_prix'] ?> %</b></p>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="finition"
                                        id="safidy<?php echo $j; ?>"
                                        value="<?php echo $valeurs[1][$j]['idtypefinition'] ?>">
                                    <label class=" form-check-label">
                                        Choix
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>

    <div class="col-md-3 mt-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" name="description">
    </div>

    <div class="col-md-3 mt-3">
        <label for="datedebut" class="form-label">Debut travaux</label>
        <input type="date" class="form-control" name="datedebut">
    </div>
    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Valider</button>
    </div>
</form>