<h1>Edit Document Content</h1>

<h3><?php echo $Document->PageTitle;?></h3>
<div class="row">
    <div class="col-lg-4">
        <?php echo $this->Form->Start('Document');?>
        <?php echo $this->Form->Hidden('Id');?>

        <div class="form-group">
            <label>Content</label>
            <?php echo $this->Form->Area('Content', array('attributes' => array('class' => 'form-control summernote', 'rows' => '30')));?>
        </div>

        <?php echo $this->Form->Submit('Save', array('attributes' => array('class' => 'btn btn-medium btn-default')));?>
        <?php echo $this->Form->End();?>
    </div>
</div>