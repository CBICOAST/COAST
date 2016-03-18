<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS004
* Program Name     : Notification Page and Service
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 20-08-2014 23:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>

<!-- row -->
<div class="row">
    <div class="col-md-12">
        <!-- The time line -->
        <ul class="timeline">
            <!-- timeline time label -->

            <?php if(isset($feed_list)){
                    $date_temp = 98;
                    foreach ($feed_list as $key => $feed) {
                        $feed['time'] = date('d F Y', strtotime($feed['time']));
                        if($date_temp != $feed['time']){ 
                            $date_temp = $feed['time']?>
                            <li class="time-label">
                                <span class="bg-green">
                                    <?= $feed['time'] ?>
                                </span>
                            </li>
                    <?php } ?>

                        <li>
                            <div class="timeline-item">
                                <h3 class="timeline-header">
								<?php 
								//ini buat cuti
								if($feed['type_id'] == '1') {?>
								<a href="#"><?= $feed['from_name'] ?></a>
								
								<?php if ($feed['activity_id'] == '3' ){
									echo 'Has cencled ';
								}?>
								<?php if ($feed['activity_id'] != '3' ){?>
									<?= $feed['activity_name'] ?><?php
								}?>
								
								<?php if($feed['activity_id'] == '1' || $feed['activity_id'] == '2') { 
									echo ' your application for  ' ;}								
								
								if($feed['activity_id'] == '0' || $feed['activity_id'] == '3'){ 
									echo' an application for ';}
								?>
								
								<?php echo $feed['type_name'] ;}
								
								
								//ini buat CA

								if($feed['type_id'] == '2') {?>
								<?php if ((($feed['activity_id'] == '1' && $feed['status_id'] == '3') || ($feed['status_id'] == '3' && $feed['activity_id'] == '2')) && $feed['create_name'] == "Nadia Alatas") {?>

								<a href="#"><?= $feed['create_name'] ?></a> <?php echo ' '.$feed['activity_name'].' application for '; ?>
								<a href="#"><?php echo $feed['from_name'];?></a> <?php echo ' '.$feed['type_name'] ;} else{  ?>
								
<a href="#"><?php echo $feed['from_name'];?></a>
								<?php  if ($feed['activity_id'] == '3' || ( $feed['activity_id'] == '11' && $feed['status_id'] != '14')){
									echo 'asks you to '.$feed['activity_name'].'  your application for ';
								}?> 

								<?php  if (  $feed['activity_id'] == '11' && $feed['status_id'] == '14'){
									echo 'asks you to '.$feed['activity_name'].' application for ';
								}?> 

								<?php  if (  $feed['activity_id'] == '12' ||  $feed['activity_id'] == '8'){
									echo $feed['activity_name'].'  application for ';
								}?> 

								<?php  if ($feed['activity_id'] == '6'  && $feed['status_id'] == '9'){
									echo 'done payment ';
								}?> 

									<?php  if ($feed['activity_id'] == '6'  && $feed['status_id'] == '12'){
									echo 'done payment your settlement application for ';
								}?> 

								<?php  if ($feed['activity_id'] == '7'  && $feed['status_id'] == '10'){
									echo 'has submitted settlement aplication for ';
								}?>

								<?php if ( $feed['activity_id'] == '4'){
									echo $feed['activity_name'].'  the application for ';
								}?> 


								<?php if (($feed['activity_id'] == '0' || $feed['activity_id'] == '2' || $feed['activity_id'] == '5'  ||  $feed['activity_id'] == '1' )){
									echo $feed['activity_name'] ;}

												
								if($feed['activity_id'] == '0' || $feed['activity_id'] == '7'  ){ 
									echo' an application for ';}

								if((($feed['activity_id'] == '1' || $feed['activity_id'] == '2') && $feed['status_id'] != '3')  || $feed['activity_id'] == '5' || $feed['activity_id'] == '18'  || $feed['activity_id'] == '9' || $feed['activity_id'] == '10' ||  ($feed['activity_id'] == '6' && $feed['status_id'] == '9' )||  ($feed['activity_id'] == '1' && $feed['status_id'] == '3' )  ){ 
									echo ' your application for ' ;}?> 

								<?php echo $feed['type_name'] ;}}?>


								<!-- Buat Notif Expense Claim -->
								<?if($feed['type_id'] == '5') {
									if($feed['status_id'] != '4' && $feed['status_id']!='12') {?>
										<a href="#"><?= $feed['from_name'] ?> </a>
										
										<!--  Buat Notif Expense ke Requester jika diminta untuk merevisi Claim -->
										<?if ($feed['activity_id'] == '3'){
											echo 'asked you to '. $feed['activity_name'] ;
										}?> 
																				
										<!-- Buat Notif Expense yang diterima Requester kalau Finance Accept / Approval Approve / Finance Checked -->
										<?if($feed['activity_id'] == '1' || $feed['activity_id'] == '5' ||  $feed['activity_id'] == '13'){ echo $feed['activity_name']. ' your application for  ' ;}
										
										// Buat Notif Expense yang diterima approval 
										if($feed['activity_id'] == '0' ){ echo $feed['activity_name'].' an application for ';}
										
										// Buat Notif Expense yang diterima Requester Kalau Finance Not Accepted pengajuan										
										if($feed['activity_id'] == '11' || $feed['activity_id'] == '15'){
											 echo $feed['activity_name'].' your application for ';
										}
										// Buat Notif Expense yang diterima Requester Kalau Finance telah paid expense
										if($feed['activity_id'] == '6'){
											 echo $feed['activity_name'].' your application for ';
										}
										
										
										// Buat Notif Expense yang diterima approval setelah merevisi
										if($feed['activity_id'] == '14' ) {  echo $feed['activity_name'] .' an application for ';} ?>
										
										<?php echo $feed['type_name'] ;
									}
									
									// Buat Expense divisi yg direjek GH
									if(($feed['status_id']=='4' || $feed['status_id']=='12') &&  $feed['activity_id'] == '2') {?>
										<a href="#"><?= $feed['from_name']. "</a> ".$feed['activity_name'] ?>	
										<?php echo ' your application for  '. $feed['type_name'] ;
									}
								}?>
								
								
								<?php //notif PR
								if($feed['type_id'] == '4') {
								if($feed['status_id'] != '4' ){?>
								<a href="#"><?= $feed['from_name'] ?></a>
								<?php if ($feed['activity_id'] == '3'){
									echo 'asked you to';
								}?> 
								<?php if ($feed['activity_id'] == '4' && $feed['status_id'] != '15'){
									echo 'Has';
								}?>
								<?= $feed['activity_name'] ?>
								<?php if($feed['activity_id'] != '0' && $feed['activity_id'] != '4' && $feed['activity_id'] != '6' && $feed['activity_id'] != '7' && $feed['activity_id'] != '8' && $feed['activity_id'] != '11' && $feed['activity_id'] != '12' && ($feed['activity_id'] != '3' && $feed['type_id'] == '1') ||(($feed['activity_id'] == '2'|| $feed['activity_id'] == '5') && $feed['type_id'] == '3') ||($feed['activity_id'] == '5' && $feed['type_id'] == '5')){ echo ' application for your ' ;}
								
								if($feed['activity_id'] == '6' && $feed['status_id'] == '12' ) {echo ' for your settlement of';} 
								if($feed['activity_id'] == '8' || ($feed['activity_id'] != '3' && $feed['type_id'] == '1') || ($feed['activity_id'] == '6' && $feed['status_id'] != '12')  || ($feed['activity_id'] == '4' && $feed['status_id'] == '17') ) {echo ' for your ';} 
								if($feed['activity_id'] == '11'){ echo' your application for ';
								}?>
								<?php if ($feed['status_id'] == '15' || ($feed['status_id'] == '2' && $feed['activity_id'] == '1' )) echo $feed['type_name'].' that You Have Revised'; else echo $feed['type_name'];
								}
								
								if ($feed['status_id'] == '4' )  { ?>
						
								<?php if (($feed['activity_id'] == '1' && $feed['status_id'] == '4')) {?><a href="#"><?= $feed['create_name'] ?></a> <?php echo ' has '. $feed['activity_name'].' '. $feed['type_name'].' '.' from '; }?>
								<a href="#"><?= $feed['from_name'] ?></a>
								<?php }
								
								}?>
																
								<?php //notif PO
								if($feed['type_id'] == '7' ) {?>
								<a href="#"><?= $feed['from_name'] ?></a>
								<?= $feed['activity_name'] ?>
								<?php if($feed['activity_id'] != '0' && $feed['activity_id'] != '4' && $feed['activity_id'] != '6' && $feed['activity_id'] != '7' && $feed['activity_id'] != '8' && $feed['activity_id'] != '11' && $feed['activity_id'] != '12' && $feed['activity_id'] != '16'){ echo ' application for your ' ;}
								if($feed['activity_id'] == '0') {echo ' application for ';}if($feed['activity_id'] == '16') {echo ' That The Vendor Has Accepted The';} 
								?>
								<?php echo $feed['type_name'] ;}
								?>
								
								
								<?php //notif buat BT
								if ($feed['type_id'] == '3' && ($feed['status_id'] != '2' && $feed['status_id'] != '4' && $feed['status_id'] != '7' && $feed['status_id'] != '10') && $feed['activity_id'] != '4'){ ?> <a href="#"><?= $feed['from_name'] ?></a>
								<?= $feed['activity_name'] ?>
								<?php if ($feed['activity_id'] =='0') { echo ' an application for ' ;} 
								if ($feed['activity_id'] =='1' || $feed['activity_id'] =='2'|| $feed['activity_id'] =='5') { echo ' your application for  ' ;}
								?> 
								<?php echo $feed['type_name'] ;}  ?>
								
								<?php if ($feed['type_id'] == '3' && $feed['status_id'] =='2'){ ?> <a href="#"><?= $feed['from_name'] ?></a><?php
								if (($feed['activity_id'] == '10' && $feed['status_id'] == '2')) {?><?php echo ' Has '. $feed['activity_name'].' Your '. $feed['type_name'].' '.' application '; }
								if (($feed['activity_id'] == '0' && $feed['status_id'] == '2')) {?><?php echo '  '. $feed['activity_name'].' an application for '. $feed['type_name'] ; }
								if (($feed['activity_id'] == '4' && $feed['status_id'] == '2')) {?><?php echo ' Has '. $feed['activity_name'].' an application for '. $feed['type_name'] ; }
								}?>
								<?php if ($feed['type_id'] == '3' && $feed['status_id'] =='7'){ ?> <a href="#"><?= $feed['from_name'] ?></a><?php
								if (($feed['activity_id'] == '3' && $feed['status_id'] == '7')){?><?php echo ' Ask You To '. $feed['activity_name'].' Your '. $feed['type_name'].' '.' Application '; }								
								}?>
								<?php if ($feed['type_id'] == '3' && $feed['activity_id'] == '4' && $feed['status_id'] != '2' ){ ?> <a href="#"><?= $feed['from_name'] ?></a><?php
								if (($feed['activity_id'] == '4' && $feed['status_id'] == '0' && $feed['status_id'] != '2')){?><?php echo ' Has '. $feed['activity_name'].'  an application for '. $feed['type_name'] ; }							
								}?>
								<?php if ($feed['type_id'] == '3' && $feed['status_id'] =='10'){ ?> <a href="#"><?= $feed['from_name'] ?></a><?php
								if (($feed['activity_id'] == '3' && $feed['status_id'] == '10')){?><?php echo ' Ask You To '. $feed['activity_name'].' '. $feed['type_name'].' '.' application '; }								
								}?>
								<?php if ($feed['type_id'] == '3' && $feed['status_id'] =='4'){ ?> <a href="#"><?= $feed['from_name'] ?></a><?php
								if (($feed['activity_id'] == '1' && $feed['status_id'] == '4')){?><?php echo ' Not '. $feed['activity_name'].' your application for  '. $feed['type_name']; }								
								}?>
 <?php if ($feed['type_id'] == '3' && $feed['status_id'] =='8'){ ?><?php
								if (($feed['activity_id'] == '4' && $feed['status_id'] == '8')){?><?php echo ' '. $feed['activity_name'].' an application for  '. $feed['type_name']; }								
								}//nambahin 27 okt
//akhir notif BT?>
								
								</h3>
								
                                <div class="timeline-body">
									<?= $feed['info'] ?>
								</div>
								<div class='timeline-footer'>
									<?php if($feed['type_id'] == '5') {
										// link edit expense jika status need to be revise
										if($feed['activity_id'] == '3' && $feed['status_id'] == '7' ){?>
											<a href="#"  title="Revise" onclick="change_page(this, 'c_oas023/load_form_edit/<?= $feed['formid'] ?>')"class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php } 
										
										// Buat link detail notif expense klaim (konfirmasi)
											if ( ($feed['activity_id'] != '1'&&$feed['activity_id'] != '5')  && ( $feed['status_id'] == '1' ||  $feed['status_id'] == '0'||  $feed['status_id'] == '8' || $feed['status_id'] == '11' ||
											($feed['status_id'] == '9' && ($feed['activity_id'] == '0')) && ($feed['activity_id'] != '3'||$feed['activity_id'] == '4') )){?>  
											<a href="#"  title="Konfirmasi" onclick="change_page(this, 'c_oas033/load_form/<?= $feed['formid'] ?>')" class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php } 
										
										// Buat link detail notif expense klaim(lihat detail)
										if (($feed['status_id'] == '2' || $feed['status_id'] == '3' || $feed['status_id'] == '4' ||
										(($feed['status_id'] == '9' && $feed['activity_id'] != '0') || $feed['status_id'] == '10' || $feed['status_id'] == '12'&& ($feed['activity_id'] !== '0'))|| $feed['status_id'] == '6')||($feed['activity_id'] != '0' && ($feed['status_id'] == '1' || $feed['status_id'] == '11'))){?> 
											<a href="#"  title="Detail" onclick="change_page(this, 'c_oas025/load_form/<?= $feed['formid'] ?>')" class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
									} ?>
									
									<?php if($feed['type_id'] == '1') {
										if( $feed['status_id'] == '0'){?>
											<a href="#"  title="Konfirmasi" onclick="change_page(this, 'c_oas012/load_form/<?= $feed['formid'] ?>')"class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
										else {?> 
											<a href="#"  title="Detail &amp; Pembatalan" onclick="change_page(this, 'c_oas014/load_form/<?= $feed['formid'] ?>')" class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
									}?>
									
									<?php //notif buat BT
									if($feed['type_id'] == '3') {
									if($feed['activity_id'] == '3' && $feed['status_id'] == '7' ){?>
											<a href="#"  title="Revise" onclick="change_page(this, 'c_oas037/load_edit_form/<?= $feed['formid'] ?>')"class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php } 
										
										if($feed['activity_id'] =='0' && $feed['status_id'] == '0' ){?>
											<a href="#"  title="Konfirmasi" onclick="change_page(this, 'c_oas057/load_form/<?= $feed['formid'] ?>')"class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
										if(  $feed['activity_id'] == '0' &&  $feed['status_id'] == '1'){?>
											<a href="#"  title="Konfirmasi" onclick="change_page(this, 'c_oas067/load_form/<?= $feed['formid'] ?>')"class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
										if( $feed['activity_id'] == '3' &&  $feed['status_id'] == '10'){?>
											<a href="#"  title="Edit GA" onclick="change_page(this, 'c_oas067/load_form/<?= $feed['formid'] ?>')"class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
										if(  ($feed['activity_id'] == '0' || $feed['activity_id'] == '4' )&&  $feed['status_id'] == '2' || $feed['status_id'] == '8'){?>
											<a href="#"  title="Konfirmasi" onclick="change_page(this, 'c_oas057/load_form/<?= $feed['formid'] ?>')"class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
										if($feed['activity_id'] == '4' &&  $feed['status_id'] == '0'){?>
											<a href="#"  title="Konfirmasi" onclick="change_page(this, 'c_oas057/load_form/<?= $feed['formid'] ?>')"class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
										
										if( $feed['activity_id'] != '0' && $feed['activity_id'] != '3' && $feed['activity_id'] != '4' && $feed['activity_id'] != '7' ){?>
											<a href="#"  title="Detail" onclick="change_page(this, 'c_oas062/load_form/<?= $feed['formid'] ?>')" class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
									}?>
									
									<?php //notif buat CA
									if($feed['type_id'] == '2') {
										if( (($feed['status_id'] == '8' || $feed['status_id'] == '19' ) && $feed['activity_id'] == '4' )|| ($feed['status_id'] == '0' || $feed['status_id'] == '1' || $feed['status_id'] == '2' || $feed['status_id'] == '16')&&  ($feed['activity_id'] == '0' ||$feed['activity_id'] == '4')){?>
											<a href="#"  title="Konfirmasi" onclick="change_page(this, 'c_oas040/load_form/<?= $feed['formid'] ?>')"class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
										if($feed['activity_id'] == '3' && ($feed['status_id'] == '7' || $feed['status_id'] == '18' )) {?>
											<a href="#"  title="Revise" onclick="change_page(this, 'c_oas038/load_edit/<?= $feed['formid'] ?>')" class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
										
										if (( $feed['activity_id'] == '7' &&  $feed['status_id'] == '10' )||( $feed['activity_id'] == '12' &&  $feed['status_id'] == '15' )){?> 
											<a href="#"  title="Konfirmasi Settle" onclick="change_page(this, 'c_oas052/load_form/<?= $feed['formid'] ?>')" class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
										
										if ( $feed['activity_id'] == '11' &&  $feed['status_id'] == '14' ){?> 
											<a href="#"  title="Revise Settle" onclick="change_page(this, 'c_oas039/load_edit/<?= $feed['formid'] ?>')" class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
										
										if ( ($feed['activity_id'] == '8' || $feed['activity_id'] == '6' ) && ( $feed['status_id'] == '11' ||  $feed['status_id'] == '15' ||  $feed['status_id'] == '12'|| $feed['status_id'] == '9' )){?> 
											<a href="#"  title="Detail" onclick="change_page(this, 'c_oas041/load_form/<?= $feed['formid'] ?>/1')" class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
										
										if (($feed['activity_id'] == '0' &&  $feed['status_id'] == '3' ) ||($feed['status_id'] == '1' ||  $feed['status_id'] == '2' ||  $feed['status_id'] == '16' || ($feed['status_id'] == '9' && $feed['activity_id'] != '6') || $feed['status_id'] == '3' || $feed['status_id'] == '4' || $feed['status_id'] == '5' || $feed['status_id'] == '6' || $feed['status_id'] == '17')&& ($feed['activity_id'] != '0' && ($feed['status_id'] != '2' || $feed['status_id'] != '1' ))){?> 
											<a href="#"  title="Detail" onclick="change_page(this, 'c_oas041/load_form/<?= $feed['formid'] ?>/1')" class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
									  } ?>
									  
									  <?php //notif buat PR
									if($feed['type_id'] == '4') {
										if( ($feed['status_id'] == '0' || $feed['status_id'] == '1' || ($feed['status_id'] == '2' && $feed['activity_id'] == '4' )|| $feed['status_id'] == '11' || $feed['status_id'] == '17' || $feed['status_id'] == '3') &&  ($feed['activity_id'] == '0' || $feed['activity_id'] == '4') ){?>
											<a href="#"  title="Konfirmasi" onclick="change_page(this, 'c_oas071/load_form/<?= $feed['formid'] ?>')"class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
									if($feed['status_id'] == '14'){?>
											<a href="#"  title="Revise" onclick="change_page(this, 'c_oas071/load_form/<?= $feed['formid'] ?>')"class="btn btn-warning btn-xs">View   details . . .</a>
										<?php }
										
										if (($feed['status_id'] == '1' ||  ($feed['activity_id'] != '4' && $feed['status_id'] != '2')||  $feed['status_id'] == '8' ||  $feed['status_id'] == '11' || ($feed['status_id'] == '9' && $feed['activity_id'] != '6') || $feed['status_id'] == '3'|| $feed['status_id'] == '5' || $feed['status_id'] == '6')&& ($feed['activity_id'] != '0' && ($feed['status_id'] != '2' || $feed['status_id'] != '1' || $feed['status_id'] == '15' || $feed['status_id'] == '18' || $feed['status_id'] != '17'))){?> 
											<a href="#"  title="Detail" onclick="change_page(this, 'c_oas092/load_form/<?= $feed['formid'] ?>')" class="btn btn-warning btn-xs">View   details . . .</a>
										<?php }
							if ($feed['from_name'] != $feed['target_id'] && $feed['status_id'] == '4' && $feed['activity_id'] == '1'){?> 
											<a href="#"  title="Detail" onclick="change_page(this, 'c_oas092/load_form/<?= $feed['formid'] ?>')" class="btn btn-warning btn-xs">View details . . .</a>
										<?php }
							if ($feed['from_name'] != $feed['target_id'] && $feed['status_id'] == '15' && $feed['activity_id'] == '1'){?> 
											<a href="#"  title="Detail" onclick="change_page(this, 'c_oas092/load_form/<?= $feed['formid'] ?>')" class="btn btn-warning btn-xs">View details . . .</a>
										<?php }			
									  } ?>
									  
							<?php //notif buat PO
									if($feed['type_id'] == '7') {
										if(($feed['status_id'] == '0' &&  ($feed['activity_id'] == '0' || $feed['activity_id'] == '5'))){?>
											<a href="#"  title="Konfirmasi" onclick="change_page(this, 'c_oas079/load_form/<?= $feed['formid'] ?>')"class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
										
										if (($feed['status_id'] == '1' || $feed['status_id'] == '2' || $feed['status_id'] == '3' && ($feed['activity_id'] == '5' || $feed['activity_id'] == '2' || $feed['activity_id'] == '13'))){?> 
											<a href="#"  title="Detail" onclick="change_page(this, 'c_oas080/load_form/<?= $feed['formid'] ?>')" class="btn btn-warning btn-xs">View   detail . . .</a>
										<?php }
										
									  } ?>
									  
								</div>
                            </div>
                        </li>

                <?php }
                }
				else{ ?>
					<li>
						<div class="timeline-item">
                            <div class="timeline-body">
                               There are no new notification
                            </div>
                            <div class='timeline-footer'>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            <li>
                <i class="fa fa-clock-o"></i>
            </li>
        </ul>
    </div><!-- /.col -->
</div><!-- /.row -->