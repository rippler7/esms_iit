<?php
class specialClass{
    protected $arr = array();
    function __construct(){
    }
    public function createForm($form){
        $header = "";
        $elements = "";
        foreach($form as $key => $value){
            if($key == "action"){
                $act = $value;
            } elseif($key == "method"){
                $method = $value;
            } elseif($key == "special"){
                $special = $value;
            } elseif($key == "tableID"){
                $id = $value;
            } elseif($key == 'submit'){
                $newArr = $form[$key];
                //$submit = "<tr><td>".$newArr['caption']."</td><td  style='text-align:center;'><input type='".$key."' name='".$newArr['name']."' /></td></tr>";
                $submit = "<div class='form-actions'><button type='".$key."' id='".$newArr['id']."' name='".$newArr['name']."' class='btn blue pull-right'>".$newArr['value']."</button></div>";
            }
            else {
                if(is_array($form[$key])){
                    $newArr = $form[$key];
                    if(is_array($newArr['name'])){
                        $counter = count($newArr['name']);
                        for ($i=0;$i<=$counter-1;$i++){
                            $elements .= "<div class='control-group'><label class='control-label visible-ie8 visbile-ie9'>".$newArr['caption'][$i]."</label><div class='controls'><div class='input-icon left'><i class='".$newArr['icon'][$i]."'></i><input class='m-wrap placeholder-no-fix' type='".$key."' name='".$newArr['name'][$i]."' id='".$newArr['id'][$i]."' ".$newArr['required'][$i]."='' /></div></div></div>";
                        }                        
                    } else {
                        $elements .= "<div class='control-group'><label class='control-label visible-ie8 visbile-ie9'>".$newArr['caption']."</label><div class='controls'><div class='input-icon left'><i class='".$newArr['icon']."'></i><input class='m-wrap placeholder-no-fix' type='".$key."' name='".$newArr['name']."' id='".$newArr['id']."' ".$newArr['required']."='' /></div></div></div>";
                    }
                } else {
                    $elements .= "<div class='control-group'><label class='control-label visible-ie8 visbile-ie9'>".$newArr['caption']."</label><div class='controls'><div class='input-icon left'><i class='".$newArr['icon']."'></i><input class='m-wrap placeholder-no-fix' type='".$key."' name='".$newArr['name']."' id='".$newArr['id']."' ".$newArr['required']."='' /></div></div></div>";
                }
            }
        }
        echo "<form action='$act' method='$method' class='form-vertical login-form'><h3>Login to your account</h3>";
        //echo "<table id='$id' class='form'><tbody>";
        echo $elements;
        if($special){
            echo $special;
        }
        echo $submit;
        echo "</tbody></table>";
        echo "</form>";
    }
}

?>