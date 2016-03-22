<?php
/************************************************************************************************
 * Program History :
*
* Project Name     : OAS
* Client Name      : CBI - Muhammad
* Program Id       : OAS002
* Program Name     : Main Frame
* Description      :
* Environment      : PHP 5.4.4
* Author           : Ahmad Nabili
* Version          : 01.00.00
* Creation Date    : 15-08-2014 11:03:00 ICT 2014
*
* Update history     Re-fix date       Person in charge      Description
* 
*
* Copyright(C) [..]. All Rights Reserved
*************************************************************************************************/

    header("Cache-Control: no-cache");
    header("Pragma: no-cache");
//Other page contents that have to be loaded

$dev_mode = false;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>

        <title>Please Wait...</title>
        <!-- <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'> -->
        <!-- bootstrap 3.0.2 -->
         <link href="<?php echo css_url();?>bootstrap.min.css" rel="stylesheet" type="text/css" /> 
       
         <style type="text/css">
             .activeClassdt{
   	background: #F00; 
        border-radius: 0px;
       color: #ECE9D8;
  }
         </style>

        <!-- Zebra Dialog -->
        <link rel="stylesheet" href="<?php echo css_url();?>zebra_dialog/default/zebra_dialog.css" type="text/css">
        <!-- <link rel="stylesheet" href="<?php echo css_url();?>zebra_dialog/flat/zebra_dialog.css" type="text/css"> -->
        <!-- font Awesome -->
        <link href="<?php echo css_url();?>font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo css_url();?>ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- mCustomScrollbar -->
        <!-- <link href="<?php echo css_url();?>mCustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" /> -->
        
        <!-- datepick -->
        <link href="<?php echo css_url();?>datepick/jquery.datepick.css" rel="stylesheet" type="text/css" />
        
        <!-- Theme style -->
        <link href="<?php echo css_url();?>AdminLTE.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo css_url();?>remodal/remodal.css">
        <link rel="stylesheet" href="<?php echo css_url();?>remodal/remodal-default-theme.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue fixed">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url();?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <!-- PT Cybertrend Intra -->
                <img src="<?php echo img_url();?>logo.png">
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <!-- <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a> -->
                <div class="title">CYBERTREND OFFICE AUTOMATION SYSTEM</div>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <!-- <a href="#" class="dropdown-toggle"> -->
                            <a href="#" id="notification" url="c_oas004/load_view" tabtitle="Notification">
                                <i class="fa fa-bell"></i>
                                <span class="label label-danger notification-counter"></span>
                            </a>
                        </li>
                        
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- <i class="glyphicon glyphicon-user"></i> -->
                                <span><?php if($this_group == "1" ) echo '<i>[Admin]</i>'; ?> <?= $this_name ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <!-- <img src="img/avatar3.png" class="img-circle" alt="User Image" /> -->
                                    <p>
                                        <?= $this_name ?>
                                        <small>Level: <?= $this_level['name'] ?></small>
                                        <small>Reporting Manager: <?php if( $this_rm['name']) echo  $this_rm['name']; else echo "-"; ?></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat" onclick="form_dialog('USER SETTING', 'c_oas018/load_view')">User Setting</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-default btn-flat"
                                            onclick="window.location.href = 'Login/do_the_logout' ">Log out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebarr-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" id="all_menu">
                        <li>
                            <a href="#" id="notification" url="c_oas004/load_view" tabtitle="Notification">
                                <i class="fa fa-dashboard"></i> <span>Notification</span>
                                <small class="badge pull-right bg-red notification-counter"></small>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="caltab" url="c_oas020/load_calendar" tabtitle="Leave Calendar">
                                <i class="fa fa-calendar"></i> <span>Leave Calendar</span>
                            </a>
                        </li>
						
						<?php
                                                if($this_posisi!='FA' && $this_posisi!='HRGA' && $this_posisi!='OPERATION')
                                                    {
                                                       echo"<li>";
                                                       echo"<a href=\"#\" id=\"caltab\" url=\"C_MANAGE_SALES/load_view/\" tabtitle=\"Leave Calendar\">";
                                                       echo"<i class=\"fa fa-file\"></i> <span>RLT</span>";
                                                       echo"</a>";
                                                       echo"</li>";    
                                                     }
                                                if($this_posisi!='FA' && $this_posisi!='HRGA' && $this_posisi!='OPERATION')
                                                    {
                                                       echo"<li>";
                                                       echo"<a href=\"#\" id=\"caltab\" url=\"c_resource_timesheet/load_view\" tabtitle=\"Unfilled Timesheet\">";
                                                       echo"<i class=\"fa fa-clock-o\"></i> <span>Timesheet</span>";
                                                       echo"</a>";
                                                       echo"</li>";    
                                                     }
                                                if($this_posisi!='FA' && $this_posisi!='HRGA' && $this_posisi!='OPERATION')
                                                    {
                                                       echo"<li>";
                                                       echo"<a href=\"#\" id=\"caltab\" url=\"c_pmo_timesheet/load_view\" tabtitle=\"PMO Timesheet\">";
                                                       echo"<i class=\"fa fa-clock-o\"></i> <span>PMO Timesheet</span>";
                                                       echo"</a>";
                                                       echo"</li>";    
                                                     }
                                                     
						if(($this_superAdmin['id'] != $this_id)){
							if(isset($menu_list)){
								foreach ($menu_list as $key => $menu) {
									if($menu['TYPE']=='3' && (($menu['div_id'] == 'RESOURCING' && $menu['posdeph'] == '4') || ($menu['group_id'] == 'CONSULTANT' && $menu['posdeph'] == '2'))  && $menu['PRIV_CA']=='1'){ ?>
										<li>
											<a href="#" id="tab-side<?= $menu['MENU_ID'] ?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
									<?php }
										if($menu['TYPE']=='3' && ($menu['div_id'] == 'HRGA' && $menu['posdeph'] == '5' && $menu['adminid'] == '1')  && $menu['PRIV_CA']=='2'){ ?>
										<li>
											<a href="#" id="tab-side<?= $menu['MENU_ID'] ?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
									<?php }
									elseif($menu['TYPE']=='3'  && $menu['PRIV_CA']=='0'){ ?>
										<li>
											<a href="#" id="tab-side<?= $menu['MENU_ID'] ?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
									<?php }
									elseif($menu['TYPE']=='1' && $menu['PRIV_CA']!='6' ){?>
										<li class="title">
											<span><i class="<?= $menu['MENU_ICON'] ?>"></i><?= $menu['MENU_TITLE'] ?></span>
										</li>
									<?php }
									elseif($menu['TYPE']=='1' && $menu['div_id'] == 'FA' && $menu['PRIV_CA']=='6' ){?>
										<li class="title">
											<span><i class="<?= $menu['MENU_ICON'] ?>"></i><?= $menu['MENU_TITLE'] ?></span>
										</li>
									<?php }
									elseif( $menu['div_id'] == 'FA' && $menu['TYPE']=='2' && $menu['PRIV_CA']=='0' ){?>
										<li class="subtitle">
											<a href="#" id="tab-side<?= $menu['MENU_ID']?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
									<?php }
									elseif( $menu['div_id'] == 'FA' && $menu['TYPE']=='2' && $menu['PRIV_CA']=='1' ){?>
										<li class="subtitle">
											<a href="#" id="tab-side<?= $menu['MENU_ID']?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
									<?php }
									elseif( $menu['div_id'] == 'FA' && $menu['TYPE']=='2' && $menu['PRIV_CA']=='3' ){?>
										<li class="subtitle">
											<a href="#" id="tab-side<?= $menu['MENU_ID']?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
									<?php }
									elseif( $menu['div_id'] == 'FA' && $menu['TYPE']=='2' && $menu['PRIV_CA']=='4' ){?>
										<li class="subtitle">
											<a href="#" id="tab-side<?= $menu['MENU_ID']?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
									<?php }
									elseif( $menu['div_id'] == 'FA' && $menu['TYPE']=='2' && $menu['PRIV_CA']=='6' ){?>
										<li class="subtitle">
											<a href="#" id="tab-side<?= $menu['MENU_ID']?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
									<?php }
									elseif( $menu['privi_ca'] == '1' && $menu['TYPE']=='2' && $menu['PRIV_CA']=='0' ){?>
										<li class="subtitle">
											<a href="#" id="tab-side<?= $menu['MENU_ID']?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
									<?php }
									elseif( ($menu['privi_ca'] == '1' || $menu['posdeph'] <= '2') && $menu['TYPE']=='2' && $menu['PRIV_CA']=='1' ){?>
									<li class="subtitle">
										<a href="#" id="tab-side<?= $menu['MENU_ID']?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
											<i class="<?= $menu['MENU_ICON'] ?>"></i></i> <span><?= $menu['MENU_TITLE'] ?></span>
										</a>
									</li>
								<?php }
									elseif( $menu['privi_ca'] == '0' && $menu['TYPE']=='2'  && $menu['PRIV_CA']=='2' ){?>
										<li class="subtitle">
											<a href="#" id="tab-side<?= $menu['MENU_ID']?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
									<?php }
										elseif( $menu['privi_ca'] == '0' && $menu['TYPE']=='2'  && $menu['PRIV_CA']=='0' ){?>
										<li class="subtitle">
											<a href="#" id="tab-side<?= $menu['MENU_ID']?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
										
									<?php }
									
									elseif( $menu['privi_pr'] == '1' && $menu['TYPE']=='2'  && $menu['PRIV_CA']=='3' ){?>
										<li class="subtitle">
											<a href="#" id="tab-side<?= $menu['MENU_ID']?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
										
									<?php }
									elseif( $menu['privi_pr'] == '1' && $menu['TYPE']=='2'  && $menu['PRIV_CA']=='0' ){?>
										<li class="subtitle">
											<a href="#" id="tab-side<?= $menu['MENU_ID']?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
										
									<?php }
									elseif( $menu['privi_pr'] == '0' && $menu['TYPE']=='2'  && $menu['PRIV_CA']=='0' ){?>
										<li class="subtitle">
											<a href="#" id="tab-side<?= $menu['MENU_ID']?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
												<i class="<?= $menu['MENU_ICON'] ?>"></i></i> <span><?= $menu['MENU_TITLE'] ?></span>
											</a>
										</li>
										
									<?php }
									
									
									?>
								<?php }
								}
								}
							else if(($this_superAdmin['id'] == $this_id)){
							if(isset($menu_superAdmin)){
								foreach ($menu_superAdmin as $key => $menu) {?>
								<?if($menu['TYPE']=='3'){?>
									<li>
                                       <a href="#" id="tab-side<?= $menu['MENU_ID'] ?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>"><i class="<?= $menu['MENU_ICON'] ?>"></i><span><?= $menu['MENU_TITLE'] ?></span></a>
									</li>
								<?php }?>
								<?if($menu['TYPE']=='1'){?>
									<li class="title">
                                        <span><i class="<?= $menu['MENU_ICON'] ?>"></i><?= $menu['MENU_TITLE'] ?></span>
									</li>
								<?php }?>
							<?if($menu['TYPE']!='1' && $menu['TYPE']!='3'){?>
								<li class="subtitle">
										<a href="#" id="tab-side<?= $menu['MENU_ID']?>" url="<?= $menu['URL'] ?>" tabtitle="<?= $menu['MENU_TITLE'] ?>">
											<i class="<?= $menu['MENU_ICON'] ?>"></i></i> <span><?= $menu['MENU_TITLE'] ?></span>
										</a>
									</li>
						<?	}}}}?>
						</ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navtab and content of the page -->
			<aside class="right-side">
                <div class="nav-tabs-custom">
                    <ul id="pageTab" class="nav nav-tabs">
                        <li class="active"><a href="#welcome-tab" id="tabPane-welcome-tab" data-toggle="tab">Welcome Page</a></li>
                    </ul>
                    <div id="pageTabContent" class="tab-content">
                        <div class="tab-pane active fade in" id="welcome-tab">
                            Please wait...
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div><!-- nav-tabs-custom -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <div data-remodal-id="modal">
  <button data-remodal-action="close" class="remodal-close"></button>
  <h1>Remodal</h1>
  <p>
    Responsive, lightweight, fast, synchronized with CSS animations, fully customizable modal window plugin with declarative configuration and hash tracking.
  </p>
</div>


        <!-- jQuery 2.0.2 -->
        <script src="<?php echo js_url();?>jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="<?php echo js_url();?>jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Zebra Dialog -->
        <script type="text/javascript" src="<?php echo js_url();?>plugins/zebra_dialog/zebra_dialog.js"></script>
        <!-- Bootstrap -->
        <!--  <script src="<?php echo js_url();?>bootstrap.min.js" type="text/javascript"></script> -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        
        <script type="text/javascript" src="<?php echo js_url();?>plugins/select2/select2.min.js"></script>
        <!-- Morris.js charts -->
        <!-- <script src="<?php echo js_url();?>raphael-min.js"></script> -->
        <!-- <script src="<?php echo js_url();?>plugins/morris/morris.min.js" type="text/javascript"></script> -->
        <!-- Sparkline -->
        <!-- <script src="<?php echo js_url();?>plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script> -->
        <!-- jvectormap -->
        <!-- <script src="<?php echo js_url();?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script> -->
        <!-- <script src="<?php echo js_url();?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script> -->
        <!-- fullCalendar -->
        <!-- <script src="<?php echo js_url();?>plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script> -->
        <!-- jQuery Knob Chart -->
        <!-- <script src="<?php echo js_url();?>plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script> -->
        <!-- Bootstrap WYSIHTML5 -->
        <!-- <script src="<?php echo js_url();?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script> -->
        <!-- iCheck -->
        <!-- <script src="<?php echo js_url();?>plugins/iCheck/icheck.min.js" type="text/javascript"></script> -->
        <!-- jquery.mCustomScrollbar.concat.min -->
        <!-- <script src="<?php echo js_url();?>plugins/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js" type="text/javascript"></script> -->

        <!-- AdminLTE App -->
        <script src="<?php echo js_url();?>AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!-- <script src="js/AdminLTE/dashboard.js" type="text/javascript"></script>     -->
        
        <!-- AdminLTE for demo purposes -->
        <!-- <script src="js/AdminLTE/demo.js" type="text/javascript"></script> -->

        <!-- datepick -->
        <script src="<?php echo js_url();?>plugins/datepick/jquery.plugin.js" type="text/javascript"></script>
        <script src="<?php echo js_url();?>plugins/datepick/jquery.datepick.js" type="text/javascript"></script>
        <!-- date-range-picker -->
        <script src="<?php echo js_url();?>plugins/daterangepicker/daterangepickernew.js" type="text/javascript"></script>
        
        <script src="<?php echo js_url();?>plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo js_url();?>plugins/chosen/chosen.jquery.js"></script>
        <script src="<?php echo js_url();?>plugins/remodal/remodal.min.js"></script>
        <script type="text/javascript">

            var notification_counter = 0;
            var notification_busy = false;
            var user_id = "<?php echo $this_id;?>";
            var applicationTitle = "CBI-CLAS";

            // Menampung daftar tab yang sedang terbuka
            // sehingga ketika suatu tab telah dibuka dan ingin membuka tab
            // tersebut, nantinya diarahkan ke tab yg telah terbuka tsb
            var tabList = [];

            // alamat host aplikasi
            var host = "<?php echo main_url();?>";
            
            // untuk pop up dialog
            var dialog = null;
            var dialog2 = null;
            //Menghapus tab dari daftar tab
            function unsetTabLink(removeItem){
                // Remove specific value from array
                tabList = jQuery.grep(tabList, function(value) {
                    return value != removeItem;
                });
            }

            // membuat menu sidebar yang diklik menjadi aktif
            function setMenuActive(menuid){
                $( "ul.sidebar-menu > li" ).removeClass("active");
                $( "#"+menuid ).parent().addClass("active");
                // alert("as");
            }

            /**
             * Fungsi untuk menambah tab baru
             * @param {string} id    id dari tab, sehingga tidak ada tab yang sama terbuka secara bersamaan
             * @param {string} title judul tab
             * @param {string} url   alamat konten dari tab baru yg akan dibuka oleh ajax
             */
            function addTab(id, title, url){

                tabList.push(id);
                // Append the tab title
                $('#pageTab').append(
                    $('<li><a href="#tab' + id + '" data-toggle="tab" id="tabPane-'+id+'">' + title +
                            '<button class="close" title="Remove this tab" type="button">x</button>' +
                        '</a></li> \
                    ')
                );

                // Append the tab content
                // in this condition, the content can be changed to loading page.
                $('#pageTabContent').append(
                    $('<div class="tab-pane fade" id="tab' + id +         '" parent="'+id+'">Sedang memuat tab:' + id + '...</div>')
                );

                $('#pageTab a:last').tab('show');
                $('#tab' + id).load(url, function( response, status, xhr ) {
                    if ( status === "error" ) {
                        var msg = "Sorry but there was an error: ";
                        msg += xhr.status + " " + xhr.statusText;
                        msg += "<br>Requested page: " + url;
                        $( this ).html( msg );
                    }
                });

            }

            function open_detail(elm, title, url){
                 var $me = $(elm),
                    key = $me.parent().siblings('.pk'),
                    kid = key.attr('val'), //identity
                    knm = key[0].className.split(' ')[1]
                    // ,url = $me.attr('href').replace('#', 'crud/')+'/delete'
                    ;
                    post = [{name: kid, value: kid}];
                    act='select';
                var tabtitle = title+": "+kid;
                if($.inArray(kid, tabList) > -1){
                        // If tab is already exist
                        $('#pageTab a[href="#tab'+kid+'"]').tab('show');
                    }else{
                        // If tab was not there
                        url += '?_=' + (new Date()).getTime();
                        addTab(kid, tabtitle, url);
                        // tabList.push(id);
                    }
            }

            function change_page(elm, url){
                url += '?_=' + (new Date()).getTime();
                var id = $( elm ).closest( "div.tab-pane" ).attr("id");
                $( "#"+id ).empty();
                $( "#"+id ).load(url, function( response, status, xhr ) {
                    // alert(url);
                    if ( status === "error" ) {
                        var msg = "Sorry but there was an error: ";
                        msg += xhr.status + " " + xhr.statusText;
                        msg += "<br>Requested page: " + url;
                        $( this ).html( msg );
                    }
                });

            }

            function search_redirect(elm, url){
                // url += '?_=' + (new Date()).getTime();
                var id = $( elm ).closest( "div.tab-pane" ).attr("id");
                $( "#"+id ).empty();
                $( "#"+id ).load(url, function( response, status, xhr ) {
                    // alert(url);
                    if ( status === "error" ) {
                        var msg = "Sorry but there was an error: ";
                        msg += xhr.status + " " + xhr.statusText;
                        msg += "<br>Requested page: " + url;
                        $( this ).html( msg );
                    }
                });

            }

            /**
             * dialog.close()
             * to close the dialog
             */
            function inform_dialog(title, message, type){
                //type:
                //- confirmation
                // - error
                // - information
                // - question
                // - warning
                if(dialog == null)
                {
                    dialog = $.Zebra_Dialog(message, {
                                    'type':     type,
                                    'modal':    false,
                                    'custom_class':  'dialog-box-inform',
                                    'title':    title,
                                    'animation_speed_hide': 1000,
                                    'animation_speed_show': 1000,
                                    'max_height': 0,
                                    'onClose':  function() {
                                                    form_dialog_close();
                                                }
                                });
                }
            }
             //fungsi untuk menambahkan row pada timesheet
function form_save_timesheet(title, url){
                if(dialog === null)
                {
                    var message = "";
                    dialog = $.Zebra_Dialog(message, {
                                    'type':     false,
                                    'overlay_close': false,
                                    'custom_class':  'form-dialog',
                                    'title':    title,
                                    'animation_speed_hide': 50,
                                    'animation_speed_show': 1000,
                                    'source':  {'ajax': url,
                                                'cache': false},
                                    'max_height': 550,
                                    'overlay_opacity': '.75',
                                    'buttons':  [
                                    {caption: 'Save', callback: function() {
                                            if($(".select_charge").chosen().val().length !== 0 && $(".select_act").chosen().val().length!==0 && $('textarea#work').val().length!==0 && $('#hours').val().length!==0 && $(".date_ts").val().length !== 0){
            $.ajax({
                    url:'<?php echo base_url(); ?>'+'c_resource_timesheet/upload_timesheet',
                    type:'POST',
                    dataType:'json',
                    data:$("#timesheet_form").serialize(),
                    success:function(data) {
                $('#table_timesheet tbody tr').remove(); 
                    
                    var trHTML = '';
                    if(data ===0){
                        $('#table_timesheet tbody').append('<tr><td colspan="7" class="text-center">Data Not Found</td></tr>');
                        $("#validasi-form").css({'display':'none'});
                        $('#send').css("display","none");
                    }
                    else{
                    	 var total=0;
                    $.each(data, function (i, item) {
                        var item_status=item.status==0?'<a class="opt delete" onclick=\"delete_timesheet(\'c_resource_timesheet/delete_timesheet\',\''+item.date_ts+'\',\''+item.charge_code+'\',\''+item.employee_id+'\',\''+item.act_code+'\',\''+item.periode_date+'\')\"></a> <a class="opt edit" onclick=\"form_edit_timesheet(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'\')"></a>':'Already Send';
                        var count_status_zero=item.status==0?1:0;
              trHTML +='<tr><td class="text-center">'+item.date_ts
                      +'</td><td class="text-center">'+item.holiday 
                      +'</td><td class="text-center">'+item.work_desc 
                      +'</td><td class="text-center">'+item.hours 
                      +'</td><td class="text-center"><a data-toggle="tooltip" title="'+item.project_desc+'">'+item.charge_code 
                      +'</a></td><td class="text-center"><a data-toggle="tooltip" title="'+item.activity+'">'+item.act_code
                      +'</a></td><td class="text-center">'+item_status+'</td></tr>';
              total +=count_status_zero;
                        });
                        $('#table_timesheet tbody').append(trHTML); 
                        $("#validasi-form").css({'display':'none'});
                        $('[data-toggle="tooltip"]').tooltip();
                        if(total<=0){
							$('#send').css("display","none");
                            }else{
                            	$('#send').css("display","block");
                                }
                    }
                        },
                  error: function(xhr, resp, text) {
                  console.log(xhr, resp, text);
                        }
                });                        
            }else{
             $("#validasi-form").css({'display':'block'});
            }
                                            
                                    }},
                                    {caption: 'Cancel', callback: function() { form_dialog_close();}}
                ],
                                    'width':1000,
                                    'height':1000,
                                    'onClose':  function() {
                                                    form_dialog_close();
                                                }
                                });
                }
            }
            
            //fungsi untuk merubah row pada timesheet
     function form_edit_timesheet(title, url){
                if(dialog === null)
                {
                    var message = "";
                    dialog = $.Zebra_Dialog(message, {
                                    'type':     false,
                                    'overlay_close': false,
                                    'custom_class':  'form-dialog',
                                    'title':    title,
                                    'animation_speed_hide': 50,
                                    'animation_speed_show': 1000,
                                    'source':  {'ajax': url,
                                                'cache': false},
                                    'max_height': 550,
                                    'overlay_opacity': '.75',
                                    'buttons':  [
                                    {caption: 'Save', callback: function() {
                                            
                                            if($(".select_charge").chosen().val().length !== 0 && $(".select_act").chosen().val().length!==0 && $('textarea#work').val().length!==0 && $('#hours').val().length!==0 && $(".date_ts").val().length !== 0){
                                                $.ajax({
                    url:'<?php echo base_url(); ?>'+'c_resource_timesheet/edit_timesheet',
                    type:'POST',
                    dataType:'json',
                    data:$("#form-edit-timesheet").serialize(),
                    success:function(data) {
                $('#table_timesheet tbody tr').remove(); 
                    
                    var trHTML = '';
                    if(data ===0){
                        $('#table_timesheet tbody').append('<tr><td colspan="7" class="text-center">Data Not Found</td></tr>');
                        $("#validasi-form").css({'display':'none'});
                        $('#send').css("display","none");
                    }
                    else{
                    	 var total=0;
                    $.each(data, function (i, item) {
                    	var item_status=item.status==0?'<a class="opt delete" onclick=\"delete_timesheet(\'c_resource_timesheet/delete_timesheet\',\''+item.date_ts+'\',\''+item.charge_code+'\',\''+item.employee_id+'\',\''+item.act_code+'\',\''+item.periode_date+'\')\"></a> <a class="opt edit" onclick=\"form_edit_timesheet(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'\')"></a>':'Already Send';
                    	var count_status_zero=item.status==0?1:0;
              trHTML +='<tr><td class="text-center">'+item.date_ts
                      +'</td><td class="text-center">'+item.holiday 
                      +'</td><td class="text-center">'+item.work_desc 
                      +'</td><td class="text-center">'+item.hours 
                      +'</td><td class="text-center"><a data-toggle="tooltip" title="'+item.project_desc+'">'+item.charge_code 
                      +'</a></td><td class="text-center"><a data-toggle="tooltip" title="'+item.activity+'">'+item.act_code
                      +'</a></td><td class="text-center">'+item_status+'</td></tr>';
              total +=count_status_zero;
                        });
                        $('#table_timesheet tbody').append(trHTML);
                        $("#validasi-form").css({'display':'none'}); 
                        $('[data-toggle="tooltip"]').tooltip();
                        if(total<=0){
							$('#send').css("display","none");
                            }else{
                            	$('#send').css("display","block");
                                }
                    }
                       },
                  error: function(xhr, resp, text) {
                  console.log(xhr, resp, text);
                        }
                });
                                    
                                            }else{

                                            	$("#validasi-form").css({'display':'block'});
                                            }
                                            
                                            }},
                                    {caption: 'Cancel', callback: function() { form_dialog_close();}}
                ],
                                    'width':1000,
                                    'height':1000,
                                    'onClose':  function() {
                                                    form_dialog_close();
                                                }
                                });
                }
                
            }
            
            //fungsi untuk menghapus salah satu row timesheet
            function delete_timesheet(url,date,charge,employee,act,periode){
            var url_link=url;
            var date_ts=date;
            var charge_code=charge;
            var employee_id=employee;
            var act_code=act;
            var periode_date=periode;
            if(dialog === null)
                {
                    dialog = $.Zebra_Dialog('Are you sure to remove your timesheet data on <strong>'+date_ts+'</strong> with Chargecode <strong>'+charge_code+'</strong>?', {
                                    'type': 'question',
                                    'overlay_close': false,
                                    'custom_class':  'form-dialog',
                                    'title':    'DELETE CONFIRMATION',
                                    'animation_speed_hide': 50,
                                    'animation_speed_show': 700,
                                    'max_height': 550,
                                    'overlay_opacity': '.75',
                                    'buttons':  [
                                    {caption: 'Yes', callback: function() {
                                            $.ajax({
                url:url_link,
                type:'POST',
                dataType:'json',
                data:{
                    date:date_ts,
                    chargecode:charge_code,
                    employeeid:employee_id,
                    actcode:act_code,
                    periode_dates:periode_date
                },
                success:function(data){
                    var trHTML = '';
                    if(data ===0){
                    	$('#table_timesheet tbody tr').remove(); 
                        $('#table_timesheet tbody').append('<tr><td colspan="7" class="text-center">Data Not Found</td></tr>');
                        $("#validasi-form").css({'display':'none'});
                        $('#send').css("display","none");
                    }
                    else{
                    	 var total=0;
                    	 $('#table_timesheet tbody tr').remove(); 
                            $.each(data, function (i, item) {
                            	var item_status=item.status==0?'<a class="opt delete" onclick=\"delete_timesheet(\'c_resource_timesheet/delete_timesheet\',\''+item.date_ts+'\',\''+item.charge_code+'\',\''+item.employee_id+'\',\''+item.act_code+'\',\''+item.periode_date+'\')\"></a> <a class="opt edit" onclick=\"form_edit_timesheet(\'EDIT TIMESHEET RECORD\', \'c_resource_timesheet/form_edit_timesheet/'+item.periode_date+'/'+item.date_ts+'/'+item.charge_code+'/'+item.employee_id+'/'+item.act_code+'\')"></a>':'Already Send';
                            	var count_status_zero=item.status==0?1:0;
              trHTML +='<tr><td class="text-center">'+item.date_ts
                      +'</td><td class="text-center">'+item.holiday 
                      +'</td><td class="text-center">'+item.work_desc 
                      +'</td><td class="text-center">'+item.hours 
                      +'</td><td class="text-center"><a data-toggle="tooltip" title="'+item.project_desc+'">'+item.charge_code 
                      +'</a></td><td class="text-center"><a data-toggle="tooltip" title="'+item.activity+'">'+item.act_code
                      +'</a></td><td class="text-center">'+item_status+'</td></tr>';
              total +=count_status_zero;
                        });
                        $('#table_timesheet tbody').append(trHTML);
                        $("#validasi-form").css({'display':'none'});
                        $('[data-toggle="tooltip"]').tooltip();
                        if(total<=0){
							$('#send').css("display","none");
                            }else{
                            	$('#send').css("display","block");
                                }
                    }
                       },
                  error: function(xhr, resp, text) {
                  console.log(xhr, resp, text);
                        }
            });
                                    }},
                                    {caption: 'No', callback: function() { form_dialog_close();}}],
                                    'width':1000,
                                    'height':1000,
                                    'onClose':  function() {
                                                    form_dialog_close();
                                                }
                                });
                }
            
        }
            
            function form_dialog(title, url,type){
                if(dialog === null)
                {
                    var tipe=type==null?false:type;
                    var message = "";
                    dialog = $.Zebra_Dialog(message, {
                                    'type':     tipe,
                                    'overlay_close': false,
                                    'custom_class':  'form-dialog',
                                    'title':    title,
                                    'animation_speed_hide': 1000,
                                    'animation_speed_show': 1000,
                                    'source':  {'ajax': url,
                                                'cache': false},
                                    'max_height': 550,
                                    'overlay_opacity': '.75',
                                    'buttons': false,
                                    'onClose':  function() {
                                                    form_dialog_close();
                                                }
                                });
                }
            }
            
function form_new_timesheet(title, url){

if(dialog === null)
                {
                    var message = "";
                    dialog = $.Zebra_Dialog(message, {
                                    'type':     false,
                                    'overlay_close': false,
                                    'custom_class':  'form-dialog',
                                    'title':    title,
                                    'animation_speed_hide': 50,
                                    'animation_speed_show': 1000,
                                    'source':  {'ajax': url,
                                                'cache': false},
                                    'max_height': 550,
                                    'overlay_opacity': '.75',
                                    'buttons':  [
                                    {caption: 'Save', callback: function() {
                                    	if($(".date_ts").val().length !== 0 && $(".date_ts2").val().length !== 0){
                                            
            $.ajax({
                    url:'<?php echo base_url(); ?>'+'c_resource_timesheet/generate_new_timesheet',
                    type:'POST',
                    dataType:'json',
                    data:$("#new_timesheet").serialize(),
                    success:function(data) {
                $('#timesheet_periode tbody tr').remove(); 
                    var trHTML = '';
                    $.each(data, function (i, item) {
                        var b=i+1;
              trHTML +='<tr><td class="text-center">'+b
                      +'</td><td><a href=\"#\" onclick=\"change_page(this,\'c_resource_timesheet/load_timesheet_periode/'+item.date_period+'\')\">Timesheet Periode '+item.char_period
                      +'</a></td><td class="text-center"><a class="opt edit" onclick=\"change_page(this,\'c_resource_timesheet/load_timesheet_periode/'+item.date_period+'\')\"></a></td></tr>';
                        });
                        $('#timesheet_periode tbody').append(trHTML); 
                        $("#validasi-form").css({'display':'none'});
                            },
                  error: function(xhr, resp, text) {
                  console.log(xhr, resp, text);
                        }
                });                        
            
                                    	}else{
                                    		$("#validasi-form").css({'display':'block'});
                                    		}        
                                    }},
                                    {caption: 'Cancel', callback: function() { form_dialog_close();}}
                ],
                                    'width':1000,
                                    'height':1000,
                                    'onClose':  function() {
                                                    form_dialog_close();
                                                }
                                });
                }

}
            function confirmation_dialog(title, message, type, functionName, elm){
                //type:
                //- confirmation
                // - error
                // - information
                // - question
                // - warning
                if(dialog == null)
                {
                    dialog = $.Zebra_Dialog(message, {
                                    'type':     type,
                                    'custom_class':  'dialog-box-inform',
                                    'title':    title,
                                    'overlay_close': false,
                                    'show_close_button' : false,
                                    'animation_speed_hide': 1000,
                                    'animation_speed_show': 1000,
                                    'max_height': 0,
                                    'buttons':  [
                                                    {caption: 'Yes', callback: function() { functionName(elm); }},
                                                    {caption: 'No'}
                                                ],
                                    'onClose':  function() {
                                                    form_dialog_close();
                                                }
                                });
                }
            }

            // Untuk menutup dialog yang terbuka
            function form_dialog_close(){
                if(dialog != null)
                    dialog.close();
                dialog = null;
            }


            function start_notification(){
                setTimeout(function () {
                    if(!notification_busy){
                        console.log('Notification refreshing on: ' + new Date());
                        refresh_notification();
                        start_notification();
                    }
                },5000);
            }

            function refresh_notification()
            {
                notification_busy= true;

                var new_notification_counter = 0;

                $.ajax({
                    url: 'c_oas004/feed_notification_counter',
                    type: 'POST',
                    async : false,
                    data: { 'ajax': 1},
                    timeout: 10000, //1000ms
                    success: function(data) {
                        new_notification_counter = data;
                        
                        if(new_notification_counter > notification_counter){
                            console.log('Do a notification about new notif!')
                        }
                        notification_busy= false;
                        notification_counter = new_notification_counter;
                    },
                    error: function(){                      
                        notification_busy= false;
                    }
                });


                if(notification_counter != 0)
                {
                    $('.notification-counter').html(notification_counter);
                    setTitle(' ('+notification_counter+') '+applicationTitle);
                }
                else
                {
                    $('.notification-counter').html('');
                    setTitle(applicationTitle);
                }
                

            }

            function setTitle(title)
            {
                document.title= title;
            }

            // closing tab from tab content, NOT close button on tab pane
            function closeTab(elm)
            {
                    var tabId = $(elm).parents('.tab-pane').attr('parent');
                    // alert(tabId);
                    $('#tabPane-'+tabId).parents('li').remove('li');
                    $('#tab'+tabId).remove();
                    unsetTabLink(tabId.replace('#tab', ''));
                    setMenuActive("");
                    $('#pageTab a:first').tab('show');
                    $('#pageTabContent div:first').addClass('fade in');
            }

            $(document).ready(function(){
                setTitle(applicationTitle);

                // Menandakan bahwa welcome screen sudah ada secara default
                tabList.push("welcome-tab");

                // Melakukan load screen welcome-page
                // default: oas003
                $('#welcome-tab').load(host+'c_oas003'+'/load_view', function( response, status, xhr ) {
                    if ( status == "error" ) {
                        var msg = "Sorry but there was an error: ";
                        msg += xhr.status + " " + xhr.statusText;
                        msg += "<br>Requested page: " + 'OAS003';
                        $( this ).html( msg );
                    }
                });

                // Sistem notifikasi
                start_notification();


                /* Activate Tab */
                $('#pageTab').on('click', 'li > a :not(button)', function (e) {
                    e.preventDefault()
                    $(this).tab('show')
                    setMenuActive($(this).attr('id').replace('tabPane-', ''))
                })
                /* End of Activate Tab */

                /* Side Menu Clicked */
                $( "ul.sidebar-menu > li > a, .notifications-menu > a" ).filter(function() { return !($(this).children().is('.active')); }).click(function() {
                //$('.btnAddPage').click(function() {
                    $( "ul.sidebar-menu > li" ).removeClass("active");
                    $( this ).parent().addClass("active");
                    var id = $(this).attr('id');
                    var title = $(this).attr('tabtitle');
                    if($.inArray(id, tabList) > -1){
                        // If tab is already exist
                        $('#pageTab a[href="#tab'+id+'"]').tab('show')
                    }else{
                        // If tab was not there
                        var contentUrl = $(this).attr('url').replace('#', '');
                        contentUrl += '?_=' + (new Date()).getTime();
                        addTab(id, title, contentUrl);
                        // tabList.push(id);
                    }
                });
                /*End of Side Menu Clicked */



                /*Remove Tab*/
                $('#pageTab').on('click', ' li a .close', function() {
                    var tabId = $(this).parents('li').children('a').attr('href');
                    $(this).parents('li').remove('li');
                    $(tabId).remove();
                    unsetTabLink(tabId.replace('#tab', ''));
                    setMenuActive("");
                    $('#pageTab a:first').tab('show');
                    $('#pageTabContent div:first').addClass('fade in');
                });
                /*End of Remove Tab*/
            });
				<?if ($this_pwdStat['STATUS_PASSWORD'] =='OLD'){?>
						$('#all_menu').hide();
						<?}
						else{?>
						$('#all_menu').show();
						<?}?>
        </script>

    </body>
</html>