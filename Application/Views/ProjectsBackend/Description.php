<h1>Edit Project Description</h1>

<h2><?php echo $Project->ProjectName;?></h2>
<div class="row">
    <div class="col-lg-4">
        <?php echo $this->Form->Start('Project');?>
        <?php echo $this->Form->Hidden('Id');?>
        <div class="form-group">
            <label>Description</label>
            <?php echo $this->Form->Area('Description', array('attributes' => array('class' => 'form-control summernote', 'rows' => '30')));?>
        </div>
        <?php echo $this->Form->Submit('Save', array('attributes' => array('class' => 'btn btn-medium btn-default')));?>
        <?php echo $this->Form->End();?>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <a href="/ProjectsBackend/">Back</a>
    </div>
</div>