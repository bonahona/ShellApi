<h1><?php echo $Document->PageTitle;?></h1>

<div class="row">
    <div class="col-lg-8">
        <?php echo $Document->Content;?>
    </div>
</div>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-8">
            <a href="/Documents/Content/<?php echo $Document->Id;?>" class="btn btn-md btn-default">Edit</a>
        </div>
    </div>
<?php endif;?>