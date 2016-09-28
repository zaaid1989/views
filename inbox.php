<?php include('header.php');?>
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Inbox <small>user inbox</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
							<i class="fa fa-home"></i>
							<a href="index.html">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Extra</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Inbox</a>
						</li>
				</ul>
				
			</div>
            
            <?php if(isset($_GET['msg_delmsgSlect']))
					  { 
						echo '<div class="alert alert-success">  
								<a class="close" data-dismiss="alert">×</a>  
								Selected Message Deleted Successfully.  
							  </div>';
					  }
			?>
            <?php if(isset($_GET['msg_delmsg']))
					  { 
						echo '<div class="alert alert-success">  
								<a class="close" data-dismiss="alert">×</a>  
								 Message Deleted Successfully.  
							  </div>';
					  }
			?>
            <?php if(isset($_GET['msg_markSlectRed']))
					  { 
						echo '<div class="alert alert-success">  
								<a class="close" data-dismiss="alert">×</a>  
								 Selected Message Mark Read Successfully.  
							  </div>';
					  }
			?>
            
			<!-- END PAGE HEADER-->
			<div class="row inbox">
				<div class="col-md-2">
					<ul class="inbox-nav margin-bottom-10">
						<li class="compose-btn">
							<a href="<?php echo base_url()?>inbox/compose" data-title="Compose" class="btn green">
							<i class="fa fa-edit"></i> Compose </a>
						</li>
						<li class="inbox <?php if($titlearray['title']=='Inbox'){ echo " active";}?>">
							<a href="<?php echo base_url()?>inbox/index/0" class="btn" data-title="Inbox">
							Inbox
                            <?php if( $unread!=0){?>
                              <span class="message_noti_up_badge" 
                              	style=" <?php if($titlearray['title']=='Inbox'){ echo " color:#fff";} else {echo 'color:#4d82a3';}?>">
                              (
                                 <span class="message_noti_up" style="margin-right:0;
                                 	<?php if($titlearray['title']=='Inbox'){ echo " color:#fff";} else {echo 'color:#4d82a3';}?>"><?php echo $unread;?>
                                 </span>
                               )
                               </span>
                             <?php }?>
                            </a>
							<b></b>
						</li>
						<li class="sent <?php if($titlearray['title']=='Sent Messages'){ echo " active";}?>">
							<a class="btn" href="<?php echo base_url()?>inbox/sentmessages/1" class="btn" data-title="Sent">
							Sent
							</a>
							<b></b>
						</li>
						<li class="trash <?php if($titlearray['title']=='Trash'){ echo " active";}?>">
							<a class="btn" href="<?php echo base_url()?>inbox/trash/1" class="btn" data-title="Trash">
							Trash
							</a>
							<b></b>
						</li>
						</ul>
				</div>
				<div class="col-md-10">
            <div class="inbox-header">
              <h1 class="pull-left">Inbox</h1>
              <!--<form class="form-inline pull-right" action="index.html">
                <div class="input-group input-medium">
                  <input type="text" class="form-control" placeholder="Password">
                  <span class="input-group-btn">
                  <button type="submit" class="btn green"><i class="fa fa-search"></i></button>
                  </span> </div>
              </form>-->
            </div>
            <!--<div class="inbox-loading"> Loading... </div>-->
            <div class="inbox-content2">
              <table class="table table-striped table-advance table-hover">
                <thead>
                  <tr>
                    <th colspan="3"> <div class="checker"><span>
                        <input type="checkbox" class="mail-checkbox mail-group-checkbox">
                        </span></div>
                      <!--<div class="btn-group"> <a data-toggle="dropdown" href="javascript:;" class="btn btn-sm blue dropdown-toggle"> More <i class="fa fa-angle-down"></i> </a>
                        <ul class="dropdown-menu">
                          <li> <a href="javascript:;"> <i class="fa fa-pencil"></i> Mark as Read </a> </li>
                          <li> <a href="javascript:;"> <i class="fa fa-ban"></i> Spam </a> </li>
                          <li class="divider"> </li>
                          <li> <a href="javascript:;"> <i class="fa fa-trash-o"></i> Delete </a> </li>
                        </ul>
                      </div>-->
                    </th>
                    <th colspan="3" class="pagination-control"> <span class="pagination-info"> <?php echo "Total (".$titlearray['total_record'].")"; echo " , Unread (".$unread.")"; ?> </span> <!--<a class="btn btn-sm blue"> <i class="fa fa-angle-left"></i> </a> <a class="btn btn-sm blue"> <i class="fa fa-angle-right"></i> </a>--> </th>
                  </tr>
                </thead>
                <tbody>
                <?php if(isset($messagedata) && !empty($messagedata)){ foreach($messagedata as $message_rec){?>
                  
                  
<tr onclick="document.location = '<?php echo base_url().'inbox/message/'.$message_rec['id']; ?>';" data-messageid="<?php echo $message_rec['id']; ?>" class=" 
<?php if($message_rec['read']==0){ echo "unread" ; }else{ echo ""; } ?>" >
                     <td class="inbox-small-cells"><div class="checker"><span>
                        <input type="checkbox" class="mail-checkbox">
                        </span></div></td>
                    <!--<td class="inbox-small-cells"><i class="fa fa-star"></i></td>-->
                    <td class="view-message hidden-xs"> <?php echo $message_rec['from']; ?>  </td>
                    <td class="view-message "> <?php if(isset($message_rec['subject']) && $message_rec['subject']!=""){ echo limit_words($message_rec['subject'],2); }else{ echo "No Subject."; } ?> - </td>
                    <td class="view-message message-color">  <?php echo limit_words($message_rec['text'],10);  ?> </td>
                    <!--<td class="view-message inbox-small-cells"><i class="fa fa-paperclip"></i></td>-->
                    <td class="view-message"><?php echo date('d F Y H:i:s', strtotime($message_rec['time'])); ?> </td>
                 </tr>
                 <?php } }else{ ?>
				 
				 <tr><td colspan="5"> <center>Inbox Empty</center> </td></tr>
				 <?php } ?>
                  
                  
                  
                  <tr><td colspan="5"><center><?php //echo $links; ?></center></td></tr>
                  
                  
                  
                 
                 
                  
                </tbody>
              </table>
            </div>
            
            
        
        
          </div>
						