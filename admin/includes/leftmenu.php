<div id="sidebar" class="sidebar responsive ace-save-state sidebar-fixed sidebar-scroll">
    <script type="text/javascript">
        try {
            ace.settings.loadState('sidebar')
        } catch (e) {
        }
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-success">
                <i class="ace-icon fa fa-signal"></i>
            </button>

            <button class="btn btn-info">
                <i class="ace-icon fas fa-pencil-alt"></i>
            </button>

            <button class="btn btn-warning">
                <i class="ace-icon fa fa-users"></i>
            </button>

            <button class="btn btn-danger">
                <i class="ace-icon fa fa-cogs"></i>
            </button>
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>
            <span class="btn btn-info"></span>
            <span class="btn btn-warning"></span>
            <span class="btn btn-danger"></span>
        </div>
    </div><!-- /.sidebar-shortcuts -->

    <ul class="nav nav-list">
        <?php
        $html = '';
        // echo '<pre>'; print_r(get_leftbar_links()); echo '</pre>';
        foreach (get_leftbar_links() as $key => $section) {
            $section_selected = false;
            if(!isset($section['children'])) {
                if(strpos($section['route'], FILE_FILENAME_WITH_EXT) !== FALSE) {
                    $section_selected = 'active highlight';
                }
                $html .= '<li class="'.$section_selected.'">
                            <a href="'.$section['route'].'">
                                <i class="'.$section['icon'].'"></i>
                                <span class="menu-text">'.$section['title'].'</span>
                            </a>
                        </li>';
            } elseif(isset($section['children'])) {
                if(in_array(CURRENT_FILE_URL, array_column($section['children'], 'route'))) {
                    $section_selected = 'active open highlight';
                }
                foreach (array_column($section['children'], 'activeLink') as $key => $value) {
                    if(in_array(FILE_FILENAME_WITH_EXT, $value)) {
                        $section_selected = 'active open highlight';
                    }
                }
                $html .= '<li class="'.$section_selected.'">
                            <a href="#" class="dropdown-toggle">
                                <i class="'.$section['icon'].'"></i>
                                <span class="menu-text">'.$section['title'].'</span>
                                <b class="arrow fa fa-angle-down"></b>
                            </a>
                            <ul class="submenu">';
                foreach($section['children'] as $menu) {
                    $menu_selected = false;
                    if(strpos($menu['route'], FILE_FILENAME_WITH_EXT) !== FALSE) {
                        $menu_selected = 'active';
                    } elseif(isset($menu['activeLink']) && in_array(FILE_FILENAME_WITH_EXT, $menu['activeLink'])) {
                        $menu_selected = 'active';
                    }
                    $html .= '<li class="'.$menu_selected.'">
                                <a href="'.$menu['route'].'">
                                    '.$menu['title'].'
                                </a>
                            </li>';
                }
                $html .= '</ul>
                        </li>';
            }
        }
        echo $html;
        ?>
    </ul><!-- /.nav-list -->

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state"
           data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>
