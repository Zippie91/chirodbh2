<?php
// Deze klasse wordt gebruikt voor de teksten

class ChatLine extends ChatBase {
	
	protected $author = '', $gravatar = '', $text = '';
	
	public function save() {
		$sql = 'INSERT INTO gastenboek_lines (author, gravatar, text) VALUES (:author, :gravatar, :text)';
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(':author' => $this->author, ':gravatar' => $this->gravatar, ':text' => $this->text));
		
		return $stmt;
	}
}
?>