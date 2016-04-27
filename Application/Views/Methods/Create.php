<h1>Create method</h1>

<div class="row">
    <div class="col-lg-4">
        <?php echo $this->Form->Start('Method');?>
        <div class="form-group">
            <label>Method Name</label>
            <?php echo $this->Form->Input('MethodName', array('attributes' => array('class' => 'form-control')));?>
        </div>
        <div class="form-group">
            <label>Short Description</label>
            <?php echo $this->Form->Input('ShortDescription', array('attributes' => array('class' => 'form-control')));?>
        </div>

        <div class="form-group">
            <label>Access ModifierId</label>
            <?php echo $this->Form->Select('AccessModifierId', $AccessModifiers, array('attributes' => array('class' => 'form-control')));?>
        </div>

        <div class="form-group">
            <label>Return type</label>
            <?php echo $this->Form->Select('ReturnTypeId', $ProjectClasses, array('key' => 'Id', 'value' => 'ClassName', 'attributes' => array('class' => 'form-control')));?>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <?php echo $this->Form->Bool('IsStatic');?>
                    Is Static
                </label>
            </div>
        </div>
        <div class="form-group">
            <label>Class</label>
            <?php echo $this->Form->Select('ProjectClassId', $ProjectClasses, array('key' => 'Id', 'value' => 'ClassName', 'attributes' => array('class' => 'form-control')));?>
        </div>

        <?php echo $this->Form->Submit('Create', array('attributes' => array('class' => 'btn btn-md btn-default')));?>
        <?php echo $this->Form->End();?>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <a href="#">Back</a>
    </div>
</div>