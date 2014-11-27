<?php
//Deze class geeft de statische functies die gebruikt worden door ChatControl

class Chat {
	public static function login ($name, $email) {
		if( !$name || !$email ) {
			throw new Exception('Vul alle velden in');	
		}
		
		if( !filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL) ){
            throw new Exception('Je email is ongeldig.');
        }
		
		// Voorbereiden van de gravatar hash:
        $gravatar = md5(strtolower(trim($email)));

        $user = new ChatUser(array(
            'name'        => $name,
            'gravatar'    => $gravatar
        ));
		
		// De save methode geeft een PDO object
		if( $user->save()->rowCount() != 1 ) {
			throw new Exception('Deze naam is al in gebruik');	
		}
		
		$_SESSION['user']    = array(
            'name'        => $name,
            'gravatar'    => $gravatar
        );
		
		return array(
            'status'    => 1,
            'name'        => $name,
            'gravatar'    => Chat::gravatarFromHash($gravatar)
        );
	}
	
	public static function checkLogged() {
		$response = array('logged' => false);
		
		if($_SESSION['user']['name']){
            $response['logged'] = true;
            $response['loggedAs'] = array(
                'name'        => $_SESSION['user']['name'],
                'gravatar'    => Chat::gravatarFromHash($_SESSION['user']['gravatar'])
            );
        }
		
		return $response;
	}
	
	public static function logout() {
		$sql = 'DELETE FROM gastenboek_users WHERE name = :name';
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(':name' => $_SESSION['user']['name']));
		
		$_SESSION = array();
        unset($_SESSION);

        return array('status' => 1);
	}
	
	public static function submitChat($chatText) {
		if( !$_SESSION['user'] ) {
			throw new Exception('Je bent niet aangemeld');	
		}
		
		if( !$chatText ) {
			throw new Exception('Je hebt geen tekst ingegeven!');	
		}
		
		$chat = new ChatLine(array(
            'author'    => $_SESSION['user']['name'],
            'gravatar'    => $_SESSION['user']['gravatar'],
            'text'        => $chatText
        ));
		
		// De save methode geeft een PDO object
		$insertID = $chat->save()->lastInsertId();
		
		return array(
            'status'    => 1,
            'insertID'    => $insertID
        );
	}
	
	public static function getUsers() {
		if( $_SESSION['user']['name'] ) {
			$user = new ChatUser(array('name' => $_SESSION['user']['name']));
            $user->update();	
		}
		
		// Verwijder chats die ouder zijn dan 30 minuten
		$sql_chat = 'DELETE FROM gastenboek_lines WHERE ts < :time_chat';
		$stmt_chat = $conn->execute(array(':time_chat' => 'SUBTIME(NOW(), 0:30:0'));
		
		// Verwijder users die meer dan 30 seconden inactief zijn
		$sql_user = 'DELETE FROM gastenboek_users WHERE last_activity < :time_user';
		$stmt_user = $conn->execute(array(':time_user' => 'SUBTIME(NOW(), 0:0:30)'));
		
		// Return users van DB
		$sql_db_users = 'SELECT * FROM gastenboek_users ORDER BY name ASC LIMIT 18';
		$stmt_db_user = $conn->execute();
	}
	
	public static function gravatarFromHash($hash, $size=23){
        return 'http://www.gravatar.com/avatar/'.$hash.'?size='.$size.'&default='.
                urlencode('http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?size='.$size);
    }
}
?>