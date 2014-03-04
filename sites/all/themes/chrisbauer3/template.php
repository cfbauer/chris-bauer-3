<?php

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */

/**
 * Override or insert variables into the maintenance page template.
 */
function chrisbauer3_preprocess_maintenance_page(&$vars) {
    // While markup for normal pages is split into page.tpl.php and html.tpl.php,
    // the markup for the maintenance page is all in the single
    // maintenance-page.tpl.php template. So, to have what's done in
    // chrisbauer3_preprocess_html() also happen on the maintenance page, it has to be
    // called here.
    chrisbauer3_preprocess_html($vars);
}

/**
 * Override or insert variables into the html template.
 */
function chrisbauer3_preprocess_html(&$vars) {
    // Classes for body element. Allows advanced theming based on context
    // (home page, node of certain type, etc.)
    if (!$vars['is_front']) {
        // Add unique class for each page.
        $path = drupal_get_path_alias($_GET['q']);
        // Add unique class for each website page
        $pageArr = preg_split('/\//', $path);
        $page = $pageArr[count($pageArr) - 1];
        if(arg(0) == 'node') {
            if(arg(1) == 'add') {
                $page = 'node-add';
            } elseif (is_numeric(arg(1)) && (arg(2) == 'edit' || arg(2) == 'delete')) {
                $page = 'node-' . arg(2);
            }
        }
        $vars['classes_array'][] = drupal_html_class('page-' . $page);
        if(count($pageArr) > 1) {
            foreach($pageArr as $key=>$section) {
                if($key != count($pageArr)-1) {
                    $depth = $depth.'section-';
                    $vars['classes_array'][] = drupal_html_class($depth . $section);
                }
            }
        } else {
            drupal_add_js('fadeInit()', array('type'=>'inline', 'scope'=>'footer', 'every_page'=>FALSE));
            drupal_add_js(drupal_get_path('theme', 'chrisbauer3').'/includes/tragic.fade.min.js', array('type'=>'file', 'every_page'=>FALSE));
        }
    } else {
    
    }
}

/**
 * Override or insert variables into the page template.
 */
function chrisbauer3_preprocess_page(&$vars) {

    // Set a variable for the site name title and logo alt attributes text.
    $slogan_text = $vars['site_slogan'];
    $site_name_text = $vars['site_name'];
    $vars['site_name_and_slogan'] = $site_name_text . ' ' . $slogan_text;

    // Set ajax and page-node tpls
    if(isset($_GET['ajax']) && $_GET['ajax'] == 1) {
        $vars['theme_hook_suggestions'] = 'page__ajax';
    }
    if(!empty($vars['node'])) {
        $vars['theme_hook_suggestions'][] = 'page__'. $vars['node']->type;
    }
}

/**
 * Override or insert variables into the node template.
 */
function chrisbauer3_preprocess_node(&$vars) {
    $vars['submitted'] = $vars['date'];
}

/**
 * Override or insert variables into the comment template.
 */
function chrisbauer3_preprocess_comment(&$vars) {
    $vars['submitted'] = $vars['author'].'<span class="pipe">|</span><span class="date">'.$vars['created'].'</span>';
    if($vars['id']%2 == 0) $vars['comment_stripe'] = 'comment-even';
    else $vars['comment_stripe'] = 'comment-odd';
}

/*
* Override filter.module's theme_filter_tips() function to disable tips display.
*/
function chrisbauer3_form_comment_form_alter(&$form, &$form_state, $form_id) {
    $form['comment_body']['#after_build'][] = 'remove_tips';
}

function remove_tips(&$form) {
    unset($form['und'][0]['format']['guidelines']);
    unset($form['und'][0]['format']['help']);
    return $form;
}

/*
* Remove description from user login form text fields
*/
function chrisbauer3_form_user_login_alter(&$form, &$form_state) {
    $form['name']['#description'] = t('');
    $form['pass'] = array('#type'  => 'password',
        '#title' => t('Password'),
        '#description' => t(''),
        '#required' => TRUE,
    );
}

/*
* Override table js to remove sticky behavior.
*/
function chrisbauer3_js_alter(&$js) {
    unset($js['misc/tableheader.js']);
}

/**
* Add unique class (mlid) to all menu items.
* with Menu title as class
*/
function chrisbauer3_menu_link(&$vars) {
    $element = $vars['element'];
    $sub_menu = '';
    $id = $element['#original_link']['mlid'];
    $name_id = strtolower(strip_tags($element['#title']));
    // remove colons and anything past colons
    if(strpos($name_id, ':')) $name_id = substr ($name_id, 0, strpos($name_id, ':'));
    //Preserve alphanumerics, everything else goes away
    $pattern = '/[^a-z]+/ ';
    $name_id = preg_replace($pattern, '', $name_id);
    $element['#attributes']['class'][] = 'menu-' . $name_id . ' mlid-' . $id;

    if($element['#below']) {
        $sub_menu = drupal_render($element['#below']);
    }
    $output = l($element['#title'], $element['#href'], $element['#localized_options']);
    return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}