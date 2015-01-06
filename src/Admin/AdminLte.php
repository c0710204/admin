<?php
/**
 * This is a php class version of AdminLTE for quick integration
 * @author jambonbill
 */
namespace Admin;


/**
* @brief Class providing adminlte skeleton
*/
class AdminLte
{
    /**
     * PDO Connection
     * Should be reused by the other objects if possible
     * @var [type]
     */
    private $db = null;

    /**
     * Static path to assets
     * @var string
     */
    private $path = '../';// static path
    
    //private $csspath = '';// css path
    
    /**
     * Admin title (display at top-left)
     * @var string
     */
    private $title='Admin';
    
    /**
     * Organisation limit, set by the config
     * @var string
     */
    private $org='';// from config


    private $config = null;//admin config

    // user, to complete
    public $django = null;//UserDjango()
    public $session = null;//UserDjango::djangoSession()
    
    /**
     * Django user data ()
     * @var [type]
     */
    public $user = [];//django user
    
    /**
     * AdminLte Constructor
     * @param boolean $private [description]
     */
    public function __construct ($private = true)
    {
        if ($private==false) {
            return;//public mode with no db connection
        }

        @$this->loadConfig();
        
        if ($this->config) {
            $this->db = Pdo::getDatabase($_SESSION['configfile']);//
            $this->django = new UserDjango($this->db);//
            $this->session = $this->django->djangoSession();//
            $this->user = $this->django->user($this->session['session_data']);//'session_data' hold the django user id
            if (isset($this->config->lte->org)) {
                $this->org = $this->config->lte->org;//'session_data' hold the django user id
            }
        } else {
            //echo "<li>Error: config not loaded\n";
            return false;
        }
        
        $log = new EdxLog();
        $log->user($this->user);
        
    }

    /**
     * Load config file
     * @return [type] [description]
     */
    private function loadConfig()
    {
        // Load configuration
        if (!isset($_SESSION['configfile'])) {
            //echo "Error: no _SESSION['configfile']\n";
            return false;
        }

        if (is_file($_SESSION['configfile'])) {
            // todo : make sure that the file is in readonly for improved security
            $this->config = json_decode(file_get_contents($_SESSION['configfile']));
            /*
            if ($err=json_last_error_msg()) {
                //die("<pre>".print_r($err, true)."</pre>");
                $_SESSION['configfile']='';
                return false;
                //exit;
            }
            */
            return $this->config;
        }
        return false;
    }


    /**
     * Set app base path
     * @param  string $path [description]
     * @return [type]       [description]
     */
    public function path($path = '')
    {
        $this->path=$path;
        //echo "<li>".$this->path;
        return true;
    }


    /**
     * Return django db connection
     * @return binary [description]
     */
    public function db()
    {
        return $this->db;
    }


    /**
     * return config object
     * @return [type] [description]
     */
    public function config()
    {
        return $this->config;
    }


    /**
     * Return config org
     * @return string [organisation]
     */
    public function org()
    {
        return $this->org;
    }

    /**
     * Set page title
     * @param  string $title [description]
     * @return [type]        [description]
     */
    public function title($title = '')
    {
        $this->title = $title;
        return $this->title;
    }


    /**
     * Return current django session data
     * @return [type] [description]
     */
    public function session()
    {
        return $this->session;
    }




    /**
     * Log function
     * @return [type] [description]
     */
    private function log()
    {
        //should log 'everything'
    }






    /**
     * Print all admin html data
     * @return [type] [description]
     */
    public function printPublic($return = false)
    {
        echo $this->head();
        echo $this->body();
        echo $this->header();
        echo $this->leftside();
        echo $this->scripts();
        echo '<aside class="right-side">';
        return;
    }

    /**
     * Print all admin html data
     * @return [type] [description]
     */
    public function printPrivate($return = false)
    {
        echo $this->head();
        echo $this->body();
        echo $this->header();
        echo $this->leftside();
        echo $this->scripts();
        echo $this->autoreload();// reload page every 15 minutes
        echo '<aside class="right-side">';
        if (!$this->session || !$this->user['is_superuser']) {
            //echo "<li>Please login";
            echo "<div class='box-body'>";
            echo "<section class=content>";
            echo "<pre>You are not logged in.<br /><a href='".$this->path."/login/'>Please login</a></pre>";
            echo "</div>";
            //print_r($this->session, true);
            exit;
        }
        return;
    }

    /**
     * Function to call in controllers, to make sure the user is logged in.
     * @return [type] [description]
     */
    public function ctrl()
    {
        if (!$this->session) {
            echo "You are not logged in";//todo : improve this message
            exit;
        }
        return true;
    }


    /**
     * head
     * bring the headers, and initial assets
     * @return [type] [description]
     */
    public function head()
    {

        // Assets
        $CSS=[];
        $CSS[]='css/bootstrap.min.css';// bootstrap 3.0.2
        //$CSS[]='css/font-awesome.css';// font Awesome, icons and fonts
        $CSS[]='css/ionicons.min.css';// Ionicons, more pretty vector icons
        $CSS[]='css/morris/morris.css';// Morris chart
        //$CSS[]='css/jvectormap/jquery-jvectormap-1.2.2.css';//jvectormap
        $CSS[]='css/fullcalendar/fullcalendar.css';//fullCalendar
        $CSS[]='css/daterangepicker/daterangepicker-bs3.css';//Daterange picker
        $CSS[]='css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css';//bootstrap wysihtml5
        $CSS[]='css/AdminLTE.css';//Theme style
        //$CSS[]='css/AdminLTE2.css';//Theme style


        // html
        $HTML=[];
        $HTML[]='<head>';
        $HTML[]='<meta charset="UTF-8">';
        $HTML[]="<title>".$this->title."</title>";
        $HTML[]="<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>";
        $HTML[]="<link rel='shortcut icon' href='".$this->path."img/favicon.png' type='image/png' />";
        foreach ($CSS as $v) {
            $HTML[]='<link href="'.$this->path.$v.'" rel="stylesheet" type="text/css" />';
        }

        //ie compatibilty mode
        $HTML[]='<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->';
        $HTML[]="<!--[if lt IE 9]>";
        $HTML[]='<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js">./';
        $HTML[]='<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js">./';
        $HTML[]="<![endif]-->";

        $HTML[]="<link href='//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' rel='stylesheet'>";//fa icons

        $HTML[]="</head>";

        return implode("\n", $HTML);
    }


    /**
     * body
     * bring the headers, and initial assets
     * @return [type] [description]
     */
    public function body()
    {
        $HTML=[];
        //$HTML[]=__FUNCTION__."()";
        //$HTML[]="<body class=\"skin-blue\">";
        $skin='skin-black';
        if (isset($this->config->lte->skin)) {
            $skin=$this->config->lte->skin;
        }

        $HTML[]="<body class='$skin'>";

        return implode("\n", $HTML);
    }



    /**
     * header 
     * this is NOT the html header, but the ADMIN header (top bar)
     * @return [type] [description]
     */
    public function header()
    {
        $HTML=[];
        //$HTML[]=__FUNCTION__."()";

        // header logo: style can be found in header.less -->
        $HTML[]='<header class="header">';

        if ($this->session) {
            // Add the class icon to your logo image or logo icon to add the margining -->
            //$HTML[]='Admin';
            $title=$this->config->lte->title;
            if (!$title) {
                $title="Admin";
            }
            //$HTML[]='<a href="?" class="logo">';
            //$HTML[]="<a href=? class=logo><img src='".$this->path."/img/logosocgen.png' width=180></i></a>";
            $HTML[]="<a href=? class=logo>$title</a>";
            //$HTML[]='</a>';
        } else {
            $HTML[]='<a href="?" class="logo"></a>';
        }

        // Header Navbar: style can be found in header.less -->
        $HTML[]='<nav class="navbar navbar-static-top" role="navigation">';
        // Sidebar toggle button-->
        $HTML[]='<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button" title="Toggle navigation">';
        $HTML[]='<span class="sr-only">Toggle navigation</span>';
        $HTML[]='<span class="icon-bar"></span>';
        $HTML[]='<span class="icon-bar"></span>';
        $HTML[]='<span class="icon-bar"></span>';
        $HTML[]='</a>';

        if ($this->session) {

            //Navbar right
            $HTML[]='<div class="navbar-right">';
            $HTML[]='<ul class="nav navbar-nav">';

            // User name
            $HTML[]='<li class="dropdown user user-menu">';
            $HTML[]='<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
            $HTML[]='<i class="glyphicon glyphicon-user"></i>';
            $HTML[]='<span>'.$this->user['username'].' <i class="caret"></i></span>';
            $HTML[]='</a>';


            $HTML[]='<ul class="dropdown-menu">';

            // User image -->
            $HTML[]='<li class="user-header bg-light-blue">';
            //$HTML[]='<img src="../../img/avatar3.png" class="img-circle" alt="User Image">';
            //$HTML[]='<p>'.$this->user['username'].'</p>';//<small>Member since Nov. 2012</small>
            $HTML[]='<p><a href=../login/logout.php>Logout</a></p>';

            $HTML[]='</li>';
            $HTML[]='</ul>';

            $HTML[]='</ul>';
            $HTML[]='</div>';
        }


        $HTML[]='</nav>';
        $HTML[]='</header>';

        return implode("\n", $HTML);
    }





    /**
     * left side
     */
    public function leftside()
    {
        $HTML=[];
        $HTML[]='<div class="wrapper row-offcanvas row-offcanvas-left">';
        $HTML[]='<aside class="left-side sidebar-offcanvas">';
        // sidebar: style can be found in sidebar.less -->
        $HTML[]='<section class="sidebar">';

        if ($this->session) {
            // Sidebar user panel -->
            $HTML[]='<div class="user-panel">';
            // avatar
            $HTML[]='<div class="pull-left image">';
            $HTML[]='<img src="'.$this->path.'img/avatar5.png" class="img-circle" alt="User Image" />';
            $HTML[]='</div>';

            $HTML[]='<div class="pull-left info">';
            $userName=$this->user['username'];
            $HTML[]='<p>Hello, '.$userName.'</p>';
            $HTML[]='<a href="#"><i class="fa fa-circle text-success"></i> Online</a>';
            $HTML[]='</div>';
            $HTML[]='</div>';
        }

        // sidebar menu: : style can be found in sidebar.less -->
        $HTML[]= $this->menu();

        $HTML[]='</section>';
        $HTML[]='</aside>';
        return implode("\n", $HTML);
    }


    /**
     * the nice litl menu
     * @return [type] [description]
     */
    public function menu()
    {
        if (!$this->session) {
            return '';
        }

        $HTML=[];
        //$HTML[]=__FUNCTION__."()";
        // sidebar menu: : style can be found in sidebar.less -->

        $HTML[]='<ul class="sidebar-menu">';

        //home
        $HTML[]='<li><a href="'.$this->path.'home/"><i class="fa fa-home"></i> <span>Home</span></a></li>';

        //config
        //$HTML[]='<li><a href="'.$this->path.'config/"><i class="fa fa-dashboard"></i> <span>Config</span></a></li>';

        // users
        $HTML[]='<li><a href="'.$this->path.'users/"><i class="fa fa-users"></i> <span>Users</span></a></li>';

        // courses
        $HTML[]='<li><a href="'.$this->path.'courses/"><i class="fa fa-book"></i> <span>Courses</span></a></li>';
        
        //canvas
        //$HTML[]='<li><a href="'.$this->path.'canvas/"><i class="fa fa-retweet"></i> <span>Canvas</span></a></li>';
        
        // files
        // $HTML[]='<li><a href="'.$this->path.'files/"><i class="fa fa-folder"></i> <span>Files</span></a></li>';


        // paid/products
        $HTML[]='<li><a href="'.$this->path.'paid/"><i class="fa fa-money"></i> <span>Paid</span></a></li>';


        // groups
        $HTML[]='<li><a href="'.$this->path.'groups/"><i class="fa fa-users"></i> <span>Groups</span></a></li>';


        // icons
        //$HTML[]='<li><a href="'.$this->path.'icons/"><i class="fa fa-file"></i> <span>Icons</span></a></li>';


        /*
        $HTML[]='<li class="treeview">';
                $HTML[]='<a href="#">';
                    $HTML[]='<i class="fa fa-folder"></i> <span>Students</span>';
                    $HTML[]='<i class="fa fa-angle-left pull-right"></i>';
                $HTML[]='</a>';
                $HTML[]='<ul class="treeview-menu">';
                    $HTML[]='<li><a href="#"><i class="fa fa-angle-double-right"></i> Student A</a></li>';
                    $HTML[]='<li><a href="#"><i class="fa fa-angle-double-right"></i> Student B</a></li>';
                $HTML[]='</ul>';
            $HTML[]='</li>';
        */

        // backup
        $HTML[]='<li><a href="'.$this->path.'backup/"><i class="fa fa-cloud-download"></i> <span>Backup</span></a></li>';


        // forum
        $HTML[]='<li><a href="'.$this->path.'forum/"><i class="fa fa-comments"></i> <span>Forum</span></a></li>';

        // mails
        //$HTML[]='<li><a href="'.$this->path.'mails/"><i class="fa fa-envelope-o"></i> <span>Mails</span></a></li>';


        //logout
        $HTML[]='<li>';
        $HTML[]='<a href="'.$this->path.'login/logout.php"><i class="fa fa-sign-out"></i> <span>Logout</span></a>';
        $HTML[]='</li>';

        $HTML[]='</ul>';

        return implode("\n", $HTML);
    }


    //scripts

    /**
    * @brief the list of admin scripts to be included
    * @returns html
    */
    public function scripts()
    {
        $PATH=[];
        //jQuery 2.0.2
        $PATH[]="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js";
        //$PATH[]="js/jquery.min.js";

        // jQuery UI 1.10.3 -->
        $PATH[]="js/jquery-ui-1.10.4.min.js";

        // jquery tablesorter
        $PATH[]="js/jquery-tablesorter.min.js";
        $PATH[]="js/jquery.cookie.js";

        // InputMask -->
        $PATH[]="/js/plugins/input-mask/jquery.inputmask.js";
        $PATH[]="/js/plugins/input-mask/jquery.inputmask.date.extensions.js";
        $PATH[]="/js/plugins/input-mask/jquery.inputmask.extensions.js";


        // Bootstrap -->
        $PATH[]="js/bootstrap.min.js";

        // Flot
        $PATH[]="js/plugins/flot/jquery.flot.js";
        
        // Morris.js charts
        $PATH[]="js/plugins/raphael/raphael-min.js";
        $PATH[]="js/plugins/morris/morris.min.js";

        // Sparkline - http://omnipotent.net/jquery.sparkline/#s-about
        //$PATH[]="js/plugins/sparkline/jquery.sparkline.min.js";

        // jvectormap
        //$PATH[]="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js";
        //$PATH[]="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js";

        // fullCalendar -->
        //$PATH[]="js/plugins/fullcalendar/fullcalendar.min.js";

        // jQuery Knob Chart -->
        //$PATH[]="js/plugins/jqueryKnob/jquery.knob.js";

        // daterangepicker -->
        $PATH[]="js/plugins/daterangepicker/daterangepicker.js";
        $PATH[]="js/plugins/timepicker/bootstrap-timepicker.min.js";

        // Bootstrap WYSIHTML5 -->
        //$PATH[]="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js";//nope, i prefer cke

        // iCheck - iCheck check if checkbox is checked
        // https://github.com/damirfoy/iCheck
        //$PATH[]="js/plugins/iCheck/icheck.min.js";

        // AdminLTE App -->
        $PATH[]="js/AdminLTE/app.js";


        // CK Editor -->
        $PATH[]="js/plugins/ckeditor/ckeditor.js";
        $PATH[]="js/plugins/ckeditor/adapters/jquery.js";//http://docs.ckeditor.com/#!/guide/dev_jquery


        // AdminLTE dashboard demo (This is only for demo purposes) -->
        //$PATH[]="js/AdminLTE/dashboard.js";

        // AdminLTE for demo purposes -->
        //$PATH[]="js/AdminLTE/demo.js";//layout options

        //D3js
        $PATH[]="js/d3.min.js";


        //$PATH[]="js/typeahead.bundle.min.js";
        $PATH[]="js/bootstrap-typeahead.js";//Typeahead jambon


        $HTML=[];
        foreach ($PATH as $k => $js) {
            if (preg_match("/^http/", $js)) {
                $HTML[]='<script src="' . $js . '" type="text/javascript"></script>';
            } else {
                $HTML[]='<script src="' . $this->path . $js . '" type="text/javascript"></script>';
            }

        }
        return implode("\n", $HTML);
    }


    /**
     * Force page reload after a given time in msec
     * @return [type] [description]
     */
    public function autoreload()
    {
        $JS=[];
        $JS[]="<script>";
        $JS[]="setTimeout(function(){console.log('reload');document.location.href=document.location.href;},600000);";//ten minutes
        $JS[]="</script>";
        return implode("", $JS);
    }


    /**
     * [dateRelative description]
     * @param  string $date [description]
     * @return [type]       [description]
     */
    public function dateRelative($date = '')
    {
        //$date=;

        if(is_int($date)){
            //$date=date('c',$date);//convert to string
            $date=date('Y-m-d H:i:s', $date);//convert to string
        }
        
        //return $date;
        
        $lap=time()-strtotime($date);//substr($date, 0, 10)
        
        $datestr='';

        if ($lap < 120) {
            $datestr = "Just now";
        } elseif ($lap < 3600) {
            $datestr =  round($lap/60)." min. ago";
        } elseif ($lap < 86000) {
            $hours=round($lap/3600);
            $datestr =  "$hours hours ago";
        } elseif ($lap < 86400) {
            $datestr =  "Today";
        } elseif ($lap < 86400*2) {
            $datestr =  "Yesterday";
        } elseif ($lap < 86400*3) {
            $datestr =  "2 days ago";
        } elseif ($lap < 86400*7) {
            $datestr =  "This week";
        } elseif ($lap < 86400*30) {
            $datestr =  "This month";
        } else {
            $datestr = $date;
        }
        return "<span title='$date'>$datestr</span>";
    }


   
}



/**
 * AdminLte Box Maker
 * http://almsaeedstudio.com/AdminLTE/pages/widgets.html
 */
class Box
{

    private $id='';
    private $type='default';
    private $icon='';
    private $iconUrl='';
    private $color='';
    private $style='';
    private $title='Box';
    private $body='';
    private $body_padding=true;//box-body no-padding
    private $footer='';
    private $collapsed=false;
    private $removable=false;
    private $loading=false;

    public function __construct ()
    {
        $this->id = md5(rand(0, time()));
    }

    /**
     * Box types : default|primary|danger|success|warning
     * @param  string $type [description]
     * @return [type]       [description]
     */
    public function type($type = '')
    {
        if ($type) {
            $this->type=$type;
        }
        return $this->type;
    }
    
    /**
     * The box title
     * @param  string $title [description]
     * @return [type]        [description]
     */
    public function title($title = '')
    {
        if ($title) {
            $this->title=$title;
        }
        return $this->title;
    }
    
    /**
     * Box icon class. Use font awesome names, ex: 'fa fa-user'
     * You can pass multiple icons in a array, ex: ['fa fa-user','fa fa-file']
     * @param  string $classname [description]
     * @return [type]            [description]
     */
    public function icon($classname = '')
    {
        if ($classname) {
            $this->icon=$classname;
        }
        return $this->icon;
    }

    /**
     * A target link on the icon
     * @param  string $url [description]
     * @return [type]      [description]
     */
    public function iconUrl($url = ''){
        if ($url) {
            $this->iconUrl=$url;
        }
        return $this->iconUrl;
    }

    /**
     * Color Used for the 'tiles'
     * @param  string $color [description]
     * @return [type]        [description]
     */
    public function color($color = '')
    {
        if ($color) {
            $this->color=$color;
        }
        return $this->color;
    }

    /**
     * The box id (html property)
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function id($id = '')
    {
        if ($id) {
            $this->id=$id;
        }
        return $this->id;
    }

    /**
     * Box html body
     * @param  string $body [description]
     * @return [type]       [description]
     */
    public function body($body = '')
    {
        if (is_array($body)) {
            $this->body=implode('', $body);
        } elseif ($body) {
            $this->body=$body;
        }
        return $this->body;
    }
    
    /**
     * Set the body padding (add the class 'no-padding to the box boddy')
     * Padding is set (true) by default
     * @param  boolean $padding [description]
     * @return [type]           [description]
     */
    public function body_padding($padding = true)
    {
        if ($padding == false) {
            $this->body_padding=$padding;
        }
        return $this->body_padding;
    }


    /**
     * Box html footer
     * @param  string $footer [description]
     * @return [type]         [description]
     */
    public function footer($footer = '')
    {
        if ($footer) {
            $this->footer=$footer;
        }
        return $this->footer;
    }

    /**
     * When set to true, the box show a overlay and a loading image
     * You can hide it with $('#boxid .overlay, #boxid.loading-img').hide()
     * @param  boolean $loading [description]
     * @return boolean
     */
    public function loading($loading = false)
    {
        if ($loading) {
            $this->loading=$loading;
        }
        return $this->loading;
    }


    public function collapsed($collapsed = false)
    {
        if ($collapsed) {
            $this->collapsed=$collapsed;
        }
        return $this->collapsed;
    }

    /**
     * Add a top-right "x" button that allow box desctruction
     * @param  boolean $removable [description]
     * @return [type]             [description]
     */
    public function removable($removable = false)
    {
        if ($removable) {
            $this->removable=$removable;
        }
        return $this->removable;
    }

    public function style($style = '')
    {
        if ($style) {
            $this->style=$style;
        }
        return $this->style;
    }


    /**
     * Return the LTE Box as html
     * @return [type] [description]
     */
    public function html($body = '',$footer = '')
    {

        if ($body) {
            $this->body($body);
        }

        if ($footer) {
            $this->footer($footer);
        }

        $STYLE='';
        if ($this->style()) {
            $STYLE="style='".$this->style()."'";
        }

        $HTML=[];
        $HTML[]='<div class="box box-'.$this->type().'" '.$STYLE.' id="'.$this->id().'">';// box-solid

        // box header
        $HTML[]='<div class="box-header">';
        
        if ($this->title) {
            $HTML[]='<h3 class="box-title">';
            
            if ($this->icon()) {
                if (is_array($this->icon())) {
                    foreach ($this->icon() as $ico) {
                        $HTML[]="<i class='".$ico."'></i> ";
                    }
                } else {
                    $HTML[]="<i class='".$this->icon()."'></i> ";
                }
                //
                //$HTML[]="<i class='fa fa-arrow-right'></i> ";
                //$HTML[]="<i class='fa fa-book'></i> ";
            }
            $HTML[]=$this->title;
            $HTML[]='</h3>';
        }
        

            $HTML[]='<div class="pull-right box-tools">';
            // reload
            //$HTML[]='<button class="btn btn-'.$type.' btn-sm refresh-btn" data-toggle="tooltip" title="" data-original-title="Reload"><i class="fa fa-refresh"></i></button>';
            
            // reduce
            $HTML[]='<button class="btn btn-'.$this->type.' btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>';
            
            // remove
            if ($this->removable()) {
                $HTML[]='<button class="btn btn-'.$type.' btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>';
            }

            $HTML[]='</div>';
        
        $HTML[]='</div>';
        
        // body
        if ($this->collapsed()) {
            $HTML[]='<div class="box-body collapsed-box" style="display:none;">';//
        } else {
            if($this->body_padding()){
                $HTML[]="<div class='box-body'>";
            } else {
                $HTML[]="<div class='box-body no-padding'>";
            }
        }
        
        if (is_array($this->body)) {
            $HTML[]=implode('', $this->body);
        } else {
            $HTML[]=$this->body;
        }
        
        $HTML[]='</div>';// body end

        // footer
        if ($this->footer()) {
            
            if ($this->collapsed()) {
                $HTML[]="<div class='box-footer collapsed-box' style='display:none;'>";// $collapse
            } else {
                $HTML[]="<div class='box-footer'>";// $collapse
            }
            
            
            if (is_array($this->footer())) {
                $HTML[]=implode('', $this->footer());
            } else {
                $HTML[]=$this->footer();
            }
            $HTML[]='</div>';
        }

        // loader layer
        //$HTML[]='<div>'.($this->loading?'Loading':'Loaded').'</div>';
        
        if ($this->loading()) {
            $HTML[]='<div class="overlay"></div>';
            $HTML[]='<div class="loading-img"></div>';
        }

        // end
        $HTML[]='</div>';// /.box -->

        return implode("", $HTML);
    }
}



/**
 * SolidBox
 */
class SolidBox extends Box
{

    public function html($body = '', $footer = '')
    {
        if ($body) {
            $this->body($body);
        }
        
        if ($body) {
            $this->footer($footer);
        }

        $STYLE='';
        if ($this->style()) {
            $STYLE="style='".$this->style()."'";
        }

        $HTML=[];
        $HTML[]='<div class="box box-solid box-'.$this->type().'" '.$STYLE.' id="'.$this->id().'">';
        $HTML[]='<div class="box-header">';
        $HTML[]='<h3 class="box-title">';
        if ($this->icon()) {
            if ($this->iconUrl()) {
                //die("iconUrl()");
                $HTML[]="<a href='".$this->iconUrl()."'>";
            }
            if (is_array($this->icon())) {
                foreach ($this->icon() as $ico) {
                    $HTML[]="<i class='".$ico."'></i></a> ";
                }
            } else {
                $HTML[]="<i class='".$this->icon()."'></i></a> ";
            }
        }
        $HTML[]=$this->title();//title
        $HTML[]='</h3>';

        $HTML[]='<div class="box-tools pull-right">';
        
        $HTML[]='<button class="btn btn-'.$this->type().' btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>';
        
        if ($this->removable()) {
            $HTML[]='<button class="btn btn-'.$this->type().' btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>';
        }
        
        $HTML[]='</div>';
        $HTML[]='</div>';
        if ($this->collapsed()) {
            $HTML[]='<div class="box-body collapsed-box" style="display:none">';//
        } else {
            if ($this->body_padding()) {
                $HTML[]='<div class="box-body">';//
            } else {
                $HTML[]='<div class="box-body no-padding">';//
            }
        }
        $HTML[]=$this->body();
        $HTML[]='</div>';//<!-- /.box-body -->
        

        // footer
        if ($this->footer()) {
            if ($this->collapsed()) {
                $HTML[]="<div class='box-footer collapsed-box' style='display:none'>";// $collapse
            } else {
                $HTML[]="<div class='box-footer'>";// $collapse
            }

            if (is_array($this->footer())) {
                $HTML[]=implode('', $this->footer());
            } else {
                $HTML[]=$this->footer();
            }
            $HTML[]='</div>';
        }
        
        // loader
        if ($this->loading()) {
            $HTML[]='<div class="overlay"></div>';
            $HTML[]='<div class="loading-img"></div>';
        }

        //end
        $HTML[]='</div>';
        return implode('', $HTML);
    }
}


/**
 * Mini boites avec icon pour homepage (gros bouton)
 */
class SmallBox extends Box
{
    private $value='0';
    public function value($str = '')
    {
        if ($str) {
            $this->value=$str;
        }
        return $this->value;
    }

    private $url='';
    public function url($str = '')
    {
        if ($str) {
            $this->url=$str;
        }
        return $this->url;
    }
    
    public function html()
    {
        $HTML=[];
        $HTML[]="<div class='small-box bg-".$this->color()."' id='".$this->id()."'>";//
        $HTML[]="<div class=inner>";
        $HTML[]="<h3>".$this->value()."</h3>";//value
        $HTML[]="<p>".$this->title()."</p>";//title
        $HTML[]="</div>";
        if ($this->icon()) {
            $HTML[]="<div class=icon><i class='".$this->icon()."'></i></div>";
        }
        
        //footer
        if ($this->url()) {
            $HTML[]="<a href=".$this->url()." class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>";
        } else {
            $HTML[]="<div class='small-box-footer'>&nbsp;</div>";// footer
        }
        

        $HTML[]="</div>";// box
        return implode('', $HTML);
    }
}




class Tile extends Box
{
   
    public function html()
    {
        $HTML=[];

        $HTML[]='<div class="box box-solid bg-'.$this->color().'" id='.$this->id().'>';
        $HTML[]='<div class="box-header">';
        // title
        $HTML[]='<h3 class="box-title">';
        if ($this->icon()) {
            $HTML[]="<i class='".$this->icon()."'></i> ";
        }
        $HTML[]=$this->title();
        $HTML[]='</h3>';
        
        $HTML[]='<div class="box-tools pull-right">';
         
        if ($this->removable()) {
            $HTML[]='<button class="btn btn-'.$this->type().' btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>';
        }
        
        $HTML[]='</div>';

        $HTML[]='</div>';
        $HTML[]='<div class="box-body">';
        //$HTML[]='Box class: <code>.box.box-solid.bg-'.$this->color.'</code>';
        $HTML[]=$this->body();
        $HTML[]='</div>';//<!-- /.box-body -->
        $HTML[]='</div>';
        return implode('', $HTML);
    }
}

/**
 * AdminLte Alert
 */
/*
 Class Alert
 { 
    public function __construct ($type = '', $title = '', $body = '')
    {
        //$this->id = md5(rand(0, time()));
    }

    function html($type = '', $title = '', $body = '')
    {
        $HTML=[];
        $HTML[]="<div class='alert alert-danger alert-dismissable'>";
        $HTML[]="<i class='fa fa-ban'></i>";
        $HTML[]="<button type=button class=close data-dismiss=alert aria-hidden=true>×</button>";
        $HTML[]=$body;
        $HTML[]="</div>";
        return implode("\n", $HTML);
    }  
}
*/


/**
 * AdminLte Callout
 */
Class Callout
{
    private $type ='type';
    private $title='title';
    private $body ='body';

    public function __construct ($type = '', $title = '', $body = '')
    {
        $this->type = $type;
        $this->title = $title;
        $this->body = $body;
    }

    public function __toString()
    {
        $HTML=[];
        $HTML[]="<div class='callout callout-".$this->type."'>";
        $HTML[]="<h4>".$this->title."</h4>";
        if ($this->body) {
            $HTML[]="<p>".$this->body."</p>";
        }
        $HTML[]="</div>";
        return implode("\n", $HTML);
    }
}
