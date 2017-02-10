<?php
require_once __DIR__."//../models/Item.class.php";
require_once __DIR__."//../models/User.class.php";

class ModelFactory {
    public static function buildModel($modelName, $modelData) {

        $ret = null;
        switch($modelName) {
            case "Item":
                $ret = self::generateItem($modelData);
                break;
            case "User":
                $ret = self::generateUser($modelData);
                break;
			default:
                echo "Unable to build model $modelName";
		}
		
		return $ret;
    }

	private static function generateUser($modelData) {
		$ret = new User();
		
		if (isset($modelData['id'])) {
			$ret ->set_id($modelData["id"]);
		}

		if (isset($modelData['first_name'])) {
			$ret ->set_first_name($modelData["first_name"]);
		}
		
		if (isset($modelData['last_name'])) {
			$ret ->set_last_name($modelData["last_name"]);
		}	

		if (isset($modelData['email'])) {
			$ret ->set_email($modelData["email"]);
		}

		if (isset($modelData['password'])) {
			$ret ->set_password($modelData["password"]);
		}
		return $ret;
	}
	
	private static function generateItem($modelData) {
		$ret = new Item();
		
		if (isset($modelData['id'])) {
			$ret ->set_id($modelData["id"]);
		}

		if (isset($modelData['title'])) {
			$ret ->set_title($modelData["title"]);
		}
		
		if (isset($modelData['description'])) {
			$ret ->set_description($modelData["description"]);
		}	

		if (isset($modelData['creator_id'])) {
			$ret ->set_creator_id($modelData["creator_id"]);
		}

		if (isset($modelData['expiry_date'])) {
			$ret ->set_expiry_date($modelData["expiry_date"]);
		}

		if (isset($modelData['created_date'])) {
			$ret ->set_created_date($modelData["created_date"]);
		}		
			
		return $ret;
	}

}
?>