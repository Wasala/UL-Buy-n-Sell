<html>
  <head>
    <title>UL Buy n' Sell - <?php printf("%s", $title);?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="assets/css/main.css">
    <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
  </head>
  <body class="">
    <!-- Wrapper -->
    <div id="wrapper">
      <!-- Header -->
      <header id="header" class="alt">
      </header>
      <!-- Nav -->
      <nav id="nav" class="alt">
        <ul>
          <li>
            <a href="./index.php" class="active">Home
            </a>
          </li>
          <?php 
            if (!isset ($_SESSION)) {
                session_start();
            }
            
            if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] != ''){ 
                printf("<li><a href=\"./sell.php\" class=\"\">Sell</a></li>");
                printf("<li><a href=\"./logout.php\" class=\"\">Logout</a></li>");
            } else {
                if (isset($no_access)) {
                    header("location:./login.php");
                } else {
                    printf("<li><a href=\"./login.php\" class=\"\">Login</a></li>");
                }
                
            }
		  ?>
        </ul>
      </nav>
      <!-- Main -->
      <div id="main">
        <!-- Introduction -->
        <section id="intro" class="main">
          <div class="spotlight">
            <div class="content">
              <header class="major">
                <h2>UL Buy n' Sell
                </h2>
              </header>