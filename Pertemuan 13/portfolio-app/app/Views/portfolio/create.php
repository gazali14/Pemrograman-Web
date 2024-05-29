<?php echo $this->extend('layouts/main') ?>

<?php echo $this->section('content'); ?>
<h1>Create Portfolio</h1>

<!-- Menampilkan pesan error ketika data tidak valid -->
<!-- cek apakah ada errors -->
<?php if (session()->has('errors')) : ?>
<div class="alert alert-danger" role="alert">
    <ul><!-- dilakukan perulangan pesan error -->
    <?php foreach (session('errors') as $error) : ?>
        <li><?= $error ?></li>
    <?php endforeach ?></ul>
</div>
<?php endif ?>

<form method="post" action="/portfolio/create"enctype="multipart/form-data">
    <?php echo csrf_field() ?>
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" class="form-control" name="title"value="<?php echo set_value('title', '');?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4"><?php echo set_value('description', '');?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a class="btn btn-secondary" href="<?php echo site_url('portfolio');?>">Back</a>
</form>
<?php echo $this->endSection(); ?>