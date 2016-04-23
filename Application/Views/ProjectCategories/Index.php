<h1>Project Categories</h1>

<div class="row">
    <div class="col-lg-8">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="col-lg-1">Id</th>
                    <th class="col-lg-8">Name</th>
                    <th class="col-lg-1">Active</th>
                    <th class="col-lg-2">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($ProjectCategories as $projectCategory):?>
                    <tr>
                        <td><?php echo $projectCategory->Id;?></td>
                        <td><?php echo $projectCategory->Name;?></td>
                        <td><?php echo $projectCategory->IsActive;?></td>
                        <td>
                            <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ProjectCategories/Edit/$projectCategory->Id";?>"><span class="glyphicon glyphicon-pencil"</span></a>
                            <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ProjectCategories/DeleteConfirm/$projectCategory->Id";?>"><span class="glyphicon glyphicon-trash"</span></a>
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
        <a class="btn btn-medium btn-default" href="/ProjectCategories/Create/">Create new</a>
    </div>
</div>