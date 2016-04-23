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
                        <th class="col-lg-12">Description</th>
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
                            <td><a href="#">GetName()</a></td>
                            <td><a href="#">String</a></td>
                            <td>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ProjectsBackend/Edit/$project->Id";?>"><span class="glyphicon glyphicon-pencil"</a>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ProjectsBackend/DeleteConfirm/$project->Id";?>"><span class="glyphicon glyphicon-trash"</a>
                            </td>
                        <?php else:?>
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
    <h3>See also</h3>

    <?php foreach($SeeAlsoLinks as $seeAlsoLink):?>
    <?php endforeach;?>

    <div class="row">
        <div class="col-lg-8">
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
                    <tbody>
                    <?php foreach($SeeAlsoLinks as $seeAlsoLink):?>
                        <tr>
                            <td><?php echo $seeAlsoLink->Id;?></td>
                            <td><?php echo $seeAlsoLink->DisplayName;?></td>
                            <td><?php echo $seeAlsoLink->Link;?></td>
                            <td>

                                <button type="button" class="btn btn-md btn-default" data-toggle="modal" data-target="#confirmdialog_<?php echo "$seeAlsoLink->Id";?>">
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
            <button type="button" class="btn btn-md btn-default" data-toggle="modal" data-target="#seealsolinkdialog">Create new</button>
        </div>
    </div>
<?php else:?>
    <?php if(count($SeeAlsoLinks) > 0):?>
        <h3>See also</h3>
        <?php foreach($SeeAlsoLinks as $seeAlsoLink):?>
            <div class="row">
                <div class="col-lg-4">
                    <a href="<?php echo $seeAlsoLink->Link;?>">
                        <?php echo $seeAlsoLink->DisplayName;?>
                    </a>
                </div>
            </div>
        <?php endforeach;?>
    <?php endif;?>
<?php endif;?>