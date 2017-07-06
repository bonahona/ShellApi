
<div class="modal fade" id="creategenerictypedialog" tabindex="-1" role="dialog" aria-labelledby="Create Generic Type">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Create new Generic Type</h4>
            </div>
            <?php echo $this->Form->Start('GenericType', array('attributes' => array('class' => 'ajax-form', 'link-target' => '/GenericTypes/Create/')));?>
            <?php echo $this->Form->Hidden('MethodId', array('value' => $Method->Id));?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Type name</label>
                        <?php echo $this->Form->Input('TypeName', array('attributes' => array('class' => 'form-control')));?>
                    </div>
                    <div class="form-group">
                        <label>Constraint</label>
                        <?php echo $this->Form->Input('Constraint', array('attributes' => array('class' => 'form-control')));?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <?php echo $this->Form->Submit('Create', array('attributes' => array('class' => 'generic-type-link btn btn-md btn-primary')));?>
                </div>
            <?php echo $this->Form->End();?>
        </div>
    </div>
</div>