<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Pak Riza
* Program Id       : APPROVAL_PERIODE
* Program Name     : List Timesheet
* Description      : Halaman Daftar Timesheet per-Periode Yang diajukan oleh resource untuk disetujui
* Environment      : PHP 5.4.4
* Author           : Abi Sa'ad Dimyati
* Version          : 01.00.00
* Creation Date    : 07-03-2016 11:10:00
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>
<div class="box-content no-padding">
    <div class="search-fields bs-callout list-title">
		<h2><b>Timeshet List Per-Periode</b></h2>
		<div style="height:100%;
					
					padding-top: 10px;
					padding-left: 15px;
                                        padding-bottom: 0px;">
                    
                </div>
               
    </div>
    
    <table class="table table-striped table-bordered table-hover table-heading no-border-bottom" id="timesheet_periode">
                    
                <thead>
			<tr>
                            <th width="5" class="text-center">No</th>
				<th class="text-center">Timesheet Periode</th>
                               
			</tr>
		</thead>
                <tbody>
                    <?php
                    if (sizeof($periode)<=0){
                    	echo "<tr class='Approved'>";
                    	echo "<td class='text-center' colspan='3'>Data Not Found</td>";
                    	echo "</tr>";
                    }else{
                    	$idx=0;
                    	foreach ($periode as $key => $value) {
                    		$idx++;
                    		 
                    		echo "<tr class='Approved'>";
                    		echo "<td class='text-center'>".$idx."</td>";
                    		echo "<td ><a href=\"#\" title=\"Detail\" onclick=\"change_page(this, 'c_resource_timesheet/approve_pmo_emp/".$value['date_period']."')\"><b>".$value['char_period']."<b></a></td>";
                    		echo "</tr>";
                    		 
                    	}
                    }

                    
                    ?>
                </tbody>
                </table>
    
</div>