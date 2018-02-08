<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                <h1> <b>Discount List</b> </h1>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12" >
                <a href="<?php echo base_url();?>/discount/add_discount"><button class="btn btn-primary waves-effect button_postion" type="button">Add New Discount</button></a>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Discount List
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Discount Name</th>
                                        <th>Discount Type</th>
                                        <th>Applied for</th>
                                        <th>Applied To</th>
                                        <th>Start date</th>
                                        <th>End date</th>
                                        <th>Discount value</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(!empty($discount_data))
                                    {
                                        $i=0;
                                        foreach($discount_data as $discount_value_data)
                                        {
                                            if($discount_value_data['discount_status']==1)
                                            {
                                                $discount_status="Active";
                                            }
                                            else if($discount_value_data['discount_status']==0)
                                            {
                                                $discount_status="Inactive";
                                            }
                                        ?>
                                            <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $discount_value_data['discount_name'];?></td>
                                                <td><?php echo $discount_value_data['discount_type'];?></td>
                                                <td><?php echo $discount_value_data['discount_apply_type'];?></td>
                                                <td><?php echo $discount_value_data['discount_applied_id'];?></td>
                                                <td><?php echo $discount_value_data['discount_start_from'];?></td>
                                                <td><?php echo $discount_value_data['discount_end_to'];?></td>
                                                <td><?php echo $discount_value_data['discount_value'];?></td>
                                                <td><?php echo $discount_status;?></td>
                                                <td>
                                                    <?php
                                                    if($discount_value_data['discount_status']==1)
                                                    {
                                                        ?>
                                                        <a href="<?php echo base_url();?>discount/inactive_status_change/<?php echo $discount_value_data['discount_id'];?>"><i class="material-icons">move_to_inbox</i></a>&nbsp;
                                                        <?php
                                                    }
                                                    else if($discount_value_data['discount_status']==0)
                                                    {
                                                        ?>
                                                        <a href="<?php echo base_url();?>discount/active_status_change/<?php echo $discount_value_data['discount_id'];?>"><i class="material-icons">unarchive</i></a>&nbsp;
                                                        <?php
                                                    }
                                                    ?>
                                                    <a href="<?php echo base_url();?>discount/add_discount/<?php echo $discount_value_data['discount_id'];?>"> <i class="material-icons">create</i></a>&nbsp;
                                                    <a href="<?php echo base_url();?>discount/delete_discount/<?php echo $discount_value_data['discount_id'];?>">
                                                       <i class="material-icons">delete_sweep</i></i>
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    else
                                    {
                                        echo '<tr><td colspan="9">No Record Found</td></tr>';
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
<?php include("include/footer.php");?>
