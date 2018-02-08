<section class="content">
    <div class="container-fluid">
        <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                   <h1> <b>Product Excel File</b> </h1>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 ">
               <a href="<?php echo base_url();?>/product/product_list" ><button class="btn btn-primary waves-effect button_postion" type="button">Product List</button></a>
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
                         <form id="form_product" name="form_product" action="<?php echo base_url();?>/product/ExcelDataAdd" method="post" enctype="multipart/form-data" onsubmit="return validate_error();">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="file" class="form-control" name="userfile" required>
                                </div>
                                <div class="help-info">Excel File Only</div>
                            </div>
                            <button class="btn btn-primary waves-effect" type="submit" name="submit" value="submit">Upload Excel</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<?php include("include/footer.php");?>