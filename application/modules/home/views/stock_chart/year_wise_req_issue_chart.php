<ul class="index_table">
  <li class="ttl">Table Index</li>
  <li><span class="color req"></span><span class="inde_label">Requisition</span></li>
  <li><span class="color iss"></span><span class="inde_label">Issue</span></li>
</ul>

<?php
$i = 1;
?>
<div class="table-responsive">
 <table class="table table-bordered dataTable tbl_pdf mtop_0 indexed_table">
     <thead>
         <tr>
            <?php 

   //           $curYear = date('Y');
   //  $last5yrs=$curYear-5;
   //  $i= $last5yrs;
   //  $coming5yrs=$curYear+5;
   // while($i <= $coming5yrs):
   // $year[] = $i;
   //    $i++;
   //  endwhile;
            $curYear = CURYEAR;
      $last5yrs=$curYear-5;
      $i= $last5yrs;
      $coming5yrs=$curYear+5;
      while($i < $coming5yrs):
       $year= substr($i,-3).'/'.substr($i+1,-2);

      echo "<th colspan=2>".$year."</th>";
      $i++;
    endwhile;
    //echo "<pre>"; print_r($year[]); die;
        //     $curYear = CURYEAR;
        //     $last5yrs=$curYear-5;
        //     $i= $last5yrs;
        //     $coming5yrs=$curYear+5;
        //       while($i < $coming5yrs):

        //   echo "<th colspan=2>".$i."</th>"; 
        //   $i++;
        // endwhile;
        ?>
         </tr>
         <tr>
         <?php
         for ($j=1; $j <=10 ; $j++) { 
         echo "<td class='req'>Req</td><td class='iss'>Issue</td>"; 
          } 
         ?>
         <tr>

     </thead>
     <tbody>
         <tr>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->reqcnt1 ?>'  data-year='<?php echo $last5yrs; ?>' data-type='pm_year' data-title='<?php echo $last5yrs ; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyrwise1" ><?php echo $req_iss_yearwise[0]->reqcnt1 ?></span></a></td>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->isscnt1 ?>'  data-year='<?php echo $last5yrs; ?>' data-type='pm_year' data-title='<?php echo $last5yrs ; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscntyrwise1" ><?php echo $req_iss_yearwise[0]->isscnt1 ?></span></a></td>

        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->reqcnt2 ?>'  data-year='<?php echo $last5yrs+1; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+1 ; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyrwise2" ><?php echo $req_iss_yearwise[0]->reqcnt2 ?></span></a> </td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->isscnt2 ?>'  data-year='<?php echo $last5yrs+1; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+1 ; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscntyrwise2" ><?php echo $req_iss_yearwise[0]->isscnt2 ?></span></a> </td>
        

        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->reqcnt3 ?>'  data-year='<?php echo $last5yrs+2; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+2 ; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyrwise3" ><?php echo $req_iss_yearwise[0]->reqcnt3 ?></span></a></td>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->isscnt3 ?>'  data-year='<?php echo $last5yrs+2; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+2 ; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscntyrwise3" ><?php echo $req_iss_yearwise[0]->isscnt3 ?></span></a></td>
        


        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->reqcnt4 ?>'  data-year='<?php echo $last5yrs+3; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+3 ; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyrwise4"><?php echo $req_iss_yearwise[0]->reqcnt4 ?></span></a></td>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->isscnt4 ?>'  data-year='<?php echo $last5yrs+3; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+3 ; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscntyrwise4" ><?php echo $req_iss_yearwise[0]->isscnt4 ?></span></a></td>
        
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->reqcnt5 ?>'  data-year='<?php echo $last5yrs+4; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+4 ; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="reqcntyrwise5"><?php echo $req_iss_yearwise[0]->reqcnt5 ?></span></a> </td>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->isscnt5 ?>'  data-year='<?php echo $last5yrs+4; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+4 ; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscntyrwise5" ><?php echo $req_iss_yearwise[0]->isscnt5 ?></span></a> </td>
        


         <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->reqcnt6 ?>'  data-year='<?php echo $last5yrs+5; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+5 ; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'> <span id="reqcntyrwise6" ><?php echo $req_iss_yearwise[0]->reqcnt6 ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->isscnt6 ?>'  data-year='<?php echo $last5yrs+5; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+5 ; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'> <span id="isscntyrwise6" ><?php echo $req_iss_yearwise[0]->isscnt6 ?></span></a></td>
       

        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->reqcnt7 ?>'  data-year='<?php echo $last5yrs+6; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+6 ; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'> <span  id="reqcntyrwise7"><?php echo $req_iss_yearwise[0]->reqcnt7 ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->isscnt7 ?>'  data-year='<?php echo $last5yrs+6; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+6 ; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'> <span id="isscntyrwise7" ><?php echo $req_iss_yearwise[0]->isscnt7 ?></span></a></td>
        

        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->reqcnt8 ?>'  data-year='<?php echo $last5yrs+7; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+7 ; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="reqcntyrwise8"><?php echo $req_iss_yearwise[0]->reqcnt8 ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->isscnt8 ?>'  data-year='<?php echo $last5yrs+7; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+7 ; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscntyrwise8" ><?php echo $req_iss_yearwise[0]->isscnt8 ?></span></a></td>
        

        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->reqcnt9 ?>'  data-year='<?php echo $last5yrs+8; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+8 ; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="reqcntyrwise9"><?php echo $req_iss_yearwise[0]->reqcnt9 ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->isscnt9 ?>'  data-year='<?php echo $last5yrs+8; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+8 ; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="isscntyrwise9" ><?php echo $req_iss_yearwise[0]->isscnt9 ?></span></a></td>
        

        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->reqcnt10 ?>'  data-year='<?php echo $last5yrs+9; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+9 ; ?>'  data-pmcat='req'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyrwise10" ><?php echo $req_iss_yearwise[0]->reqcnt10 ?></span></a>
         </td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_yearwise[0]->isscnt10 ?>'  data-year='<?php echo $last5yrs+9; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+9 ; ?>'  data-pmcat='issue'  data-url='<?php echo base_url('home/req_iss_detail'); ?>'> <span id="isscntyrwise10" ><?php echo $req_iss_yearwise[0]->isscnt10 ?></span></a>
        </td>
        
         <tr>
     </tbody>
 </table>
</div>
<div id="yearwisecontainer" style="min-width: 310px; height: 400px; margin: 0 auto">

</div>
<script type="text/javascript">


    var d = new Date();
    var curyrs = '<?php echo CURYEAR; ?>';
    var yearpm=[];
    var yea='';
    // alert(curyrs);
    var last5yrs =curyrs-5;
    var coming5yrs=curyrs+5;
  

    var isscntyrwise1     =parseInt($('#isscntyrwise1').html());
    var reqcntyrwise1 =parseInt($('#reqcntyrwise1').html());
    var isscntyrwise2     =parseInt($('#isscntyrwise2').html());
    var reqcntyrwise2 =parseInt($('#reqcntyrwise2').html());
    var isscntyrwise3     =parseInt($('#isscntyrwise3').html());
    var reqcntyrwise3 =parseInt($('#reqcntyrwise3').html());
    var isscntyrwise4     =parseInt($('#isscntyrwise4').html());
    var reqcntyrwise4 =parseInt($('#reqcntyrwise4').html());
    var isscntyrwise5     =parseInt($('#isscntyrwise5').html());
    var reqcntyrwise5 =parseInt($('#reqcntyrwise5').html());
    var isscntyrwise6     =parseInt($('#isscntyrwise6').html());
    var reqcntyrwise6 =parseInt($('#reqcntyrwise6').html());
    //alert(reqcntyrwise6);
    var isscntyrwise7     =parseInt($('#isscntyrwise7').html());
    var reqcntyrwise7 =parseInt($('#reqcntyrwise7').html());
    var isscntyrwise8     =parseInt($('#isscntyrwise8').html());
    var reqcntyrwise8 =parseInt($('#reqcntyrwise8').html());
    var isscntyrwise9     =parseInt($('#isscntyrwise9').html());
    var reqcntyrwise9 =parseInt($('#reqcntyrwise9').html());
    var isscntyrwise10     =parseInt($('#isscntyrwise10').html());
    var reqcntyrwise10 =parseInt($('#reqcntyrwise10').html());
 

  Highcharts.chart('yearwisecontainer', {
    colors: ['#e20d0d','#14e44c'],
    chart: {
        type: 'column'
    },
    title: {
        text: 'Year Wise Requisition/Issue'
    },
    subtitle: {
        text: ''
    },credits: {
      enabled: false
  },
    xAxis: {
        categories: [
           '070/71','071/72','072/73','073/74','074/75','075/76','076/77','077/78','078/79','079/80'
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
            '<td style="padding:0"><b>{point.y} </b></td></tr>',
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
    series: [ {
        name: 'Requisition',
        data: [reqcntyrwise1,reqcntyrwise2,reqcntyrwise3,reqcntyrwise4,reqcntyrwise5,reqcntyrwise6,reqcntyrwise7,reqcntyrwise8,reqcntyrwise9,reqcntyrwise10]

    },{
        name: 'Issue',
        data: [isscntyrwise1,isscntyrwise2,isscntyrwise3,isscntyrwise4,isscntyrwise5,isscntyrwise6,isscntyrwise7,isscntyrwise8,isscntyrwise9,isscntyrwise10]

    }]
});
</script>