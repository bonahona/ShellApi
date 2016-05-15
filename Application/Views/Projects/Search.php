<h1>Search results for: <?php echo $SearchQuery;?></h1>

<?php if(count($Results) > 0):?>
<div class="row">
    <div class="col-lg-12">
        <?php if(count($Results) == 1):?>
            Found <?php echo count($Results);?> result.
        <?php else:?>
            Found <?php echo count($Results);?> results.
        <?php endif;?>
    </div>
</div>

<?php foreach($Results as $result):?>
    <div class="row">
        <div class="col-lg-12">
            <a href="<?php echo $result['Link'];?>">
                <h3 class="no-margin-bottom"><?php echo $result['Header'];?></h3>
            </a>
        </div>
        <div class="col-lg-12">
            <span class="light-grey">
                <?php echo $result['Link'];?>
            </span>
        </div>
        <div class="col-lg-6">
            <?php echo $result['Context'];?>
        </div>
    </div>
<?php endforeach;?>
<?php else:?>
    <div class="row">
        <div class="col-lg-12">
    </div>
        <h3>Sorry but no results were found</h3>
    </div>
<?php endif;?>
