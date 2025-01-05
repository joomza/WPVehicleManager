<?php
if (!defined('ABSPATH')) die('Restricted Access');?>
<div id="jsvehiclemanager-main-up-wrapper">
<?php
JSVEHICLEMANAGERbreadcrumbs::getBreadcrumbs();
include_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/header.php');

$number_of_makes= JSVEHICLEMANAGERincluder::getJSModel('make')->getNumberOfMakes();
$final_number= 0;
foreach (jsvehiclemanager::$_data[0] as $key) {
    $final_number++;
}
$show_number_of_vehicle =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('vehiclebymake_show_number_of_vehicles');
$count = count(jsvehiclemanager::$_data[0]);
$count = $count + $number_of_makes;
$column = ceil($count / 3);
$div1content = '';
$div2content = '';
$div3content = '';
$count = 0;
$make = '';
?>
<div id="jsvehiclemanager-wrapper">
        <div class="control-pannel-header">
            <span class="heading"><?php echo __('Vehicles by Make', 'js-vehicle-manager'); ?></span>
        </div>
        <div>
        <?php
            foreach (jsvehiclemanager::$_data[0] as $mkmd) {
                $link_make = jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles', 'makeid'=>$mkmd->makeid));
                $link = jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles', 'modelid'=>$mkmd->modelid));
                if($count < $column){
                    if($make == $mkmd->maketitle){
                        $div1content .= '<div class="jsvehiclemanager-values"><a title="'.__($mkmd->modeltitle,'js-vehicle-manager').'" href="'.esc_url($link).'">
                                            <div class="jsvehiclemanager-make-name" >'.__($mkmd->modeltitle,'js-vehicle-manager').'</div> ';
                                                if( $show_number_of_vehicle == 1){
                                                    $div1content .=  '<div class="jsvehiclemanager-make-number">('.$mkmd->totalvehiclemodel .')</div>';
                                                }
                        $div1content         .=   '</a></div>';
                    }else{
                        $make = $mkmd->maketitle;
                        $imgpath = JSVEHICLEMANAGERincluder::getJSModel('make')->getMakeImage($mkmd->logo);
                        $div1content .= '<a title="'.__($make,'js-vehicle-manager').'" href="'.esc_url($link_make).'"><div class="jsvehiclemanager-title"><h3><img alt="'.__($make,'js-vehicle-manager').'" title="'.__($make,'js-vehicle-manager').'" src="'.esc_attr($imgpath).'" /> '. __($mkmd->maketitle,'js-vehicle-manager') .'</h3></a></div>';
                        $div1content .= '<div class="jsvehiclemanager-values"><a title="'.__($mkmd->modeltitle,'js-vehicle-manager').'" href="'.esc_url($link).'">
                                            <div class="jsvehiclemanager-make-name" >'.__($mkmd->modeltitle,'js-vehicle-manager').'</div> ';
                                                if( $show_number_of_vehicle == 1){
                                                    $div1content .=  '<div class="jsvehiclemanager-make-number">('.$mkmd->totalvehiclemodel .')</div>';
                                                }
                        $div1content         .=   '</a></div>';
                        $count = $count + 1;
                    }
                }elseif($count < $column * 2){
                    if($make == $mkmd->maketitle){
                        $div2content .= '<div class="jsvehiclemanager-values"><a title="'.__($mkmd->modeltitle,'js-vehicle-manager').'" href="'.esc_url($link).'">
                                            <div class="jsvehiclemanager-make-name" >'.__($mkmd->modeltitle,'js-vehicle-manager').'</div> ';
                                                if( $show_number_of_vehicle == 1){
                                                    $div2content .=  '<div class="jsvehiclemanager-make-number">('.$mkmd->totalvehiclemodel .')</div>';
                                                }
                        $div2content         .=   '</a></div>';
                    }else{
                        $make = $mkmd->maketitle;
                        $imgpath = JSVEHICLEMANAGERincluder::getJSModel('make')->getMakeImage($mkmd->logo);
                        $div2content .= '<a title="'.__($make,'js-vehicle-manager').'" href="'.esc_url($link_make).'"><div class="jsvehiclemanager-title"><h3><img alt="'.__($make,'js-vehicle-manager').'" title="'.__($make,'js-vehicle-manager').'" src="'.esc_attr($imgpath).'" /> '. __($mkmd->maketitle,'js-vehicle-manager') .'</h3></a></div>';
                        $div2content .= '<div class="jsvehiclemanager-values"><a title="'.__($mkmd->modeltitle,'js-vehicle-manager').'" href="'.esc_url($link).'">
                                            <div class="jsvehiclemanager-make-name" >'.__($mkmd->modeltitle,'js-vehicle-manager').'</div> ';
                                                if( $show_number_of_vehicle == 1){
                                                    $div2content .=  '<div class="jsvehiclemanager-make-number">('.$mkmd->totalvehiclemodel .')</div>';
                                                }
                        $div2content         .=   '</a></div>';
                        $count = $count + 1;
                    }
                }else{
                    if($make == $mkmd->maketitle){
                        $div3content .= '<div class="jsvehiclemanager-values"><a title="'.__($mkmd->modeltitle,'js-vehicle-manager').'" href="'.esc_url($link).'">
                                            <div class="jsvehiclemanager-make-name" >'.__($mkmd->modeltitle,'js-vehicle-manager').'</div>';
                                                if( $show_number_of_vehicle == 1){
                                                    $div3content .=  '<div class="jsvehiclemanager-make-number">('.$mkmd->totalvehiclemodel .')</div>';
                                                }
                        $div3content         .=   '</a></div>';
                    }else{
                        $make = $mkmd->maketitle;
                        $imgpath = JSVEHICLEMANAGERincluder::getJSModel('make')->getMakeImage($mkmd->logo);
                        $div3content .= '<a title="'.__($make,'js-vehicle-manager').'" href="'.esc_url($link_make).'"><div class="jsvehiclemanager-title"><h3><img alt="'.__($make,'js-vehicle-manager').'" title="'.__($make,'js-vehicle-manager').'" src="'.esc_attr($imgpath).'" /> '. __($mkmd->maketitle,'js-vehicle-manager') .'</h3></a></div>';
                        $div3content .= '<div class="jsvehiclemanager-values"><a title="'.__($mkmd->modeltitle,'js-vehicle-manager').'" href="'.esc_url($link).'">
                                            <div class="jsvehiclemanager-make-name" >'.__($mkmd->modeltitle,'js-vehicle-manager').'</div> ';
                                                if( $show_number_of_vehicle == 1){
                                                    $div3content .=  '<div class="jsvehiclemanager-make-number">('.$mkmd->totalvehiclemodel .')</div>';
                                                }
                        $div3content         .=   '</a></div>';
                        $count = $count + 1;
                    }
                }
                $count++;
            }
            echo '<div class="jsvehiclemanager-vehicle-by-make">';
                echo'<div class="jsvehiclemanager-vehicle-by-make-wrapper">' . wp_kses($div1content, JSVEHICLEMANAGER_ALLOWED_TAGS) . '</div>';
                echo '<div class="jsvehiclemanager-vehicle-by-make-wrapper">' . wp_kses($div2content, JSVEHICLEMANAGER_ALLOWED_TAGS). '</div>';
                echo '<div class="jsvehiclemanager-vehicle-by-make-wrapper">' . wp_kses($div3content, JSVEHICLEMANAGER_ALLOWED_TAGS) . '</div>';
            echo '</div>'
        ?>
        </div>
</div>
</div>