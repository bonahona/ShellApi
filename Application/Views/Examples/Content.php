<h1>Edit Example Content</h1>

<div class="row">
    <div class="col-lg-4">
        <?php echo $this->Form->Start('Example');?>
        <?php echo $this->Form->Hidden('Id');?>
        <?php echo $this->Form->Hidden('ProjectId');?>
        <?php echo $this->Form->Hidden('ClassId');?>
        <?php echo $this->Form->Hidden('MethodId');?>
        <?php echo $this->Form->Hidden('PropertyId');?>
        <div class="form-group">
            <label>Description</label>
            <?php echo $this->Form->Area('ExampleText', array('attributes' => array('class' => 'form-control', 'required' => 'true', 'rows' => '10')));?>
        </div>
        <div class="form-group">
            <label>Content</label>
            <?php echo $this->Form->Area('ExampleContent', array('attributes' => array('class' => 'form-control', 'required' => 'true', 'rows' => '30')));?>
        </div>
        <?php echo $this->Form->Submit('Save', array('attributes' => array('class' => 'btn btn-medium btn-default')));?>
        <?php echo $this->Form->End();?>
    </div>
</div>