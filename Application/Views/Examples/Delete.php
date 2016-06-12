<h1>Delete Example</h1>

<h2>Are you sure you want to delete <?php echo $Example->Id;?></h2>

<?php echo $this->Form->Start('Example');?>
    <?php echo $this->Form->Hidden('Id');?>
    <div class="row">
        <div class="col-lg-2">
            <a href="<?php echo $ReturnLink;?>" class="btn btn-md btn-default">Cancel</a>
        </div>
        <div class="col-lg-2">
            <?php echo $this->Form->Submit('Delete', array('attributes' => array('class' => 'btn btn-md btn-danger')));?>
        </div>
    </div>
<?php echo $this->Form->End();?>
