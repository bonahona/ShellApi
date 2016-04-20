<h1>Delete Project Language</h1>

<div class="row">
    <div class="col-lg-4">
        <h3>Delete Project Language <?php echo $ProjectLanguage->DisplayName;?>?</h3>
        <?php echo $this->Form->Start('ProjectLanguage', array('location' => '/ProjectLanguages/Delete/' . $ProjectLanguage->Id));?>

        <div class="row">
            <div class="col-lg-2">
                <a href="/ProjectLanguages/" class="btn btn-md btn-success">No</a>
            </div>
            <div class="col-lg-2">
                <?php echo $this->Form->Submit('Delete', array('attributes' => array('class' => 'btn btn-md btn-danger')));?>
            </div>
        </div>
        <?php echo $this->Form->End();?>
    </div>
</div>