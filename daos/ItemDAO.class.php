<?php
require_once __DIR__."/../models/Item.class.php";
require_once __DIR__."/../utils/ModelFactory.class.php";
require_once __DIR__."/../utils/PDOAccess.class.php";

class ItemDAO {
    public static function getItem($itemId) {
        $item = null;
        if (!is_null($itemId)) {
            $args = $itemId;
            $result = PDOAccess::call("getItem", $args);
            if ($result) {
                $item = ModelFactory::buildModel("Item", $result[0]);
            }
        }
        return $item;
    }
	
	public static function save($item) {
        if (is_null($item->get_id())) {
            self::insert($item);
        } else {
            self::update($item);
        }
        return $item;
    }
	
	private static function insert(&$item) {
        $args = $item->get_creator_id().", ".
		    PDOAccess::prepareString($item->get_title()).", ".
			PDOAccess::prepareString($item->get_description());
	    $result = PDOAccess::call("addItem", $args);
        if ($result) {
			$item = ModelFactory::buildModel("Item", $result[0]);
        } else {
            $item = null;
        }
    }
	
	private static function update(&$item) {
        $args = $item->get_id().", ".
		    PDOAccess::prepareString($item->get_title()).", ".
			PDOAccess::prepareString($item->get_description()).", ".
			$item->get_creator_id().", ".
			$item->get_created_date().", ".
			$item->get_expiry_date();
        $result = PDOAccess::call("addItem", $args);
        if ($result) {
            $item = ModelFactory::buildModel("Item", $result[0]);
        } else {
            $item = null;
        }
    }
	
    public static function getAvailableItems() {
        $args = "";
	    $result = PDOAccess::call("getAvailableAds", $args);
        $ret = null;
        if ($result) {
            $ret = array();
            foreach ($result as $row) {
                 $ret[] = ModelFactory::buildModel("Item", $row);
            }
        }
        return $ret;	
    }
	
	public static function markItemAsSold($itemId, $userId) {
        $args = "";
	    $result = PDOAccess::call("markItemAsSold", $args);
        if ($result) {
            $ret = array();
            foreach ($result as $row) {
                 $ret[] = ModelFactory::buildModel("Item", $row);
            }
        }
        return $ret;	
    }
	
	/*public static function delete($itemId){
        $args = Lib\PDOAccess::cleanseNull($itemId);
        $result = Lib\PDOAccess::call("deleteItem", $args);
        return $result[0]["result"];
    }*/
}
?>