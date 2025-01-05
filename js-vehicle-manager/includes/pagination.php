<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERpagination {

    static $_limit;
    static $_offset;
    static $_currentpage;

    static function getPagination($total) {
        $pagenum = isset($_GET['pagenum']) ? absint($_GET['pagenum']) : 1;
        self::$_limit = jsvehiclemanager::$_config['pagination_default_page_size']; // number of rows in page
        self::$_offset = ( $pagenum - 1 ) * self::$_limit;
        self::$_currentpage = $pagenum;
        $num_of_pages = ceil($total / self::$_limit);
        $result = '';
        if(is_admin()){
            $result = paginate_links(array(
                'base' => add_query_arg('pagenum', '%#%'),
                'format' => '',
                'prev_next' => true,
                'prev_text' => __('Previous', 'js-vehicle-manager'),
                'next_text' => __('Next', 'js-vehicle-manager'),
                'total' => $num_of_pages,
                'current' => $pagenum,
                'add_args' => false,
            ));
        }else{
            if(jsvehiclemanager::$_car_manager_theme == 1){
                $links = paginate_links( array(
                    'type' => 'array',
                    'base' => add_query_arg('pagenum', '%#%'),
                    'format' => '',
                    'prev_next' => true,
                    'prev_text' => '&laquo;',
                    'total' => $num_of_pages,
                    'current' => $pagenum,
                    'next_text' => '&raquo;',
                    'add_args' => false,
                ) );
                if(!empty($links) && is_array($links)){
                    $result = '<ul class="pagination pagination-lg">';
                    foreach($links AS $link){
                        if(strstr($link, 'current')){
                            $result .= '<li class="active">'.$link.'</li>';
                        }else{
                            $result .= '<li>'.$link.'</li>';
                        }
                    }
                    $result .= '</ul>';
                }
            }else{
                $result = paginate_links(array(
                            'base' => add_query_arg('pagenum', '%#%'),
                            'format' => '',
                            'prev_next' => true,
                            'prev_text' => __('Previous', 'js-vehicle-manager'),
                            'next_text' => __('Next', 'js-vehicle-manager'),
                            'total' => $num_of_pages,
                            'current' => $pagenum,
                            'add_args' => false,
                        ));
            }


        }
        return $result;
    }

    static function isLastOrdering($total, $pagenum) {
        $maxrecord = $pagenum * jsvehiclemanager::$_config['pagination_default_page_size'];
        if ($maxrecord >= $total)
            return false;
        else
            return true;
    }

}

?>