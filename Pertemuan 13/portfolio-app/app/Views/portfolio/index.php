<?php echo $this->extend('layouts/main');?>
<?php echo $this->section('content');?>
<!-- menampilkan pesan sukses dari flashdata -->
<?php if(session()->getFlashData('success_message')): ?>
    <div class="alert alert-success" role="alert">
        <?php echo session()->getFlashData('success_message'); ?>
    </div>
<?php endif;?>
<!-- menampilkan list portfolio -->
    <div class="row gx-5 gy-5 mt-2">
        <?php foreach($portfolios as $portfolio):?>
        <div class="col col-6">
            <div class="card">
            <img src="<?php echo base_url($portfolio->image);?>"width="100%" height="400" class="card-img-top" alt="<?php echo $portfolio->title;?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo $portfolio->title;?></h5>
                <p class="card-text"><?php echo $portfolio->description;?></p>
                <br>
                <a href="<?php echo site_url('portfolio/update/'.$portfolio->id);?>" class="btn btn-primary">Edit</a>
                <button onclick="return deletePortfolio('<?php echo $portfolio->id;?>');" class="btn btn-danger">Delete</button>
            </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
<?php echo $this->endSection(); ?>
<!-- script untuk action hapus data portfolio -->
<?php echo $this->section('scripts');?>
<script>
    function deletePortfolio(id) {
        var confirmation = confirm("Are you sure to delete this?");
        if(confirmation == true) {
            fetch("<?php echo site_url('/portfolio/delete');?>/" +id, {
                method: 'DELETE'
            }).then(data => {
                location.reload();
            });
        }
    }
</script>
<?php echo $this->endSection(); ?>
