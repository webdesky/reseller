<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                <?php 
                if($category_master)
                {?>
                   <h1> <b>Modify Category</b> </h1> 
                <?php
                }
                else
                {
                    ?>
                    <h1> <b>Add Category</b> </h1>
                    <?php
                }
                ?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 ">
                <a href="<?php echo base_url();?>/category/category_master" ><button class="btn btn-primary waves-effect button_postion" type="button">Category List</button></a>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>New Category</h2>
                        
                    </div>
                    <?php if($category_master) {                    
                        foreach ($category_master as $gdata) { 
                    ?>
                    <div class="body">
                        <form id="form_advanced_validation" method="POST" action="<?php echo base_url() ?>home/addcategory_master" enctype="multipart/form-data">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="category_name" value="<?php echo $gdata['category_name'] ?>" required>
                                    <label class="form-label">Category Name</label>
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
                        <form id="form_advanced_validation" method="POST" action="<?php echo base_url() ?>home/addcategory_master" enctype="multipart/form-data">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="category_name" required>
                                    <label class="form-label">Category Name</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="file" class="form-control" name="category_image" required>
                                </div>
                                <div class="help-info">Image only</div>
                            </div>
                            <button class="btn btn-primary waves-effect" type="submit" name="submit" value="submit">SUBMIT</button>
                        </form>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- #END# Advanced Validation -->
    </div>
</section>