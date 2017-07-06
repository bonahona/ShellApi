<?php if($this->IsLoggedIn()):?>
    <h3>Generic Types</h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="col-lg-2">Id</th>
                        <th class="col-lg-4">Name</th>
                        <th class="col-lg-4">Contraint</th>
                        <th class="col-lg-2">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody class="create-parameter-body">
                    <?php foreach($GenericTypes->OrderBy('SortIndex') as $genericType):?>
                        <tr>
                            <td><?php echo $genericType->Id;?></td>
                            <td><?php echo $genericType->TypeName;?></td>
                            <td><?php echo $genericType->Constraint;?></td>
                            <td>
                                <button type="button" class="delete-parameter btn btn-md btn-default" link-target="/GenericTypes/Delete/<?php echo $genericType->Id;?>">
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
            <button type="button" class="btn btn-md btn-default" data-toggle="modal" data-target="#creategenerictypedialog">Create generic type</button>
        </div>
    </div>
<?php endif;?>