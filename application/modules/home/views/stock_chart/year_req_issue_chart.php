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
         
            <th colspan="2">Shrawan</th>
            <th colspan="2">Bhadra</th>
            <th colspan="2">Ashoj</th>
            <th colspan="2">Kartik</th>
            <th colspan="2">Mangsir</th>
            <th colspan="2">Poush</th>
            <th colspan="2">Magh</th>
            <th colspan="2">Falgun</th>
            <th colspan="2">Chaitra</th>
            <th colspan="2">Baisakh</th>
            <th colspan="2">Jesth</th>
            <th colspan="2">Ashar</th>
        
         </tr>
         <tr>
         <?php
         for ($i=1; $i <=12 ; $i++) { 
         echo "<td class='req'>Req</td><td class='iss'>Issue</td>"; 
          } 
         ?>
         <tr>

    </thead>
    <tbody>
        <tr>
  
        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt1; ?>' data-month='4' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Shrawan Req'; ?>' data-pmcat='req' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyr1" > <?php echo $req_iss_year[0]->reqcnt1 ?></span></a>

        </td>
        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt1; ?>' data-month='4' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Shrawan Issue'; ?>' data-pmcat='issue' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="isscntyr1"><?php echo $req_iss_year[0]->isscnt1 ?></span></a>

        </td>


        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt2; ?>' data-month='5' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Bhadra Req'; ?>' data-pmcat='req' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyr2" > <?php echo $req_iss_year[0]->reqcnt2 ?></span></a>
        </td>

        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt2; ?>' data-month='5' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Bhadra Issue'; ?>' data-pmcat='issue' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="isscntyr2"><?php echo $req_iss_year[0]->isscnt2 ?></span></a>
        </td>

        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt3; ?>' data-month='6' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Ashoj Req'; ?>' data-pmcat='req' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyr3" > <?php echo $req_iss_year[0]->reqcnt3 ?></span></a>
        </td>

        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt3; ?>' data-month='6' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Ashoj Issue'; ?>' data-pmcat='issue' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="isscntyr3"><?php echo $req_iss_year[0]->isscnt3 ?></span></a>

        </td>

        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt4; ?>' data-month='7' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Kartik Req'; ?>' data-pmcat='req' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyr4" > <?php echo $req_iss_year[0]->reqcnt4 ?></span></a>
        </td>

        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt4; ?>' data-month='7' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Kartik Issue'; ?>' data-pmcat='issue' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="isscntyr4"><?php echo $req_iss_year[0]->isscnt4 ?></span></a>
        </td>

        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt5; ?>' data-month='8' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Mangsir Req'; ?>' data-pmcat='req' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyr5" > <?php echo $req_iss_year[0]->reqcnt5 ?></span></a>

        </td>

        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt5; ?>' data-month='8' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Mangsir Issue'; ?>' data-pmcat='issue' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="isscntyr5"><?php echo $req_iss_year[0]->isscnt5 ?></span></a>

        </td>

        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt6; ?>' data-month='9' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Poush Req'; ?>' data-pmcat='req' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyr6" > <?php echo $req_iss_year[0]->reqcnt6 ?></span></a>

        </td>

        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt6; ?>' data-month='9' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Poush Issue'; ?>' data-pmcat='issue' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="isscntyr6"><?php echo $req_iss_year[0]->isscnt6 ?></span></a>

        </td>

        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt7; ?>' data-month='10' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Magh Req'; ?>' data-pmcat='req' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyr7" > <?php echo $req_iss_year[0]->reqcnt7 ?></span></a>

        </td>

        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt7; ?>' data-month='10' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Magh Issue'; ?>' data-pmcat='issue' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="isscntyr7"><?php echo $req_iss_year[0]->isscnt7 ?></span></a>

        </td>

        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt8; ?>' data-month='11' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Falgun Req'; ?>' data-pmcat='req' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyr8" > <?php echo $req_iss_year[0]->reqcnt8 ?></span></a>

        </td>

        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt8; ?>' data-month='11' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Falgun Issue'; ?>' data-pmcat='issue' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="isscntyr8"><?php echo $req_iss_year[0]->isscnt8 ?></span></a>

        </td>

        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt9; ?>' data-month='12' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Chaitra Req'; ?>' data-pmcat='req' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyr9" > <?php echo $req_iss_year[0]->reqcnt9 ?></span></a>
        </td>

        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt9; ?>' data-month='12' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Chaitra Issue'; ?>' data-pmcat='issue' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="isscntyr9"><?php echo $req_iss_year[0]->isscnt9 ?></span></a>
        </td>

        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt10; ?>' data-month='1' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Baisakh Req'; ?>' data-pmcat='req' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyr10" > <?php echo $req_iss_year[0]->reqcnt10 ?></span></a>
        </td>

        <td>
             <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt10; ?>' data-month='1' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Baisakh Issue'; ?>' data-pmcat='issue' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="isscntyr10"><?php echo $req_iss_year[0]->isscnt10 ?></span></a>

        </td>

         <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt11; ?>' data-month='2' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Jestha Req'; ?>' data-pmcat='req' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyr11" > <?php echo $req_iss_year[0]->reqcnt11 ?></span></a>
        </td>

        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt11; ?>' data-month='2' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Jestha Issue'; ?>' data-pmcat='issue' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="isscntyr11"><?php echo $req_iss_year[0]->isscnt11 ?></span>
        </td>

        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt12; ?>' data-month='3' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Asar Req'; ?>' data-pmcat='req' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span id="reqcntyr12" > <?php echo $req_iss_year[0]->reqcnt12 ?></span></a>
        </td>

        <td>
            <a href="javascript:void(0)" class="btnpmdata" data-pmcount='<?php echo $req_iss_year[0]->isscnt12; ?>' data-month='3' data-year='<?php echo CURYEAR; ?>' data-type='pm_year' data-title='<?php echo CURYEAR.'-'.'Asar Issue'; ?>' data-pmcat='issue' data-url='<?php echo base_url('home/req_iss_detail'); ?>'><span  id="isscntyr12"><?php echo $req_iss_year[0]->isscnt12 ?></span></a>
        </td>

        <tr>
    </tbody>
</table>
</div>
<div id="yearcontainer" style="min-width: 310px; height: 400px; margin: 0 auto">

</div>
<script type="text/javascript">
    var reqcntyr1     =parseInt($('#reqcntyr1').html());
    var isscntyr1 =parseInt($('#isscntyr1').html());
    var reqcntyr2     =parseInt($('#reqcntyr2').html());
    var isscntyr2 =parseInt($('#isscntyr2').html());
    var reqcntyr3     =parseInt($('#reqcntyr3').html());
    var isscntyr3 =parseInt($('#isscntyr3').html());
    var reqcntyr4     =parseInt($('#reqcntyr4').html());
    var isscntyr4 =parseInt($('#isscntyr4').html());
    var reqcntyr5     =parseInt($('#reqcntyr5').html());
    var isscntyr5 =parseInt($('#isscntyr5').html());
    var reqcntyr6     =parseInt($('#reqcntyr6').html());
    var isscntyr6 =parseInt($('#isscntyr6').html());
    var reqcntyr7     =parseInt($('#reqcntyr7').html());
    var isscntyr7 =parseInt($('#isscntyr7').html());
    var reqcntyr8     =parseInt($('#reqcntyr8').html());
    var isscntyr8 =parseInt($('#isscntyr8').html());
    var reqcntyr9     =parseInt($('#reqcntyr9').html());
    var isscntyr9 =parseInt($('#isscntyr9').html());
    var reqcntyr10     =parseInt($('#reqcntyr10').html());
    var isscntyr10 =parseInt($('#isscntyr10').html());
    var reqcntyr11     =parseInt($('#reqcntyr11').html());
    var isscntyr11 =parseInt($('#isscntyr11').html());
    var reqcntyr12     =parseInt($('#reqcntyr12').html());
    var isscntyr12 =parseInt($('#isscntyr12').html());

  Highcharts.chart('yearcontainer', {
    colors: ['#e20d0d','#14e44c'],
    chart: {
        type: 'column'
    },
    title: {
        text: 'This Year Req/ Chart'
    },
    subtitle: {
        text: ''
    },credits: {
      enabled: false
  },
    
    xAxis: {
        categories: [
            'Shrawan',
            'Bhadra',
            'Ashoj',
            'Kartik',
            'Mangsir',
            'Poush',
            'Magh',
            'Falgun',
            'Chaitra',
            'Baisakh',
            'Jesth',
            'Asar',
            
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
    series: [{
        name: 'Requisition',
        data: [reqcntyr1,reqcntyr2,reqcntyr3,reqcntyr4,reqcntyr5,reqcntyr6,reqcntyr7,reqcntyr8,reqcntyr9,reqcntyr10,reqcntyr11,reqcntyr12]

    }, {
        name: 'Issue',
        data: [isscntyr1,isscntyr2,isscntyr3,isscntyr4,isscntyr5,isscntyr6,isscntyr7,isscntyr8,isscntyr9,isscntyr10,isscntyr11,isscntyr12]

    }]
});
</script>