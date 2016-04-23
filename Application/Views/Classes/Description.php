<h1>Edit Class Description</h1>

<h3><?php echo $ProjectClass->ClassName;?></h3>
<div class="row">
    <div class="col-lg-4">
        <?php echo $this->Form->Start('ProjectClass');?>
        <?php echo $this->Form->Hidden('Id');?>
        <div class="form-group">
            <label>Description</label>
            <?php echo $this->Form->Area('Description', array('attributes' => array('class' => 'form-control', 'rows' => '30')));?>
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