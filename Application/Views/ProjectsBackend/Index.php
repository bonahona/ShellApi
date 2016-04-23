<h1>Projects</h1>

<?php foreach($ProjectCategories as $projectCategory):?>
    <h3>Category: <?php echo $projectCategory->Name;?></h3>

    <div class="row">
        <div class="col-lg-8">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="col-lg-1">Id</th>
                        <th class="col-lg-2">Name</th>
                        <th class="col-lg-5">Description</th>
                        <th class="col-lg-1">Language</th>
                        <th class="col-lg-1">Active</th>
                        <th class="col-lg-2">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($projectCategory->Projects as $project):?>
                        <tr>
                            <td><?php echo $project->Id;?></td>
                            <td>
                                <a href="<?php echo "/Projects/Details/$project->ProjectName";?>"><?php echo $project->ProjectName;?></a>
                            </td>
                            <td><?php echo $project->ShortDescription;?></td>
                            <td><?php echo $project->ProjectLanguage->DisplayName;?></td>
                            <td><?php echo $project->IsActive;?></td>
                            <td>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ProjectsBackend/Description/$project->Id";?>"><span class="glyphicon glyphicon glyphicon-align-left"</span></a>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ProjectsBackend/Edit/$project->Id";?>"><span class="glyphicon glyphicon-pencil"</span></a>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ProjectsBackend/DeleteConfirm/$project->Id";?>"><span class="glyphicon glyphicon-trash"</span></a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php endforeach;?>

<div class="row">
    <div class="col-lg-8">
        <a class="btn btn-medium btn-default" href="/ProjectsBackend/Create/">Create new</a>
    </div>
</div>