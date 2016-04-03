<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Pak Riza
* Program Id       : RESOURCE_TIMESHEET
* Program Name     : List Timesheet
* Description      : Daftar Timesheet yang akan terisi oleh resource
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
		<h2><b>Timeshet List</b></h2>
		<div style="height:100%;
					
					padding-top: 10px;
					padding-left: 15px;
                                        padding-bottom: 0px;">
                    
                </div>
               
    </div>
    <div class="text-center" id="validasi-form" style="background-color: #f2dede;border: 1px solid #ccc;color: red;margin-bottom: 2px;display: none;padding: 6px 6px 6px 6px;">Data Can't be Saved (the required data is not complete)</div>
     <div>
        <button class="btn btn-primary"  onclick="form_new_timesheet('Create New Timesheet Periode','c_resource_timesheet/form_new_timesheet')"><i class="fa fa-plus-square-o fa-lg"></i> Add Timesheet</button>
        </div>
    <table class="table table-striped table-bordered table-hover table-heading no-border-bottom" id="timesheet_periode">
                    
                <thead>
			<tr>
                            <th width="5" class="text-center">No</th>
				<th class="text-center">Timesheet Periode</th>
                                <th width="50" class="text-center">.:::.</th>
			</tr>
		</thead>
                <tbody>
                    <?php
                    $idx=0;
                    foreach ($periode as $key => $value) {
                        $idx++;
                        echo "<tr class='Approved'>";
                        echo "<td class='text-center'>".$idx."</td>";
                        echo "<td ><a href=\"#\" title=\"Detail\" onclick=\"change_page(this, 'c_resource_timesheet/load_timesheet_periode/".$value['date_period']."/".$employee_id."/resource')\"><b>".$value['char_period']."</b></a></td>";
                        echo "<td class=\"text-center\"><a class='btn btn-danger btn-xs' onclick=\"delete_periode('c_resource_timesheet/delete_periode','".$value['date_period']."')\"><i class='fa fa-times'></i>Delete</a></td>";
                        echo "</tr>";
     }
                    
                    ?>
                </tbody>
                </table>
    
</div>