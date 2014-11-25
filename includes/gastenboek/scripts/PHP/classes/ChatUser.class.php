<?php
class ChatUser extends ChatBase{

    protected $name = '', $gravatar = '';

    public function save(){

        DB::query("
            INSERT INTO gastenboek_users (name, gravatar)
            VALUES (
                '".DB::esc($this->name)."',
                '".DB::esc($this->gravatar)."'
        )");

        return DB::getPDOObject();
    }

    public function update(){
        DB::query("
            INSERT INTO gastenboek_users (name, gravatar)
            VALUES (
                '".DB::esc($this->name)."',
                '".DB::esc($this->gravatar)."'
            ) ON DUPLICATE KEY UPDATE last_activity = NOW()");
    }
}
?>