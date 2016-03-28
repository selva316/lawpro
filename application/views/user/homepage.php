<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Homepage</title>
    <!-- jQuery UI CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/jquery/css/jquery-ui.min.css" />
	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/dist/css/bootstrap.min.css" />
	<!-- Bootstrap Responsive CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/bootstrap-responsive.min.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/jquery/css/datepicker.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/datatables/css/jquery.dataTables.css" />
	
	<!-- MetisMenu CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/metisMenu/dist/metisMenu.min.css" />
	
	<link rel="stylesheet" href="<?php echo base_url();?>assets/menu/css/menu.css" />
	
    <!-- Timeline CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>dist/css/timeline.css" />
    <!-- Custom CSS -->
    
	<!-- Custom Fonts -->
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" />
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	
	<style>
		
		.navbar{
			border:none;
		}
		
		.nav {
			font-size:14px;
			padding-left:40%;
		}
	</style>
</head>

<body>
    <div class="container-fluid">
		<?php $this->load->view('includes/defaultconfiguration');?>
		<div class="panel panel-success">
		<div class="panel-heading">
			<center><label><b>Notation List</b></label></center></div>
		</div>		
		<div id="page-wrapper">
				<div class="row">
					<div class="col-lg-12">
						<div style="margin-left:30px;margin-bottom:10px;">
							<a href="<?php echo site_url('user/notation');?>" class="btn btn-large btn-success">Add Notation</a>
						</div>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
				<div class="panel panel-info">
					<div class="panel-heading">Draft Notation List</div>
					<div class="panel-body">
						<table id="example" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
									
									<th>Notation ID</th>
									<th>Case Name</th>
									<th>Citation</th>
									<th>Court Name</th>
									<th>Type</th>
									<th>Action</th>
								</tr>
							</thead>
							
						</table>
					</div>
				</div>
			   
			    <div class="panel panel-danger">
					<div class="panel-heading">Notation List</div>
					<div class="panel-body">
						<table id="notationlist" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
									
									<th>Notation ID</th>
									<th>Case Name</th>
									<th>Citation</th>
									<th>Court Name</th>
									<th>Type</th>
									<th>Action</th>
								</tr>
							</thead>
							
						</table>
					</div>
				</div>
			</div>
			<!-- /#page-wrapper -->

		</div>
		<!-- /#wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/jquery/jquery.js"></script>
	<script src="<?php echo base_url();?>assets/jquery/jquery-ui.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/jquery/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url();?>assets/menu/js/menuscript.js"></script>
	
	<script src="<?php echo base_url();?>assets/calc/auto.js"></script>
	<script src="<?php echo base_url();?>assets/datatables/js/jquery.dataTables.js"></script>
	
	<!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/metisMenu/dist/metisMenu.min.js"></script>
	
	
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>dist/js/sb-admin-2.js"></script>
	<script>
	$(document).ready(function() {
		var table;
		var notationlist;
		$('#example').dataTable().fnDestroy();
        table = $('#example').DataTable({
            "ajax": "homepage/fetchDraftNotation",
            "columnDefs": [
                        { 
                            "visible": false
                        }
                    ],
            "columns": [
               { "data": "notation" },  
               { "data": "casename" },  
               { "data": "citation" },  
               { "data": "court_name" },
               { "data": "type" },
               { "data": "action" }
            ]
        });

        $('#notationlist').dataTable().fnDestroy();
        notationlist = $('#notationlist').DataTable({
            "ajax": "homepage/fetchNotation",
            "columnDefs": [
                        { 
                            "visible": false
                        }
                    ],
            "columns": [
               { "data": "notation" },  
               { "data": "casename" },  
               { "data": "citation" },  
               { "data": "court_name" },
               { "data": "type" },
               { "data": "action" }
            ]
        });

	});
	</script>
</body>

</html>