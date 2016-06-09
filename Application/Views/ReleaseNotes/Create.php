<h1>Create release notes</h1>

<h2><?php echo $ReleaseNotes->Project->ProjectName;?></h2>

<div class="row">
    <div class="col-lg-8">
        <?php echo $this->Form->Start('ReleaseNotes');?>
        <?php echo $this->Form->Hidden('ProjectId');?>
            <div class="form-group">
                <label>VersionNumber</label>
                <?php echo $this->Form->Input('VersionNumber', array('attributes' => array('class' => 'form-control')));?>
            </div>
            <div class="form-group">
                <label>ReleaseDate</label>
                <?php echo $this->Form->Input('ReleaseDate', array('attributes' => array('class' => 'form-control')));?>
            </div>
            <div class="form-group">
                <label>Content</label>
                <?php echo $this->Form->Area('Content', array('attributes' => array('class' => 'form-control', 'rows' => '10')));?>
            </div>
            <?php echo $this->Form->Submit('Create', array('attributes' => array('class' => 'btn btn-md btn-default')));?>
        <?php echo $this->Form->End();?>
    </div>
</div>