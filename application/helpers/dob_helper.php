<?php
//drop down for the year

function YearDropDown($name,$start_year,$end_year,$selected_value) 
{ 
	  echo "<select name=\"$name\" class='dob_y'>\n";
	echo "<option value='0'>Year:</option>";
   for ($j = $end_year; $j > $start_year; $j--) {
      
	?>
		<option value="<?=$j;?>" <? if($j==$selected_value) echo"Selected"; ?>><?=$j;?></option>
	<?  
   }
   echo "</select>\n";
}

//drop down for the month
function MonthDropDown($name,$selected_value) 
{
	  echo "<select name=\"$name\" class='dob_y'>\n";
	echo "<option value='0'>Month:</option>";
   for ($j = 1; $j <= 12; $j++) {
      
	?>
		<option value="<?=date("m", mktime(0, 0, 0, $j, 1, 2000))?>" <? if($j==$selected_value) echo"Selected"; ?>><?=date("M", mktime(0, 0, 0, $j, 1, 2000))?></option>
	<?  
   }
   echo "</select>\n";
}
//drop down for the day
function DayDropDown($name,$selected_value) 
{
	  echo "<select name=\"$name\" class='dob_y'>\n";
	echo "<option value='0'>Day:</option>";
   for ($j = 1; $j <= 31; $j++) {
      
	?>
		<option value="<?=date("d", mktime(0, 0, 0, 1, $j, 2000))?>" <? if($j==$selected_value) echo"Selected"; ?>><?=date("d", mktime(0, 0, 0, 1, $j, 2000))?></option>
	<?  
   }
   echo "</select>\n";
}
?>