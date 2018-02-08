<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                <h1> <b>Customers List</b> </h1>
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
                            Customers
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable" >
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                      
                                        <th>Address</th>
                                        <th>City</th>
                                         
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 
                                    
                                   if(!empty($customers_data))
                                   {
                                       
                                       foreach($customers_data as $customer) 
                                       {
                                       ?>
                                        <tr>
                                            <td><?php echo $customer['user_fname'].' '. $customer['user_lname']?></td>
                                            <td><?php echo $customer['user_email']?></td>
                                            <td><?php echo $customer['user_mobile']?></td>
                                            <td><?php echo $customer['user_address1']?></td>
                                            <td><?php echo $customer['user_city']?></td>
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

                   <!-- For Material Design Colors -->
        <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <div class="card">
                                 <div class="header">
                                  <h2>
                                    Sales Detail
                                     
                                  </h2>
                            </div>
                            <div class="body">
                                    <table id="mainTable" class="table table-striped table-responsive" style="cursor: pointer;">
                                      <?php   echo $modaldata;  ?>    
                                    </table>
                                    <input style="position: absolute; display: none;"></div>
                                </div>
                            </div>
                        </div>
                     </div>

                    <div class="modal-footer">
                        <!--<button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>-->
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<?php include("include/footer.php");?>
