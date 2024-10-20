<ul class="index_table">
  <li class="ttl">Table Index</li>
  <li><span class="color req"></span><span class="inde_label">Requisition</span></li>
  <li><span class="color iss"></span><span class="inde_label">Issue</span></li>
  
</ul>


<?php


 $strdate = $this->home_mdl->dateAddCase();
 //echo $strdate; die;
 $befor     = strtotime($strdate);

 $befordate = date("Y/m/d", $befor);
// $befordate= CURDATE_NP;
 //echo $befordate; die;
 //print_r($befor); die;
 $indate = new DateTime($befordate);
 $i = 1;
?>
<div class="table-responsive">
 <table class="table table-bordered dataTable tbl_pdf mtop_5 indexed_table">
     <thead>
         <tr>
            <?php 
            $days=$this->config->item('days');
            // die();
            while($i <= 7):
          $indate->add(new DateInterval('P1D'));
          //print_r($indate) ; die;
          $genDate = $indate->format('Y/m/d');
          $nepDate=$this->general->EngToNepDateConv($genDate);
           $sevenDate[] = $indate->format('Y/m/d');
          
          echo "<th colspan=2><div class='pre_main_date'>".$nepDate."</div><div class='pre_main_day'>".$days[$i-1]."</div></th>"; 
          $i++;
        endwhile;
        ?>
         </tr>
         <tr>
         <?php
         for ($i=1; $i <=7 ; $i++) { 
         echo "<td class='req'>Req</td><td class='iss'>Issue</td>"; 
          } 
         ?>
         <tr>

      </thead>
      <tbody>
        <tr>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->reqcnt1 ?>'  data-date='<?php echo $sevenDate[0]; ?>' data-type='pm_weekly' data-title='<?php echo $sevenDate[0]; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcnt1" ><?php echo $req_iss_weekly[0]->reqcnt1 ?></span></a></td>

          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->isscnt1 ?>' data-type='pm_weekly' data-date='<?php echo $sevenDate[0]; ?>' data-title='<?php echo $sevenDate[0]; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscnt1" ><?php echo $req_iss_weekly[0]->isscnt1 ?></span></a></td>

          

          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->reqcnt1 ?>'  data-date='<?php echo $sevenDate[1]; ?>' data-type='pm_weekly' data-title='<?php echo $sevenDate[1]; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcnt2" ><?php echo $req_iss_weekly[0]->reqcnt2 ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->isscnt1 ?>' data-type='pm_weekly' data-date='<?php echo $sevenDate[1]; ?>' data-title='<?php echo $sevenDate[1]; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscnt2" ><?php echo $req_iss_weekly[0]->isscnt2 ?></span></a></td>

          
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->reqcnt1 ?>'  data-date='<?php echo $sevenDate[2]; ?>' data-type='pm_weekly' data-title='<?php echo $sevenDate[1]; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcnt3" ><?php echo $req_iss_weekly[0]->reqcnt3 ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->isscnt1 ?>' data-type='pm_weekly' data-date='<?php echo $sevenDate[2]; ?>' data-title='<?php echo $sevenDate[2]; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscnt3" ><?php echo $req_iss_weekly[0]->isscnt3 ?></span></a></td>

          
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->reqcnt1 ?>'  data-date='<?php echo $sevenDate[3]; ?>' data-type='pm_weekly' data-title='<?php echo $sevenDate[3]; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcnt4"><?php echo $req_iss_weekly[0]->reqcnt4 ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->isscnt1 ?>' data-type='pm_weekly' data-date='<?php echo $sevenDate[3]; ?>' data-title='<?php echo $sevenDate[3]; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscnt4" ><?php echo $req_iss_weekly[0]->isscnt4 ?></span></a></td>
          

          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->reqcnt1 ?>'  data-date='<?php echo $sevenDate[4]; ?>' data-type='pm_weekly' data-title='<?php echo $sevenDate[4]; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="reqcnt5"><?php echo $req_iss_weekly[0]->reqcnt5 ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->isscnt1 ?>' data-type='pm_weekly' data-date='<?php echo $sevenDate[4]; ?>' data-title='<?php echo $sevenDate[4]; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscnt5" ><?php echo $req_iss_weekly[0]->isscnt5 ?></span></a></td>
          

          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->reqcnt1 ?>'  data-date='<?php echo $sevenDate[5]; ?>' data-type='pm_weekly' data-title='<?php echo $sevenDate[5]; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcnt6" ><?php echo $req_iss_weekly[0]->reqcnt6 ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->isscnt1 ?>' data-type='pm_weekly' data-date='<?php echo $sevenDate[5]; ?>' data-title='<?php echo $sevenDate[5]; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscnt6" ><?php echo $req_iss_weekly[0]->isscnt6 ?></span></a></td>
          

          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->reqcnt1 ?>'  data-date='<?php echo $sevenDate[6]; ?>' data-type='pm_weekly' data-title='<?php echo $sevenDate[6]; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="reqcnt7"><?php echo $req_iss_weekly[0]->reqcnt7 ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_weekly[0]->isscnt1 ?>' data-type='pm_weekly' data-date='<?php echo $sevenDate[6]; ?>' data-title='<?php echo $sevenDate[6]; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscnt7" ><?php echo $req_iss_weekly[0]->isscnt7 ?></span></a></td>
          



        <tr>
      </tbody>
 </table>
 </div>
<div id="weeklycontainer" style="min-width: 310px; height: 400px; margin: 0 auto">

</div>
<script type="text/javascript">
    
    var reqcnt1 =parseInt($('#reqcnt1').html());
    var isscnt1     =parseInt($('#isscnt1').html());
    
    var reqcnt2 =parseInt($('#reqcnt2').html());
    var isscnt2     =parseInt($('#isscnt2').html());
    
    var reqcnt3 =parseInt($('#reqcnt3').html());
    var isscnt3     =parseInt($('#isscnt3').html());
    
    var reqcnt4 =parseInt($('#reqcnt4').html());
    var isscnt4     =parseInt($('#isscnt4').html());
    
    var reqcnt5 =parseInt($('#reqcnt5').html());
    var isscnt5     =parseInt($('#isscnt5').html());
    
    var reqcnt6 =parseInt($('#reqcnt6').html());
    var isscnt6     =parseInt($('#isscnt6').html());
    
    var reqcnt7 =parseInt($('#reqcnt7').html());
    var isscnt7     =parseInt($('#isscnt7').html());
    

  Highcharts.chart('weeklycontainer', {
    colors: ['#e20d0d','#14e44c'],
    chart: {
        type: 'column'
    },
    title: {
        text: 'This Week Requisition Issue Chart'
    },
    subtitle: {
        text: ''
    },
    credits: {
      enabled: false
  },
    xAxis: {
        categories: [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
            
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Requisition Vs Issue Count'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [  {
        name: 'Requisition',
        data: [reqcnt1,reqcnt2,reqcnt3,reqcnt4,reqcnt5,reqcnt6,reqcnt7]

    },{
        name: 'Issue',
        data: [isscnt1,isscnt2,isscnt3,isscnt4,isscnt5,isscnt6,isscnt7]

    }]
});
</script>