<h1>Create Project Category</h1>

<div class="row">
    <div class="col-lg-4">
        <?php echo $this->Form->Start('ProjectCategory');?>
        <div class="form-group">
            <label>Display Name</label>
            <?php echo $this->Form->Input('Name', array('attributes' => array('class' => 'form-control', 'required' => 'true')));?>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <?php echo $this->Form->Bool('IsActive');?>
                    Is Active
                </label>
            </div>
        </div>
        <?php echo $this->Form->Submit('Create', array('attributes' => array('class' => 'btn btn-medium btn-default')));?>
        <?php echo $this->Form->End();?>
    </div>
</div>