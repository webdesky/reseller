<section class="content">
    <div class="container-fluid">
        <!-- Advanced Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>New Category</h2>
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
                    <?php if($subcategory_master) {  
                    //print_r($subcategory_master); die();                  
                        foreach ($subcategory_master as $gdata) { 
                    ?>
                    <div class="body">
                        <form id="form_advanced_validation" method="POST" action="<?php echo base_url() ?>home/addsubcategory_master" enctype="multipart/form-data">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="category_name" value="<?php echo $gdata['category_name'] ?>" required>
                                    <label class="form-label">Category Name</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="parent_id" value="<?php echo $gdata['parent_id'] ?>" required>
                                    <label class="form-label">Parent</label>
                                </div>
                            </div>
                            <div class="form-group form-float dropdown">
                                <div class="form-line">
                                    <select class="form-control show-tick" name="parent_id">
                                        <option style="color: purple" value="">Select Category </option>
                                          <?php if(!empty($category_master)){foreach ($category_master as $key ) {?>
                                          <option style="color:  black" value="<?php echo $key['category_id']; ?>" <?php if($gdata['parent_id'] == $key['category_id']){ echo 'selected'; } ?>><?php echo $key['category_name']; ?></option>
                                            <?php } }?>
                                    </select>
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
                            <div class="form-group form-float dropdown">
                                <div class="form-line">
                                    <select name="parent_id" class="form-control show-tick" required="">
                                      <option style="color: purple" value="">Select Category</option>
                                      <?php foreach ($category_master as $key ) {?>
                                      <option style="color:  black" value="<?php echo($key['category_id']); ?>"><?php echo($key['category_name']); ?></option>
                                        <?php } ?>
                                    </select>
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