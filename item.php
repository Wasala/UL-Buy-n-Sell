<?php
    require_once __DIR__.'/daos/ItemDAO.class.php';
    $title = "Item Details";
    include(__DIR__."/templates/header.template.php");

    if (isset($_GET["id"])) {
        
        $id = $_GET["id"];
        $itemDao = new ItemDAO();
        
        try {
            $item = $itemDao->getItem($id);
        } catch (Exception $e) {
            $item = null;
        }
        
        if (!is_null($item) ){
            printf("<h2> %s </h2> <p> %s </p>\n", $item->get_title(), $item->get_description());
        } else {
            printf("Item not found.");
        }
    }
?>
              <ul class="actions small">
              <?php
                if (!isset ($_SESSION)) {
                    session_start();
                }
                if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] != '') { 
              ?>
                    <li>
                      <a href="#" class="button special small">Commit to buy</a>
                    </li>
              <?php } ?>
                <li>
                  <a href="./index.php" class="button small">Back</a>
                </li>
              </ul>
<?php include(__DIR__."/templates/footer.template.php"); ?>
