<?php if(count($Methods)):?>
    <h2><?php echo $Header;?></h2>
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
                    <?php foreach($Methods as $methods):?>
                        <tr>
                            <?php if($this->IsLoggedIn()):?>
                                <td><a href="#"><?php echo $methods->MethodName;?></a></td>
                                <td><a href="#"><?php echo $methods->ReturnType->ClassName;?></a></td>
                                <td><?php echo $methods->ShortDescription;?></td>
                                <td>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Methods/Description/$methods->Id";?>"><span class="glyphicon glyphicon-align-left"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Methods/Edit/$methods->Id";?>"><span class="glyphicon glyphicon-pencil"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Methods/DeleteConfirm/$methods->Id";?>"><span class="glyphicon glyphicon-trash"</a>
                                </td>
                            <?php else:?>
                                <td><a href="#"><?php echo $methods->MethodName;?></a></td>
                                <td><a href="#"><?php echo $methods->ReturnType->ClassName;?></a></td>
                                <td><?php echo $methods->ShortDescription;?></td>
                            <?php endif;?>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif;?>