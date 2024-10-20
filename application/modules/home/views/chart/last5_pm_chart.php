<ul class="index_table">
  <li class="ttl">Table Index</li>
  <li><span class="color sch"></span><span class="inde_label">Schedule</span></li>
  <li><span class="color don"></span><span class="inde_label">Done</span></li>
  <li><span class="color ndo"></span><span class="inde_label">Not Done</span></li>
</ul>

<?php
 $weekno      = $this->home_mdl->weekFormate();
 // print_r($weekno);
 // die();


$firstWeek = $this->home_mdl->getFSundayOfFiveWeek();
$lastWeek  =  $this->home_mdl->getCurSundayDate();

$secweek = strtotime($firstWeek);
$secondweek =  date('Y/m/d',strtotime("+7 day", $secweek));

$thweek = strtotime($secondweek);
$thirdweek =  date('Y/m/d',strtotime("+7 day", $thweek));

$frthweek = strtotime($thirdweek);
$fourthweek =  date('Y/m/d',strtotime("+7 day", $frthweek));

$fifweek = strtotime($fourthweek);
$fifthweek =  date('Y/m/d',strtotime("+7 day", $fifweek));

$sixwek = strtotime($fifthweek);
$sixthweek =  date('Y/m/d',strtotime("+7 day", $sixwek));

$weekseries=array($firstWeek,$secondweek,$thirdweek,$fourthweek,$fifthweek,$sixthweek);

// echo "<pre>";
// print_r($weekseries);

// echo $lastWeek;
// die();


 $i = 1;
?>
 <table class="table table-bordered dataTable tbl_pdf mtop_0 indexed_table">
     <thead>
         <tr>
            <?php 
            $weeks=$this->config->item('weeks');
            // die();
            while($i <= 5):
         
          echo "<th colspan=3>".$weeks[$i-1]." (".$weekseries[$i-1]."-".$weekseries[$i].")</th>"; 
          $i++;
        endwhile;
        ?>
         </tr>
         <tr>
         <?php
         for ($i=1; $i <=5 ; $i++) { 
         echo "<td class='sch'>Sc.</td><td class='don'>Do.</td><td class='ndo'>N.D.</td>"; 
          } 
         ?>
         <tr>

     </thead>
     <tbody>
         <tr>

             <td>
          <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[0]->not_comp1+ $pm_last5week[0]->comp1; ?>' data-week='<?php echo $weekno[0]; ?>'  data-type='pm_week' data-title='<?php echo 'Week 1' ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'> <span id="pm_schedulel5_1"><?php echo $pm_last5week[0]->not_comp1+ $pm_last5week[0]->comp1; ?></a>
         </td>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[0]->comp1 ?>' data-type='pm_week' data-week='<?php echo $weekno[0]; ?>'  data-title='<?php echo 'Week 1' ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compl5_1" ><?php echo $pm_last5week[0]->comp1 ?></span></a></td>


        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[0]->not_comp1 ?>'  data-year='' data-week='<?php echo $weekno[0]; ?>' data-type='pm_week' data-title='<?php echo 'Week 1' ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_not_compl5_1" ><?php echo $pm_last5week[0]->not_comp1 ?></span></a></td>
 


        <td>
          <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[1]->not_comp2+ $pm_last5week[0]->comp2; ?>' data-week='<?php echo $weekno[1]; ?>'  data-type='pm_week' data-title='<?php echo 'Week 2' ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_schedulel5_2" ><?php echo $pm_last5week[0]->not_comp2+ $pm_last5week[0]->comp2; ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[1]->comp1 ?>' data-type='pm_week' data-week='<?php echo $weekno[0]; ?>'  data-title='<?php echo 'Week 2' ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compl5_2" ><?php echo $pm_last5week[0]->comp2 ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[1]->not_comp2 ?>'  data-year='' data-week='<?php echo $weekno[1]; ?>' data-type='pm_week' data-title='<?php echo 'Week 2' ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_not_compl5_2" ><?php echo $pm_last5week[0]->not_comp2 ?></span></a></td>




        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[2]->not_comp3+ $pm_last5week[2]->comp2; ?>' data-week='<?php echo $weekno[2]; ?>'  data-type='pm_week' data-title='<?php echo 'Week 3' ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_schedulel5_3" ><?php echo $pm_last5week[0]->not_comp3+ $pm_last5week[0]->comp3; ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[2]->comp3 ?>' data-type='pm_week' data-week='<?php echo $weekno[2]; ?>'  data-title='<?php echo 'Week 3' ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compl5_3" ><?php echo $pm_last5week[0]->comp3 ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[2]->not_comp3 ?>'  data-year='' data-week='<?php echo $weekno[2]; ?>' data-type='pm_week' data-title='<?php echo 'Week 3' ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_not_compl5_3" ><?php echo $pm_last5week[0]->not_comp3 ?></span></a></td>





        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[3]->not_comp4+ $pm_last5week[3]->comp4; ?>' data-week='<?php echo $weekno[3]; ?>'  data-type='pm_week' data-title='<?php echo 'Week 4' ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_schedulel5_4" ><?php echo $pm_last5week[0]->not_comp4+ $pm_last5week[0]->comp4; ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[3]->comp4 ?>' data-type='pm_week' data-week='<?php echo $weekno[3]; ?>'  data-title='<?php echo 'Week 4' ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compl5_4" ><?php echo $pm_last5week[0]->comp4 ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[3]->not_comp4 ?>'  data-year='' data-week='<?php echo $weekno[3]; ?>' data-type='pm_week' data-title='<?php echo 'Week 4' ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_not_compl5_4"><?php echo $pm_last5week[0]->not_comp4 ?></span></a></td>





        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[4]->not_comp5+ $pm_last5week[0]->comp5; ?>' data-week='<?php echo $weekno[4]; ?>'  data-type='pm_week' data-title='<?php echo 'Week 5' ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_schedulel5_5"><?php echo $pm_last5week[0]->not_comp5+ $pm_last5week[0]->comp5; ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[4]->comp5 ?>' data-type='pm_week' data-week='<?php echo $weekno[4]; ?>'  data-title='<?php echo 'Week 5' ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compl5_5" ><?php echo $pm_last5week[0]->comp5 ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_last5week[4]->not_comp5 ?>'  data-year='' data-week='<?php echo $weekno[4]; ?>' data-type='pm_week' data-title='<?php echo 'Week 5' ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compl5_5"><?php echo $pm_last5week[0]->not_comp5 ?></span></a></td>
        <tr>
     </tbody>
 </table>
<div id="last5_pmcontainer" style="min-width: 310px; height: 400px; margin: 0 auto">

</div>
<script type="text/javascript">
    var pm_schedulel5_1 =parseInt($('#pm_schedulel5_1').html());
    var pm_compl5_1     =parseInt($('#pm_compl5_1').html());
    var pm_not_compl5_1 =parseInt($('#pm_not_compl5_1').html());
    var pm_schedulel5_2 =parseInt($('#pm_schedulel5_2').html());
    var pm_compl5_2     =parseInt($('#pm_compl5_2').html());
    var pm_not_compl5_2 =parseInt($('#pm_not_compl5_2').html());
    var pm_schedulel5_3 =parseInt($('#pm_schedulel5_3').html());
    var pm_compl5_3     =parseInt($('#pm_compl5_3').html());
    var pm_not_compl5_3 =parseInt($('#pm_not_compl5_3').html());
    var pm_schedulel5_4 =parseInt($('#pm_schedulel5_4').html());
    var pm_compl5_4     =parseInt($('#pm_compl5_4').html());
    var pm_not_compl5_4 =parseInt($('#pm_not_compl5_4').html());
    var pm_schedulel5_5 =parseInt($('#pm_schedulel5_5').html());
    var pm_compl5_5     =parseInt($('#pm_compl5_5').html());
    var pm_not_compl5_5 =parseInt($('#pm_not_compl5_5').html());
  

  Highcharts.chart('last5_pmcontainer', {
    colors: ['#072ae2','#14e44c','#e20d0d'],
    chart: {
        type: 'column'
    },
    title: {
        text: 'Last 5 Week PM'
    },
    subtitle: {
        text: ''
    },
    credits: {
      enabled: false
  },
    xAxis: {
        categories: [
            'Week 1',
            'Week 2',
            'Week 3',
            'Week 4',
            'Week 5',    
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Equipment Count'
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
    series: [{
        name: 'PM Schedule',
        data: [pm_schedulel5_1, pm_schedulel5_2,pm_schedulel5_3,pm_schedulel5_4,pm_schedulel5_5]

    }, {
        name: 'PM done',
        data: [pm_compl5_1,pm_compl5_2,pm_compl5_3,pm_compl5_4,pm_compl5_5]

    }, {
        name: 'PM Not Done',
        data: [pm_not_compl5_1,pm_not_compl5_2,pm_not_compl5_3,pm_not_compl5_4,pm_not_compl5_5]

    }]
});
</script>