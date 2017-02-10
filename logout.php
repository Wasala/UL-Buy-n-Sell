<?php
    require_once __DIR__.'/daos/UserDAO.class.php';  
    $title = "Logout";
    include(__DIR__."/templates/header.template.php");
?>
                <?php
                     
                    $userDao = new UserDAO();
                    $userDao->logout();
                ?>
              <h2>You have been logged out.
              </h2>
<?php include(__DIR__."/templates/footer.template.php"); ?>