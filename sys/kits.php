<?php $this->load->view('header');
$file_name = date('m_Y_').$this->session->userdata('userid').'.html';
$path = 'monthly_reports/'.$file_name;
if(file_exists($path))
    {
       include $path;
    }
?>
										
										
    
<?php $this->load->view('footer');?>
