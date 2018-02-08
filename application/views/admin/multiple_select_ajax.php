<?php
if(!empty($result))
{?>
    <div class="form-group form-float">
            <label class="form-label">Category Level-<?php echo $level;?> </label>
            <?php $cat_var ='category_level_'.$level;?>
            <div class="form-line <?php if(form_error($cat_var) != false) { echo 'error focused'; }?>">
                
                    <select class="form-control show-tick" name="category_level_<?php echo $level;?>" id="category_level_<?php echo $level;?>" onchange="get_selected_data(this.value,'<?php echo $level;?>')">
                        <option value="">Select Level-<?php echo $level;?></option>
                        <?php  
                        if(!empty($result)>0)
                        {
                            
                            for($i=0;$i<count($result);$i++)
                            {
                                ?>
                                <option value="<?php echo $result[$i]->category_id;?>"><?php echo ucfirst($result[$i]->category_name);?></option>
                            <?php
                           
                            }
                        }
                        ?>
                    </select>      
                                         
            </div>
            <label id="category_level_<?php echo $level;?>-error" class="error" for="category_level_<?php echo $level;?>"><?php echo form_error($cat_var); ?></label>
    </div>
<?php
}
else
{
    ?>
    <div class="form-group form-float">  </div>
    <?php
}
?>    
