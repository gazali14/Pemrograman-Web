<?php echo $this->extend('layouts/main') ?>

<?php echo $this->section('content'); ?>
<!-- title -->
<h1>Update Portfolio</h1>

<!-- alert validation errors -->
<!-- cek apakah ada errors -->
<?php if (session()->has('errors')) : ?>
<div class="alert alert-danger" role="alert">
    <ul><!-- dilakukan perulangan pesan error -->
    <?php foreach (session('errors') as $error) : ?>
        <li><?= $error ?></li>
    <?php endforeach ?></ul>
</div>
<?php endif ?>

<!-- form update -->
<form method="post" action="<?php echo site_url('portfolio/update/'.$portfolio->id);?>"enctype="multipart/form-data">
    <?php echo csrf_field() ?>
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo set_value('title', $portfolio->title);?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4"><?php echo set_value('description', $portfolio->description);?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image">
    </div>
    <div class="mb-3">
        <?php if($portfolio->image):?>
            <img src="<?php echo base_url($portfolio->image);?>" width="50%" alt="<?php echo $portfolio->title;?>">
        <?php endif;?>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a class="btn btn-secondary" href="<?php echo site_url('portfolio');?>">Back</a>
</form>
<?php echo $this->endSection(); ?>