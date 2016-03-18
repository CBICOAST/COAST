<?php 
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS010
* Program Name     : Daftar Tipe Cuti
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ritman Sigit K
* Version          : 01.00.00
* Creation Date    : 19-08-2014 23:34:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/
?>
<script type="text/javascript">
	var form_url = "c_oas011/load_form/";
</script>
					<!-- TO DO List -->
                    <div class="box box-primary leave-type-list">
                        <div class="box-header">
                            <i class="ion ion-clipboard"></i>
                            <h3 class="box-title">List Of Leave Type</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
								<ul class="todo-list">
								<?php foreach($data as $cuti){ ?>
									<li onclick="change_page(this, form_url+'<?= $cuti['LEAVE_TYPE_ID'] ?>')">
										<!-- drag handle -->
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>  
										<!-- Emphasis label -->
										<small class="label label-primary hastooltip">
											<div>
												<?php
													echo $cuti['LEAVE_TYPE_DESCRIPTION'];
												?>
											</div>
											<i class="fa fa-info"></i>
										</small>
										<!-- todo text -->
										<span class="text"> <?php
															echo $cuti['LEAVE_TYPE_NAME'];
															?>
										</span>
									</li>
							<?php } ?>	
							</ul>
						</div>
					</div>