<?php
require_once __DIR__."/../models/User.class.php";
require_once __DIR__."/../utils/ModelFactory.class.php";
require_once __DIR__."/../utils/PDOAccess.class.php";

class UserDAO {
    public static function getUser($userId, $email) {
        $user = null;
        if (!is_null($userId) || !is_null($email)) {
            $args = $userId.", ".
			PDOAccess::prepareString($email);
            $result = PDOAccess::call("getUser", $args);
            if ($result) {
                $user = ModelFactory::buildModel("User", $result[0]);
            }
        }
        return $user;
    }
	
	public static function save($user) {
        if (is_null($user->get_id())) {
            self::insert($user);
        }/*else {
            self::update($user);
        }*/
        return $user;
    }
	
	private static function insert(&$user) {
		$args = PDOAccess::prepareString($user->get_email()).", ".
		PDOAccess::prepareString($user->get_first_name()).", ".
		PDOAccess::prepareString($user->get_last_name()).", ".
		PDOAccess::prepareString($user->get_password());
		$result = PDOAccess::call("addUser", $args);
        if ($result) {
            $user = ModelFactory::buildModel("User", $result[0]);
        } else {
            $user = null;
        }
    }
	
	public static function login($email, $password) {
		$user = self::getUser("null",$email);
		if (!is_null($user)) {
			$id = $user->get_id();
			$passwordHash = $user->get_password();
			$siteSalt  = "ulbuynsell";
			$saltedHash = hash('sha256', $password.$siteSalt);
			if ($passwordHash == $saltedHash) {
				return $user;
			}
        return null;
		}
	}
	

	public static function logout() {
		/*http://php.net/manual/en/function.session-unset.php*/
		if (!isset ($_SESSION)) {
			session_start();
		}
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(),'',0,'/');
		session_regenerate_id(true);	
	}	
}
?>