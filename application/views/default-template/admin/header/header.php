<?php
/**
 * @var GN_ComplementHandler
 */
 $gnComplementHandler;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="shortcut icon" href="images/favicon.png"> -->

    <title><?= $site->getName()?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?= tmpl_lib_url('css/bootstrap.min.css') ?>" rel="stylesheet" />    
    <?php $gnComplementHandler->printViewCss()?>
    <link href="<?= panel_url('js/intro.js/introjs.css') ?>" rel="stylesheet" />
    <link href="<?= tmpl_lib_url('css/project/tour.intro.css') ?>" rel="stylesheet" />
    <link href="<?= tmpl_lib_url('css/project/helppopovers.css') ?>" rel="stylesheet" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->
        

    <script src="<?= panel_url('js/jquery.js') ?>"></script>
    <script type="text/javascript">
        var Config = <?= json_encode($viewConfig) ?>;
    </script>
    
</head>
<body>
		<div class="hidden-elements jpanel-menu-exclude">
		<!--@modal - confirm order modal-->
		<!-- Modal -->
			<!------------------ THIS MODAL SHOW A SHORT DESCRIPTION BEFORE PURCHASE BY PANEL ..see manualpaymententry.js-->
			<div class="modal fade" id="confirm-order" tabindex="-1" role="dialog" aria-hidden="true">
			    <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				        <h2><i class="fa fa-money"></i> Please check out your data</h2>
				      </div>
				      <div class="modal-body">
				      	<p>Short description</p>
						<div id="short-description">
							<table>
								<thead>
									<tr>
										<th colspan="2" class="text-center"><strong>Donated to</strong></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="width:30%;"><strong>Organization</strong></td>
										<td id="confirm-organization"></td>
									</tr>
									<tr>
										<td style="width:30%;"><strong>Event</strong></td>
										<td id="confirm-event"></td>
									</tr>
									<tr>
										<td style="width:30%;"><strong>Team</strong></td>
										<td id="confirm-team"></td>
									</tr>
									<tr>
										<td style="width:30%;"><strong>Individual</strong></td>
										<td id="confirm-individual"></td>
									</tr>
								</tbody>
							</table><br>
							<table>
								<thead>
									<tr>
										<th colspan="2" class="text-center"><strong>Donnor information</strong></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="width:30%;"><strong>Fist name</strong></td>
										<td  id="confirm-firstname"></td>
									</tr>
									<tr>
										<td style="width:30%;"><strong>Last name</strong></td>
										<td id="confirm-lastname"></td>
									</tr>
									<tr>
										<td style="width:30%;"><strong>Phone</strong></td>
										<td id="confirm-phone"></td>
									</tr>
									<tr>
										<td style="width:30%;"><strong>Email</strong></td>
										<td id="confirm-email"></td>
									</tr>									
									<tr>
										<td style="width:30%;"><strong>Address</strong></td>
										<td id="confirm-address"></td>
									</tr>	
									<tr>
										<td style="width:30%;"><strong>Zip</strong></td>
										<td id="confirm-zip"></td>
									</tr>																		
								</tbody>
							</table><br>
							<h3 id="confirm-total-amount" class="text-center"></h3>												
						</div>
				      </div>
				      <div class="modal-footer">
				      	<button type="button" id="acept" class="btn btn-primary" data-dismiss="modal">Agree</button>
				        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				      </div>
				    </div>
			      <!-- /.modal-content -->
			    </div>
			<!-- /.modal-dialog -->
			</div>
			<!------------------ THIS MODAL SHOW A PROGRESS BAR WHEN A PAYMENT IS MADE BY THE PANEL.. see manualpaymententry.js-->
			<div class="modal fade" id="processing-payment" tabindex="-1" role="dialog" aria-hidden="true">
			    <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-body">
				      	<h5>Processing your payment...</h5>
						<div class="progress">
							<div class="progress progress-striped active">
							  <div class="progress-bar progress-bar-info" style="width: 100%"></div>
							</div>
					    </div>				      	
				      </div>
				    </div>
			      <!-- /.modal-content -->
			    </div>
			<!-- /.modal-dialog -->
			</div>
			<!------------------ THIS MODAL SHOW A SHORT DESCRIPTION BEFORE PURCHASE BY PANEL ..see searchpayment.js-->
			<div class="modal fade" id="confirm-refund" tabindex="-1" role="dialog" aria-hidden="true">
			    <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				        <h2><i class="fa fa-undo"></i> Refund this payment?</h2>
				      </div>
				      <div class="modal-body">
						<p>All changes you do on this section can't be undo</p>
				      </div>
				      <div class="modal-footer">
				      	<button type="button" id="acept" class="btn btn-primary" data-dismiss="modal">Agree</button>
				        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				      </div>
				    </div>
			      <!-- /.modal-content -->
			    </div>
			<!-- /.modal-dialog -->
			</div>			
			<!------------------ THIS SHOWS A PROGRESS BAR WHEN THERE IS A REFUND IN PROCESS.. see searchpayment.js-->
			<div class="modal fade" id="processing-refund" tabindex="-1" role="dialog" aria-hidden="true">
			    <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-body">
				      	<h5>Processing your refund...</h5>
						<div class="progress">
							<div class="progress progress-striped active">
							  <div class="progress-bar progress-bar-info" style="width: 100%"></div>
							</div>
					    </div>				      	
				      </div>
				    </div>
			      <!-- /.modal-content -->
			    </div>
			<!-- /.modal-dialog -->
			</div>
			<!------------------ RESPONSE ON MODAL AFTER SUBMIT THE REFUND.. see searchpayment.js-->
			<div class="modal fade" id="response-refund" tabindex="-1" role="dialog" aria-hidden="true">
			    <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close closeResponse" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				        <h2><i class="fa fa-info-circle"></i> Response</h2>
				      </div>
				      <div class="modal-body">
						<p id="text-response-refund"></p>
						<p id="text-force-refund" style="display: none">
							The gateway can't refund this payment. Apply just to the system?
							<button type="button" id="forceRefund" class="btn btn-primary">Yes</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
						</p>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-primary closeResponse" data-dismiss="modal">Close</button>
				      </div>
				    </div>
			      <!-- /.modal-content -->
			    </div>
			<!-- /.modal-dialog -->
			</div>						
			<!------------------ THIS MODAL SHOW DETAIL ABOUT PRODUCT TYPE ON RESULT REFUND SEARCH .. see refund.js-->
			<div class="modal fade" id="detail-product-type" tabindex="-1" role="dialog" aria-hidden="true">
			    <div class="modal-dialog">
				    <div class="modal-content">
					    <div class="modal-header">
					    	<h2><!-- This content is generated dinamically--></h2>
					    </div>
					    <div class="modal-body">
					    	<!-- This content is generated dinamically-->
					    </div>
					    <div class="modal-footer">
					        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					    </div>
				    </div>
			      <!-- /.modal-content -->
			    </div>
			<!-- /.modal-dialog -->
			</div> 			  			   
		</div>         
        <div id="cl-wrapper" class="fixed-menu">
