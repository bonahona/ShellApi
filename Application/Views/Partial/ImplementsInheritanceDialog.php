<div class="modal fade" id="implementsinheritancedialog" tabindex="-1" role="dialog" aria-labelledby="Implements Inheritance">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Create new inheritance</h4>
            </div>
            <?php echo $this->Form->Start('ImplementsInheritance', array('attributes' => array('class' => 'ajax-form', 'link-target' => '/ImplementsInheritances/Create/')));?>
            <?php echo $this->Form->Hidden('ProjectClassId');?>
            <div class="modal-body">
                <div class="form-group">
                    <label>Class</label>
                    <?php echo $this->Form->Select('InheritInterfaceId', $Classes,  array('key' => 'Id', 'value' => 'ClassName', 'attributes' => array('class' => 'form-control')));?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <?php echo $this->Form->Submit('Create', array('attributes' => array('class' => 'implements-inheritance btn btn-md btn-primary')));?>
            </div>
            <?php echo $this->Form->End();?>
        </div>
    </div>
</div>