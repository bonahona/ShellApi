<h1><?php echo $Project->ProjectName . ' ' . $ReleaseNotes->VersionNumber;?></h1>

<h2 class="light-grey">Released <?php echo $ReleaseNotes->ReleaseDate;?></h2>

<div class="row">
    <div class="col-lg-8">
        <?php echo $ReleaseNotes->Content;?>
    </div>
</div>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-8">
            <a href="/ReleaseNotes/Edit/<?php echo $ReleaseNotes->Id;?>">Edit</a>
        </div>
    </div>
<?php endif;?>