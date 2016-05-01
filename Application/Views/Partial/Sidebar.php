<?php foreach($Sidebar as $sidebarPanel):?>
<div class="panel panel-default">
    <div class="panel-heading"><?php echo $sidebarPanel['Title'];?></div>
    <ul class="list-group">
        <?php foreach($sidebarPanel['Items'] as $sidebarItem):?>
            <li class="list-group-item">
                <?php echo $this->Html->Link($sidebarItem['Link'], $sidebarItem['DisplayName']);?>
            </li>
        <?php endforeach;?>
    </ul>
</div>
<?php endforeach;?>
