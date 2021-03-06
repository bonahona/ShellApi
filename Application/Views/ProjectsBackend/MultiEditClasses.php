<h1>Multi edit classes</h1>

<div class="row">
    <div class="form-group">
        <?php echo $this->Form->Start('Classes');?>
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th class="col-lg-2">Name</th>
                        <th class="col-lg-4">Short Description</th>
                        <th class="col-lg-6">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                <?php $counter = 1;?>
                <?php foreach($Classes as $class):?>
                    <tr>
                        <td>
                            <?php echo $class->ClassName;?>
                        </td>
                        <td>
                        <?php echo $this->Form->Hidden('Id', array('index' => $counter, 'value' => $class->Id));?>
                        <?php echo $this->Form->Input('Description', array('index' => $counter, 'value' => $class->ShortDescription, 'attributes' => array('class' => 'form-control')));?>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php $counter ++;?>
                <?php endforeach;?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-4">
                <?php echo $this->Form->Submit('Save', array('attributes' => array('class' => 'btn btn-medium btn-default')));?>
            </div>
        </div>
    <?php echo $this->Form->End();?>
    </div>
</div>

