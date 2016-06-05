<h1>Edit static block</h1>

<h2>Identifier: <?php echo $StaticBlock->Identifier;?></h2>

<div class="row">
    <div class="col-lg-8">
        <?php echo $this->Form->Start('StaticBlock');?>
        <?php echo $this->Form->Hidden('Id');?>
        <?php echo $this->Form->Hidden('Identifier');?>
        <div class="form-group">
            <label>Content</label>
            <?php echo $this->Form->Area('Content', array('attributes' => array('class' => 'form-control', 'required' => 'true', 'rows' => '30')));?>
        </div>
        <?php echo $this->Form->Submit('Save', array('attributes' => array('class' => 'btn btn-medium btn-default')));?>
        <?php echo $this->Form->End();?>
    </div>
</div>