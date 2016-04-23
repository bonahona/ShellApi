<div class="modal fade" id="seealsolinkdialog" tabindex="-1" role="dialog" aria-labelledby="See Also Link">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Create new See Also Link</h4>
            </div>
            <?php echo $this->Form->Start('SeeAlsoLink', array('attributes' => array('class' => 'ajax-form', 'link-target' => '/SeeAlsoLinks/Create/')));?>
            <?php echo $this->Form->Hidden('ProjectId');?>
            <?php echo $this->Form->Hidden('ClassId');?>
            <?php echo $this->Form->Hidden('MethodId');?>
            <?php echo $this->Form->Hidden('PropertyId');?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Display name</label>
                        <?php echo $this->Form->Input('DisplayName', array('attributes' => array('class' => 'form-control')));?>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <?php echo $this->Form->Input('Link', array('attributes' => array('class' => 'form-control')));?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <?php echo $this->Form->Submit('Create', array('attributes' => array('class' => 'ajax-link btn btn-md btn-primary')));?>
                </div>
            <?php echo $this->Form->End();?>
        </div>
    </div>
</div>