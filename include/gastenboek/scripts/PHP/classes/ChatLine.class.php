<?php
/* Chat line is used for the chat entries */

class ChatLine extends ChatBase{

    protected $text = '', $author = '', $gravatar = '';

    public function save(){
        DB::query("
            INSERT INTO gastenboek_lines (author, gravatar, text)
            VALUES (
                '".DB::esc($this->author)."',
                '".DB::esc($this->gravatar)."',
                '".DB::esc($this->text)."'
        )");

        // Returns the PDO object of the DB class

        return DB::getPDOObject();
    }
}
?>