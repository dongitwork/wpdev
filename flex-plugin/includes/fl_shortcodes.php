<?php
/* Add extra type on visual composer */
/**/

require_once FL_INCLUDES . 'types/fl_template_img.php';
require_once FL_INCLUDES . 'types/fl_template.php';
require_once FL_INCLUDES . '/fontlibs/pe7stroke.php';
require_once FL_INCLUDES . '/fontlibs/etline.php';
require_once FL_INCLUDES . '/fontlibs/linearicons.php';

/* Get List Shortcodes From Folder*/
require_once FL_DIR . '/shortcodes/fl_base.php';

//Start adding shortcode
require_once FL_DIR . '/shortcodes/flgrid.php';
require_once FL_DIR . '/shortcodes/flcarousel.php';