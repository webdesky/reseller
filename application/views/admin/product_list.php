<style>
.button_postion1 {
    margin-top: 17px !important;
    font-size: 15px !important;
    
     margin-left: 22px !important; 
}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="col-lg-8 col-md-10 col-sm-6 col-xs-12">
                <h1> <b>Product List</b> </h1>
            </div>
            <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">
                <a href="<?php echo base_url();?>product/add_product"><button class="btn btn-primary waves-effect button_postion1" type="button">Demo Excel</button></a>&nbsp;
                <a href="<?php echo base_url();?>product/add_excel_file"><button class="btn btn-primary waves-effect button_postion1" type="button">Import Excel File</button></a>&nbsp;
                <a href="<?php echo base_url();?>product/add_product"><button class="btn btn-primary waves-effect button_postion1" type="button">Add New Product</button></a>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Product List
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Tax</th>
                                        <th>Discount</th>
                                        <th>Offer</th>
                                        <th>Sale Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(count($product_list_data)>0)
                                    {
                                        $i=0;
                                        foreach ($product_list_data as $product_data) 
                                        {
                                            $where=array("category_id"=>$product_data['category_id']);
                                            $result = $this->common_model->getAllwhere('category_master',$where);
                                            $category_name=$result[0]->category_name;
                                            if($product_data['product_status']==1)
                                            {
                                                $product_status="Active";
                                            }
                                            else if($product_data['product_status']==0)
                                            {
                                                $product_status="Inactive";
                                            }
                                            ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $product_data['product_name']; ?></td>
                                            <td><?php echo $product_data['product_description']; ?></td>
                                            <td><?php echo $category_name; ?></td>
                                            <td><?php echo $product_data['product_price']; ?></td>
                                            <td><?php echo $product_data['tax_amount']; ?></td>
                                            <td><?php echo $product_data['discount_amount'] ?></td>
                                            <td><?php echo $product_data['offer_amount']; ?></td>
                                            <td><?php echo $product_data['sale_price']; ?></td>
                                            <td><?php echo $product_status; ?></td>
                                            <td>
                                                <?php 
                                                    if($product_data['product_status']==1)
                                                    {
                                                        ?>
                                                        <a href="<?php echo base_url();?>product/inactive_status_change/<?php echo $product_data['product_id'];?>"><i class="material-icons">move_to_inbox</i></a>&nbsp;
                                                        <?php
                                                    }
                                                    else if($product_data['product_status']==0)
                                                    {
                                                        ?>
                                                        <a href="<?php echo base_url();?>product/active_status_change/<?php echo $product_data['product_id'];?>"><i class="material-icons">unarchive</i></a>&nbsp;
                                                       
                                                        <?php
                                                    }
                                                ?>
                                                    <a href="<?php echo base_url();?>product/add_product/<?php echo $product_data['product_id'];?>"> <i class="material-icons">create</i></a>&nbsp;
                                                    <a href="<?php echo base_url();?>product/delete_discount/<?php echo $product_data['product_id'];?>">
                                                       <i class="material-icons">delete_sweep</i></i>
                                                    </a>
                                            </td>
                                        </tr>
                                        <?php 
                                        } 
                                    }
                                    else
                                    {
                                        echo '<tr><td colspan="11">No Record Found</td></tr>';
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