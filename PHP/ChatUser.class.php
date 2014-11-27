<?php
// Deze klasse wordt gebruikt om de users op te slaan, te updaten en weer te geven.

class ChatUser extends ChatBase {
	protected $name = '', $gravatar = '';
	
	private function StatementExec($sql) {
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(':name' => $this->name, ':gravatar' => $this->gravatar));
		
		return $stmt;
	}
	
	public function save() {
		$sql = 'INSERT INTO gastenboek_users (name, gravatar) VALUES (:name, :gravatar)';
		$stmt = ChatUser::StatementExec($sql);
		
		return $stmt;
	}
	
	public function update() {
		$sql = 'INSERT INTO gastenboek_users (name, gravatar) VALUES (:name, :gravatar) ON DUPLICATE KEY UPDATE last_activity = NOW()';
		ChatUser::StatementExec($sql);	
	}
}
?>