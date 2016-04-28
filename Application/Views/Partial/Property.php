<?php if(count($Properties) > 0):?>
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
                            <th class="col-lg-2">&nbsp;</th>
                        <?php else:?>
                            <th class="col-lg-2">Name</th>
                            <th class="col-lg-2">Type</th>
                            <th class="col-lg-8">Description</th>
                        <?php endif;?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($Properties as $properties):?>
                        <tr>
                            <?php if($this->IsLoggedIn()):?>
                                <td><a href="#"><?php echo $properties->PropertyName;?></a></td>
                                <td><a href="#"><?php echo $properties->PropertyName;?></a></td>
                                <td><?php echo $properties->ShortDescription;?></td>
                                <td>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Properties/Description/$properties->Id";?>"><span class="glyphicon glyphicon-align-left"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Properties/Edit/$properties->Id";?>"><span class="glyphicon glyphicon-pencil"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Properties/DeleteConfirm/$properties->Id";?>"><span class="glyphicon glyphicon-trash"</a>
                                </td>
                            <?php else:?>
                                <td><a href="#"><?php echo $properties->PropertyName;?></a></td>
                                <td><a href="#"><?php echo $properties->PropertyName;?></a></td>
                                <td><?php echo $properties->ShortDescription;?></td>
                            <?php endif;?>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif;?>