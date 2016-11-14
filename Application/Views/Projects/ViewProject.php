<?php /*@var $this Controller */?>
<h1 class="page-header"><?php echo $Project->ProjectName;?></h1>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-8">
            <a class="btn btn-medium btn-default" href="<?php echo "/ProjectsBackend/Edit/$Project->Id";?>">Edit details</a>
        </div>
    </div>
<?php endif;?>

<div class="row">
    <div class="col-lg-8">
        <?php echo $Project->Description;?>
    </div>
</div>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-8">
            <a class="btn btn-medium btn-default" href="<?php echo "/ProjectsBackend/Description/$Project->Id";?>">Edit description</a>
        </div>
    </div>
<?php endif;?>

<?php echo $this->PartialView('Classes', array('NamespacesExists' => $NamespacesExists, 'NamespacedClasses' => $NamespacedClasses, 'PublicClasses' => $PublicClasses, 'ExternalClasses' => $ExternalClasses));?>
<?php echo $this->PartialView('Examples', array('Examples' => $Examples, 'Project' => $Project));?>

<?php echo $this->PartialView('Documents', array('Documents' => $Documents, 'AllDocuments' => $AllDocuments, 'Project' => $Project));?>
<?php echo $this->PartialView('ReleaseNotes', array('ReleaseNotes' => $ReleaseNotes, 'Project' => $Project));?>
<?php echo $this->PartialView('SeeAlsoLinks', array('SeeAlsoLinks' => $SeeAlsoLinks), 'Project', $Project);?>

<?php if($this->IsLoggedIn()):?>
    <?php echo $this->PartialView('SeeAlsoLinkDialog');?>
<?php endif;?>
