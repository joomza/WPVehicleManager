<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
$data = jsvehiclemanager::$_data[0];
?>
<table id="js-table">
    <thead>
        <tr>
            <th width="50%"></th>
            <th class="centered"><?php echo __('Total', 'js-vehicle-manager'); ?></th>
            <th><?php echo __('Active', 'js-vehicle-manager'); ?></th>
        </tr>
    </thead>
</table>