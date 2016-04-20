<h1>Delete Project Category</h1>

<div class="row">
    <div class="col-lg-4">
        <h3>Delete Project Language <?php echo $ProjectCategory->Name;?>?</h3>
        <?php echo $this->Form->Start('ProjectCategory', array('location' => '/ProjectCategories/Delete/' . $ProjectCategory->Id));?>

        <div class="row">
            <div class="col-lg-2">
                <a href="/$ProjectCategories//" class="btn btn-md btn-success">No</a>
            </div>
            <div class="col-lg-2">
                <?php echo $this->Form->Submit('Delete', array('attributes' => array('class' => 'btn btn-md btn-danger')));?>
            </div>
        </div>
        <?php echo $this->Form->End();?>
    </div>
</div>