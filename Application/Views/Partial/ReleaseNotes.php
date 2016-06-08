<h2>Release notes</h2>
<?php if($this->IsLoggedIn()):?>
    <?php foreach($ReleaseNotes as $releaseNote):?>
    <?php endforeach;?>

    <div class="row">
        <div class="col-lg-12">
            <a href="/ReleaseNotes/Create/<?php echo $Project->Id;?>" class="btn btn-md btn-default">Create new</a>
        </div>
    </div>
<?php endif;?>