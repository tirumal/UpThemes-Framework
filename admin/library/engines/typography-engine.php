<?php

/* Initialize Font Libraries */
function upfw_typography_init(){
    
    /* Google Fonts */
    if(!defined('DISABLE_GOOGLE_FONTS') )
        upfw_google_fonts();
        
    /* Universal Fonts */
    if( !defined('DISABLE_UNIVERSAL_FONTS') )
        upfw_universal_fonts();
    
    /* Sort The Fonts Alphabetically */
    global $up_fonts;
    ksort($up_fonts);
    
}
add_action('init', 'upfw_typography_init', 10);


/* Enqueue The Font CSS */
function upfw_enqueue_font_css(){
    global $up_fonts;
    $fonts = get_option('up_themes_'.UPTHEMES_SHORT_NAME.'_fonts');

    /* Current Custom Fonts - Since we have no way of knowing when a user deletes a font */
    $current_custom = get_option('up_themes_'.UPTHEMES_SHORT_NAME.'_custom_fonts_queue');

    /* Stored Custom Fonts */
    $custom_fonts = get_option('up_themes_'.UPTHEMES_SHORT_NAME.'_custom_fonts');
    
    /* Check stored against current to make sure we don't display deleted css */
    foreach($custom_fonts as $id => $font):
        if(!$current_custom[$id])unset($custom_fonts[$id]);
    endforeach;
    
    /* Merge custom fonts into main font array */
    if(is_array($custom_fonts))$fonts = array_merge($fonts, $custom_fonts);
    
    if(is_array($fonts)):
        foreach($fonts as $option):
            foreach ($option as $font => $property):
                $lineheight = $property['lineheight'];
                $size = $property['size'];
                $selector = $property['selector'];
                $font_family = $up_fonts[$font]['font_family'];
                $stylesheet = $up_fonts[$font]['style'];
                if($stylesheet)wp_enqueue_style($font, $up_fonts[$font]['style']);
                $css .= $selector."{font-family:'$font_family'; font-size:$size; line-height:$lineheight;}\n";
            endforeach;
        endforeach;
    endif;
    
    global $up_fonts_css;
    $up_fonts_css = $css;
}
if(!is_admin())add_action('init', 'upfw_enqueue_font_css');

/* Print the font CSS */
function upfw_print_fonts_css(){
    global $up_fonts_css;?>
    <style type="text/css">
        <?php echo $up_fonts_css;?>
    </style>

<?php }
if(!is_admin())add_action('wp_print_scripts', 'upfw_print_fonts_css', 10);

/* Register A Font*/
function upfw_register_font($args){
    global $up_fonts;
    extract($args);
    if($id && $name):
        if($font_family)$up_fonts[$id] = $args;
        return true;
    endif;
}

/* Deregister A Font */
function upfw_deregister_font($id){
    global $up_fonts;
    if(is_array($up_fonts[$id])):
        unset($up_fonts[$id]);
        return true;
    endif;
}

/* Register Universal Fonts */
function upfw_universal_fonts(){
    global $up_universal_fonts;
    $up_universal_fonts = array(
        'Georgia',
        'Helvetica',
        'Times New Roman',
        'Arial',
        'Arial Narrow',
        'Impact',
        'Palatino Linotype',
        'Courier New',
        'Century Gothic',
        'Lucida Sans Unicode'
    );
    
    foreach($up_universal_fonts as $font):
        $arg = array(
            'name' => $font,
            'id' => strtolower(str_replace(' ', '_', $font)),
            'font_family' => $font
        );
        upfw_register_font($arg);
    endforeach;
}

/* Register Google Webfonts */
function upfw_google_fonts(){
    global $upfw_google_fonts;
    $upfw_google_fonts = array(
        'Sue Ellen Francisco',
        'Aclonica',
        'Damion',
        'News Cycle',
        'Swanky and Moo Moo',
        'Wallpoet',
        'Over the Rainbow',
        'Special Elite',
        'Quattrocento Sans',
        'Smythe',
        'The Girl Next Door',
        'Sue Ellen Francisco',
        'Dawning of a New Day',
        'Waiting for the Sunrise',
        'Annie Use Your Telescope',
        'Bangers',
        'VT323',
        'Six Caps',
        'EB Garamond',
        'Miltonian',
        'Miltonian Tattoo',
        'Sunshiney',
        'Indie Flower',
        'Sniglet:800',
        'Terminal Dosis Light',
        'Anonymous Pro',
        'Bevan',
        'Nova Square',
        'Nova Oval',
        'Nova Slim',
        'Nova Mono',
        'Nova Round',
        'Nova Cut',
        'Nova Flat',
        'Nova Script',
        'Lekton',
        'MedievalSharp',
        'Michroma',
        'Philosopher',
        'Kenia',
        'Maiden Orange',
        'Kristi',
        'Astloch',
        'Architects Daughter',
        'Cuprum',
        'Crimson Text',
        'Cabin',
        'Quattrocento',
        'Expletus Sans',
        'PT Serif',
        'PT Serif Caption',
        'Josefin Slab',
        'UnifrakturMaguntia',
        'Radley',
        'Crafty Girls',
        'Vibur',
        'Geo',
        'Luckiest Guy',
        'Anton',
        'IM Fell Double Pica SC',
        'IM Fell Great Primer SC',
        'IM Fell DW Pica',
        'IM Fell Double Pica',
        'IM Fell French Canon',
        'IM Fell English SC',
        'IM Fell Great Primer',
        'IM Fell DW Pica SC',
        'IM Fell English',
        'IM Fell French Canon SC',
        'Cousine',
        'Just Another Hand',
        'Molengo',
        'Raleway:100',
        'Old Standard TT',
        'Mountains of Christmas',
        'Homemade Apple',
        'Coda',
        'Neucha',
        'League Script',
        'Unkempt',
        'Walter Turncoat',
        'Cherry Cream Soda',
        'Calligraffitti',
        'Permanent Marker',
        'Josefin Sans',
        'Lato',
        'Meddon',
        'Kranky',
        'Rock Salt',
        'Arimo',
        'Covered By Your Grace',
        'Just Me Again Down Here',
        'Neuton',
        'Schoolbell',
        'OFL Sorts Mill Goudy TT',
        'Syncopate',
        'Droid Sans',
        'Inconsolata',
        'Tinos',
        'Droid Serif',
        'Vollkorn',
        'Reenie Beanie',
        'Cardo',
        'Arvo',
        'Droid Sans Mono',
        'Merriweather',
        'Yanone Kaffeesatz',
        'Candal',
        'Cantarell',
        'Gruppo',
        'Lobster',
        'PT Sans',
        'PT Sans Narrow',
        'PT Sans Caption',
        'Chewy',
        'Coming Soon',
        'Pacifico',
        'Orbitron',
        'Tangerine',
        'Allerta Stencil',
        'Allerta',
        'Fontdiner Swanky',
        'Ubuntu',
        'Nobile',
        'Slackey',
        'Bentham',
        'Crushed',
        'Puritan',
        'Corben:bold',
        'Dancing Script',
        'Kreon',
        'Amaranth',
        'Irish Grover',
        'Cabin Sketch:bold',
        'UnifrakturCook:bold',
        'Buda:light',
        'Coda:800',
        'Coda Caption:800',
    );
    $font_list = '';
    foreach($upfw_google_fonts as $font):
        if(preg_match('/:/', $font)):
            $string = explode(':', $font);
            $font = $string[0];
            $style = ':'.$string[1];
        else:
            $style = '';
        endif;
        $args = array(
            'name' => $font,
            'id' => strtolower(str_replace(' ', '_', $font)),
            'style' => 'http://fonts.googleapis.com/css?family='.str_replace(' ', '+', $font).$style,
            'font_family' => $font
        );
        upfw_register_font($args);
        $font_list .= $font_list ? ', "'.$font.'"' : $font;
    endforeach;
}

/* Render Multiple Options */
function upfw_multiple_typography($options){
    global $up_options;
    
    $multiple = array(
        array(
        'name' => __('Selector Groups', 'upfw'),
        'desc' => __('Add a new selector group (comma delimited) to generate a font style option below. You must save the options first.', 'upfw'),
        'id' => 'upfw_user_selectors',
        'type' => 'text_list',
        'default_text' => __('Add New Selector Group', 'upfw'))
    );
    
    if(is_array($up_options->upfw_user_selectors)):
        foreach($up_options->upfw_user_selectors as $name):
            $multiple[] = array(
                'name' => $name,
                'desc' => __('Custom Selectors', 'upfw'),
                'type' => 'typography',
                'id' => preg_replace('/[^a-z\sA-Z\s0-9\s]/', '', strtolower(str_replace(' ', '_', $name))),
                'selector' => $name,
                'custom' => true
            );
            $custom[preg_replace('/[^a-z\sA-Z\s0-9\s]/', '', strtolower(str_replace(' ', '_', $name)))] = true;
        endforeach;
    endif;
    
    if(is_array($multiple)) $options = array_merge($options, $multiple);
    update_option('up_themes_'.UPTHEMES_SHORT_NAME.'_custom_fonts_queue', $custom);
    return $options;
}

?>