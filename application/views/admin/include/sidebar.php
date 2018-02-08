 <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</div>
                    <div class="email"><?php //echo $this->session->userdata['name'];?>admin@gmail.com</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Change Password</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="active">
                        <a href="<?php echo base_url();?>home/index">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">widgets</i>
                            <span>Masters</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url();?>category/category_master">Category Master</a>
                                <a href="<?php echo base_url();?>category/subcategory_master">SubCategory Master</a>
                                <a href="<?php echo base_url();?>discount/discount_list">Discount Master</a>
                                <a href="<?php echo base_url();?>offer/offer_list">Offer Master</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">swap_calls</i>
                            <span>Product</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url();?>product/product_list">Product Master</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="menu-toggle">
                            <i class="material-icons">assignment</i>
                            <span>Sales Master</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url();?>Sales/sales_list">Sales</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">assignment</i>
                            <span>Suppliers</span>
                        </a>
                        
                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url();?>home/Suppliers_list">Suppliers List</a>                                
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">assignment</i>
                            <span>Users </span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url();?>home/Customers_list">Users List</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">assignment</i>
                            <span>Reports</span>
                        </a>
                       
                        <ul class="ml-menu">
                            <li>
                                <a href="pages/widgets/cards/basic.html">Reports Master</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
       
        <!-- #END# Right Sidebar -->
    