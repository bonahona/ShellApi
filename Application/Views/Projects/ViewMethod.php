<h1 class="page-header"><?php echo $Method->MethodName;?></h1>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <dl>
            <dt>Type:</dt>
            <dd>
                <?php if($Method->ReturnType->ExternalSource === ''):?>
                    <a href="<?php echo '/Projects/Details/' . $Project->ProjectName . '/Classes/' . $Method->ReturnType->ClassName;?>">
                        <?php echo $Method->ReturnType->ClassName;?>
                    </a>
                <?php else:?>
                    <a target="_blank" href="<?php echo $Method->ReturnType->ExternalSource;?>">
                        <?php echo $Method->ReturnType->ClassName;?>
                    </a>
                <?php endif;?>
            </dd>
            <dt>Variants:</dt>
            <dd>
                <?php foreach($Methods as $method):?>
                    <div>
                        <?php echo $method->MethodName;?>
                    </div>
                <?php endforeach?>
            </dd>
        </dl>
    </div>
</div>

<?php echo $this->PartialView('ParameterList', array('Parameters' => $Method->Parameters));?>

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
    <?php echo $this->PartialView('CreateParameterDialog', array('Classes' => $Classes))?>
<?php endif;?>

