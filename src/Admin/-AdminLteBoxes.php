<?php

/**
 * This is a php class version of AdminLTE for quick integration
 * @author jambonbill
 */
namespace Admin;



/**
 * AdminLte Box Maker
 */
class Box
{

    private $id='';
    private $type='default';
    private $icon='';
    private $color='';
    private $title='Box';
    private $body='';
    private $footer='';
    private $collapsed=false;
    private $removable=false;
    private $loading=false;

    public function __construct ($private = true)
    {
        $this->id = md5(rand(0, time()));
    }



    public function type($type = '')
    {
        if ($type) {
            $this->type=$type;
        }
        return $this->type;
    }
    
    public function title($title = '')
    {
        if ($title) {
            $this->title=$title;
        }
        return $this->title;
    }
    
    public function icon($classname = '')
    {
        if ($classname) {
            $this->icon=$classname;
        }
        return $this->icon;
    }

    public function color($color = '')
    {
        if ($color) {
            $this->color=$color;
        }
        return $this->color;
    }

    public function id($id = '')
    {
        if ($id) {
            $this->id=$id;
        }
        return $this->id;
    }

    public function body($body = '')
    {
        if ($body) {
            $this->body=$body;
        }
        return $this->body;
    }
    
    public function footer($footer = '')
    {
        if ($footer) {
            $this->footer=$footer;
        }
        return $this->footer;
    }

    public function loading($loading = false)
    {
        $this->loading=$loading;
        return $this->loading;
    }

    public function collapsed($collapsed = false)
    {
        if ($collapsed) {
            $this->collapsed=$collapsed;
        }
        return $this->collapsed;
    }

    public function removable($removable = false)
    {
        if ($removable) {
            $this->removable=$removable;
        }
        return $this->removable;
    }


    public function html()
    {
        $HTML=[];
        $HTML[]='<div class="box box-'.$this->type.'" id="'.$this->id.'">';// box-solid

        // box header
        $HTML[]='<div class="box-header">';
        
        if ($this->title) {
            $HTML[]='<h3 class="box-title">';
            if ($this->icon()) {
                $HTML[]="<i class='".$this->icon()."'></i> ";
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
        
        //body
        //<div class="box-body">
        
        $HTML[]="<div class='box-body'>";
        if (is_array($this->body)) {
            $HTML[]=implode('', $this->body);
        } else {
            $HTML[]=$this->body;
        }
        $HTML[]='</div>';

        //footer
        if ($this->footer()) {
            
            $HTML[]="<div class='box-footer'>";// $collapse
            if (is_array($this->footer())) {
                $HTML[]=implode('', $this->footer());
            } else {
                $HTML[]=$this->footer();
            }
            $HTML[]='</div>';
        }

        // loader layer
        //$HTML[]='<div>'.($this->loading?'Loading':'Loaded').'</div>';
        
        if ($this->loading) {
            $HTML[]='<div class="overlay"></div>';
            $HTML[]='<div class="loading-img"></div>';
        }

        // end
        $HTML[]='</div>';// /.box -->

        return implode("", $HTML);
    }
}


class SolidBox extends Box
{

    public function html()
    {
        $HTML=[];
        //return "solidbox youpi ".$this->title();
        $HTML[]='<div class="box box-solid box-'.$this->type().'">';
        $HTML[]='<div class="box-header">';
        $HTML[]='<h3 class="box-title">';
        if ($this->icon()) {
            $HTML[]="<i class='".$this->icon()."'></i> ";
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
        $HTML[]='<div class="box-body">';
        $HTML[]=$this->body();
        /*
                Box class: <code>.box.box-solid.box-primary</code>
                <p>
                    amber, microbrewery abbey hydrometer, brewpub ale lauter tun saccharification oxidized barrel.
                    berliner weisse wort chiller adjunct hydrometer alcohol aau!
                    sour/acidic sour/acidic chocolate malt ipa ipa hydrometer.
                </p>
        */
        $HTML[]='</div>';//<!-- /.box-body -->
        

        // footer
        if ($this->footer()) {
            
            $HTML[]="<div class='box-footer'>";// $collapse
            if (is_array($this->footer())) {
                $HTML[]=implode('', $this->footer());
            } else {
                $HTML[]=$this->footer();
            }
            $HTML[]='</div>';
        }

        $HTML[]='</div>';
        return implode('', $HTML);
    }
}

// http://almsaeedstudio.com/AdminLTE/pages/widgets.html

class SmallBox
{

    private $id = '';
    //private $type='default';
    private $color='aqua';
    private $icon='';
    private $title='title';
    private $value='value';
    private $link="<a href=# class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>";

    public function __construct ()
    {
        $this->id=md5(rand(0, time()));
    }

    public function id($str='')
    {
        $this->id=$str;
        return $this->id;
    }

    public function color($str = '')
    {
        $this->color=$str;
        return $this->color;
    }

    public function icon($classicon = '')
    {
        $this->icon=$classicon;
        return $this->icon;
    }

    public function title($title = '')
    {
        $this->title=$title;
        return $this->title;
    }

    public function value($str = '')
    {
        $this->value=$str;
        return $this->value;
    }

    public function link($str = '')
    {
        $this->link=$str;
        return $this->link;
    }

    public function html()
    {
        $HTML=[];
        $HTML[]="<div class='small-box bg-".$this->color."' id='".$this->id."'>";//
        $HTML[]="<div class=inner>";
        $HTML[]="<h3>".$this->value."</h3>";//value
        $HTML[]="<p>".$this->title."</p>";//title
        $HTML[]="</div>";
        if ($this->icon) {
            $HTML[]="<div class=icon><i class='".$this->icon."'></i></div>";
        }
        
        $HTML[]="<div class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>";//link
        $HTML[]=$this->link;//link
        $HTML[]="</div>";
        $HTML[]="</div>";
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

/*
<div class="box box-solid bg-aqua">
    <div class="box-header">
        <h3 class="box-title">Info Tile</h3>
    </div>
    <div class="box-body">
        Box class: <code>.box.box-solid.bg-aqua</code>
        <p>
            amber, microbrewery abbey hydrometer, brewpub ale lauter tun saccharification oxidized barrel.
            berliner weisse wort chiller adjunct hydrometer alcohol aau!
            sour/acidic sour/acidic chocolate malt ipa ipa hydrometer.
        </p>
    </div><!-- /.box-body -->
</div>
*/