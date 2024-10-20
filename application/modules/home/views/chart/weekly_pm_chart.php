<ul class="index_table">
  <li class="ttl">Table Index</li>
  <li><span class="color sch"></span><span class="inde_label">Schedule</span></li>
  <li><span class="color don"></span><span class="inde_label">Done</span></li>
  <li><span class="color ndo"></span><span class="inde_label">Not Done</span></li>
</ul>


<?php
// echo "<pre>";
// print_r($pm_weekly);
// // die();
// echo $pm_weekly[0]->comp1;

 $strdate = $this->home_mdl->dateAddCase();
 $befor     = strtotime($strdate);
 $befordate = date("Y/m/d", $befor);
 $indate = new DateTime($befordate);
 $i = 1;
?>
 <table class="table table-bordered dataTable tbl_pdf mtop_5 indexed_table">
     <thead>
         <tr>
            <?php 
            $days=$this->config->item('days');
            // die();
            while($i <= 7):
          $indate->add(new DateInterval('P1D'));
          $genDate = $indate->format('Y/m/d');
          $sevenDate[] = $indate->format('Y/m/d');
          echo "<th colspan=3><div class='pre_main_date'>".$genDate."</div><div class='pre_main_day'>".$days[$i-1]."</div></th>"; 
          $i++;
        endwhile;
        ?>
         </tr>
         <tr>
         <?php
         for ($i=1; $i <=7 ; $i++) { 
         echo "<td class='sch'>Sc.</td><td class='don'>Do.</td><td class='ndo'>N.D.</td>"; 
          } 
         ?>
         <tr>

      </thead>
      <tbody>
        <tr>
          <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->not_comp1+ $pm_weekly[0]->comp1; ?>'  data-date='<?php echo $sevenDate[0]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[0]; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'> 
              <span id="pm_schedule1"><?php echo $pm_weekly[0]->not_comp1+ $pm_weekly[0]->comp1; ?></span>
            </a>
          </td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->comp1 ?>' data-type='pm_year' data-date='<?php echo $sevenDate[0]; ?>' data-title='<?php echo $sevenDate[0]; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_comp1" ><?php echo $pm_weekly[0]->comp1 ?></span></a></td>

          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp1 ?>'  data-date='<?php echo $sevenDate[0]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[0]; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_not_compyw1" ><?php echo $pm_yearwise[0]->not_comp1 ?></span></a></td>



          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->not_comp2+ $pm_weekly[0]->comp2; ?>'  data-date='<?php echo $sevenDate[1]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[1]; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_schedule2" ><?php echo $pm_weekly[0]->not_comp2+ $pm_weekly[0]->comp2; ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->comp1 ?>' data-type='pm_year' data-title='<?php echo $sevenDate[1]; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_comp2" ><?php echo $pm_weekly[0]->comp2 ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp1 ?>'  data-date='<?php echo $sevenDate[0]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[1]; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_not_comp2" ><?php echo $pm_weekly[0]->not_comp2 ?></span></a></td>



          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->not_comp1+ $pm_weekly[0]->comp1; ?>'  data-date='<?php echo $sevenDate[2]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[1]; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_schedule3" ><?php echo $pm_weekly[0]->not_comp3+ $pm_weekly[0]->comp3; ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->comp1 ?>' data-type='pm_year' data-title='<?php echo $sevenDate[2]; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_comp3" ><?php echo $pm_weekly[0]->comp3 ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp1 ?>'  data-date='<?php echo $sevenDate[2]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[1]; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_not_comp3" ><?php echo $pm_weekly[0]->not_comp3 ?></span></a></td>



          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->not_comp1+ $pm_weekly[0]->comp1; ?>'  data-date='<?php echo $sevenDate[3]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[1]; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_schedule4" ><?php echo $pm_weekly[0]->not_comp4+ $pm_weekly[0]->comp4; ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->comp1 ?>' data-type='pm_year' data-title='<?php echo $sevenDate[3]; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_comp4" ><?php echo $pm_weekly[0]->comp4 ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp1 ?>'  data-date='<?php echo $sevenDate[3]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[3]; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_not_comp4"><?php echo $pm_weekly[0]->not_comp4 ?></span></a></td>



          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->not_comp1+ $pm_weekly[0]->comp1; ?>'  data-date='<?php echo $sevenDate[4]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[4]; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_schedule5"><?php echo $pm_weekly[0]->not_comp5+ $pm_weekly[0]->comp5; ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->comp1 ?>' data-type='pm_year' data-title='<?php echo $sevenDate[4]; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_comp5" ><?php echo $pm_weekly[0]->comp5 ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp1 ?>'  data-date='<?php echo $sevenDate[4]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[4]; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_comp5"><?php echo $pm_weekly[0]->not_comp5 ?></span></a></td>



          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->not_comp1+ $pm_weekly[0]->comp1; ?>'  data-date='<?php echo $sevenDate[5]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[5]; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_schedule6" ><?php echo $pm_weekly[0]->not_comp6+ $pm_weekly[0]->comp6; ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->comp1 ?>' data-type='pm_year' data-title='<?php echo $sevenDate[5]; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_comp6" ><?php echo $pm_weekly[0]->comp6 ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp1 ?>'  data-date='<?php echo $sevenDate[5]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[5]; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_not_comp6" ><?php echo $pm_weekly[0]->not_comp6 ?></span></a></td>



          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->not_comp1+ $pm_weekly[0]->comp1; ?>'  data-date='<?php echo $sevenDate[6]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[6]; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_schedule7" ><?php echo $pm_weekly[0]->not_comp7+ $pm_weekly[0]->comp7; ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_weekly[0]->comp1 ?>' data-type='pm_year' data-title='<?php echo $sevenDate[6]; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_comp7" ><?php echo $pm_weekly[0]->comp7 ?></span></a></td>
          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp1 ?>'  data-date='<?php echo $sevenDate[6]; ?>' data-type='pm_year' data-title='<?php echo $sevenDate[6]; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_comp7"><?php echo $pm_weekly[0]->not_comp7 ?></span></a></td>



        <tr>
      </tbody>
 </table>
<div id="weeklycontainer" style="min-width: 310px; height: 400px; margin: 0 auto">

</div>
<script type="text/javascript">
    var pm_schedule1 =parseInt($('#pm_schedule1').html());
    var pm_comp1     =parseInt($('#pm_comp1').html());
    var pm_not_comp1 =parseInt($('#pm_not_comp1').html());
    var pm_schedule2 =parseInt($('#pm_schedule2').html());
    var pm_comp2     =parseInt($('#pm_comp2').html());
    var pm_not_comp2 =parseInt($('#pm_not_comp2').html());
    var pm_schedule3 =parseInt($('#pm_schedule3').html());
    var pm_comp3     =parseInt($('#pm_comp3').html());
    var pm_not_comp3 =parseInt($('#pm_not_comp3').html());
    var pm_schedule4 =parseInt($('#pm_schedule4').html());
    var pm_comp4     =parseInt($('#pm_comp4').html());
    var pm_not_comp4 =parseInt($('#pm_not_comp4').html());
    var pm_schedule5 =parseInt($('#pm_schedule5').html());
    var pm_comp5     =parseInt($('#pm_comp5').html());
    var pm_not_comp5 =parseInt($('#pm_not_comp5').html());
    var pm_schedule6 =parseInt($('#pm_schedule6').html());
    var pm_comp6     =parseInt($('#pm_comp6').html());
    var pm_not_comp6 =parseInt($('#pm_not_comp6').html());
    var pm_schedule7 =parseInt($('#pm_schedule7').html());
    var pm_comp7     =parseInt($('#pm_comp7').html());
    var pm_not_comp7 =parseInt($('#pm_not_comp7').html());

  Highcharts.chart('weeklycontainer', {
    colors: ['#072ae2','#14e44c','#e20d0d'],
    chart: {
        type: 'column'
    },
    title: {
        text: 'This Week PM Chart'
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
        data: [pm_schedule1, pm_schedule2,pm_schedule3,pm_schedule4,pm_schedule5,pm_schedule6,pm_schedule7]

    }, {
        name: 'PM done',
        data: [pm_comp1,pm_comp2,pm_comp3,pm_comp4,pm_comp5,pm_comp6,pm_comp7]

    }, {
        name: 'PM Not Done',
        data: [pm_not_comp1,pm_not_comp2,pm_not_comp3,pm_not_comp4,pm_not_comp5,pm_not_comp6,pm_not_comp7]

    }]
});
</script>