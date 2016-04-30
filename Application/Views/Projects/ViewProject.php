<h1 class="page-header"><?php echo $Property->PropertyName;?></h1>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <dl>
            <dt>Type:</dt>
            <dd>
                <?php if($Property->Type->ExternalSource === ''):?>
                    <a href="<?php echo '/Projects/Details/' . $Project->ProjectName . '/Classes/' . $Property->Type->ClassName;?>">
                        <?php echo $Property->Type->ClassName;?>
                    </a>
                <?php else:?>
                    <a target="_blank" href="<?php echo $Property->Type->ExternalSource;?>">
                        <?php echo $Property->Type->ClassName;?>
                    </a>
                <?php endif;?>
            </dd>
        </dl>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <?php echo $Property->Description;?>
    </div>
</div>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-md btn-default" href="<?php echo "/Properties/Description/$Property->Id";?>">Edit description</a>
        </div>
    </div>
<?php endif;?>

<?php echo $this->PartialView('Documents', array('Documents' => $Documents, 'Project' => $Project));?>
<?php echo $this->PartialView('SeeAlsoLinks', array('SeeAlsoLinks' => $SeeAlsoLinks, 'Project', $Project));?>

<?php if($this->IsLoggedIn()):?>
    <?php echo $this->PartialView('SeeAlsoLinkDialog');?>
<?php endif;?>

