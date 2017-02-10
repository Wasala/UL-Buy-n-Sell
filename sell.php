<?php
    require_once __DIR__.'/daos/ItemDAO.class.php';
    
    $title = "Sell an item"; $no_access = true;
    include(__DIR__."/templates/header.template.php");
?>

              <h2>Sell an item</h2>
                <?php

                if (isset($_POST) && count ($_POST) > 0 
                    && isset($_SESSION["user_id"])) {
                        
                        $id = $_SESSION["user_id"];
                        $title = htmlspecialchars(trim($_POST["title"]));
                        $description = htmlspecialchars(trim($_POST["description"]));

                        if ($title == '' || $description == '') { //in case Javascript is disabled.
                            printf("<h2> Both title and description are required.</h2>");
                        } else {
                            $item = new Item();
                            $itemDao = new ItemDao();
                            
                            $item->set_creator_id($id);
                            $item->set_title($title);
                            $item->set_description($description);
                            $item = $itemDao->save($item);
                            
                            if (!is_null($item)) {
                                    printf("<h2> Your <a href=\"./item.php?id=%s\">item</a> will soon appear in our website. The advertisement will expire on %s. <br>\n", $item->get_id(), $item->get_expiry_date());
                            }
                        }
                }

                ?>
              <form method="post" id="sell-form">
                Title: 
                <input type="text" name="title"  placeholder="Enter item title" required="required" maxlength="200"/>
                Description: 
                <br>
                <textarea name="description" placeholder="Enter item description" required="required" rows="4" cols="120"/>
                </textarea>
              <br>
              <ul class="actions">
                <li>
                  <input type="submit" value="Submit" class="special">
                </li>
                <li>
                  <input type="reset" value="Reset">
                </li>
              </ul>
              </form>
<?php include(__DIR__."/templates/footer.template.php"); ?>