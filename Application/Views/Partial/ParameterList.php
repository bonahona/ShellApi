<?php if($this->IsLoggedIn()):?>
    <h3>Parameters</h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="col-lg-2">Id</th>
                        <th class="col-lg-3">Name</th>
                        <th class="col-lg-2">Type</th>
                        <th class="col-lg-3">Default value</th>
                        <th class="col-lg-2">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody class="see-also-links-body">
                    <?php foreach($Parameters as $parameter):?>
                        <tr>
                            <td><?php echo $parameter->Id;?></td>
                            <td><?php echo $parameter->ParameterName;?></td>
                            <td><?php echo $parameter->Type->ClassName;?></td>
                            <td><?php echo $parameter->DefaultValue;?></td>
                            <td>
                                <button type="button" class="delete-see-also-link btn btn-md btn-default" link-target="/Parameters/Delete/<?php echo $parameter->Id;?>">
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
            <button type="button" class="btn btn-md btn-default" data-toggle="modal" data-target="#createparameterdialog">Create parameter</button>
        </div>
    </div>
<?php else:?>
    <?php if(count($Parameters) > 0):?>
        <h3>See also</h3>
        <?php foreach($SeeAlsoLinks as $seeAlsoLink):?>
            <div class="row">
                <div class="col-lg-4">
                    <a target="_blank" href="<?php echo $seeAlsoLink->Link;?>">
                        <?php echo $seeAlsoLink->DisplayName;?>
                    </a>
                </div>
            </div>
        <?php endforeach;?>
    <?php endif;?>
<?php endif;?>