<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                <?php 
                if(!empty($edit_discount_data[0]->discount_id))
                {?>
                   <h1> <b>Modify Discount</b> </h1> 
                <?php
                }
                else
                {
                    ?>
                    <h1> <b>Add Discount</b> </h1>
                    <?php
                }
                ?>
               
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 ">
                <a href="<?php echo base_url();?>/discount/discount_list" ><button class="btn btn-primary waves-effect button_postion" type="button">Discount List</button></a>
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
                        <form id="form_discount" name="form_discount" action="<?php echo base_url();?>/discount/add_discount" method="post">

                            <div class="form-group form-float">
                                <label class="form-label">Discount Name</label>
                                <div class="form-line <?php if(form_error('discount_name') != false) { echo 'error focused'; }?>">
                                    <input type="hidden" name="discount_id" id="discount_id" class="form-control" value="<?php if(!empty($edit_discount_data[0]->discount_id)){ echo $edit_discount_data[0]->discount_id;}?>">
                                    <input type="text" name="discount_name" id="discount_name" class="form-control" value="<?php if(!empty($edit_discount_data[0]->discount_apply_type)){ echo $edit_discount_data[0]->discount_name;}else { echo set_value('discount_name'); }?>">                                 
                                </div>
                                <label id="date-error" class="error" for="discount_name"><?php echo form_error('discount_name'); ?></label>
                            </div>

                            <div class="form-group form-float">
                                <label class="form-label">Discount Type</label>
                                <div class="form-line <?php if(form_error('discount_type') != false) { echo 'error focused'; }?>">
                                    <select class="form-control show-tick" name="discount_type" id="discount_type">
                                        <option value="">Select</option>
                                        <option value="fixed" <?php if(!empty($edit_discount_data[0]->discount_type)){ if($edit_discount_data[0]->discount_type=='level0'){ echo "selected";}}else if(set_value('discount_type')=='level0'){ echo "selected";}?>>Fixed</option>
                                        <option value="percentage" <?php if(!empty($edit_discount_data[0]->discount_type)){ if($edit_discount_data[0]->discount_type=='level0'){ echo "selected";}}else if(set_value('discount_type')=='level0'){ echo "selected";}?>>Percentage</option>
                                    </select>                                   
                                </div>
                                <label id="date-error" class="error" for="discount_type"><?php echo form_error('discount_type'); ?></label>
                            </div>
                            <div class="form-group form-float">
                                <label class="form-label">Discount Applied Type</label>
                                <div class="form-line <?php if(form_error('discount_apply_type') != false) { echo 'error focused'; }?>">
                                    <select class="form-control show-tick" name="discount_apply_type" id="discount_apply_type" onchange="get_selected_data(this.value)">
                                        <option value="">Select</option>
                                        <option value="level0" <?php if(!empty($edit_discount_data[0]->discount_apply_type)){ if($edit_discount_data[0]->discount_apply_type=='level0'){ echo "selected";}}else if(set_value('discount_apply_type')=='level0'){ echo "selected";}?>>Category</option>
                                        <option value="level1" <?php if(!empty($edit_discount_data[0]->discount_apply_type)){ if($edit_discount_data[0]->discount_apply_type=='level1'){ echo "selected";}}else if(set_value('discount_apply_type')=='level1'){ echo "selected";}?> >Subcategory</option>
                                        <option value="product" <?php if(!empty($edit_discount_data[0]->discount_apply_type)){ if($edit_discount_data[0]->discount_apply_type=='product'){ echo "selected";}}else if(set_value('discount_apply_type')=='product'){ echo "selected";}?> >Other</option>
                                        <option value="product" 
                                        <?php if(!empty($edit_discount_data[0]->discount_apply_type)){ if($edit_discount_data[0]->discount_apply_type=='product'){ echo "selected";}}else if(set_value('discount_apply_type')=='product'){ echo "selected";}?> >Product</option>
                                    </select>                                   
                                </div>
                                <label id="date-error" class="error" for="discount_apply_type"><?php echo form_error('discount_apply_type'); ?></label>
                            </div>
                            <div class="form-group form-float">
                                <label class="form-label">Discount Applied Value</label>
                                <div class="form-line <?php if(form_error('discount_applied_id') != false) { echo 'error focused'; }?>">
                                    <select class="form-control show-tick" name="discount_applied_id" id="discount_applied_id" value="<?php echo set_value('discount_applied_id') ?>">
                                        
                                    </select>                                 
                                </div>
                                <label id="date-error" class="error" for="discount_applied_id"><?php echo form_error('discount_applied_id'); ?></label>
                            </div>
                            <div class="form-group form-float">
                                <div class="col-md-6 <?php if(form_error('discount_start_from') != false) { echo 'error focused'; }?>">
                                    <label class="form-label">Discount Start From</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Ex: 30/07/2016" name="discount_start_from" id="discount_start_from" value="<?php if(!empty($edit_discount_data[0]->discount_start_from)){ echo date('d/m/Y',strtotime($edit_discount_data[0]->discount_start_from));}else { echo set_value('discount_start_from'); }?>">
                                        </div>
                                        <label id="date-error" class="error" for="discount_start_from"><?php echo form_error('discount_start_from'); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Discount End To</label>
                                    <div class="input-group <?php if(form_error('discount_end_to') != false) { echo 'error focused'; }?>">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Ex: 30/07/2016" name="discount_end_to" id="discount_end_to" value="<?php if(!empty($edit_discount_data[0]->discount_end_to)){  echo date('d/m/Y',strtotime($edit_discount_data[0]->discount_end_to));}else { echo set_value('discount_end_to'); }?>">
                                        </div>
                                        <label id="date-error" class="error" for="discount_start_from"><?php echo form_error('discount_end_to'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <label class="form-label">Discount Value</label>
                                <div class="form-line <?php if(form_error('discount_value') != false) { echo 'error focused'; }?>">
                                    <input type="text" name="discount_value" id="discount_value" class="form-control" value="<?php if(!empty($edit_discount_data[0]->discount_value)){ echo $edit_discount_data[0]->discount_value;}else { echo set_value('discount_value'); }?>" >                                 
                                </div>
                                <label id="date-error" class="error" for="discount_value"><?php echo form_error('discount_value'); ?></label>
                            </div>
                            <div class="form-group form-float">
                                <?php 
                                if(!empty($edit_discount_data[0]->discount_id))
                                {?>
                                    <button class="btn btn-primary waves-effect" type="submit" name="save_category" id="save_category">Update Discount</button>
                                <?php
                                }
                                else
                                {
                                    ?>
                                    <button class="btn btn-primary waves-effect" type="submit" name="save_category" id="save_category">Save Discount</button>
                                    <?php
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include("include/footer.php");?>
<script type="text/javascript">
    function get_selected_data(selected_value)
    {
        alert(selected_value);
        $.ajax
            ({
                    type: "post",
                    url: "<?php echo base_url('discount/discount_selected_type');?>",
                    data: {'selected_value':selected_value},
                    success: function(responseData) 
                    {
                        alert(responseData);
                        $("#discount_applied_id").html(responseData);
                    }
            });
    }
</script>
