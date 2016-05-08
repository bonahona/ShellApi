<?php foreach($Sidebar as $sidebarPanel):?>
    <div class="panel panel-default">
        <?php if(isset($sidebarPanel['Title'])):?>
            <div class="panel-heading"><?php echo $sidebarPanel['Title'];?></div>
        <?php endif;?>
        <ul class="list-group">
            <?php foreach($sidebarPanel['Items'] as $sidebarItem):?>
                <?php if(isset($sidebarItem['SubsectionName'])):?>
                    <li class="list-group-item">
                        <?php echo $sidebarItem['SubsectionName'];?>
                    </li>
                    <?php foreach($sidebarItem['Items'] as $subsectionItem):?>
                        <li class="list-group-item indent-left-1">
                            <?php echo $this->Html->Link($subsectionItem['Link'], $subsectionItem['DisplayName']);?>
                        </li>
                    <?php endforeach;?>
                <?php else:?>
                <li class="list-group-item">
                    <?php echo $this->Html->Link($sidebarItem['Link'], $sidebarItem['DisplayName']);?>
                </li>
                <?php endif;?>
            <?php endforeach;?>
        </ul>
    </div>
<?php endforeach;?>