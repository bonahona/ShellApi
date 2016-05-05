<h1>Edit Example</h1>

<div class="row">
    <div class="col-lg-4">
        <?php echo $this->Form->Start('Example');?>
        <?php echo $this->Form->Hidden('Id');?>
        <?php echo $this->Form->Hidden('ProjectId');?>
        <?php echo $this->Form->Hidden('ClassId');?>
        <?php echo $this->Form->Hidden('MethodId');?>
        <?php echo $this->Form->Hidden('PropertyId');?>
        <div class="form-group">
            <label>Sort Order</label>
            <?php echo $this->Form->Select('SortOrder', $SortOrderList, array('attributes' => array('class' => 'form-control', 'required' => 'true')));?>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <?php echo $this->Form->Bool('IsActive');?>
                    Is Active
                </label>
            </div>
        </div>
        <div class="form-group">
            <label>Project Language</label>
            <?php echo $this->Form->Select('ProjectLanguageId', $ProjectLanguages, array('key' => 'Id', 'value'=>'DisplayName', 'attributes' => array('class' => 'form-control', 'required' => 'true')));?>
        </div>
        <?php echo $this->Form->Submit('Save', array('attributes' => array('class' => 'btn btn-medium btn-default')));?>
        <?php echo $this->Form->End();?>
    </div>
</div>