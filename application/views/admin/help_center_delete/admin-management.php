<?php
/**
 * Help Center User Management Template
 */
?>
<div class="main-wrap">
    <!-- start :: banner-section -->
    <section class="banner-section inner-banner user-management pos_rel">
        <div class="user-icon">
            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/user-management.svg" alt="user list">
        </div>
        <div class="container-default">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="banner-main-info">
                        <h5><a href="https://phpstack-1074629-4371560.cloudwaysapps.com/admin/help_center/">Help Center</a> <span>/ Admin Management</span></h5>
                        <h1>Admin Management</h1>
                    </div>
                </div>
                <div class="col-6">
                    <div class="banner-main-info">
                        <div class="search-input-wrapper pos_rel">
                            <input type="search" placeholder="What can we help with?">
                            <input type="submit" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end :: banner-section -->
    <!-- start :: menubar-section -->
    <section class="menubar-section">
        <div class="container-default">
           <div class="row">
                <div class="col-3">
                    <nav class="sidebar">
                        <div class="line"></div>
                        <ul>
                            <li><a href="#adminmenu1" class="menu-item" data-index="1"> <span class="circle"></span>Add New Admin</a></li>
                            <li><a href="#adminmenu2" class="menu-item" data-index="2"> <span class="circle"></span>View All Admins</a></li>
                            <li><a href="#adminmenu3" class="menu-item" data-index="3"> <span class="circle"></span>Show Entries</a></li>
                            <li><a href="#adminmenu4" class="menu-item" data-index="4"> <span class="circle"></span>Search Admin</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-9">
                    <div class="content-main">
                            <div class="content" id="adminmenu1">
                                <h4>How to Add a New Admin</h4>
                                <ol>
                                    <li>Navigate to the "Admin Management" section.</li>
                                    <li>Click on the "Add New Admin" button. </li>
                                    <li>Fill in the necessary details in the form:
                                        <ul>
                                            <li>Admin name, Last name, Email.</li>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/new-admin.jpg" alt="new admin">
                                        </ul>
                                     </li>
                                    <li>Click "Save" to add the admin to the database.</li>
                                    <li>The admin will receive an email with a temporary password to set their own password and log in.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/admin-list.jpg" alt="admin list"></ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="adminmenu2">
                                <h4>Overview of Admin List</h4>
                                <p>The admin list includes the following columns:</p>
                                <ul>
                                    <li>Admin email</li>
                                    <li>Admin name </li>
                                    <li>Admin contact</li>
                                    <li>Actions: Edit, Delete, Send Temporary Password
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/add-delete-view.jpg" alt="admin list"></ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="content" id="adminmenu3">
                                <h4>Display Options for Admin Entries</h4>
                                <ol>
                                    <li>Navigate to the "Admin Management" section.</li>
                                    <li>Use the "Show Entries" dropdown to select the number of entries displayed per page (25, 50, 100). 
                                        <ul> <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/admin-entity.jpg" alt="admin entity"></ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="adminmenu4">
                                <h4>Methods to Search for an Admin</h4>
                                <ol>
                                    <li>Navigate to the "Admin Management" section.</li>
                                    <li>Use the search bar at the top to enter the admin's name or email.</li>
                                    <li>Filter results using predefined and custom filters.
                                        <ul> <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/filter-admin.jpg" alt="filter admin"></ul>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end :: menubar-section -->
</div8