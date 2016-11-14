
<?php if($this->IsLoggedIn() || count($NamespacedClasses) > 0 || count($PublicClasses) > 0):?>
    <h2>Classes</h2>

    <?php if($NamespacesExists):?>
        <?php foreach($NamespacedClasses as $namespace => $classes):?>
            <h3>Namespace <?php echo $namespace;?></h3>
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
                            <?php foreach($classes as $projectClass):?>
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
        <?php endforeach;?>
    <?php else:?>
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
                        <?php foreach($PublicClasses as $projectClass):?>
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
    <?php endif;?>

    <?php if($this->IsLoggedIn()):?>
        <div class="row">
            <div class="col-lg-12">
                <a href="/ProjectsBackend/MultiEditClasses/<?php echo $Project->Id;?>" class="btn btn-md btn-default">Multi Edit</a>
            </div>
        </div>
    <?php endif;?>

    <?php if($this->IsLoggedIn()):?>
        <h2>External Classes</h2>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="col-lg-2">Name</th>
                            <th class="col-lg-8">Description</th>
                            <th class="col-lg-2">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($ExternalClasses as $projectClass):?>
                            <tr>
                                <td><?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Classes/$projectClass->ClassName", $projectClass->ClassName);?></td>
                                <td><?php echo $projectClass->ShortDescription;?></td>
                                <td>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Classes/Description/$projectClass->Id";?>"><span class="glyphicon glyphicon-align-left"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Classes/Edit/$projectClass->Id";?>"><span class="glyphicon glyphicon-pencil"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Classes/DeleteConfirm/$projectClass->Id";?>"><span class="glyphicon glyphicon-trash"</a>
                                </td>
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
            <div class="col-lg-2">
                <a class="btn btn-md btn-default" href="<?php echo "/Classes/Create/$Project->Id";?>">Create class</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <a class="btn btn-md btn-default" href="<?php echo "/ProjectsBackend/GenerateDefaultPrimitives/$Project->Id";?>">Generate primitives</a>
            </div>
        </div>
    <?php endif;?>
<?php endif;?>
