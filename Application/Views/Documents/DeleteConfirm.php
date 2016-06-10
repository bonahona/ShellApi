<h1>Confirm delete document?</h1>
<h2>Are you sure you want to delete <?php echo $Document->PageTitle;?></h2>

<div class="row">
    <div class="col-lg-4">
        <?php echo $this->Form->Start('Delete');?>
            <div class="row">
                <div class="col-lg-6">
                    <a href="/Projects/Details/<?php echo $Project->ProjectName;?>/" class="btn btn-md btn-default">Cancel</a>
                </div>
                <div class="col-lg-4">
                    <?php echo $this->Form->Submit('Delete', array('attributes' => array('class' => 'btn btn-medium btn-danger')));?>
                </div>
            </div>
        <?php echo $this->Form->End();?>
    </div>
</div>