<?php
/************************************************************************************************
  * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS422
* Program Name     : Show Limit Status
* Description      :
* Environment      : PHP 5.4.4
* Author           : Metta Kharisma
* Version          : 01.00.00
* Creation Date    : 17-11-2014 15:08:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
*1					17-11-2014			Metta Kharisma		 Merubah Tampilan
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

    header("Cache-Control: no-cache");
    header("Pragma: no-cache");
//Other page contents that have to be loaded

$dev_mode = false;
?>
<br>
<h4 style ="color:rgb(0,128,0)","text-align:left","font-size: 17px" ><i>Your Limit Status </i><br/>
<p> -------------------------------------------------<br/><br><br>
		
		<table class="table table-striped table-bordered table-hover table-heading no-border-bottom">
		<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="10%">
					<col width="15%">
					<col width="10%">
		</colgroup>
		<thead>
			<tr  >
				<th class="text-center" rowspan="2">No</th>
				<th  class="text-center" rowspan="2" >Type </th>
				<th  class="text-center" rowspan="2">Limit/Periode </th>
				<th class="text-center"  rowspan="2">Left (This Month)</th>
			</tr>
			
		</thead>
		
		<tbody style="height: 10px; overflow: scroll;">
		
				<tr class="active">					
					<td class="text-center">1</td>	
					<td>Annual leave</td>
					<td  class="text-center"><?= $this_leave['cuti'] ?></td>
					<td  class="text-center"><?= $this_leave_left ?></td>
				</tr>
				<tr class="active">					
					<td class="text-center">2</td>	
					<td>Expense Claim Medical</td>
					<td  class="text-center"><?= number_format($this_claim_left['medis_awal'],0,',','.') ?></td>
					<td  class="text-center"><?= number_format($this_claim_left['medis'],0,',','.') ?></td>
				</tr>
				<tr>	
					<td class="text-center">3</td>	
					<td>Expense Claim Telecommunication</td>
					<td  class="text-center"><?= number_format($this_claim_left['transport_awal'],0,',','.') ?></td>
					<td  class="text-center"><?= number_format($this_claim_left['transport'],0,',','.') ?></td>
				</tr>
				<tr>	
					<td class="text-center">4</td>	
					<td>Expense Claim Transportation Allowance</td>
					<td  class="text-center"><?= number_format($this_claim_left['telkom_awal'],0,',','.') ?></td>
					<td  class="text-center"><?= number_format($this_claim_left['telkom'],0,',','.') ?></td>
					
					
				</tr>
			
		</tbody>
	
	</table>
</p>	

</h4>




<script type="text/javascript">
var refresh = false;
	function start_refresh(){
        setTimeout(function () {
            if(!refresh){
                console.log('Leave refreshed on: ' + new Date());
                refreshLeaveLeft();			
                start_refresh();
            }
        },5000);
    }
    function refreshLeaveLeft()
    {
        refresh = true;
        $.ajax({
            url: 'c_oas004/feed_leave_left_counter',
            type: 'POST',
            async : false,
            data: { 'ajax': 1},
            timeout: 10000, //1000ms
            success: function(data) {
            	$('#annual-leave-left').html(data);
                refresh= false;
            },
            error: function(){                      
                refresh= false;
            }
        });
    }
	$(document).ready(function(){
		start_refresh();
	});
</script>