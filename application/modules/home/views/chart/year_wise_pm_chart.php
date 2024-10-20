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

   //           $curYear = date('Y');
   //  $last5yrs=$curYear-5;
   //  $i= $last5yrs;
   //  $coming5yrs=$curYear+5;
   // while($i <= $coming5yrs):
   // $year[] = $i;
   //    $i++;
   //  endwhile;

            $curYear = date('Y');
    $last5yrs=$curYear-5;
    $i= $last5yrs;
    $coming5yrs=$curYear+5;
              while($i < $coming5yrs):

          echo "<th colspan=3>".$i."</th>"; 
          $i++;
        endwhile;
        ?>
         </tr>
         <tr>
         <?php
         for ($j=1; $j <=10 ; $j++) { 
         echo "<td class='sch'>Sc.</td><td class='don'>Do.</td><td class='ndo'>N.D.</td>"; 
          } 
         ?>
         <tr>

     </thead>
     <tbody>
         <tr>
        <td>
          <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp1+ $pm_yearwise[0]->comp1; ?>'  data-year='<?php echo $last5yrs; ?>' data-type='pm_year' data-title='<?php echo $last5yrs ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'> <span id="pm_scheduleyw1"><?php echo $pm_yearwise[0]->not_comp1+ $pm_yearwise[0]->comp1; ?></span></a>
         </td>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->comp1 ?>'  data-year='<?php echo $last5yrs; ?>' data-type='pm_year' data-title='<?php echo $last5yrs ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compyw1" ><?php echo $pm_yearwise[0]->comp1 ?></span></a></td>


        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp1 ?>'  data-year='<?php echo $last5yrs; ?>' data-type='pm_year' data-title='<?php echo $last5yrs ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_not_compyw1" ><?php echo $pm_yearwise[0]->not_comp1 ?></span></a></td>



        <td>
          <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp2+ $pm_yearwise[0]->comp2; ?>'  data-year='<?php echo $last5yrs+1; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+1 ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'> <span id="pm_scheduleyw2" ><?php echo $pm_yearwise[0]->not_comp2+ $pm_yearwise[0]->comp2; ?></span></a>          
        </td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->comp2 ?>'  data-year='<?php echo $last5yrs+1; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+1 ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compyw2" ><?php echo $pm_yearwise[0]->comp2 ?></span></a> </td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp2 ?>'  data-year='<?php echo $last5yrs+1; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+1 ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_not_compyw2" ><?php echo $pm_yearwise[0]->not_comp2 ?></span></a> </td>



        <td>
           <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp3+ $pm_yearwise[0]->comp3; ?>'  data-year='<?php echo $last5yrs+2; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+2 ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'> <span id="pm_scheduleyw3" ><?php echo $pm_yearwise[0]->not_comp3+ $pm_yearwise[0]->comp3; ?></span></a>     

          </td>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->comp3 ?>'  data-year='<?php echo $last5yrs+2; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+2 ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compyw3" ><?php echo $pm_yearwise[0]->comp3 ?></span></a></td>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp3 ?>'  data-year='<?php echo $last5yrs+2; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+2 ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_not_compyw3" ><?php echo $pm_yearwise[0]->not_comp3 ?></span></a></td>



        <td>
           <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp4+ $pm_yearwise[0]->comp4; ?>'  data-year='<?php echo $last5yrs+3; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+3 ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'>  <span id="pm_scheduleyw4" ><?php echo $pm_yearwise[0]->not_comp4+ $pm_yearwise[0]->comp4; ?></span></a>  
         </td>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->comp4 ?>'  data-year='<?php echo $last5yrs+3; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+3 ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compyw4" ><?php echo $pm_yearwise[0]->comp4 ?></span></a></td>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp4 ?>'  data-year='<?php echo $last5yrs+3; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+3 ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_not_compyw4"><?php echo $pm_yearwise[0]->not_comp4 ?></span></a></td>
        <td>




          <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp4+ $pm_yearwise[0]->comp4; ?>'  data-year='<?php echo $last5yrs+4; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+4 ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'>  <span id="pm_scheduleyw5"><?php echo $pm_yearwise[0]->not_comp5+ $pm_yearwise[0]->comp5; ?></span></a>  

          </td>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->comp5 ?>'  data-year='<?php echo $last5yrs+4; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+4 ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compyw5" ><?php echo $pm_yearwise[0]->comp5 ?></span></a> </td>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp5 ?>'  data-year='<?php echo $last5yrs+4; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+4 ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compyw5"><?php echo $pm_yearwise[0]->not_comp5 ?></span></a> </td>



        <td>
          <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp6+ $pm_yearwise[0]->comp6; ?>'  data-year='<?php echo $last5yrs+5; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+5 ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'> <span id="pm_scheduleyw6" ><?php echo $pm_yearwise[0]->not_comp6+ $pm_yearwise[0]->comp6; ?></span></a>
          </td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->comp6 ?>'  data-year='<?php echo $last5yrs+5; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+5 ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'> <span id="pm_compyw6" ><?php echo $pm_yearwise[0]->comp6 ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp6 ?>'  data-year='<?php echo $last5yrs+5; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+5 ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'> <span id="pm_not_compyw6" ><?php echo $pm_yearwise[0]->not_comp6 ?></span></a></td>


        <td>
          <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp7+ $pm_yearwise[0]->comp7; ?>'  data-year='<?php echo $last5yrs+6; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+6 ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'>   <span id="pm_scheduleyw7" ><?php echo $pm_yearwise[0]->not_comp7+ $pm_yearwise[0]->comp7; ?></span></a>

         </td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->comp7 ?>'  data-year='<?php echo $last5yrs+6; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+6 ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'> <span id="pm_compyw7" ><?php echo $pm_yearwise[0]->comp7 ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp7 ?>'  data-year='<?php echo $last5yrs+6; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+6 ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'> <span  id="pm_not_compyw7"><?php echo $pm_yearwise[0]->not_comp7 ?></span></a></td>



        <td>
          <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp8+ $pm_yearwise[0]->comp8; ?>'  data-year='<?php echo $last5yrs+7; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+7 ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'> <span id="pm_scheduleyw8" ><?php echo $pm_yearwise[0]->not_comp8+ $pm_yearwise[0]->comp8; ?></span></a>
          </td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->comp8 ?>'  data-year='<?php echo $last5yrs+7; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+7 ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compyw8" ><?php echo $pm_yearwise[0]->comp8 ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp8 ?>'  data-year='<?php echo $last5yrs+7; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+7 ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compyw8"><?php echo $pm_yearwise[0]->not_comp8 ?></span></a></td>



        <td>
          <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp9+ $pm_yearwise[0]->comp9; ?>'  data-year='<?php echo $last5yrs+8; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+8 ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'>  <span id="pm_scheduleyw9" ><?php echo $pm_yearwise[0]->not_comp9+ $pm_yearwise[0]->comp9; ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->comp9 ?>'  data-year='<?php echo $last5yrs+8; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+8 ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_compyw9" ><?php echo $pm_yearwise[0]->comp9 ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp9 ?>'  data-year='<?php echo $last5yrs+8; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+8 ; ?>'  data-pmcat='not_done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span  id="pm_not_compyw9"><?php echo $pm_yearwise[0]->not_comp9 ?></span></a></td>



        <td>
          <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp10+ $pm_yearwise[0]->comp10; ?>'  data-year='<?php echo $last5yrs+9; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+9 ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'>  <span id="pm_scheduleyw10" ><?php echo $pm_yearwise[0]->not_comp10+ $pm_yearwise[0]->comp10; ?></span></a></td>
        <td><a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->comp10 ?>'  data-year='<?php echo $last5yrs+9; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+9 ; ?>'  data-pmcat='done'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'>  <span id="pm_not_doneyw10" ><span id="pm_compyw10" ><?php echo $pm_yearwise[0]->comp10 ?></span></a>
        </td>
        <td> <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $pm_yearwise[0]->not_comp10 ?>'  data-year='<?php echo $last5yrs+9; ?>' data-type='pm_year' data-title='<?php echo $last5yrs+9 ; ?>'  data-pmcat='schedule'  data-url='<?php echo base_url('biomedical/pm_data/get_pm_detail'); ?>'><span id="pm_scheduleyw10" >
            <span id="pm_compyw10" ><?php echo $pm_yearwise[0]->not_comp10 ?></span></a>
         </td>
       
       


         <tr>
     </tbody>
 </table>
<div id="yearwisecontainer" style="min-width: 310px; height: 400px; margin: 0 auto">

</div>
<script type="text/javascript">


    var d = new Date();
    var curyrs = d.getFullYear();
    var yearpm=[];
    var yea='';
    // alert(curyrs);
    var last5yrs =curyrs-5;
    var coming5yrs=curyrs+5;
    // var val=[ 

            // ];

    // for (var i =last5yrs ; i<=coming5yrs; i++) {
    // yearpm=i;
    // yea += "'"+yearpm+"',";
    // }
    //  var axixcat=yea.replace(/,\s*$/, "");
     // $(axixcat).each(function(i){
     //      val[i] = i
     //    });

    // return false;
   //
   // console.log(val);


    var pm_scheduleyw1 =parseInt($('#pm_scheduleyw1').html());
    var pm_compyw1     =parseInt($('#pm_compyw1').html());
    var pm_not_compyw1 =parseInt($('#pm_not_compyw1').html());
    var pm_scheduleyw2 =parseInt($('#pm_scheduleyw2').html());
    var pm_compyw2     =parseInt($('#pm_compyw2').html());
    var pm_not_compyw2 =parseInt($('#pm_not_compyw2').html());
    var pm_scheduleyw3 =parseInt($('#pm_scheduleyw3').html());
    var pm_compyw3     =parseInt($('#pm_compyw3').html());
    var pm_not_compyw3 =parseInt($('#pm_not_compyw3').html());
    var pm_scheduleyw4 =parseInt($('#pm_scheduleyw4').html());
    var pm_compyw4     =parseInt($('#pm_compyw4').html());
    var pm_not_compyw4 =parseInt($('#pm_not_compyw4').html());
    var pm_scheduleyw5 =parseInt($('#pm_scheduleyw5').html());
    var pm_compyw5     =parseInt($('#pm_compyw5').html());
    var pm_not_compyw5 =parseInt($('#pm_not_compyw5').html());
    var pm_scheduleyw6 =parseInt($('#pm_scheduleyw6').html());
    var pm_compyw6     =parseInt($('#pm_compyw6').html());
    var pm_not_compyw6 =parseInt($('#pm_not_compyw6').html());
    var pm_scheduleyw7 =parseInt($('#pm_scheduleyw7').html());
    var pm_compyw7     =parseInt($('#pm_compyw7').html());
    var pm_not_compyw7 =parseInt($('#pm_not_compyw7').html());
    var pm_scheduleyw8 =parseInt($('#pm_scheduleyw8').html());
    var pm_compyw8     =parseInt($('#pm_compyw8').html());
    var pm_not_compyw8 =parseInt($('#pm_not_compyw8').html());
    var pm_scheduleyw9 =parseInt($('#pm_scheduleyw9').html());
    var pm_compyw9     =parseInt($('#pm_compyw9').html());
    var pm_not_compyw9 =parseInt($('#pm_not_compyw9').html());
    var pm_scheduleyw10 =parseInt($('#pm_scheduleyw10').html());
    var pm_compyw10     =parseInt($('#pm_compyw10').html());
    var pm_not_compyw10 =parseInt($('#pm_not_compyw10').html());
 

  Highcharts.chart('yearwisecontainer', {
    colors: ['#072ae2','#14e44c','#e20d0d'],
    chart: {
        type: 'column'
    },
    title: {
        text: 'Year Wise PM'
    },
    subtitle: {
        text: ''
    },credits: {
      enabled: false
  },
    xAxis: {
        categories: [
           '2013','2014','2015','2016','2017', '2018','2019','2020','2021','2022'
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
    series: [{
        name: 'PM Schedule',
        data: [pm_scheduleyw1, pm_scheduleyw2,pm_scheduleyw3,pm_scheduleyw4,pm_scheduleyw5,pm_scheduleyw6,pm_scheduleyw7,pm_scheduleyw8,pm_scheduleyw9,pm_scheduleyw10]

    }, {
        name: 'PM done',
        data: [pm_compyw1,pm_compyw2,pm_compyw3,pm_compyw4,pm_compyw5,pm_compyw6,pm_compyw7,pm_compyw8,pm_compyw9,pm_compyw10]

    }, {
        name: 'PM Not Done',
        data: [pm_not_compyw1,pm_not_compyw2,pm_not_compyw3,pm_not_compyw4,pm_not_compyw5,pm_not_compyw6,pm_not_compyw7,pm_not_compyw8,pm_not_compyw9,pm_not_compyw10]

    }]
});
</script>