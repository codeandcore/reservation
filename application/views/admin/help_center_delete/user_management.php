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
                        <h5><a href="https://phpstack-1074629-4371560.cloudwaysapps.com/admin/help_center/">Help Center</a> <span>/ User Management</span></h5>
                        <h1>User Management</h1>
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
                            <li><a href="#usermenu1" class="menu-item" data-index="1"> <span class="circle"></span>Add User</a></li>
                            <li><a href="#usermenu2" class="menu-item" data-index="2"> <span class="circle"></span>Search User</a></li>
                            <li><a href="#usermenu3" class="menu-item" data-index="3"> <span class="circle"></span>Show Entries</a></li>
                            <li><a href="#usermenu4" class="menu-item" data-index="4"> <span class="circle"></span>User List</a></li>
                            <li><a href="#usermenu5" class="menu-item" data-index="5"> <span class="circle"></span>Import User</a></li>
                            <li><a href="#usermenu6" class="menu-item" data-index="6"> <span class="circle"></span>Export User</a></li>
                            <li><a href="#usermenu7" class="menu-item" data-index="7"> <span class="circle"></span>Bulk Delete</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-9">
                    <div class="content-main">
                            <div class="content" id="usermenu1">
                                <h4>How to Add a New User</h4>
                                <ol>
                                    <li>Navigate to the "User Management" section.</li>
                                    <li>Click on the "Add User" button. </li>
                                    <li>Fill in the necessary details in the form:
                                        <ul>
                                            <li>User code, Email, Alternative email, Name, Contact, Temporary Password.</li>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/new-user-screenshot.jpg" alt="screenshot">
                                        </ul>
                                     </li>
                                    <li>Click "Save" to add the user to the database.</li>
                                    <li>The user will receive an email with a temporary password to set their own password and log in.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/screenshot-userlist.jpg" alt="user list"></ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="usermenu2">
                                <h4>Methods to Search for a User</h4>
                                <ol>
                                    <li>Navigate to the "User Management" section. </li>
                                    <li>Use the search bar at the top to enter the user's name or email. </li>
                                    <li>Filter results using predefined and custom filters.
                                        <ul> <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/search-user.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="usermenu3">
                                <h4>Display Options for User Entries</h4>
                               <ol>
                                <li>Navigate to the "User Management" section.</li>
                                <li>Use the "Show Entries" dropdown to select the number of entries displayed per page (25, 50, 100).
                                    <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/user-entity.jpg" alt="screenshot"></ul>
                                </li>
                               </ol>
                            </div>
                            <div class="content" id="usermenu4">
                                <h4>Overview of User List</h4>
                                <p>The user list includes the following columns:</p>
                               <ul>
                                <li>User code</li>
                                <li>User email</li>
                                <li>User alternative email</li>
                                <li>Name</li>
                                <li>Contact</li>
                                <li>Temporary Password</li>
                                <li>Booking status</li>
                                <li>Actions: Edit, Delete, Resend Confirmation, Send Temporary Password, Edit Card Details
                                    <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/user-list.jpg" alt="screenshot"></ul>
                                </li>
                               </ul>
                            </div>
                            <div class="content" id="usermenu5">
                                <h4>How to Import Users</h4>
                               <ol>
                                <li>Navigate to the "User Management" section.</li>
                                <li>Click on the "Import Sheet" button.</li>
                                <li>Drag & drop an .xlsx file or browse to upload it.</li>
                                <li>Ensure the file format is .xlsx for successful upload.
                                    <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/import-userlist.jpg" alt="screenshot"></ul>
                                </li>
                               </ol>
                            </div>
                            <div class="content" id="usermenu6">
                                <h4>How to Export Users</h4>
                               <ol>
                                <li>Navigate to the "User Management" section.</li>
                                <li>Click on the "Download Sheet" button</li>
                                <li>The .xlsx file will automatically download with the following details:
                                    <ul>
                                        <li>User code, Email, Alternative email, Name, Contact, Temporary Password.</li>
                                        <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/export-user.jpg" alt="screenshot">
                                    </ul>
                                </li>
                               </ol>
                            </div>
                            <div class="content" id="usermenu7">
                                <h4>How to Delete Users in Bulk</h4>
                               <ol>
                                <li>Navigate to the "User Management" section.</li>
                                <li>Select multiple users using the checkboxes next to their names.</li>
                                <li>Click on the "Bulk Delete" button.</li>
                                <li>Confirm the deletion.
                                    <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/delete-bulk-user-screenshot.jpg" alt="bulk user delete"></ul>
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
</div>