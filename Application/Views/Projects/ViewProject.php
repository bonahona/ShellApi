<h1 class="page-header"><?php echo $Project->ProjectName;?></h1>

<div class="row">
    <div class="col-lg-8">
        <?php echo $Project->Description;?>
    </div>
</div>

<h2>Classes</h2>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <?php if($this->IsLoggedIn()):?>
                        <th class="col-lg-2">Name</th>
                        <th class="col-lg-8">Description</th>
                        <th class="col-lg-2">&nbsp;</th>
                    <?php else:?>
                        <th class="col-lg-2">Name</th>
                        <th class="col-lg-10">Description</th>
                    <?php endif;?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($Project->ProjectClasses as $projectClass):?>
                    <tr>
                        <?php if($this->IsLoggedIn()):?>
                            <td><?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Classes/$projectClass->ClassName", $projectClass->ClassName);?></td>
                            <td><?php echo $projectClass->ShortDescription;?></td>
                            <td>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Classes/Description/$projectClass->Id";?>"><span class="glyphicon glyphicon-align-left"</a>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Classes/Edit/$projectClass->Id";?>"><span class="glyphicon glyphicon-pencil"</a>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Classes/DeleteConfirm/$projectClass->Id";?>"><span class="glyphicon glyphicon-trash"</a>
                            </td>
                        <?php else:?>
                            <td><?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Classes/$projectClass->ClassName", $projectClass->ClassName);?></td>
                            <td><?php echo $projectClass->ShortDescription;?></td>
                        <?php endif;?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-8">
            <a class="btn btn-md btn-default" href="<?php echo "/Classes/Create/$Project->Id";?>">Create class</a>
        </div>
    </div>
<?php endif;?>

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
            <a class="btn btn-md btn-default" href="<?php echo "/Documents/Create/Project/$Project->Id";?>">Create document</a>
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
<?php endif;?>
