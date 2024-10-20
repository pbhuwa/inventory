<!DOCTYPE html>
<?php 

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=" Admin Login">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="<?php echo base_url('assets/backend/img/favicon.png');?>">

    <title><?php echo $template['title'];?></title>
      <link href="<?php echo base_url().TEMPLATE_CSS ?>bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
   <link rel="stylesheet" href="<?php echo site_url(TEMPLATE_CSS).'/'; ?>font-awesome.css?v=0.1.1" />
<script src="<?php echo base_url().PLUGIN_DIR.'/'; ?>jquery/dist/jquery.min.js"></script>
     <link rel="stylesheet" href="<?php echo base_url('assets/template/css/login.css');?>">
   
   
</head>

<style type="text/css">

    .error {
        color: red;
        font-family: -webkit-body;
    }
    .message_admin
    {
    color: #f9f9f9 !important;
    font-family: -webkit-body  !important;
    font-size: 14px  !important;
    text-align: center  !important;
    }
</style>

 <body class="login">
 <?php echo $template['body'];?>
  </body>
</html>