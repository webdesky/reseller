

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h1> <b>Add Offer</b> </h1>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <a href="<?php base_url();?>/offer/offer_list"><button class="btn btn-primary waves-effect" type="button">Offer List</button></a>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <?php 
                        if($this->session->flashdata('msg'))
                        { ?>
                            <div class="alert <?php echo $this->session->flashdata('class_msg');?>">
                                <?php echo $this->session->flashdata('msg'); ?>
                            </div>
                            <br/>
                        <?php
                        }
                        ?>
                        <form id="form_discount" name="form_discount" action="<?php echo base_url();?>/offer/add_offer" method="post">

                            <div class="form-group form-float">
                                <label class="form-label">Offer Name</label>
                                <div class="form-line <?php if(form_error('offer_name') != false) { echo 'error focused'; }?>">
                                    <input type="hidden" name="offer_id" id="offer_id" class="form-control">
                                    <input type="text" name="offer_name" id="offer_name" class="form-control" value="<?php echo set_value('offer_name') ?>">                                 
                                </div>
                                <label id="date-error" class="error" for="offer_name"><?php echo form_error('offer_name'); ?></label>
                            </div>

                            <div class="form-group form-float">
                                <label class="form-label">Offer Type</label>
                                <div class="form-line <?php if(form_error('offer_type') != false) { echo 'error focused'; }?>">
                                    <select class="form-control show-tick" name="offer_type" id="offer_type">
                                        <option value="fixed">Fixed</option>
                                        <option value="percentage">Percentage</option>
                                    </select>                                   
                                </div>
                                <label id="date-error" class="error" for="offer_type"><?php echo form_error('offer_type'); ?></label>
                            </div>
                            <div class="form-group form-float">
                                <label class="form-label">Offer Applied Type</label>
                                <div class="form-line <?php if(form_error('offer_apply_type') != false) { echo 'error focused'; }?>">
                                    <select class="form-control show-tick" name="offer_apply_type" id="offer_apply_type">
                                        <option value="">Select</option>
                                        <option value="level0" <?php if(!empty($edit_offer_data[0]->offer_apply_type)){ if($edit_offer_data[0]->offer_apply_type=='level0'){ echo "selected";}}else if(set_value('offer_apply_type')=='level0'){ echo "selected";}?>>Category</option>
                                        <option value="level1" <?php if(!empty($edit_offer_data[0]->offer_apply_type)){ if($edit_offer_data[0]->offer_apply_type=='level1'){ echo "selected";}}else if(set_value('offer_apply_type')=='level1'){ echo "selected";}?> >Subcategory</option>
                                        <option value="level2" <?php if(!empty($edit_offer_data[0]->offer_apply_type)){ if($edit_offer_data[0]->offer_apply_type=='level2'){ echo "selected";}}else if(set_value('offer_apply_type')=='level2'){ echo "selected";}?> >Other</option>
                                        <option value="product" <?php if(!empty($edit_offer_data[0]->offer_apply_type)){ if($edit_offer_data[0]->offer_apply_type=='product'){ echo "selected";}}else if(set_value('offer_apply_type')=='product'){ echo "selected";}?> >Product</option>
                                    </select>                                   
                                </div>
                                <label id="date-error" class="error" for="offer_apply_type"><?php echo form_error('offer_apply_type'); ?></label>
                            </div>
                            <div class="form-group form-float">
                                <label class="form-label">Offer Applied Value</label>
                                <div class="form-line <?php if(form_error('offer_apply_id') != false) { echo 'error focused'; }?>">
                                    <select class="form-control show-tick" name="offer_apply_id" id="offer_apply_id" value="<?php echo set_value('offer_apply_id') ?>">
                                        <option value="">Select</option>
                                        <option value="1">Category</option>
                                        <option value="2">Subcategory</option>
                                        <option value="3">Inner Category</option>
                                        <option value="4">Product</option>
                                    </select>                                 
                                </div>
                                <label id="date-error" class="error" for="offer_apply_id"><?php echo form_error('offer_apply_id'); ?></label>
                            </div>
                            <div class="form-group form-float">
                                <div class="col-md-6 <?php if(form_error('offer_start_from') != false) { echo 'error focused'; }?>">
                                    <label class="form-label">Offer Start From</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Ex: 30/07/2016" name="offer_start_from" id="offer_start_from" value="<?php echo set_value('offer_start_from') ?>">
                                        </div>
                                        <label id="date-error" class="error" for="offer_start_from"><?php echo form_error('offer_start_from'); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Offer End To</label>
                                    <div class="input-group <?php if(form_error('offer_end_to') != false) { echo 'error focused'; }?>">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Ex: 30/07/2016" name="offer_end_to" id="offer_end_to" value="<?php echo set_value('offer_end_to') ?>">
                                        </div>
                                        <label id="date-error" class="error" for="offer_start_from"><?php echo form_error('offer_end_to'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <label class="form-label">Offer Value</label>
                                <div class="form-line <?php if(form_error('offer_value') != false) { echo 'error focused'; }?>">
                                    <input type="text" name="offer_value" id="offer_value" class="form-control" value="<?php echo set_value('offer_value') ?>">                                 
                                </div>
                                <label id="date-error" class="error" for="offer_value"><?php echo form_error('offer_value'); ?></label>
                            </div>
                            <div class="form-group form-float">
                                <button class="btn btn-primary waves-effect" type="submit" name="save_category" id="save_category">Save Offer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include("include/footer.php");?>
