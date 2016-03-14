<div id="container">
    <div class=""><?php $d = array(
        'name'        => 'refresh',
        'id'        => 'refresh',
        'class'       => 'btn btn-default',
        'content' => 'refresh'
    );

    echo form_button($d);?></div>
    <img src="<?php echo base_url("assets/images/loading8.gif"); ?>" id="loading-indicator" name="loading-indicator" style="display:none" />
    <div id="tablediv" name="tablediv">
        <table class="table table-bordered table-hover" id="testtable" name="testtable">
            <?php foreach ($data as $item):?>
                <tr>
                <?php foreach ($item as $item2):?>
                    <?php foreach ($item2 as $item3):?>
                        <td><?php echo $item3; ?></td>
                    <?php endforeach;?>
                <?php endforeach;?>
                </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="<?php echo $max ?>">Итого строк: <?php echo $count_rows ?></td>
                <td ><?php echo $count_all ?></td>
            </tr>
        </table>

    </div>
    <?php $d = array(
        'name'        => 'refresh2',
        'id'        => 'refresh2',
        'class'       => 'btn btn-default',
        'content' => 'refresh'
    );
    echo form_button($d);?>
    <p class="footer"> <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

