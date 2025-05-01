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
                        <h5><a href="https://phpstack-1074629-4371560.cloudwaysapps.com/admin/help_center/">Help Center</a> <span>/ Restaurant Management</span></h5>
                        <h1>Restaurant Management</h1>
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
                            <li><a href="#restaurantmenu1" class="menu-item" data-index="1"> <span class="circle"></span> Add Restaurant</a></li>
                            <li><a href="#restaurantmenu2" class="menu-item" data-index="2"> <span class="circle"></span> Search Restaurant</a></li>
                            <li><a href="#restaurantmenu3" class="menu-item" data-index="3"> <span class="circle"></span> Show Entries</a></li>
                            <li><a href="#restaurantmenu4" class="menu-item" data-index="4"> <span class="circle"></span> Restaurant List</a></li>
                            <li><a href="#restaurantmenu5" class="menu-item" data-index="5"> <span class="circle"></span> Actions: View | Edit | Delete</a></li>
                            <li><a href="#restaurantmenu6" class="menu-item" data-index="6"> <span class="circle"></span> Import Restaurant</a></li>
                            <li><a href="#restaurantmenu7" class="menu-item" data-index="7"> <span class="circle"></span> Export Restaurant</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-9">
                    <div class="content-main">
                            <div class="content" id="restaurantmenu1">
                                <h4>How to Add a New Restaurant</h4>
                                <p>To add a new restaurant to the system, follow these steps:</p>
                                <ol>
                                    <li>Navigate to the "Restaurants Management" section.</li>
                                    <li>Click on the "Add Restaurant" button.</li>
                                    <li>Fill in the necessary details in the multi-step form:
                                        <h5>Step 1: Restaurant Info</h5>
                                        <ul>
                                            <li>Fields: Name, Website URL, Unique ID, Map Link, Phone Number, Email, Description, Address, Deposit Applicable, Late Cancel/No-Show Fee.</li>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/add-restaurant.jpg" alt="screenshot">
                                        </ul>
                                        <h5>Step 2: Booking Slot</h5>
                                        <ul>
                                            <li>Fields: Reservation Time, Date, Table Size, Capacity, Actions.</li>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/booking-restaurant.jpg" alt="screenshot">
                                        </ul>
                                        <h5>Step 3: Upload Menu & Images</h5>
                                        <ul>
                                            <li>Fields: Upload Restaurant Content, Menu, Feature Image, Images.</li>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/upload-menu.jpg" alt="screenshot">
                                        </ul>
                                    </li>
                                    <li>Click "Save" to add the restaurant to the database.</li>
                                </ol>
                            </div>
                            <div class="content" id="restaurantmenu2">
                                <h4>Methods to Search for a Restaurant</h4>
                                <ol>
                                    <li>Navigate to the "Restaurants Management" section.</li>
                                    <li>Use the search bar at the top to enter the restaurant's name or other details.</li>
                                    <li>Filter results using predefined and custom filters.
                                    <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/filter-screenshot.jpg" alt="screenshot">
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="restaurantmenu3">
                                <h4>Display Options for Restaurant Entries</h4>
                                <ol>
                                    <li>Navigate to the "Restaurants Management" section.</li>
                                    <li>Use the "Show Entries" dropdown to select the number of entries displayed per page (25, 50, 100).
                                    <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/entity-screenshot.jpg" alt="screenshot">
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="restaurantmenu4">
                                <h4>Overview of Restaurant List</h4>
                                <p>The restaurant list includes the following columns:</p>
                                <ul>
                                    <li>Restaurant Image</li>
                                    <li>Name</li>
                                    <li>Contact</li>
                                    <li>Email</li>
                                    <li>Deposit</li>
                                    <li>Seating Capacity</li>
                                    <li>Action</li>
                                    <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/restaurant-list-screenshot.jpg" alt="screenshot">
                                </ul>
                            </div>
                            <div class="content" id="restaurantmenu5">
                                <h4>Manage Restaurant Entries</h4>
                                <ol>
                                    <li><strong>View:</strong> Click "View" to see detailed information about the restaurant.
                                    <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/view-edit-deletescreenshot.jpg" alt="screenshot">
                                    </li>
                                    <li><strong>Edit:</strong> Click "Edit" to modify restaurant details. The edit form follows the same steps as adding a restaurant.
                                    <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/view-edit-deletescreenshot.jpg" alt="screenshot">
                                    </li>
                                    <li><strong>Delete:</strong> Click "Delete" to remove the restaurant from the database.
                                    <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/view-edit-deletescreenshot.jpg" alt="screenshot">
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="restaurantmenu6">
                                <h4>How to Import Restaurants</h4>
                                <ol>
                                    <li>Navigate to the "Restaurants Management" section.</li>
                                    <li>Click on the "Import Restaurant" button.</li>
                                    <li>Drag & drop an .xlsx file or browse to upload it.</li>
                                    <li>Ensure the file format is .xlsx for successful upload.</li>
                                    <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/import-screenshot.jpg" alt="screenshot">
                                </ol>
                            </div>
                            <div class="content" id="restaurantmenu7">
                                <h4>How to Export Restaurants</h4>
                                <ol>
                                    <li>Navigate to the "Restaurants Management" section.</li>
                                    <li>Click on the "Export Restaurant" button.</li>
                                    <li>The .xlsx file will automatically download with the following details:
                                        <ul>
                                            <li>Restaurant name, Property type, Description, Website URL, Address, Phone, Fee, Person, Group.</li>
                                            <li>Reservation details including start date, time, table size, and capacity.</li>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/export-screenshot.jpg" alt="screenshot">
                                        </ul>
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