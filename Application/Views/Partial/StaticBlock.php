<div class="row">
    <div class="col-lg-12">
        <?php if(isset($Identifier)):?>
            <?php $staticBlock = $this->Models->StaticBlock->Where(array('Identifier' => $Identifier))->First();?>
            <?php if($staticBlock != null):?>
                <?php echo $staticBlock->Content;?>

                <?php if($this->IsLoggedIn()):?>
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="/StaticBlocks/Edit/<?php echo $staticBlock->Id;?>?ref=<?php echo $this->RequestUri;?>" class="btn btn-md btn-default">Edit</a>
                        </div>
                    </div>
                <?php endif;?>
            <?php endif;?>
        <?php endif;?>
    </div>
</div>