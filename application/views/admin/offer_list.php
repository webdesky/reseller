<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                <h1> <b>Offer List</b> </h1>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12" >
                <a href="<?php echo base_url();?>/offer/add_offer"><button class="btn btn-primary waves-effect button_postion" type="button">Add New Offer</button></a>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Offer List
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Offer Name</th>
                                        <th>Offer Type</th>
                                        <th>Start from </th>
                                        <th>End To</th>
                                        <th>Offer value</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 
                                   if(!empty($offers))
                                   {
                                       foreach($offers as $offer)
                                       {
                                       ?>
                                        <tr>
                                            <td><?php echo $offer['offer_name']?></td>
                                            <td><?php echo $offer['offer_type']?></td>
                                            <td><?php echo $offer['offer_start_from']?></td>
                                            <td><?php echo $offer['offer_end_to']?></td>
                                            <td><?php echo $offer['offer_value']?></td>
                                            <td><?php echo $offer['offer_status']?></td>
                                        </tr>
                                       <?php 
                                       }
                                    }
                                    else
                                    {
                                        echo '<tr><td colspan="7">No Record Found</td></tr>';
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
