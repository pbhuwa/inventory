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
	width:500px;
	margin:0 auto; 
	border:1px solid #CCC; 
	padding:10px; 
	border-radius:6px; 
	margin-top:10px;
	height:auto;
}
.logo{
	text-align:center;
}
.heading{
	text-align:center;
}
</style>

<body>
<!--header sec start-->
<header>
<hgroup>
<h1 class="logo">
	<a href="<?php echo site_url();?>"> <img src="<?php echo base_url(LOGO_IMG_PATH.'logo.png');?>" alt="PropertyBid"></a>
</h1>
<div class="clear"></div>
</hgroup>
</header>
<!--header sec end--> 

<!--product sec start-->
<section>
  <h1 class="heading"><?php if(isset($offline_msg->heading))echo ucwords($offline_msg->heading);?></h1>
  <div><?php if(isset($offline_msg->content))echo $offline_msg->content;?></div>
</section>
<!--product sec end--> 

<!--footer sec start-->
<footer></footer>
<!--footer sec end-->

</body>
</html>
