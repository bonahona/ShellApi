<h1>Create Project</h1>

<div class="row">
    <div class="col-lg-4">
        <?php echo $this->Form->Start('Project');?>
        <?php echo $this->Form->Hidden('Id');?>
        <div class="form-group">
            <label>Project Name</label>
            <?php echo $this->Form->Input('ProjectName', array('attributes' => array('class' => 'form-control', 'required' => 'true')));?>
        </div>
        <div class="form-group">
            <label>Project Title</label>
            <?php echo $this->Form->Input('TitleName', array('attributes' => array('class' => 'form-control', 'required' => 'true')));?>
        </div>
        <div class="form-group">
            <label>Short description</label>
            <?php echo $this->Form->Input('ShortDescription', array('attributes' => array('class' => 'form-control', 'required' => 'true')));?>
        </div>
        <div class="form-group">
            <label>Project Category</label>
            <?php echo $this->Form->Select('ProjectCategoryId', $ProjectCategories, array('key' => 'Id', 'value' => 'Name', 'attributes' => array('class' => 'form-control', 'required' => 'true')));?>
        </div>
        <div class="form-group">
            <label>Project Language</label>
            <?php echo $this->Form->Select('ProjectLanguageId', $ProjectLanguages, array('key' => 'Id', 'value' => 'DisplayName', 'attributes' => array('class' => 'form-control', 'required' => 'true')));?>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <?php echo $this->Form->Bool('IsActive');?>
                    Is Active
                </label>
            </div>
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