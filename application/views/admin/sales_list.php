<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                <h1> <b>Sales List</b> </h1>
            </div>
             
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Sales List
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable" >
                                <thead>
                                    <tr>
                                        <th>Invoice No.</th>
                                        <th>Transaction</th>
                                        <th>Customer Name </th>
                                        <th>Email</th>
                                        <th>Product Name</th>
                                        <th>Sold Amount</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 
                                   $modaldata="";
                                    
   
                                   if(!empty($sales_data))
                                   {
                                       $modaldata.=' <thead>
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Price</th>
                                                            <th>Quantity</th>
                                                            <th>Tax</th>
                                                            <th>Discount</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead><tbody>';
                                       foreach($sales_data as $sales)
                                       {
                                       ?>
                                        <tr>
                                            <td><?php echo $sales['invoice_no']?></td>
                                            <td><?php echo $sales['transaction_no']?></td>
                                            <td><?php echo $sales['user_fname']?></td>
                                            <td><?php echo $sales['user_email']?></td>
                                            <td><?php echo $sales['product_name']?></td>
                                            <td><?php echo $sales['total_sale_price']?></td>
                                            <td>
                                                <div class="button-demo js-modal-buttons">
                                                      <button type="button" data-color="red" class="btn bg-red  waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">
                                                      <!--<button type="button" data-color="red" class="btn bg-red waves-effect">-->
                                                        RED</button>
                                                </div>
                                            </td>      
                                        </tr>
                                       <?php 
                                           $modaldata.='<tr>';
                                           $modaldata.='<td tabindex="1">'.$sales['product_name'].'</td>';
                                           $modaldata.='<td tabindex="1">'.$sales['product_price'].'</td>';
                                           $modaldata.='<td tabindex="1">'.$sales['product_qty'].'</td>';
                                           $modaldata.='<td tabindex="1">'.$sales['total_tax_amount'].'</td>';
                                           $modaldata.='<td tabindex="1">'.$sales['total_discount_amount'].'</td>';
                                           $modaldata.='<td tabindex="1">'.$sales['total_sale_price'].'</td>';
                                           $modaldata.='</tr>';
                                       }
                                       $modaldata.="</tbody>";
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
