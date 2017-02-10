<?php
class Item {

    private $id;
    private $title;
    private $description;
    private $creator_id;
    private $created_date;
    private $expiry_date;

    public function set_id($id) { $this->id = $id; }
    public function get_id() { return $this->id; }
    public function set_title($title) { $this->title = $title; }
    public function get_title() { return $this->title; }
    public function set_description($description) { $this->description = $description; }
    public function get_description() { return $this->description; }
    public function set_creator_id($creator_id) { $this->creator_id = $creator_id; }
    public function get_creator_id() { return $this->creator_id; }
    public function set_created_date($created_date) { $this->created_date = $created_date; }
    public function get_created_date() { return $this->created_date; }
    public function set_expiry_date($expiry_date) { $this->expiry_date = $expiry_date; }
    public function get_expiry_date() { return $this->expiry_date; }

}
?>