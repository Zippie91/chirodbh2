<?php
//Deze klasse wordt door ChatUsers en ChatLines gebruikt.

class ChatBase {
	public function __construct(array $options){

        foreach($options as $k=>$v){
            if(isset($this->$k)){
                $this->$k = $v;
            }
        }
    }
}
?>