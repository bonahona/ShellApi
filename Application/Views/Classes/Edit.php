<h1>Edit Class</h1>

<div class="row">
    <div class="col-lg-4">
        <?php echo $this->Form->Start('ProjectClass');?>
        <?php echo $this->Form->Hidden('Id');?>
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
            <label>Base class</label>
            <?php echo $this->Form->Select('BaseClassId', $Classes, array('key' => 'Id', 'value' => 'ClassName', 'attributes' => array('class' => 'form-control')));?>
        </div>
        <div class="form-group">
            <label>Project</label>
            <?php echo $this->Form->Select('ProjectId', $Projects, array('key' => 'Id', 'value' => 'ProjectName', 'attributes' => array('class' => 'form-control')));?>
        </div>
        <?php echo $this->Form->Submit('Save', array('attributes' => array('class' => 'btn btn-md btn-default')));?>
        <?php echo $this->Form->End();?>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <a href="<?php echo '/Projects/Details/' . $ProjectClass->Project->ProjectName;?>">Back</a>
    </div>
</div>