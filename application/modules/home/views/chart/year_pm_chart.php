<ul class="index_table">
  <li class="ttl">Table Index</li>
  <li><span class="color sch"></span><span class="inde_label">Schedule</span></li>
  <li><span class="color don"></span><span class="inde_label">Done</span></li>
  <li><span class="color ndo"></span><span class="inde_label">Not Done</span></li>
</ul>

<?php
$i = 1;
?>
 <table class="table table-bordered dataTable tbl_pdf mtop_0 indexed_table">
     <thead>
         <tr>
            <?php 
            $months=$this->config->item('months');
            // print_r($months);
            // die();
            // die();
            while($i <= 12):
          // $indate->add(new DateInterval('P1D'));
          // $genDate = $indate->format('Y/m/d');
          echo "<th colspan=3>".$months[$i-1]."</th>"; 
          $i++;
        endwhile;
        ?>
         </tr>
         <tr>
         <?php
         for ($i=1; $i <=12 ; $i++) { 
         echo "<td class='sch'>Sc.</td><td class='don'>Do.</td><td class='ndo'>N.D.</td>"; 
          } 
         ?>
         <tr>

     </thead>
     <tbody>
         <tr>
       


        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp1+ $pm_year[0]->comp1; ?>' data-month='1' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'January PM'; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_scheduley1" ><?php echo $pm_year[0]->not_comp1+ $pm_year[0]->comp1; ?></span></a></td>
        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp1; ?>' data-month='1' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'January PM'; ?>' data-pmcat='done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compy1" > <?php echo $pm_year[0]->comp1 ?></span></a>

        </td>
        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp1; ?>' data-month='1' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'January PM'; ?>' data-pmcat='not_done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compy1"><?php echo $pm_year[0]->not_comp1 ?></span></a>

        </td>



        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp2+ $pm_year[0]->comp2; ?>' data-month='10' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'Fabrury PM'; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_scheduley2" ><?php echo $pm_year[0]->not_comp2+ $pm_year[0]->comp2; ?></span></a></td>
        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp2; ?>' data-month='2' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'Fabrury PM'; ?>' data-pmcat='done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compy12" > <?php echo $pm_year[0]->comp2 ?></span></a>

        </td>
        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp2; ?>' data-month='2' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'Fabrury PM'; ?>' data-pmcat='not_done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compy2"><?php echo $pm_year[0]->not_comp2 ?></span></a>

        </td>




        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp3+ $pm_year[0]->comp3; ?>' data-month='3' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'March PM'; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_scheduley3" ><?php echo $pm_year[0]->not_comp3+ $pm_year[0]->comp3; ?></span></a></td>
        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp3; ?>' data-month='3' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'March PM'; ?>' data-pmcat='done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compy3" > <?php echo $pm_year[0]->comp3 ?></span></a>

        </td>
        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp3; ?>' data-month='3' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'March PM'; ?>' data-pmcat='not_done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compy3"><?php echo $pm_year[0]->not_comp3 ?></span></a>

        </td>





        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp4+ $pm_year[0]->comp4; ?>' data-month='4' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'April PM'; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_scheduley4" ><?php echo $pm_year[0]->not_comp4+ $pm_year[0]->comp4; ?></span></a></td>
        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp4; ?>' data-month='4' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'April PM'; ?>' data-pmcat='done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compy4" > <?php echo $pm_year[0]->comp4 ?></span></a>

        </td>
        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp4; ?>' data-month='4' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'April PM'; ?>' data-pmcat='not_done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compy4"><?php echo $pm_year[0]->not_comp4 ?></span></a>

        </td>



        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp5+ $pm_year[0]->comp5; ?>' data-month='10' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'May PM'; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_scheduley5" ><?php echo $pm_year[0]->not_comp5+ $pm_year[0]->comp5; ?></span></a></td>
        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp5; ?>' data-month='5' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'May PM'; ?>' data-pmcat='done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compy5" > <?php echo $pm_year[0]->comp5 ?></span></a>

        </td>
        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp5; ?>' data-month='5' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'May PM'; ?>' data-pmcat='not_done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compy5"><?php echo $pm_year[0]->not_comp5 ?></span></a>

        </td>




        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp6+ $pm_year[0]->comp6; ?>' data-month='6' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'June PM'; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_scheduley6" ><?php echo $pm_year[0]->not_comp6+ $pm_year[0]->comp6; ?></span></a></td>
        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp6; ?>' data-month='6' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'June PM'; ?>' data-pmcat='done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compy6" > <?php echo $pm_year[0]->comp6 ?></span></a>

        </td>
        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp6; ?>' data-month='6' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'June PM'; ?>' data-pmcat='not_done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compy6"><?php echo $pm_year[0]->not_comp6 ?></span></a>

        </td>



        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp7+ $pm_year[0]->comp7; ?>' data-month='10' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'July PM'; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_scheduley7" ><?php echo $pm_year[0]->not_comp7+ $pm_year[0]->comp7; ?></span></a></td>
        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp7; ?>' data-month='7' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'July PM'; ?>' data-pmcat='done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compy7" > <?php echo $pm_year[0]->comp7 ?></span></a>

        </td>
        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp7; ?>' data-month='7' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'July PM'; ?>' data-pmcat='not_done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compy7"><?php echo $pm_year[0]->not_comp7 ?></span></a>

        </td>


     


        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp8+ $pm_year[0]->comp8; ?>' data-month='10' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'August PM'; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_scheduley8" ><?php echo $pm_year[0]->not_comp8+ $pm_year[0]->comp8; ?></span></a></td>
        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp8; ?>' data-month='8' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'August PM'; ?>' data-pmcat='done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compy8" > <?php echo $pm_year[0]->comp8 ?></span></a>

        </td>
        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp8; ?>' data-month='8' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'August PM'; ?>' data-pmcat='not_done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compy8"><?php echo $pm_year[0]->not_comp8 ?></span></a>

        </td>





          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp9+ $pm_year[0]->comp9; ?>' data-month='9' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'September PM'; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_scheduley8" ><?php echo $pm_year[0]->not_comp9+ $pm_year[0]->comp9; ?></span></a></td>
        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp9; ?>' data-month='9' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'September PM'; ?>' data-pmcat='done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compy9" > <?php echo $pm_year[0]->comp9 ?></span></a>

           </td>
        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp9; ?>' data-month='9' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'September PM'; ?>' data-pmcat='not_done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compy9"><?php echo $pm_year[0]->not_comp9 ?></span></a>

            </td>



       

          <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp10+ $pm_year[0]->comp10; ?>' data-month='10' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'Octomber PM'; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_scheduley8" ><?php echo $pm_year[0]->not_comp10+ $pm_year[0]->comp10; ?></span></a></td>
        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp10; ?>' data-month='10' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'Octomber PM'; ?>' data-pmcat='done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compy10" > <?php echo $pm_year[0]->comp10 ?></span></a>

           </td>
        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp10; ?>' data-month='10' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'Octomber PM'; ?>' data-pmcat='not_done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compy10"><?php echo $pm_year[0]->not_comp10 ?></span></a>

            </td>




        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp11+ $pm_year[0]->comp11; ?>' data-month='11' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'November PM'; ?>' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_scheduley11" ><?php echo $pm_year[0]->not_comp11+ $pm_year[0]->comp11; ?></span></a></td>
         <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp11; ?>' data-month='11' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'November PM'; ?>' data-pmcat='done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compy11" > <?php echo $pm_year[0]->comp11 ?></span></a>

           </td>
        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp11; ?>' data-month='11' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'November PM'; ?>' data-pmcat='not_done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compy11"><?php echo $pm_year[0]->not_comp11 ?></span>
         </td>





        
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp12+ $pm_year[0]->comp12; ?>' data-month='12' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'December PM'; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_scheduley12" ><?php echo $pm_year[0]->not_comp12+ $pm_year[0]->comp12; ?></span></a></td>
        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp12; ?>' data-month='12' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'December PM'; ?>' data-pmcat='done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compy12" > <?php echo $pm_year[0]->comp12 ?></span></a>

           </td>
        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_year[0]->not_comp12; ?>' data-month='12' data-year='<?php echo date('Y'); ?>' data-type='pm_year' data-title='<?php echo date('Y').'-'.'December PM'; ?>' data-pmcat='not_done' data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compy12"><?php echo $pm_year[0]->not_comp12 ?></span></a>

            </td>


       


         <tr>
     </tbody>
 </table>
<div id="yearcontainer" style="min-width: 310px; height: 400px; margin: 0 auto">

</div>
<script type="text/javascript">
    var pm_scheduley1 =parseInt($('#pm_scheduley1').html());
    var pm_compy1     =parseInt($('#pm_compy1').html());
    var pm_not_compy1 =parseInt($('#pm_not_compy1').html());
    var pm_scheduley2 =parseInt($('#pm_scheduley2').html());
    var pm_compy2     =parseInt($('#pm_compy2').html());
    var pm_not_compy2 =parseInt($('#pm_not_compy2').html());
    var pm_scheduley3 =parseInt($('#pm_scheduley3').html());
    var pm_compy3     =parseInt($('#pm_compy3').html());
    var pm_not_compy3 =parseInt($('#pm_not_compy3').html());
    var pm_scheduley4 =parseInt($('#pm_scheduley4').html());
    var pm_compy4     =parseInt($('#pm_compy4').html());
    var pm_not_compy4 =parseInt($('#pm_not_compy4').html());
    var pm_scheduley5 =parseInt($('#pm_scheduley5').html());
    var pm_compy5     =parseInt($('#pm_compy5').html());
    var pm_not_compy5 =parseInt($('#pm_not_compy5').html());
    var pm_scheduley6 =parseInt($('#pm_scheduley6').html());
    var pm_compy6     =parseInt($('#pm_compy6').html());
    var pm_not_compy6 =parseInt($('#pm_not_compy6').html());
    var pm_scheduley7 =parseInt($('#pm_scheduley7').html());
    var pm_compy7     =parseInt($('#pm_compy7').html());
    var pm_not_compy7 =parseInt($('#pm_not_compy7').html());
    var pm_scheduley8 =parseInt($('#pm_scheduley8').html());
    var pm_compy8     =parseInt($('#pm_compy8').html());
    var pm_not_compy8 =parseInt($('#pm_not_compy8').html());
    var pm_scheduley9 =parseInt($('#pm_scheduley9').html());
    var pm_compy9     =parseInt($('#pm_compy9').html());
    var pm_not_compy9 =parseInt($('#pm_not_compy9').html());
    var pm_scheduley10 =parseInt($('#pm_scheduley10').html());
    var pm_compy10     =parseInt($('#pm_compy10').html());
    var pm_not_compy10 =parseInt($('#pm_not_compy10').html());
    var pm_scheduley11 =parseInt($('#pm_scheduley11').html());
    var pm_compy11     =parseInt($('#pm_compy11').html());
    var pm_not_compy11 =parseInt($('#pm_not_compy11').html());
    var pm_scheduley12 =parseInt($('#pm_scheduley12').html());
    var pm_compy12     =parseInt($('#pm_compy12').html());
    var pm_not_compy12 =parseInt($('#pm_not_compy12').html());

  Highcharts.chart('yearcontainer', {
    colors: ['#072ae2','#14e44c','#e20d0d'],
    chart: {
        type: 'column'
    },
    title: {
        text: 'This Year PM Chart'
    },
    subtitle: {
        text: ''
    },credits: {
      enabled: false
  },
    
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
            
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
        data: [pm_scheduley1, pm_scheduley2,pm_scheduley3,pm_scheduley4,pm_scheduley5,pm_scheduley6,pm_scheduley7,pm_scheduley8,pm_scheduley9,pm_scheduley10,pm_scheduley11,pm_scheduley12]

    }, {
        name: 'PM done',
        data: [pm_compy1,pm_compy2,pm_compy3,pm_compy4,pm_compy5,pm_compy6,pm_compy7,pm_compy8,pm_compy9,pm_compy10,pm_compy11,pm_compy12]

    }, {
        name: 'PM Not Done',
        data: [pm_not_compy1,pm_not_compy2,pm_not_compy3,pm_not_compy4,pm_not_compy5,pm_not_compy6,pm_not_compy7,pm_not_compy8,pm_not_compy9,pm_not_compy10,pm_not_compy11,pm_not_compy12]

    }]
});
</script>