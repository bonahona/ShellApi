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
                    <?php foreach($Properties as $property):?>
                        <tr>
                            <?php if($this->IsLoggedIn()):?>
                                <td>
                                    <?php /*
                                    <a href="<?php echo '/Projects/Details/' . $Project->ProjectName . '/Classes/' . $property->ProjectClass->ClassName . '/Properties/' . $property->PropertyName;?>">
                                        <?php echo $property->PropertyName;?>
                                    </a>
                                    */ ?>
                                    <?php echo $property->PropertyName;?>
                                </td>
                                <td>
                                    <?php if($property->Type->ExternalSource === ''):?>
                                        <a href="<?php echo '/Projects/Details/' . $Project->ProjectName . '/Classes/' . $property->Type->ClassName;?>">
                                            <?php echo $property->Type->ClassName;?>
                                        </a>
                                    <?php else:?>
                                        <a target="_blank" href="<?php echo $property->Type->ExternalSource;?>">
                                            <?php echo $property->Type->ClassName;?>
                                        </a>
                                    <?php endif;?>
                                </td>
                                <td><?php echo $property->ShortDescription;?></td>
                                <td>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Properties/Description/$property->Id";?>"><span class="glyphicon glyphicon-align-left"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Properties/Edit/$property->Id";?>"><span class="glyphicon glyphicon-pencil"</a>
                                    <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Properties/DeleteConfirm/$property->Id";?>"><span class="glyphicon glyphicon-trash"</a>
                                </td>
                            <?php else:?>
                                <td>
                                    <a href="<?php echo '/Projects/Details/' . $Project->ProjectName . '/Classes/' . $property->ProjectClass->ClassName . '/Properties/' . $property->PropertyName;?>">
                                        <?php echo $property->PropertyName;?>
                                    </a>
                                </td>
                                <td>
                                    <?php if($property->Type->ExternalSource === ''):?>
                                        <a href="<?php echo '/Projects/Details/' . $Project->ProjectName . '/Classes/' . $property->Type->ClassName;?>">
                                            <?php echo $property->Type->ClassName;?>
                                        </a>
                                    <?php else:?>
                                        <a target="_blank" href="<?php echo $property->Type->ExternalSource;?>">
                                            <?php echo $property->Type->ClassName;?>
                                        </a>
                                    <?php endif;?>
                                </td>
                                <td><?php echo $property->ShortDescription;?></td>
                            <?php endif;?>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif;?>