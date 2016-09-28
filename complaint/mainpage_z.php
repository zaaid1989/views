<?php $this->load->view('header.php');?>
<link rel="stylesheet" href="<?php echo base_url();?>zaaid/taggd/normalize.css" />
<link rel="stylesheet" href="<?php echo base_url();?>zaaid/taggd/taggd.css" />
<script src="<?php echo base_url();?>zaaid/taggd/jquery.taggd.min.js"></script>
<style>
.page-content
{
	padding:0 0 0 0 !important;
}
</style>
		<center>
			<img style="margin-top:35px;" src="<?php echo base_url();?>usersimages/parts_images/8/amctawtuaoagro-9g0gqtbeslowjppb83x7wwhdsmcip_8894277228.jpg" class="imgresponsive2 taggd" >
		</center>
		
		
		
		
		<form action="<?php echo base_url();?>complaint/add_tagg_insert" class="form-horizontal" method="post">
                <input type="hidden" value="" id="tagg" name="tagg">
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-6 col-md-6">
                                    <button type="submit" class="btn yellow pull-right">Submit</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </form>
			
	</div>
	
	<!-- END CONTENT -->
	<!-- BEGIN QUICK SIDEBAR -->
	<a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
	
	<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->

<script>
	var options = {
		edit: true,
		align: {
			y: 'top'
		},
		offset: {
			top: 15
		},
		handlers: {
			click: 'toggle'
		}
	};
	
	var data = [
		<?php 
		$q=$this->db->query("select * from tbl_tagg");
        $tags_list=$q->result_array();
		$i = sizeof($tags_list);
		$last_index = $i - 1;
		if ($i > 0) {
			$j=0;
			foreach ($tags_list AS $tag) {
				if ($j!= $last_index)
					echo '{ x: '. $tag["x"].', y: '.$tag["y"].', text: "'.$tag["text"].'"},';
				else
					echo '{ x: '. $tag["x"].', y: '.$tag["y"].', text: "'.$tag["text"].'"}';
				$j++;
			}
		}
	?>
	];
	
	var taggd = $('.taggd').taggd( options, data );
	taggd.show();
	taggd.on('change', function() {
		//console.log(taggd.data);
		o = JSON.stringify(taggd.data, null, 4);
		
		//$('#test').val(taggd.data);
		$('#tagg').val(o);
		$('#testt').html(o);
		
		
		
	});
</script>
<?php $this->load->view('footer.php');?>