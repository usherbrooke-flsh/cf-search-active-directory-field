<?php
class cfSearchActiveDirectory {
    private $path;
    private $configFile;

    public function __construct() {
        $this->path = plugin_dir_path(__FILE__);
        $this->configFile = $this->path.'config/config.php';
        $this->listTemplate = $this->path.'config/listTemplate.php';
        $this->ajaxUrl = admin_url( 'admin-ajax.php' );
        $this->init();
    }

    private function init() {
        add_action('wp_ajax_cfSADsearch', array($this, 'searchAD'));
        add_action('wp_ajax_nopriv_cfSADsearch', array($this, 'searchAD'));
        add_action('wp_footer', array($this, 'addAjaxUrlJS')); // Write our JS below here
    }

    public function addAjaxUrlJS() {
        ?>
        <script type="text/javascript">
            var cfSearchActiveDirectory = {
                'ajaxUrl': '<?php echo $this->ajaxUrl; ?>'
            };
        </script>
        <?php
    }

    /**
     * Search
     * @param string $search_string
     */
    public function searchAD($search_string='') {
        $isAjax = empty($search_string) && !empty($_POST);
        $data = array(
            'message'   => '',
            'list'      => array()
        );

        if(isset($_POST['search_string']) || !empty($search_string)) {
            if(file_exists($this->configFile)) {
                include $this->configFile;
            }
            $adServer = $adConfig['protocol'].'://'.$adConfig['host'].':'.$adConfig['port'];
            $ldap = ldap_connect($adServer);

            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

            $bind = @ldap_bind($ldap, $adConfig['username'], $adConfig['password']);
            if ($bind) {
                $filterStr = '';
                //$filterArray = explode(' ', empty($search_string) ? $_POST['search_string'] : $search_string);
                $search_string = (empty($search_string) ? $_POST['search_string'] : $search_string);
                foreach($adConfig['whereToSearch'] as $wts) {
                    $filterStr .= "({$wts}=*{$search_string}*)";
//                    foreach($filterArray as $fa) {
//                        $filterStr .= "({$wts}=*{$fa}*)";
//                    }
                }
                $filterStr = "(|{$filterStr})";

                try {
                    $result = ldap_search($ldap, $adConfig['baseFilter'], $filterStr, $adConfig['attributes'], 0, $adConfig['maxResults']+1);
                    ldap_sort($ldap, $result, "sn");
                    $info = ldap_get_entries($ldap, $result);

                    if (is_array($info) && ($info['count'] > 0)) {
                        if($info['count'] > $adConfig['maxResults']) {
                            $data['message'] = 'Trop de résultats, veuillez raffiner votre recherche.';
                        } else {
                            for ($i=0; $i<$info['count']; $i++) {
                                $data['message'] = sprintf('%d résultat%2$s trouvé%2$s', $info['count'], (($info['count'] > 1) ? 's' : ''));
                                $data['list'][$i] = array();
//                                foreach ($info[$i] as $k => $v) {
//                                    if (!is_numeric($k)) {
//                                        $data['list'][$i][$k] = $v[0];
//                                    }
//                                }
                                $name = $info[$i]['displayname'][0];
                                $uid = $info[$i]['uid'][0];
                                $mail = $info[$i]['mail'][0];
                                $dataAttr = " ";
                                foreach($adConfig['attributes'] as $a) {
                                    $dataAttr .= "data-{$a}='".str_replace('\'', '\\\'', $info[$i][$a][0])."'";
                                }
                                ob_start();
                                include $this->listTemplate;
                                $data['list'][$i] = ob_get_clean();
                            }
                        }
                    }
                } catch(Exception $e) {
                    $data['message'] = $e->getMessage();
                }
            }
            @ldap_close($ldap);
        }

        if($isAjax) {
            echo json_encode($data);
            wp_die();
        } else {
            return $data;
        }
    }
}

//This file is loaded on init
new cfSearchActiveDirectory();