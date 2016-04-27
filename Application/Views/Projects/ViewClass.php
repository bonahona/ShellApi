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

<?php if(count($PublicMethods)):?>
    <h2>Public methods</h2>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <?php if($this->IsLoggedIn()):?>
                            <th class="col-lg-2">Name</th>
                            <th class="col-lg-2">Type</th>
                            <th class="col-lg-6">Description</th>
                            <th class="col-lg-2">&nbsp;</th>
                        <?php else:?>
                            <th class="col-lg-2">Name</th>
                            <th class="col-lg-2">Type</th>
                            <th class="col-lg-8">Description</th>
                        <?php endif;?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($PublicMethods as $publicMethod):?>
                        <tr>
                            <?php if($this->IsLoggedIn()):?>
                                <td><a href="#"><?php echo $publicMethod->MethodName;?></a></td>
                                <td><a href="#"><?php echo $publicMethod->ReturnType->ClassName;?></a></td>
                                <td><?php echo $publicMethod->ShortDescription;?></td>
                                <td>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Methods/Description/$publicMethod->Id";?>"><span class="glyphicon glyphicon-align-left"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Methods/Edit/$publicMethod->Id";?>"><span class="glyphicon glyphicon-pencil"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Methods/DeleteConfirm/$publicMethod->Id";?>"><span class="glyphicon glyphicon-trash"</a>
                                </td>
                            <?php else:?>
                                <td><a href="#"><?php echo $publicMethod->MethodName;?></a></td>
                                <td><a href="#"><?php echo $publicMethod->ReturnType->ClassName;?></a></td>
                                <td><?php echo $publicMethod->ShortDescription;?></td>
                            <?php endif;?>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif;?>


<?php if(count($ProtectedMethods)):?>
    <h2>Protected methods</h2>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <?php if($this->IsLoggedIn()):?>
                            <th class="col-lg-2">Name</th>
                            <th class="col-lg-2">Type</th>
                            <th class="col-lg-6">Description</th>
                            <th class="col-lg-2">Description</th>
                        <?php else:?>
                            <th class="col-lg-2">Name</th>
                            <th class="col-lg-2">Type</th>
                            <th class="col-lg-8">Description</th>
                        <?php endif;?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($ProtectedMethods as $protectedMethod):?>
                        <tr>
                            <?php if($this->IsLoggedIn()):?>
                                <td><a href="#"><?php echo $protectedMethod->MethodName;?></a></td>
                                <td><a href="#"><?php echo $protectedMethod->ReturnType->ClassName;?></a></td>
                                <td><?php echo $protectedMethod->ShortDescription;?></td>
                                <td>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Methods/Description/$protectedMethod->Id";?>"><span class="glyphicon glyphicon-align-left"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Methods/Edit/$protectedMethod->Id";?>"><span class="glyphicon glyphicon-pencil"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Methods/DeleteConfirm/$protectedMethod->Id";?>"><span class="glyphicon glyphicon-trash"</a>
                                </td>
                            <?php else:?>
                                <td><a href="#"><?php echo $protectedMethod->MethodName;?></a></td>
                                <td><a href="#"><?php echo $protectedMethod->ReturnType->ClassName;?></a></td>
                                <td><?php echo $protectedMethod->ShortDescription;?></td>
                            <?php endif;?>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif;?>

<?php if(count($StaticMethods)):?>
    <h2>Static methods</h2>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <?php if($this->IsLoggedIn()):?>
                            <th class="col-lg-2">Name</th>
                            <th class="col-lg-2">Type</th>
                            <th class="col-lg-6">Description</th>
                            <th class="col-lg-2">Description</th>
                        <?php else:?>
                            <th class="col-lg-2">Name</th>
                            <th class="col-lg-2">Type</th>
                            <th class="col-lg-8">Description</th>
                        <?php endif;?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($StaticMethods as $staticMethods):?>
                        <tr>
                            <?php if($this->IsLoggedIn()):?>
                                <td><a href="#"><?php echo $staticMethods->MethodName;?></a></td>
                                <td><a href="#"><?php echo $staticMethods->ReturnType->ClassName;?></a></td>
                                <td><?php echo $staticMethods->ShortDescription;?></td>
                                <td>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Methods/Description/$staticMethods->Id";?>"><span class="glyphicon glyphicon-align-left"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Methods/Edit/$staticMethods->Id";?>"><span class="glyphicon glyphicon-pencil"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Methods/DeleteConfirm/$staticMethods->Id";?>"><span class="glyphicon glyphicon-trash"</a>
                                </td>
                            <?php else:?>
                                <td><a href="#"><?php echo $staticMethods->MethodName;?></a></td>
                                <td><a href="#"><?php echo $staticMethods->ReturnType->ClassName;?></a></td>
                                <td><?php echo $staticMethods->ShortDescription;?></td>
                            <?php endif;?>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif;?>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-md btn-default" href="<?php echo "/Methods/Create/$ProjectClass->Id";?>">Create method</a>
        </div>
    </div>
<?php endif;?>

<h2>Properties</h2>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="col-lg-2">Name</th>
                    <th class="col-lg-2">Type</th>
                    <th class="col-lg-8">Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><a href="#">Name</a></td>
                    <td><a href="#">String</a></td>
                    <td>Internal name</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if($this->IsLoggedIn()):?>
    <h3>Documents</h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="col-lg-2">Id</th>
                        <th class="col-lg-4">Page title</th>
                        <th class="col-lg-4">Navigation title</th>
                        <th class="col-lg-2">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($Documents as $document):?>
                        <tr>
                            <td><?php echo $document->Id;?></td>
                            <td>
                                <?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Documents/$document->NavigationTitle", $document->PageTitle);?>
                            </td>
                            <td><?php echo $document->NavigationTitle;?></td>
                            <td>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Documents/Content/$document->Id";?>"><span class="glyphicon glyphicon-align-left"</a>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Documents/Edit/$document->Id";?>"><span class="glyphicon glyphicon-pencil"</a>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Documents/DeleteConfirm/$document->Id";?>"><span class="glyphicon glyphicon-trash"</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <a class="btn btn-md btn-default" href="<?php echo "/Documents/Create/Class/$Project->Id";?>">Create document</a>
        </div>
    </div>

<?php else:?>
    <?php if(count($Documents) > 0):?>
        <h3>Documents</h3>
        <ul>
            <?php foreach($Documents as $document):?>
                <li>
                    <?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Documents/$document->NavigationTitle", $document->PageTitle);?>
                </li>
            <?php endforeach;?>
        </ul>
    <?php endif;?>
<?php endif;?>

<?php if($this->IsLoggedIn()):?>
    <h3>See also</h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="col-lg-2">Id</th>
                        <th class="col-lg-4">Display Name</th>
                        <th class="col-lg-4">Link</th>
                        <th class="col-lg-2">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody class="see-also-links-body">
                    <?php foreach($SeeAlsoLinks as $seeAlsoLink):?>
                        <tr>
                            <td><?php echo $seeAlsoLink->Id;?></td>
                            <td><?php echo $seeAlsoLink->DisplayName;?></td>
                            <td><?php echo $seeAlsoLink->Link;?></td>
                            <td>

                                <button type="button" class="delete-see-also-link btn btn-md btn-default" link-target="/SeeAlsoLinks/Delete/<?php echo $seeAlsoLink->Id;?>">
                                    <span class="glyphicon glyphicon-trash"</span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <button type="button" class="btn btn-md btn-default" data-toggle="modal" data-target="#seealsolinkdialog">Create link</button>
        </div>
    </div>
<?php else:?>
    <?php if(count($SeeAlsoLinks) > 0):?>
        <h3>See also</h3>
        <?php foreach($SeeAlsoLinks as $seeAlsoLink):?>
            <div class="row">
                <div class="col-lg-4">
                    <a target="_blank" href="<?php echo $seeAlsoLink->Link;?>">
                        <?php echo $seeAlsoLink->DisplayName;?>
                    </a>
                </div>
            </div>
        <?php endforeach;?>
    <?php endif;?>
<?php endif;?>

<?php if($this->IsLoggedIn()):?>
    <?php echo $this->PartialView('SeeAlsoLinkDialog');?>
    <?php echo $this->PartialView('InheritInterfaceDialog', array('Classes' => $Classes));?>
<?php endif;?>

