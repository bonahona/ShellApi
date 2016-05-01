<?php if($this->IsLoggedIn()):?>
    <h3>See also</h3>

    <div class="row">
        <div class="col-lg-12">
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
                    <tbody class="see-also-links-body">
                    <?php foreach($SeeAlsoLinks as $seeAlsoLink):?>
                        <tr>
                            <td><?php echo $seeAlsoLink->Id;?></td>
                            <td><?php echo $seeAlsoLink->DisplayName;?></td>
                            <td><?php echo $seeAlsoLink->Link;?></td>
                            <td>
                                <button type="button" class="delete-see-also-link btn btn-md btn-default" link-target="/SeeAlsoLinks/Delete/<?php echo $seeAlsoLink->Id;?>">
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
            <button type="button" class="btn btn-md btn-default" data-toggle="modal" data-target="#seealsolinkdialog">Create link</button>
        </div>
    </div>
<?php else:?>
    <?php if(count($SeeAlsoLinks) > 0):?>
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