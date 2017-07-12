<h1 class="page-header"><?php echo $Method->GetHeaderText($Project, $this->Html);?></h1>

<?php $constraintLines = $Method->GetConstraints();?>
<?php if(count($constraintLines) > 0):?>
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <?php foreach($constraintLines as $constraintLine):?>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <?php echo $constraintLine;?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
<?php endif;?>

<div class="row margin-top">
    <div class="col-lg-6 col-md-12">
        <dl>
            <dt>Return Type:</dt>
            <dd>
                <?php $returnType = $Method->GetReturnType();?>

                <?php if($returnType->HasLink()):?>
                    <?php echo $returnType->GetLink();?>
                <?php else:?>
                    <?php echo $returnType->GetName();?>
                <?php endif;?>
            </dd>
        </dl>
    </div>
</div>

<?php echo $this->PartialView('GenericTypeList', array('GenericTypes' => $Method->GenericTypes));?>
<?php echo $this->PartialView('ParameterList', array('Parameters' => $Method->Parameters));?>

<?php if($this->IsLoggedIn()):?>
    <h2>Description</h2>
<?php endif;?>

<div class="row">
    <div class="col-lg-8">
        <?php if($Method->Description != ""):?>
            <?php echo $Method->Description;?>
        <?php else:?>
            <?php echo $Method->ShortDescription;?>
        <?php endif;?>
    </div>
</div>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-md btn-default" href="<?php echo "/Methods/Description/$Method->Id";?>">Edit description</a>
        </div>
    </div>
<?php endif;?>

<?php echo $this->PartialView('Examples', array('Examples' => $Examples, 'Method' => $Method));?>

<?php echo $this->PartialView('Documents', array('Documents' => $Documents, 'Project' => $Project, 'ProjectClass' => $ProjectClass, 'Method' => $Method));?>
<?php echo $this->PartialView('SeeAlsoLinks', array('SeeAlsoLinks' => $SeeAlsoLinks, 'Project' => $Project));?>

<?php if($this->IsLoggedIn()):?>
    <?php echo $this->PartialView('SeeAlsoLinkDialog');?>
    <?php echo $this->PartialView('/Modals/ParameterDialog', array('Classes' => $Classes, 'Method' => $Method))?>
    <?php echo $this->PartialView('/Modals/GenericTypeDialog', array('Classes' => $Classes, 'Method' => $Method))?>
<?php endif;?>

