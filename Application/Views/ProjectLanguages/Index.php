<h1>Project Languages</h1>

<div class="row">
    <div class="col-lg-8">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-lg-1">Id</th>
                        <th class="col-lg-4">Name</th>
                        <th class="col-lg-4">Class</th>
                        <th class="col-lg-1">Active</th>
                        <th class="col-lg-2">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ProjectLanguages as $projectLanguage):?>
                        <tr>
                            <td><?php echo $projectLanguage->Id;?></td>
                            <td><?php echo $projectLanguage->DisplayName;?></td>
                            <td><?php echo $projectLanguage->ClassName;?></td>
                            <td><?php echo $projectLanguage->IsActive;?></td>
                            <td>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ProjectLanguages/Edit/$projectLanguage->Id";?>"><span class="glyphicon glyphicon-pencil"</span></a>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ProjectLanguages/DeleteConfirm/$projectLanguage->Id";?>"><span class="glyphicon glyphicon-trash"</span></a>
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
        <a class="btn btn-medium btn-default" href="/ProjectLanguages/Create/">Create new</a>
    </div>
</div>