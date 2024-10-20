
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Xelwel:User Access</title>
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body { margin:0; } 
    .off_wrapper { font-family: raleway; width:100%; height:100vh; background-color:#F4F4F4; display:table; text-align: center; }
    .off_head { padding-bottom:35px; background: url(http://sabaikojobs.com/assets/frontend/images/divider.png) bottom center no-repeat;}
    .off_head img.logo {margin-bottom: 10px; margin-top: 20vh; display:block; margin-left:auto; margin-right:auto;}
    .off_body span { color:#021c2c; margin-bottom: 20px; font-size:13px; }
    .off_body .avail_stat_txt { font-size:25px; font-weight: bold; color: #044b77; line-height:20px; margin-bottom:10px;}
    .off_body span { display:block; padding:0 17%; text-align: justify; -moz-text-align-last: center; text-align-last: center;}
    .off_body .visit { padding: 20px 0 20px;}
    .visit .maintainance_key input{min-height: 25px; border: 1px solid #e4e4e4; border-radius: 2px; width:100%; max-width: 330px; padding: 5px; line-height: 30px; font-size: 14px;}
    .visit .maintainance_key button {background-color: #EF3D2B; border: none; font-size: 18px; padding: 0 20px; border-radius: 2px; line-height: 41px; color:#fff; font-weight:bold;}

    .socialize h4 {color: rgba(2, 28, 44, 0.7); font-size: 13px;font-weight: 400; margin: 0px;}
    .socialize ul {list-style-type: none; padding:0;}
    .socialize ul li {display:inline-block; width: 30px; border-radius:2px;}
    .socialize ul li i {line-height:30px; color: rgba(255,255,255,0.97); }
    .socialize li.fb { background-color: #134395; }
    .socialize li.twt { background-color: #00C3FC; }
    .socialize li.gp { background-color: #DD4D42; }
    .socialize li.inst { background-color: #517FA4; }
  </style>
</head>

<body>
  <section class="off_wrapper">
    <div class="off_head">
        <a href="<?php echo base_url(); ?>">Xelwel Innovation Pvt.Ltd</a>    
      
    </div>
    <div class="off_body">
      <div class="visit">
        <span class="avail_stat_txt">User Access</span>
        <span>Type Access key if you have 
</span>
        
        <div class="maintainance_key">
                <form action="" method="post">
          <input type="text" name="key" placeholder="Enter Access Key here ..." />          
                    <button type="submit" name="submit" value="" class="mtn_btn" style="cursor: pointer;">Submit</button>
                      <?php if($this->session->flashdata('message')) echo $this->session->flashdata('message');?>
                  
                 </form>
        </div>
      </div>
      
    </div>
   
  </section>
</body>
</html>