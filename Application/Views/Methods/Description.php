<h1>Edit method Description</h1>

<div class="row">
    <div class="col-lg-4">
        <?php echo $this->Form->Start('Method');?>
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
        <a href="#">Back</a>
    </div>
</div>