<ul class="breadcrumb">
    <?php
    $lastIndex = count($BreadCrumbs);
    $currentIndex = 1;
    ?>
    <?php foreach($BreadCrumbs as $breadCrumbs):?>
        <?php if($currentIndex == $lastIndex):?>
            <li class="active"><?php echo $breadCrumbs['Text'];?></li>
        <?php else:?>
            <li>
                <?php echo $this->Html->Link($breadCrumbs['Link'], $breadCrumbs['Text']);?>
                <span class="divider"></span>
            </li>
        <?php endif;?>
        <?php $currentIndex ++;?>
    <?php endforeach;?>
</ul>