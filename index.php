<?php
    require_once './daos/ItemDAO.class.php';
    $title = "Home";
    include(__DIR__."/templates/header.template.php");

    $itemDao = new ItemDAO();
    try {
        $items = $itemDao->getAvailableItems();
    } catch (Exception $e) {
        $items = null;
    }
    if (!is_null($items)) {
        foreach ($items as $item) {
            printf("\n\t\t\t<h2> <a href=\"./item.php?id=%s\"> %s  </h2>", $item->get_id(), $item->get_title());
        }
    }
    include(__DIR__."/templates/footer.template.php"); 
?>
