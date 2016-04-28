<h1 class="page-header"><?php echo $ProjectClass->ClassName;?></h1>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <dl>
            <?php if($ProjectClass->BaseClass != null):?>
                <dt>Inherits:</dt>
                <dd>
                    <a href="#">Object</a>
                </dd>
            <?php endif;?>

            <?php if($this->IsLoggedIn()):?>
                <h3>Implements</h3>

                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Class</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody class="implements-inheritance-body">
                            <?php foreach($InheritInterfaces as $inheritInterface):?>
                                <tr>
                                    <td><?php echo $inheritInterface->Id;?></td>
                                    <td><?php echo $inheritInterface->InheritInterface->ClassName;?></td>
                                    <td>
                                        <a href="#" class="btn btn-md btn-default"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <button type="button" class="btn btn-md btn-default" data-toggle="modal" data-target="#inheritinterfacedialog">Create interface</button>
                    </div>
                </div>
            <?php else:?>
                <?php if(count($InheritInterfaces) > 0):?>
                    <dt>Implements:</dt>
                    <dd>
                        <?php foreach($InheritInterfaces as $inheritInterface):?>
                            <?php if($inheritInterface->InheritInterface->ExternalSource != ''):?>
                                 <a target="_blank" href="<?php echo $inheritInterface->InheritInterface->ExternalSource;?>">
                                     <?php echo $inheritInterface->InheritInterface->ClassName;?>
                                 </a>,
                            <?php else:?>
                                <a href="#"><?php echo $inheritInterface->InheritInterface->ClassName;?></a>,
                            <?php endif;?>
                        <?php endforeach;?>
                    </dd>
                <?php endif;?>
            <?php endif;?>

            <?php if(!empty($ProjectClass->Namespace)):?>
                <dt>Namespace:</dt>
                <dd><?php echo $ProjectClass->Namespace;?></dd>
            <?php endif;?>
        </dl>
    </div>
</div>
<h2>Description</h2>
<div class="row">
    <div class="col-lg-8">
        <?php echo $ProjectClass->Description;?>
    </div>
</div>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-md btn-default" href="<?php echo "/Classes/Description/$ProjectClass->Id";?>">Edit description</a>
        </div>
    </div>
<?php endif;?>

<?php echo $this->PartialView('Method', array('Methods' => $PublicMethods, 'Header' => 'Public Methods', 'Project' => $Project));?>
<?php echo $this->PartialView('Method', array('Methods' => $ProtectedMethods, 'Header' => 'Protected Methods', 'Project' => $Project));?>
<?php echo $this->PartialView('Method', array('Methods' => $StaticMethods, 'Header' => 'Static Methods', 'Project' => $Project));?>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-md btn-default" href="<?php echo "/Methods/Create/$ProjectClass->Id";?>">Create method</a>
        </div>
    </div>
<?php endif;?>

<?php echo $this->PartialView('Property', array('Properties' => $PublicProperties, 'Header' => 'Public Properties', 'Project' => $Project));?>
<?php echo $this->PartialView('Property', array('Properties' => $ProtectedProperties, 'Header' => 'Protected Properties', 'Project' => $Project));?>
<?php echo $this->PartialView('Property', array('Properties' => $StaticProperties, 'Header' => 'Static Properties', 'Project' => $Project));?>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-md btn-default" href="<?php echo "/Properties/Create/$ProjectClass->Id";?>">Create property</a>
        </div>
    </div>
<?php endif;?>

<?php echo $this->PartialView('Documents', array('Documents' => $Documents, 'Project' => $Project));?>
<?php echo $this->PartialView('SeeAlsoLinks', array('SeeAlsoLinks' => $SeeAlsoLinks, 'Project', $Project));?>

<?php if($this->IsLoggedIn()):?>
    <?php echo $this->PartialView('SeeAlsoLinkDialog');?>
    <?php echo $this->PartialView('InheritInterfaceDialog', array('Classes' => $Classes));?>
<?php endif;?>

