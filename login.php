<?php
    require_once __DIR__.'/daos/UserDAO.class.php'; 
    $title = "Login";
    include(__DIR__."/templates/header.template.php");
?>
              <?php
  
              if (isset($_POST["e"]) && isset($_POST["p"]) 
                && trim($_POST["e"]) !='' && trim($_POST["p"]) != ''  ){
                    try {
                        $email = trim(strtolower($_POST["e"]));
                        $password = $_POST["p"];		

                        $userDao = new UserDAO();
                        $user = $userDao->login($email, $password);
                    
                        if (!is_null($user)) {
                            $_SESSION['user_id'] = $user->get_id(); 
                            header("Location:./index.php");
                        } else {
                            printf("<h2> Password incorrect or account not found. </h2>");
                        }
                    } catch (Exception $exception) {
                        printf("Connection error: %s", $exception->getMessage());
                    }
                }
              ?>  
              <h2>Login
              </h2>
              <form method="post" id="login-form">
                <input type="text" name="e" placeholder="email" required="required" maxlength="35" />
                <br>
                <input type="password" name="p" placeholder="Password" required="required" maxlength="50" />
                <br>
                <button type="submit" class="button special small">Login
                </button>
                <label>Don't have account yet ! 
                  <a href="./register.php">Sign Up
                  </a>
                </label>
              </form>
<?php include(__DIR__."/templates/footer.template.php"); ?>
