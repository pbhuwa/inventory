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
 <table class="table table-bordered dataTable tbl_pdf">
     <thead>
         <tr>
            <?php 
            $months=$this->config->item('month');
            // die();
            while($i <= 7):
          $indate->add(new DateInterval('P1D'));
          $genDate = $indate->format('Y/m/d');
          echo "<th colspan=3>".$genDate."<br>".$days[$i-1]."</th>"; 
          $i++;
        endwhile;
        ?>
         </tr>
         <tr>
         <?php
         for ($i=1; $i <=7 ; $i++) { 
         echo "<td>Sched.</td><td>Done</td><td>Not Done</td>"; 
          } 
         ?>
         <tr>

     </thead>
     <tbody>
         <tr>
        <td><span id="pm_schedule1"><?php echo $pm_weekly[0]->not_comp1+ $pm_weekly[0]->comp1; ?></span></td>
        <td><span id="pm_comp1" ><?php echo $pm_weekly[0]->comp1 ?></span></td>
        <td><span id="pm_not_comp1" ><?php echo $pm_weekly[0]->not_comp1 ?></span></td>
        <td><span id="pm_schedule2" ><?php echo $pm_weekly[0]->not_comp2+ $pm_weekly[0]->comp2; ?></span></td>
        <td><span id="pm_comp2" ><?php echo $pm_weekly[0]->comp2 ?></span></td>
        <td><span id="pm_not_comp2" ><?php echo $pm_weekly[0]->not_comp2 ?></span></td>
        <td><span id="pm_schedule3" ><?php echo $pm_weekly[0]->not_comp3+ $pm_weekly[0]->comp3; ?></span></td>
        <td><span id="pm_comp3" ><?php echo $pm_weekly[0]->comp3 ?></span></td>
        <td><span id="pm_not_comp3" ><?php echo $pm_weekly[0]->not_comp3 ?></span></td>
        <td><span id="pm_schedule4" ><?php echo $pm_weekly[0]->not_comp4+ $pm_weekly[0]->comp4; ?></span></td>
        <td><span id="pm_comp4" ><?php echo $pm_weekly[0]->comp4 ?></span></td>
        <td><span id="pm_not_comp4"><?php echo $pm_weekly[0]->not_comp4 ?></span></td>
        <td><span id="pm_schedule5"><?php echo $pm_weekly[0]->not_comp5+ $pm_weekly[0]->comp5; ?></span></td>
        <td><span id="pm_comp5" ><?php echo $pm_weekly[0]->comp5 ?></span></td>
        <td><span  id="pm_not_comp5"><?php echo $pm_weekly[0]->not_comp5 ?></span></td>
        <td><span id="pm_schedule6" ><?php echo $pm_weekly[0]->not_comp6+ $pm_weekly[0]->comp6; ?></span></td>
        <td><span id="pm_comp6" ><?php echo $pm_weekly[0]->comp6 ?></span></td>
        <td><span id="pm_not_comp6" ><?php echo $pm_weekly[0]->not_comp6 ?></span></td>
        <td><span id="pm_schedule7" ><?php echo $pm_weekly[0]->not_comp7+ $pm_weekly[0]->comp7; ?></span></td>
        <td><span id="pm_comp7" ><?php echo $pm_weekly[0]->comp7 ?></span></td>
        <td><span  id="pm_not_comp7"><?php echo $pm_weekly[0]->not_comp7 ?></span></td>
       


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
        text: 'Weekly PM Chart'
    },
    subtitle: {
        text: ''
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