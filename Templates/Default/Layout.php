<!DOCTYPE html>

<html>
<head>
  <title><?php echo $system['siteTitle']; ?><?php if(!is_null($pageTitle)) { echo " &raquo; " . $pageTitle; } ?></title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="<?php echo $this->template->directory; ?>/Stylesheets/Global.css" type="text/css">
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]--> 
</head>
<body>
<div id="header">
 <div class="wrapper">
  <h1><a href="<?php echo $system['location']; ?>"><?php echo $system['siteTitle']; ?></a></h1>
  <div id="siteDescription">
    <?php echo $system['siteDescription']; ?>
  </div> <!-- #siteDescription -->
  <div id="navigation">
    <ul>
      <li><a href="<?php echo $system['location']; ?>">Home</a></li>
      <!-- Nav Module -->
    </ul>
  </div> <!-- #navigation -->
 </div> <!-- .wrapper -->
</div> <!-- #header -->
<div id="content" class="wrapper">
  <?php $this->view(); ?>
</div>
<div id="footer" class="wrapper">
  <p>Copyright &copy; <?php echo date("Y"); ?> by <?php echo $system['siteTitle']; ?> | Powered by Pineapple</p>
</div>
</body>
</html>
