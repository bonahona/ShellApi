<h1>Create Class</h1>

<div class="row">
    <div class="col-lg-4">
        <?php echo $this->Form->Start('ProjectClass');?>
        <div class="form-group">
            <label>Class Name</label>
            <?php echo $this->Form->Input('ClassName', array('attributes' => array('class' => 'form-control')));?>
        </div>
        <div class="form-group">
            <label>Short Description</label>
            <?php echo $this->Form->Input('ShortDescription', array('attributes' => array('class' => 'form-control')));?>
        </div>
        <div class="form-group">
            <label>Namespace</label>
            <?php echo $this->Form->Input('Namespace', array('attributes' => array('class' => 'form-control')));?>
        </div>
        <div class="form-group">
            <label>ExternalSource</label>
            <?php echo $this->Form->Input('ExternalSource', array('attributes' => array('class' => 'form-control')));?>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <?php echo $this->Form->Bool('IsPrimitive');?>
                    Is Primitive
                </label>
            </div>
        </div>
        <div class="form-group">
            <label>Base class</label>
            <?php echo $this->Form->Select('BaseClassId', $Classes, array('key' => 'Id', 'value' => 'ClassName', 'nullfield' => true, 'attributes' => array('class' => 'form-control')));?>
        </div>
        <div class="form-group">
            <label>Project</label>
            <?php echo $this->Form->Select('ProjectId', $Projects, array('key' => 'Id', 'value' => 'ProjectName', 'attributes' => array('class' => 'form-control')));?>
        </div>
        <?php echo $this->Form->Submit('Create', array('attributes' => array('class' => 'btn btn-md btn-default')));?>
        <?php echo $this->Form->End();?>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <a href="<?php echo '/Projects/Details/' . $Project->ProjectName;?>">Back</a>
    </div>
</div>