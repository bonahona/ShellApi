<h1 class="page-header"><?php echo $Method->MethodName;?></h1>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <dl>
            <dt>Return:</dt>
            <dd>
                <?php if($Method->ReturnType->ExternalSource === ''):?>
                    <a href="<?php echo '/Projects/Details/' . $Method->ProjectName . '/Classes/' . $Method->Type->ClassName;?>">
                        <?php echo $Method->ReturnType->ClassName;?>
                    </a>
                <?php else:?>
                    <a target="_blank" href="<?php echo $Method->ReturnType->ExternalSource;?>">
                        <?php echo $Method->ReturnType->ClassName;?>
                    </a>
                <?php endif;?>
            </dd>
        </dl>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <?php echo $Method->Description;?>
    </div>
</div>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-md btn-default" href="<?php echo "/Methods/Description/$Method->Id";?>">Edit description</a>
        </div>
    </div>
<?php endif;?>

<?php echo $this->PartialView('Documents', array('Documents' => $Documents, 'Project' => $Project));?>
<?php echo $this->PartialView('SeeAlsoLinks', array('SeeAlsoLinks' => $SeeAlsoLinks, 'Project', $Project));?>

<?php if($this->IsLoggedIn()):?>
    <?php echo $this->PartialView('SeeAlsoLinkDialog');?>
<?php endif;?>

