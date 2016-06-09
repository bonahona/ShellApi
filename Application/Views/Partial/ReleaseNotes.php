<h2>Release notes</h2>
<?php if($this->IsLoggedIn()):?>
    <table class="table table-responsive table-striped">
        <thead>
            <tr>
                <th class="col-lg-2">Id</th>
                <th class="col-lg-4">VersionName</th>
                <th class="col-lg-4">Date</th>
                <th class="col-lg-2">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ReleaseNotes as $releaseNote):?>
                <tr>
                    <td><?php echo $releaseNote->Id;?></td>
                    <td>
                        <a href="/Projects/Details/<?php echo $releaseNote->Project->ProjectName;?>/ReleaseNotes/<?php echo $releaseNote->VersionNumber;?>">
                            <?php echo $releaseNote->VersionNumber;?>
                        </a>
                    </td>
                    <td><?php echo $releaseNote->ReleaseDate;?></td>
                    <td>
                        <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ReleaseNotes/Edit/$releaseNote->Id";?>"><span class="glyphicon glyphicon-pencil"</a>
                        <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/ReleaseNotes/DeleteConfirm/$releaseNote->Id";?>"><span class="glyphicon glyphicon-trash"</a>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

    <div class="row">
        <div class="col-lg-12">
            <a href="/ReleaseNotes/Create/<?php echo $Project->Id;?>" class="btn btn-md btn-default">Create new</a>
        </div>
    </div>
<?php else:?>
    <div class="row">
        <div class="col-lg-8">
            <table class="table table-responsive table-striped">
                <tbody>
                    <?php foreach($ReleaseNotes as $releaseNote):?>
                        <tr>
                            <td>
                                <a href="/Projects/Details/<?php echo $Project->ProjectName;?>/ReleaseNotes/<?php echo $releaseNote->VersionNumber;?>/">
                                    <?php echo $releaseNote->VersionNumber;?>
                                </a>
                            </td>
                            <td class="light-grey">
                                Released <?php echo $releaseNote->ReleaseDate;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif;?>