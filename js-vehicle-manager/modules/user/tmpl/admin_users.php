<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<script type="text/javascript">
    function confirmdelete() {
        if (confirm("<?php echo __('Are you sure to remove','js-vehicle-manager') . ' ?'; ?>") == true) {
            return false;
        } else {
            event.preventDefualt();
            return false;
        }
        return false;
    }

    function resetFrom() {
        jQuery("input#searchname").val('');
        jQuery("input#email").val('');
        jQuery("select#status").val('');
        jQuery("form#jsvehiclemanagerform").submit();
    }
</script>
<?php wp_enqueue_script('jsauto-res-tables', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/responsivetable.js'); ?>

<?php
$categoryarray = array(
    (object) array('id' => 1, 'text' => __('Name', 'js-vehicle-manager')),
    (object) array('id' => 2, 'text' => __('Created', 'js-vehicle-manager')),
);
?>

<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <?php
        $msgkey = JSVEHICLEMANAGERincluder::getJSModel('user')->getMessagekey();
        JSVEHICLEMANAGERMessages::getLayoutMessage($msgkey);
        $model_city = JSVEHICLEMANAGERincluder::getJSModel('city');
        ?>
        <span class="jsvm_js-admin-title">
            <a class="jsvm_js-admin-title-left" href="<?php  echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" />
            <?php echo __('Users', 'js-vehicle-manager') ?>
            </a>
            <?php  ?>
                <a class="jsvm_js-button-link button" href="<?php  echo esc_url(admin_url('admin.php?page=jsvm_user&jsvmlt=formprofile')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/add_icon.png" /><?php echo __('Add','js-vehicle-manager') .' '. __('New Profile', 'js-vehicle-manager') ?></a>
            <?php  ?>
        </span>
        <?php
        $message = __('Are you sure to delete','js-vehicle-manager') . ' ?';
        $desc = __('Delete user','js-vehicle-manager').'\'s '.__('data only from our system','js-vehicle-manager');
        $desc2 = __('Delete user and their data also from wp','js-vehicle-manager');
        ?>
        <div class="jsvm_page-actions js-row jsvm_no-margin">
            <label class="jsvm_js-bulk-link button" for="jsvm_selectall"><input type="checkbox" name="selectall" id="jsvm_selectall" value=""><?php echo __('Select All', 'js-vehicle-manager') ?></label>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERMessages::getMSelectionEMessage()); ?>" data-for="publish" data-for-wpnonce="<?php echo esc_attr(wp_create_nonce("publish-user")); ?>" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/publish-icon.png" /><?php echo __('Active', 'js-vehicle-manager') ?></a>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERMessages::getMSelectionEMessage()); ?>" data-for="unpublish" data-for-wpnonce="<?php echo esc_attr(wp_create_nonce("unpublish-user")); ?>" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/unbuplish.png" /><?php echo __('Disable', 'js-vehicle-manager') ?></a>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" title="<?php echo esc_attr($desc); ?>" message="<?php echo esc_attr(JSVEHICLEMANAGERMessages::getMSelectionEMessage()); ?>" confirmmessage="<?php echo esc_attr($message); ?>" data-for="remove" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/delete-icon.png" /><?php echo __('Delete Data', 'js-vehicle-manager') ?></a>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" title="<?php echo esc_attr($desc2); ?>" message="<?php echo esc_attr(JSVEHICLEMANAGERMessages::getMSelectionEMessage()); ?>" confirmmessage="<?php echo esc_attr($message); ?>" data-for="enforceremove" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/fe-forced-delete.png" /><?php echo __('Delete WP User', 'js-vehicle-manager') ?></a>
            <?php
            $image1 = JSVEHICLEMANAGER_PLUGIN_URL . "includes/images/up.png";
            $image2 = JSVEHICLEMANAGER_PLUGIN_URL . "includes/images/down.png";
            if (jsvehiclemanager::$_data['sortby'] == 1) {
                $image = $image1;
            } else {
                $image = $image2;
            }
            ?>
            <span class="jsvm_sort">
                <span class="jsvm_sort-text"><?php echo __('Sort by', 'js-vehicle-manager'); ?>:</span>
                <span class="jsvm_sort-field"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('jsvm_sorting', $categoryarray, jsvehiclemanager::$_data['combosort'], '', array('class' => 'jsvm_inputbox', 'onchange' => 'changeCombo();')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></span>
                <a class="jsvm_sort-icon" href="#" data-image1="<?php echo esc_attr($image1); ?>" data-image2="<?php echo esc_attr($image2); ?>" data-sortby="<?php echo esc_attr(jsvehiclemanager::$_data['sortby']); ?>"><img id="jsvm_sortingimage" src="<?php echo esc_url($image); ?>" /></a>
            </span>
            <script type="text/javascript">
                function changeSortBy() {
                    var value = jQuery('a.jsvm_sort-icon').attr('data-sortby');
                    var img = '';
                    if (value == 1) {
                        value = 2;
                        img = jQuery('a.jsvm_sort-icon').attr('data-image2');
                    } else {
                        img = jQuery('a.jsvm_sort-icon').attr('data-image1');
                        value = 1;
                    }
                    jQuery("img#jsvm_sortingimage").attr('src', img);
                    jQuery('input#sortby').val(value);
                    jQuery('form#jsvehiclemanagerform').submit();
                }
                jQuery('a.jsvm_sort-icon').click(function (e) {
                    e.preventDefault();
                    changeSortBy();
                });
                function changeCombo() {
                    jQuery("input#sorton").val(jQuery('select#jsvm_sorting').val());
                    changeSortBy();
                }
            </script>
        </div>
        <form class="jsvm_js-filter-form" name="jsvehiclemanagerform" id="jsvehiclemanagerform" method="post" action="<?php  echo esc_url(admin_url("admin.php?page=jsvm_user&jsvmlt=users"))?>">
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('searchname', jsvehiclemanager::$_data['filter']['searchname'], array('class' => 'inputbox', 'placeholder' => __('Name', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('email', jsvehiclemanager::$_data['filter']['email'], array('class' => 'inputbox', 'placeholder' => __('Email', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('status', JSVEHICLEMANAGERincluder::getJSModel('common')->getstatus(), is_numeric(jsvehiclemanager::$_data['filter']['status']) ? jsvehiclemanager::$_data['filter']['status'] : '', __('Select status', 'js-vehicle-manager'), array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('JSVEHICLEMANAGER_form_search', 'JSVEHICLEMANAGER_SEARCH'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('btnsubmit', __('Search', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::button('reset', __('Reset', 'js-vehicle-manager'), array('class' => 'button', 'onclick' => 'resetFrom();')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>

            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('sortby', jsvehiclemanager::$_data['sortby']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('sorton', jsvehiclemanager::$_data['sorton']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
        </form>
        <?php
        if (!empty(jsvehiclemanager::$_data[0])) {
            ?>
            <form id="jsvehiclemanager-list-form" method="post" action="<?php  echo esc_url(admin_url("admin.php?page=jsvm_user")); ?>">
                   <?php
                        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum', 'get', 1);
                        $pageid = ($pagenum > 1) ? '&pagenum=' . $pagenum : '';
                        for ($i = 0, $n = count(jsvehiclemanager::$_data[0]); $i < $n; $i++) {
                            $row = jsvehiclemanager::$_data[0][$i];
                            $link =  esc_url(admin_url('admin.php?page=jsvm_user&jsvmlt=formprofile&jsvehiclemanagerid=' . $row->id));
                            if($row->photo){
                                $logo = $row->photo;
                            }else{
                                $logo = JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/Users.png';
                            }
                            ?>
                            <div id="jsvehiclemanager-seller-listing-wrap">
                                <div id="jsvehiclemanager-seller-listing-limage">
                                   <img src="<?php echo esc_url($logo); ?>" />
                                </div>
                                <div id="jsvehiclemanager-seller-listing-top-wrap">
                                    <div id="jsvehiclemanager-seller-listing-heading-wrap">
                                        <div id="jsvehiclemanager-seller-listing-heading">
                                            <span id="jsvehiclemanager-seller-listing-heading-name">
                                                <input type="checkbox" class="jsvehiclemanager-cb" id="jsvehiclemanager-cb" name="jsvehiclemanager-cb[]" value="<?php echo esc_attr($row->id); ?>" />
                                                <a href="<?php echo esc_url($link); ?>">
                                                <?php echo esc_html(__($row->name,'js-vehicle-manager')); ?>
                                                </a>
                                            </span>
                                            <?php
                                            if($row->status == 1){
                                                $status[0] = 'jsvm_active';
                                                $status[1] = __('Active', 'js-vehicle-manager');
                                            }else{
                                                $status[0] = 'jsvm_disabled';
                                                $status[1] = __('Disable', 'js-vehicle-manager');
                                            } ?>
                                            <span class="jsvehiclemanager-seller-listing-right">
                                                <span class="jsvehiclemanager-seller-listing-heading-status <?php echo esc_attr($status[0]); ?>"><?php echo esc_html($status[1]); ?></span>
                                                <span class="jsvehiclemanager-seller-listing-smedia-wrap">
                                                    <?php  if($row->facebook !=''){
                                                            if(!strstr($row->facebook, 'http')){
                                                                $row->facebook = 'http://'.$row->facebook;
                                                            }
                                                    ?>
                                                        <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->facebook); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/facebook.png" title="<?php echo __('Facebook','js-vehicle-manager');?>" /></a>
                                                    <?php   } ?>
                                                    <?php if($row->twitter !=''){
                                                            if(!strstr($row->twitter, 'http')) {
                                                                $row->twitter = 'http://'.$row->twitter;
                                                            }
                                                    ?>
                                                        <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->twitter); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/twitter.png" title="<?php echo __('Twitter','js-vehicle-manager');?>" /></a>
                                                    <?php } ?>
                                                    <?php if($row->linkedin !='') {
                                                            if(!strstr($row->linkedin, 'http')){
                                                                $row->linkedin = 'http://'.$row->linkedin;
                                                            }
                                                    ?>
                                                        <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->linkedin); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/linkedin.png" title="<?php echo __('Linkedin','js-vehicle-manager');?>" /></a>
                                                    <?php } ?>
                                                    <?php if($row->googleplus !=''){
                                                            if(!strstr($row->googleplus, 'http')){
                                                                $row->googleplus = 'http://'.$row->googleplus;
                                                            }
                                                    ?>
                                                        <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->googleplus); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/google-plus.png" title="<?php echo __('Google Plus','js-vehicle-manager');?>" /></a>
                                                    <?php } ?>
                                                    <?php if($row->pinterest !=''){
                                                            if(!strstr($row->pinterest,'http')){
                                                                $row->pinterest = 'http://'.$row->pinterest;
                                                            }
                                                    ?>
                                                        <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->pinterest); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/pinterest.png" title="<?php echo __('Pintrest','js-vehicle-manager');?>" /></a>
                                                    <?php } ?>
                                                    <?php if($row->instagram !=''){
                                                            if(!strstr($row->instagram, 'http')){
                                                                $row->instagram = 'http://'.$row->instagram;
                                                            }
                                                    ?>
                                                        <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->instagram); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/instagram.png" title="<?php echo __('Instagram','js-vehicle-manager');?>" /></a>
                                                    <?php } ?>
                                                    <?php if($row->reddit !=''){
                                                            if(!strstr($row->reddit, 'http')){
                                                                $row->reddit = 'http://'.$row->reddit;
                                                            }
                                                    ?>
                                                        <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->reddit); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/reddit.png" title="<?php echo __('Reddit','js-vehicle-manager');?>" /></a>
                                                    <?php } ?>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="jsvehiclemanager-seller-listing-data-wrap">
                                        <div class="jsvehiclemanager-seller-listing-left">
                                            <span class="jsvehiclemanager-seller-listing-data">
                                                <span class="jsvehiclemanager-seller-listing-data-title"><?php echo __('Email','js-vehicle-manager'); ?>:</span>
                                                <span class="jsvehiclemanager-seller-listing-data-value"><?php echo esc_html($row->email); ?></span>
                                            </span>
                                            <span class="jsvehiclemanager-seller-listing-data">
                                                <span class="jsvehiclemanager-seller-listing-data-title"><?php echo __('Location','js-vehicle-manager'); ?>:</span>
                                                <span class="jsvehiclemanager-seller-listing-data-value"><?php echo esc_html($model_city->getLocationDataForView($row->cityid)); ?></span>
                                            </span>
                                                <?php
                                                $customfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsData(2,0,1);// 10 for main section of vehicle
                                                foreach($customfields AS $field){
                                                    $array = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->showCustomFields($field, 2,$row->params); ?>
                                                    <span class="jsvehiclemanager-seller-listing-data">
                                                        <span class="jsvehiclemanager-seller-listing-data-title">
                                                            <?php echo esc_html(__($array[0],'js-vehicle-manager'))." : "; ?>
                                                        </span>
                                                        <span class="jsvehiclemanager-seller-listing-data-value">
                                                            <?php echo esc_html($array[1]);?>
                                                        </span>
                                                    </span>
                                                <?php
                                                    }
                                                ?>
                                        </div>
                                        <div class="jsvehiclemanager-seller-listing-right">
                                            <?php if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isSellerCheck($row->id)){ ?>
                                                <a href="<?php  echo esc_url(admin_url("admin.php?page=jsvm_vehicle&jsvmlt=vehicles&uid=".$row->id)); ?>" class="jsvehiclemanager-seller-listing-viewBtn"><?php echo __('Vehicles' , 'js-vehicle-manager'); ?></a>
                                            <?php } ?>
                                            <a href="<?php  echo esc_url(admin_url("admin.php?page=jsvm_user&jsvmlt=profile&jsvehiclemanagerid=".$row->id)); ?>" class="jsvehiclemanager-seller-listing-viewBtn"><?php echo __('View Profile', 'js-vehicle-manager'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('pagenum', ($pagenum > 1) ? $pagenum : ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('task', ''), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('delete-user')), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('uid', isset($row->uid) ? $row->uid :''  ), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('id', isset($row->id) ? $row->id :''  ), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </form>
            <?php
            if (jsvehiclemanager::$_data[1]) {
                echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post(jsvehiclemanager::$_data[1]) . '</div></div>';
            }
        } else {
            $msg = __('No record found','js-vehicle-manager');
            $link[] = array(
                        'link' => 'admin.php?page=jsvm_user&jsvmlt=formprofile',
                        'text' => __('Add New','js-vehicle-manager') .' '. __('Profile','js-vehicle-manager')
                    );
           echo wp_kses(JSVEHICLEMANAGERlayout::getNoRecordFound(), JSVEHICLEMANAGER_ALLOWED_TAGS);
        }
        ?>
    </div>
</div>
