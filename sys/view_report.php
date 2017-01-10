<?php
if (!(isset($_GET['report']))) show_404();
?>
<?php $this->load->view('header');
$file_name = $_GET['report'];
$path = 'monthly_reports/'.$file_name.'.html';
if(file_exists($path))
    {
       include $path;
    }
?>
										
										
    </div>
	</div>
<?php $this->load->view('footer');?>
