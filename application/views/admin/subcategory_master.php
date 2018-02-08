<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="block-header">
                <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                    <h1> <b>Subcategory List</b> </h1>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12" >
                    <a href="<?php echo base_url();?>/category/addsubcategory_master"><button class="btn btn-primary waves-effect button_postion" type="button">Add New Subcategory</button></a>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Subcategory List
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Subcategory Image</th>
                                        <th>Subcategory Name</th>
                                        <th>Status</th>
                                        <th>Added Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(count($subcategory_master)>0)
                                    {
                                        foreach ($subcategory_master as $category) 
                                        {

                                            if($category['category_status']==1)
                                            {
                                                $status="Active";
                                            }
                                            else if($category['category_status']==0)
                                            {
                                                $status="Inactive";
                                            }
                                            ?>
                                        <tr>
                                            <td><?php echo $category['category_id']; ?></td>
                                            <?php 
                                            if($category['category_image']!='')
                                            {
                                                ?>
                                                <td><img src="<?php echo base_url();?>assets/images/no_image.png" width="30" height="30"></td>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <td><img src="<?php echo base_url().'uploads/'.$category['category_image']; ?>" width="30" height="30"></td>
                                                <?php
                                            }
                                            ?>
                                            <td><?php echo $category['category_name']; ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td><?php echo date('d/m/Y',strtotime($category['added_date'])); ?></td>
                                            <td>
                                                    <?php if($category['category_status']==1)
                                                    {
                                                        ?>
                                                        <a href="<?php echo base_url();?>category/inactive_status_change/<?php echo $category['category_id'];?>/subcategory_master"><i class="material-icons">move_to_inbox</i></a>&nbsp;
                                                        <?php
                                                    }
                                                    else if($category['category_status']==0)
                                                    {
                                                        ?>
                                                        <a href="<?php echo base_url();?>category/active_status_change/<?php echo $category['category_id'];?>/subcategory_master"><i class="material-icons">unarchive</i></a>&nbsp;
                                                       
                                                        <?php
                                                    }
                                                    ?>
                                                    <a href="<?php echo base_url();?>home/addsubcategory_master/<?php echo $category['category_id'];?>"> <i class="material-icons">create</i></a>&nbsp;
                                                    <a href="<?php echo base_url();?>category/delete_category/<?php echo $category['category_id'];?>/subcategory_master">
                                                       <i class="material-icons">delete_sweep</i></i>
                                                    </a>
                                            </td>
                                        </tr>
                                        <?php 
                                        } 
                                    }
                                    else
                                    {
                                        echo '<tr><td colspan="6">No Record Found</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">

    $(document).ready(function(){
     $(".delete").click(function(e){
        alert("Sure you want to delete ?");
         e.preventDefault(); 
         var href = $(this).attr("href-data");
         var btn = this;
            $.ajax({
              type: "POST",
              url: href,
              data:{tabname:'category_master'},
              success: function(response) {

                  if (response == "Success")
                  {
                     $(btn).closest('tr').fadeOut("slow");
                  }
                  else
                  {
                    alert("Error");
                  }
                }
            });
        })
    });

</script>