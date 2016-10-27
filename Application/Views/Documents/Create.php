<h1>Create Document</h1>

<div class="row">
    <div class="col-lg-4">
        <?php echo $this->Form->Start('Document');?>
        <?php echo $this->Form->Hidden('ProjectId');?>
        <?php echo $this->Form->Hidden('ClassId');?>
        <?php echo $this->Form->Hidden('MethodId');?>
        <?php echo $this->Form->Hidden('PropertyId');?>
        <div class="form-group">
            <label>Page title</label>
            <?php echo $this->Form->Input('PageTitle', array('attributes' => array('class' => 'form-control', 'required' => 'true')));?>
        </div>
        <div class="form-group">
            <label>Navigation title</label>
            <?php echo $this->Form->Input('NavigationTitle', array('attributes' => array('class' => 'form-control', 'required' => 'true')));?>
        </div>
        <div class="form-group">
            <label>Parent document</label>
            <?php echo $this->Form->Select('ParentDocumentId', $AllDocuments, array('key' => 'Id', 'value' => 'PageTitle', 'nullfield' => true, 'attributes' => array('class' => 'form-control')));?>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <?php echo $this->Form->Bool('ShowInMenu');?>
                    Show in Menu
                </label>
            </div>
        </div>
        <?php echo $this->Form->Submit('Create', array('attributes' => array('class' => 'btn btn-medium btn-default')));?>
        <?php echo $this->Form->End();?>
    </div>
</div>