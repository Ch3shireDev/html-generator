<?php

/**
 * Html is a class for fast content generation.
 *
 * @version 1.0
 * @author Ch3shireDev
 */

class argument{
    public $value;
    public $quotation = true;

    public function __construct($value, $quotation=true){
        $this->value = $value;
        $this->quotation = $quotation;
    }
}

class Html{

    protected $type = 'div';
    protected $attributes = array();
    protected $content = array();
    protected $format = true;

    static $selfClosedTags = array(
        "area",
        "base",
        "br",
        "col",
        "command",
        "embed",
        "hr",
        "img",
        "input",
        "keygen",
        "link",
        "menuitem",
        "meta",
        "param",
        "source",
        "track",
        "wbr"
    );

    public function dontFormat(){
        $this->format=false;
        return $this;
    }

    public function __call($method, $args){
        $value = new argument($args[0]);
        if(count($args)>1){
            $value->quotation = $args[1];
        }
        $this->attributes[$method] = $value;
        return $this;
    }

    public function content(...$args){
        $this->content = $args;
        return $this;
    }

    public static function __callStatic($method, $args){
        $object = new Html();
        $object->type = $method;
        $object->content = $args;

        return $object;
    }

    public function __toString(){

        $str = "";

        if(in_array($this->type,Html::$selfClosedTags)){
            $str .= $this->selfClosing();
        }
        else{
            $str .= $this->opening();
            $str .= $this->_content();
            $str .= $this->closing();
        }

        return $str;
    }

    public function show(){
        echo $this->__toString();
        return $this;
    }

    public function showSelfClosing(){
        echo $this->selfClosing();
    }

    public function showOpening(){
        echo $this->opening();
    }

    public function showClosing(){
        echo $this->closing();
    }

    public function showContent(){
        echo $this->_content();
    }

    public function opening(){
        $str = $this->startOpening();
        $str .= ">";
        return $str;
    }

    public function closing(){
        $str="";
        if(count($this->content)>0){
            if($this->format){
                $str.="\n";
            }
        }
        $str .= "</".$this->type.">\n";
        return $str;
    }

    public function _content(){
        $str = "";
        foreach($this->content as $element){
            $a = "$element";
            $lines = explode("\n", $a);
            foreach($lines as $line){
                if(ctype_space($line)){
                    continue;
                }
                if($this->format){
                    $str .= "\n\t";
                }
                $str .= $line;
            }
        }
        return $str;
    }

    private function startOpening(){
        $str = "<".$this->type;
        foreach($this->attributes as $key=>$value){
            $val = $value->value;
            if($value->quotation){
                $str .= " ".$key."=\"".$val."\"";
            }
            else{
                $str .= " ".$key."=".$val;
            }
        }
        return $str;
    }

    public function selfClosing(){
        $str = $this->startOpening();
        $str .= "/>";
        return $str;
    }

}


//example

//Html::div()
//    ->class("section")
//    ->content(
//        Html::div()
//        ->class("baloon")
//        ->content(
//            Html::header("Title"),
//            Html::p("Paragraph")
//        )
//    )->show();

//output:


//<div class="section">
//    <div class="baloon">
//        <header>
//            Title
//        </header>
//        <p>
//            Paragraph
//        </p>
//    </div>
//</div>
