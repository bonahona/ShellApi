<?php if($this->IsLoggedIn()):?>
    <h3>Documents</h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="col-lg-2">Id</th>
                        <th class="col-lg-3">Page title</th>
                        <th class="col-lg-3">Navigation title</th>
                        <th class="col-lg-2">Parent Page</th>
                        <th class="col-lg-2">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!isset($AllDocuments)){$AllDocuments = $Documents;}?>
                    <?php foreach($AllDocuments as $document):?>
                        <tr>
                            <td><?php echo $document->Id;?></td>
                            <td>
                                <?php if(isset($Property)):?>
                                    <?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Classes/$ProjectClass->ClassName/Properties/$Property->PropertyName/Documents/$document->NavigationTitle", $document->PageTitle);?>
                                <?php elseif(isset($Method)):?>
                                    <?php echo $this->Html->Link('/Projects/Details/' . $Project->ProjectName .'/Classes/' . $ProjectClass->ClassName . '/Methods/' . $Method->MethodName . $Method->CreateLink() . '/Documents/' . $document->NavigationTitle, $document->PageTitle);?>
                                <?php elseif(isset($ProjectClass)):?>
                                    <?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Classes/$ProjectClass->ClassName/Documents/$document->NavigationTitle", $document->PageTitle);?>
                                <?php else:?>
                                    <?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Documents/$document->NavigationTitle", $document->PageTitle);?>
                                <?php endif;?>
                            </td>
                            <td><?php echo $document->NavigationTitle;?></td>
                            <td>
                                <?php if($document->ParentDocument != null):?>
                                    <?php echo $document->ParentDocument->PageTitle;?>
                                <?php endif;?>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Documents/Content/$document->Id";?>"><span class="glyphicon glyphicon-align-left"</a>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Documents/Edit/$document->Id";?>"><span class="glyphicon glyphicon-pencil"</a>
                                <a class="btn btn-sm btn-default btn-margin-right" href="<?php echo "/Documents/DeleteConfirm/$document->Id";?>"><span class="glyphicon glyphicon-trash"</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <?php if(isset($Property)):?>
                <a class="btn btn-md btn-default" href="<?php echo "/Documents/Create/Property/$Project->Id";?>">Create document</a>
            <?php elseif(isset($Method)):?>
                <a class="btn btn-md btn-default" href="<?php echo "/Documents/Create/Method/$Project->Id";?>">Create document</a>
            <?php elseif(isset($ProjectClass)):?>
                <a class="btn btn-md btn-default" href="<?php echo "/Documents/Create/Class/$Project->Id";?>">Create document</a>
            <?php else:?>
                <a class="btn btn-md btn-default" href="<?php echo "/Documents/Create/Project/$Project->Id";?>">Create document</a>
            <?php endif;?>
        </div>
    </div>

<?php else:?>
    <?php if(count($Documents) > 0):?>
        <h3>Documents</h3>
        <ul class="list-group">
            <?php foreach($Documents as $document):?>
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
                    <?php if(count($document->Documents) > 0):?>
                        <ul class="list-group inner">
                            <?php foreach($document->Documents as $childDocument):?>
                                <li class="list-group-item">
                                    <?php if(isset($Property)):?>
                                        <?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Classes/$ProjectClass->ClassName/Properties/$Property->PropertyName/Documents/$childDocument->NavigationTitle", $childDocument->PageTitle);?>
                                    <?php elseif(isset($Method)):?>
                                        <?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Classes/$ProjectClass->ClassName/Methods/$Method->MethodName/Documents/$childDocument->NavigationTitle", $childDocument->PageTitle);?>
                                    <?php elseif(isset($ProjectClass)):?>
                                        <?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Classes/$ProjectClass->ClassName/Documents/$childDocument->NavigationTitle", $childDocument->PageTitle);?>
                                    <?php else:?>
                                        <?php echo $this->Html->Link("/Projects/Details/$Project->ProjectName/Documents/$childDocument->NavigationTitle", $childDocument->PageTitle);?>
                                    <?php endif;?>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    <?php endif;?>
                </li>
            <?php endforeach;?>
        </ul>
    <?php endif;?>
<?php endif;?>