<h1>Search results</h1>

<?php if(count($Results) > 0):?>
<div class="row">
    <div class="col-lg-12">
        Found: <?php echo count($Results);?>
    </div>
</div>

<?php foreach($Results as $result):?>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <a href="<?php echo $result['Link'];?>">
                        <?php echo $result['Header'];?>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?php echo $result['Link'];?>
            </div>
        </div>
    </div>
<?php endforeach;?>
<?php else:?>
    <div class="row">
        <div class="col-lg-12">
    </div>
        <h3>Sorry but no results were found for: <?php echo $SearchQuery;?></h3>
    </div>
<?php endif;?>
