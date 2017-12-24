<?php

/**
 * Html is a class for fast content generation.
 *
 * @version 1.0
 * @author Ch3shireDev
 */

class Html{

    protected $type = 'div';
    protected $attributes = array();
    protected $content = array();

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

    public function __call($method, $args){
        $this->attributes[$method] = implode($args);
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
            $str.="\n";
        }
        $str .= "</".$this->type.">";
        return $str;
    }

    public function _content(){
        $str = "";
        foreach($this->content as $element){
            $a = "$element";
            $lines = explode("\n", $a);
            foreach($lines as $line){
                $str .= "\n\t$line";
            }
        }
        return $str;
    }

    private function startOpening(){
        $str = "<".$this->type;
        foreach($this->attributes as $key=>$value){
            $str .= " ".$key."=\"".$value."\"";
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
