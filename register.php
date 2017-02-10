<?php
    require_once __DIR__.'/daos/UserDAO.class.php';   

    $title = "Sign up";
    include(__DIR__."/templates/header.template.php");
?>
             <h2>Sign up</h2>
             <?php

                if (isset($_POST) && count ($_POST) > 0) {
                    $firstName = htmlspecialchars(ucfirst(trim($_POST["first_name"])));
                    $lastName = htmlspecialchars(ucfirst(trim($_POST["last_name"])));
                    $email = trim(strtolower($_POST["email"]));
                    $passOne = $_POST["pass_one"];
                    $passTwo = $_POST["pass_two"];
                    $userDao = new UserDAO();
                    $user = $userDao->getUser('',$email);
                    
                    //check wheter user/email alerady exists
                    
                    if ($passOne != $passTwo) { //in case Javascript is disabled.
                        printf("<h2> Passwords do not match. </h2>");
                    } else {
                        if (!is_null($user)) { 
                            printf("<h2> An account already exists with the given email.</h2>");
                        } else {
                            
                            $siteSalt  = "ulbuynsell";
                            $saltedHash = hash('sha256', $passOne.$siteSalt);	
                            
                            $user = new User();
                            $user->set_first_name($firstName);
                            $user->set_last_name($lastName);
                            $user->set_email($email);
                            $user->set_password($saltedHash);
                            $user = $userDao->save($user);
                    
                            if (!is_null($user)) {
                                    printf("<h2> Welcome %s! Please <a href=\"./login.php\"> login </a> to proceed. </h2>", $user->get_first_name());
                                    $userDao->logout();
                            }
                        }
                    }
                }
            ?>
          <?php 
            if (!isset($_POST) || count($_POST) == 0) { ?>
                  <form method="post" id="sign-up-form" >
                    <label> First name*:
                    </label>
                    <input type="text" name="first_name" placeholder="first name" required="required" maxlength="60"/>
                    <label> Last name:
                    </label>
                    <input type="text" name="last_name" placeholder="last name" maxlength="60"/>
                    <label> Email*:
                    </label>
                    <input type="text" name="email" placeholder="email" required="required" maxlength="60"/>
                    <br>
                    <label> Password*:
                    </label>
                    <input type="password" name="pass_one" placeholder="password" required="required" maxlength="50" id="pass-one"/>
                    <br>
                    <label> Re-enter password*:
                    </label>
                    <input type="password" name="pass_two" placeholder="re-enter password" required="required" maxlength="50"/>
                    <br>
                    <button type="submit" class="button special small">Register
                    </button>
                    <button type="reset" class="button small">Reset
                    </button>
                  </form>
          <?php } 
           include(__DIR__."/templates/footer.template.php"); ?>
