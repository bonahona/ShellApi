<div class="modal fade" id="createparameterdialog" tabindex="-1" role="dialog" aria-labelledby="Create Parameter">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Create new Parameter</h4>
            </div>
            <?php echo $this->Form->Start('Parameter', array('attributes' => array('class' => 'ajax-form', 'link-target' => '/Parameters/Create/')));?>
            <?php echo $this->Form->Hidden('MethodId', array('value' => $Method->Id));?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Parameter name</label>
                        <?php echo $this->Form->Input('ParameterName', array('attributes' => array('class' => 'form-control')));?>
                    </div>
                    <div class="form-group">
                        <label>Default value</label>
                        <?php echo $this->Form->Input('DefaultValue', array('attributes' => array('class' => 'form-control')));?>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <?php echo $this->Form->Select('TypeId', $Classes, array('key' => 'Id', 'value' => 'ClassName', 'attributes' => array('class' => 'form-control')));?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <?php echo $this->Form->Submit('Create', array('attributes' => array('class' => 'parameter-link btn btn-md btn-primary')));?>
                </div>
            <?php echo $this->Form->End();?>
        </div>
    </div>
</div>