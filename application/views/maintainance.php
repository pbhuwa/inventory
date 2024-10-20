<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $this->page_title;?></title>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<style>
body{
	border: 1px solid #ccc;
    border-radius: 6px;
    height: auto;
    margin: 10px auto 0;
    padding: 10px;
    top: 200px;
    width: 500px;
}
h1.logo{
	text-align:center;
}
.maintainance .heading{
	text-align:center;
}
.maintainance form{
	text-align:center;
}
.btn{
	background-color: #55a118;
    border: 1px solid #ccc;
    border-radius: 7px;
    color: #F7941E;
    cursor: pointer;
    font-family: Georgia;
    font-size: 16px;
    font-weight: bold;
    padding: 4px 10px;
	text-shadow: 0 1px 0 rgb(40, 57, 102);
}
.maintainance input[type=text]{
	padding:6px 10px;
	border: 1px solid #ccc;
	border-radius:6px;
}
</style>

<body>
<!--header sec start-->
<header>
<hgroup>
<h1 class="logo">
	<a href="<?php echo site_url();?>"><img src="<?php echo base_url('/themes/images/adminlogo.png');?>" alt="<?php echo WEBSITE_NAME; ?>"></a>
</h1>
<div class="clear"></div>
</hgroup>
</header>
<!--header sec end--> 

<!--product sec start-->
<section class="maintainance">
  <h1 class="heading"><?php if(isset($maintainance_msg->heading))echo ucwords($maintainance_msg->heading);?></h1>
  <div><?php if(isset($maintainance_msg->content))echo $maintainance_msg->content;?></div>
  
  <form action="" method="post">
  	<input type="text" name="key" value="" placeholder="Enter Maintainance Key to test site" size="30">
    <button type="submit" name="submit" value="" class="btn">Submit</button>
  </form>
</section>
<!--product sec end--> 

<!--footer sec start-->
<footer></footer>
<!--footer sec end-->

</body>
</html>
