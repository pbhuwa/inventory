		<table width="100%" style="font-size:12px;">
		         <tr>
		          <td></td>
		          <td class="web_ttl text-center" style="text-align:center;"><h2><?php echo ORGA_NAME; ?></h2></td>
		          <td></td>
		        </tr>
		        <tr class="title_sub">
		          <td></td>
		          <td style="text-align:center;"><?php echo ORGA_ADDRESS1.','.ORGA_ADDRESS2 ?></td>
		          <td style="text-align:right; font-size:10px;">Date/Time: <?php echo CURDATE_NP ?> BS,</td>
		        </tr> 
		         <tr class="title_sub">
		          <td></td>
		          <td style="text-align:center;"><b style="font-size:15px;">
		          	Req Analysis</b></td>
		          <td style="text-align:right; font-size:10px;"><?php echo CURDATE_EN ?> AD </td>
		        </tr>
		        <tr class="title_sub">
		          <td width="200px"></td>
		          <td style="text-align:center;"><b></b></td>
		          <td width="200px" style="text-align:right; font-size:10px;"><?php echo $this->general->get_currenttime(); ?> </td>
		        </tr> 
		      </table>
