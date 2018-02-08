<section class="content">
    <div class="container-fluid">
        <!-- Advanced Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>New Product</h2>
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
                    <?php if($product_master) {                    
                        foreach ($product_master as $gdata) { 
                    ?>
                    <div class="body">
                        <form id="form_advanced_validation" method="POST" action="<?php echo base_url() ?>home/addproduct_master" enctype="multipart/form-data">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="product_name" value="<?php echo $gdata['product_name'] ?>" required>
                                    <label class="form-label">Product Name</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="product_description" value="<?php echo $gdata['product_description'] ?>" required>
                                    <label class="form-label">Description</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="discount_id" class="form-control" value="<?php echo $gdata['discount_id'] ?>" required>
                                    <label class="form-label">Discount Id</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="discount_amount" class="form-control" value="<?php echo $gdata['discount_amount'];?>">
                                    <label class="form-label">Discount Amount </label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="offer_id" class="form-control" value="<?php echo $gdata['offer_id']; ?>">
                                    <label class="form-label"> Offer Id</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="offer_amount" class="form-control" value="<?php echo $gdata['offer_amount']; ?>">
                                    <label class="form-label">Offer Amount</label>
                                </div>    
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="product_price" class="form-control" value="<?php echo $gdata['product_price']; ?>">
                                </div>    
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="sale_price" class="form-control" value="<?php echo $gdata['sale_price']; ?>">
                                    
                                </div>
                                
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="added_date" value="<?php echo $gdata['added_date'] ?>" required>
                                    <label class="form-label">Date</label>
                                </div>
                                <div class="help-info">YYYY-MM-DD format</div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <img style="width:100px;height: 100px " src="<?php echo base_url().'uploads/'.$gdata['category_image'] ?>"  >
                                                <div>
                                                  <span class="btn btn-rose btn-round btn-file">
                                                      <span class="fileinput-new">Select image</span>
                                                      <span class="fileinput-exists">Change</span>
                                                      <input name="category_image" type="file" >
                                                  <div class="ripple-container"></div></span>
                                                </div>
                                        </div>
                                        <div class="help-info">Image only</div>
                                    </div>
                                </div>
                                <div class="help-info">Image only</div>
                            </div>
                            <input type="hidden" value="<?php echo $gdata['category_id']; ?>" name="id">
                            <button class="btn btn-primary waves-effect" type="submit" name="update"
                            value="update">Update</button>
                        </form>
                    </div>
                    <?php } } else { ?>
                    <div class="body">
                        <form id="form_advanced_validation" method="POST" action="<?php echo base_url() ?>home/addproduct_master" enctype="multipart/form-data">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="product_name" required>
                                    <label class="form-label">Product Name</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="product_description"  required>
                                    <label class="form-label">Description</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="discount_id" class="form-control" required>
                                    <label class="form-label">Discount Id</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="discount_amount" class="form-control" required>
                                    <label class="form-label">Discount Amount </label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="offer_id" class="form-control" required>
                                    <label class="form-label"> Offer Id</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="offer_amount" class="form-control" required>
                                    <label class="form-label">Offer Amount</label>
                                </div>    
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="product_price" class="form-control" required>
                                </div>    
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="sale_price" class="form-control" required>
                                    <label class="form-label">Product Price</label>
                                </div>
                                
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="added_date" required>
                                    <label class="form-label">Date</label>
                                </div>
                                <div class="help-info">YYYY-MM-DD format</div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input name="category_image" type="file" >
                                            <div class="ripple-container"></div></span>
                                        </div>
                                        <div class="help-info">Image only</div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary waves-effect" type="submit" name="submit"
                            value="submit">Submit</button>
                        </form>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- #END# Advanced Validation -->
    </div>
</section>