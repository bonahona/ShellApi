<?php if($this->IsLoggedIn()):?>
    <h3>Examples</h3>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-lg-2">Id</th>
                        <th class="col-lg-4">Language</th>
                        <th class="col-lg-2">SortOrder</th>
                        <th class="col-lg-2">IsActive</th>
                        <th class="col-lg-2">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($Examples as $example):?>
                        <tr>
                            <td><?php echo $example->Id;?></td>
                            <td><?php echo $example->ProjectLanguage->DisplayName;?></td>
                            <td><?php echo $example->SortOrder;?></td>
                            <td><?php echo $example->IsActive;?></td>
                            <td>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Examples/Content/$example->Id";?>"><span class="glyphicon glyphicon-align-left"</a>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Examples/Edit/$example->Id";?>"><span class="glyphicon glyphicon-pencil"</a>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Examples/DeleteConfirm/$example->Id";?>"><span class="glyphicon glyphicon-trash"</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
                </table>
            </div>
        </div>
    </div>

<?php else:?>
    <?php if(count($Examples) > 0):?>
        <h3>Examples</h3>

        <?php foreach($Examples as $example):?>
        <div class="row margin-top">
            <div class="col-lg-12">
                <?php echo $example->ExampleText;?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <pre class="<?php echo $example->ProjectLanguage->ClassName;?>">
<?php echo $this->Html->SafeHtml($example->ExampleContent);?>
            </div>
        </div>
        <?php endforeach;?>
    <?php endif;?>
<?php endif;?>

<?php if($this->IsLoggedIn()):?>
    <div class="row">
        <div class="col-lg-12">
            <?php if(isset($Project)):?>
                <a class="btn btn-md btn-default" href="/Examples/Create/Project/<?php echo $Project->Id;?>">Create example</a>
            <?php elseif(isset($ProjectClass)):?>
                <a class="btn btn-md btn-default" href="/Examples/Create/ProjectClass/<?php echo $ProjectClass->Id;?>">Create example</a>
            <?php elseif(isset($Method)):?>
                <a class="btn btn-md btn-default" href="/Examples/Create/Method/<?php echo $Method->Id;?>">Create example</a>
            <?php elseif(isset($Property)):?>
                <a class="btn btn-md btn-default" href="/Examples/Create/Property/<?php echo $Property->Id;?>">Create example</a>
            <?php endif;?>
        </div>
    </div>
<?php endif;?>