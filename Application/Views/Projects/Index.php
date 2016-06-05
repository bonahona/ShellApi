<h1>Projects</h1>

<?php echo $this->PartialView('StaticBlock', array('Identifier' => 'presentation'));?>

<?php foreach($ProjectCategories as $projectCategory):?>
    <?php if(count($projectCategory->Projects) > 0):?>
        <h3><?php echo $projectCategory->Name;?></h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <?php if($this->IsLoggedin()):?>
                            <thead>
                            <tr>
                                <th class="col-lg-4">Project</th>
                                <th class="col-lg-6">Description</th>
                                <th class="col-lg-2">&nbsp;</th>
                            </tr>
                            </thead>
                        <?php endif;?>
                        <tbody>
                            <?php foreach($projectCategory->Projects as $project):?>
                                <tr>
                                    <?php if($this->IsLoggedIn()):?>
                                        <td>
                                            <a href="<?php echo "/Projects/Details/$project->ProjectName";?>"><?php echo $project->ProjectName;?></a>
                                        </td>
                                        <td><?php echo $project->ShortDescription;?></td>
                                        <td>
                                            <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ProjectsBackend/Description/$project->Id";?>"><span class="glyphicon glyphicon glyphicon-align-left"</span></a>
                                            <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ProjectsBackend/Edit/$project->Id";?>"><span class="glyphicon glyphicon-pencil"</span></a>
                                            <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ProjectsBackend/DeleteConfirm/$project->Id";?>"><span class="glyphicon glyphicon-trash"</span></a>
                                        </td>
                                    <?php else:?>
                                        <td class="col-lg-4">
                                            <a href="<?php echo "/Projects/Details/$project->ProjectName";?>"><?php echo $project->ProjectName;?></a>
                                        </td>
                                        <td class="col-lg-8"><?php echo $project->ShortDescription;?></td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif;?>
<?php endforeach;?>