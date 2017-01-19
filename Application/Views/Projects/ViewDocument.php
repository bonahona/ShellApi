<h1><?php echo $Document->PageTitle;?></h1>

<?php if(count($Document->Documents) > 0):?>
    <ul class="list-group">
        <?php foreach($Document->Documents as $document):?>
            <li class="list-group-item">
                <?php if(isset($Property)):?>
                    <?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Classes/$ProjectClass->ClassName/Properties/$Property->PropertyName/Documents/$document->NavigationTitle", $document->PageTitle);?>
                <?php elseif(isset($Method)):?>
                    <?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Classes/$ProjectClass->ClassName/Methods/$Method->MethodName/Documents/$document->NavigationTitle", $document->PageTitle);?>
                <?php elseif(isset($ProjectClass)):?>
                    <?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Classes/$ProjectClass->ClassName/Documents/$document->NavigationTitle", $document->PageTitle);?>
                <?php else:?>
                    <?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Documents/$document->NavigationTitle", $document->PageTitle);?>
                <?php endif;?>
            </li>
        <?php endforeach;?>
    </ul>
    <hr/>
<?php endif;?>

<div class="row">
    <div class="col-lg-8">
        <?php echo $Document->Content;?>
    </div>
</div>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-8">
            <a href="/Documents/Content/<?php echo $Document->Id;?>" class="btn btn-md btn-default">Edit</a>
        </div>
    </div>
<?php endif;?>