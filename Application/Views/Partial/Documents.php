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