<?php
/**
 * Help Center User Management Template
 */
?>
<div class="main-wrap">
    <!-- start :: banner-section -->
    <section class="banner-section inner-banner user-management pos_rel">
        <div class="user-icon">
            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/user-management.svg" alt="screenshot">
        </div>
        <div class="container-default">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="banner-main-info">
                        <h5><a href="https://phpstack-1074629-4371560.cloudwaysapps.com/admin/help_center/">Help Center</a> <span>/ Booking Report Dashboard</span></h5>
                        <h1>Booking Report Dashboard</h1>
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
                            <li><a href="#bookingmenu1" class="menu-item" data-index="1"> <span class="circle"></span>Restaurant slot reservation reports</a></li>
                            <li><a href="#bookingmenu2" class="menu-item" data-index="2"> <span class="circle"></span> Master reservation</a></li>
                            <li><a href="#bookingmenu3" class="menu-item" data-index="3"> <span class="circle"></span>Master modification logs</a></li>
                            <li><a href="#bookingmenu4" class="menu-item" data-index="4"> <span class="circle"></span> All bookings</a></li>
                            <li><a href="#bookingmenu5" class="menu-item" data-index="5"> <span class="circle"></span> Accepted reservations</a></li>
                            <li><a href="#bookingmenu6" class="menu-item" data-index="6"> <span class="circle"></span> Non-responders</a></li>
                            <li><a href="#bookingmenu7" class="menu-item" data-index="7"> <span class="circle"></span>Partial reservations</a></li>
                            <li><a href="#bookingmenu8" class="menu-item" data-index="8"> <span class="circle"></span>Canceled reservations</a></li>
                            <li><a href="#bookingmenu9" class="menu-item" data-index="9"> <span class="circle"></span>Invite list</a></li>
                            <li><a href="#bookingmenu10" class="menu-item" data-index="10"> <span class="circle"></span>Unauthorized user emails</a></li>
                            <li><a href="#bookingmenu11" class="menu-item" data-index="11"> <span class="circle"></span>Credit card details</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-9">
                    <div class="content-main">
                            <div class="content" id="bookingmenu1">
                                <h4>Overview of Restaurant Slot Reservation Reports</h4>
                                <p>This page displays a comprehensive list of restaurant slot reservations with the following columns:</p>
                                <ul>
                                    <li><strong>Restaurant Name:</strong> The name of the restaurant.</li>
                                    <li><strong>Property Type:</strong> The type of property.</li>
                                    <li><strong>Reservation Time:</strong> The time of the reservation.</li>
                                    <li><strong>Reservation Date:</strong> The date of the reservation.</li>
                                    <li><strong>Table Size:</strong> The size of the table.</li>
                                    <li><strong>Capacity:</strong> The seating capacity.</li>
                                    <li><strong>Booked:</strong> The number of seats booked.</li>
                                    <li><strong>Remaining:</strong> The number of seats remaining.</li>
                                    <li><strong>Action:</strong> Actions available for each entry.
                                        <h5>Viewing Table Occupancy</h5>
                                        <ol>
                                            <li>Click the "View" button in the "Action" column.</li>
                                            <li>A pop-up window will display detailed information about table occupancy, including confirmation status and guest names.</li>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/booking-pop-up.jpg" alt="screenshot">
                                        </ol>
                                    </li>
                                </ul>
                                <h4>Downloading Reports</h4>
                                <ol>
                                    <li>Click the "Download Report" button.</li>
                                    <li>An .xlsx file will be automatically downloaded with the following details:
                                        <ul>
                                            <li>Restaurant name, property type, reservation time, reservation date, table size, capacity, booked, remaining, and booked list.</li>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/booking-download-report.jpg" alt="screenshot">
                                        </ul>
                                    </li>
                                </ol>
                               <h4>Show Entries</h4>
                               <ol>
                                <li>Use the "Show Entries" dropdown to select the number of entries displayed per page (25, 50, 100).</li>
                                <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/booking-entity.jpg" alt="screenshot">
                               </ol>
                               <h4>Search</h4>
                               <ol>
                                <li>Use the search bar to find specific reservations.</li>
                                <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/search-booking.jpg" alt="screenshot">
                               </ol>
                               <h4>Filtering Data</h4>
                               <ol>
                                <li>Click on column headers to sort data alphabetically or numerically.</li>
                                <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/softing-arrow-booking.jpg" alt="screenshot">
                               </ol>
                            </div>
                            <div class="content" id="bookingmenu2">
                                <h4>Overview of Master Reservation</h4>
                                <p>This page includes detailed columns for each reservation:</p>
                                <ul>
                                    <li><strong>First and Last Name:</strong> The names of the guests. </li>
                                    <li><strong>Email Address:</strong> The guest's email. </li>
                                    <li><strong>Response Status:</strong> The status of the response.</li>
                                    <li><strong>Day 1 Status:</strong> Status for Day 1.</li>
                                    <li><strong>Day 1 Role:</strong> Role for Day 1.</li>
                                    <li><strong>Day 1 Date:</strong> Date for Day 1.</li>
                                    <li><strong>Day 1 Time:</strong> Time for Day 1.</li>
                                    <li><strong>Day 1 Restaurant Name:</strong> Restaurant name for Day 1.</li>
                                    <li><strong>Day 1 Property Type:</strong> Property type for Day 1.</li>
                                    <li><strong>Day 1 Pax:</strong> Number of people for Day 1.</li>
                                    <li><strong>Day 1 Guests:</strong> Guests for Day 1.</li>
                                    <li><strong>Day 1 Admin Note:</strong> Admin notes for Day 1.</li>
                                    <li><strong>Day 1 Last Updated:</strong> Last update for Day 1.</li>
                                    <ul>
                                        <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/marter-resorvation.jpg" alt="screenshot">
                                    </ul>
                                </ul>
                                <h4>Downloading Master Reservation Reports</h4>
                                <ol>
                                    <li>Click the "Download Report" button.</li>
                                    <li>An .xlsx file will be automatically downloaded with details such as first and last name, email address, response status, and detailed day-by-day information.
                                        <ul>
                                        <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/download-master-reservation.jpg" alt="screenshot">
                                        </ul>
                                    </li>
                                </ol>
                                <h4>Filtering by Date and Status</h4>
                                <ol>
                                    <li>Use the start date and end date fields to filter data by date.
                                        <ul> <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/date-status-filter.jpg" alt="screenshot"></ul>
                                    </li>
                                    <li>Use the status filter to select specific statuses.
                                        <ul>
                                        <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/status=filter.jpg" alt="screenshot">
                                        </ul>
                                    </li>
                                </ol>
                                <h4>Show Entries</h4>
                                <ol>
                                    <li>Use the "Show Entries" dropdown to select the number of entries displayed per page (25, 50, 100).
                                        <ul>
                                        <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/entity-marter-reservation.jpg" alt="screenshot">
                                        </ul>
                                    </li>
                                </ol>
                                <h4>Search</h4>
                                <ol>
                                    <li>Use the search bar to find specific reservations.
                                        <ul>
                                        <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/search-master-reservation.jpg" alt="screenshot">
                                        </ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="bookingmenu3">
                                <h4>Overview of Master Modification Logs</h4>
                                <p>This page tracks all modifications with the following columns:</p>
                                <ul>
                                    <li><strong>Time Stamp:</strong> The date and time of the modification.</li>
                                    <li><strong>Booking ID:</strong> The ID of the booking.</li>
                                    <li><strong>Action Performed:</strong> The action that was performed.</li>
                                    <li><strong>By:</strong> The user who performed the action.</li>
                                    <li><strong>By Email:</strong> The email of the user who performed the action.</li>
                                    <li><strong>For User:</strong> The user for whom the action was performed.</li>
                                    <li><strong>To User:</strong> The target user of the action.</li>
                                    <li><strong>Restaurant Name:</strong> The name of the restaurant.</li>
                                    <li><strong>Restaurant Date:</strong> The date of the reservation.</li>
                                    <li><strong>Restaurant Time:</strong> The time of the reservation.</li>
                                    <li><strong>No. of People:</strong> The number of people.</li>
                                    <li><strong>Reason Note:</strong> The reason for the modification.</li>
                                    <li><strong>Admin Note:</strong> Admin notes.
                                        <ul>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/master-modification-list.jpg" alt="screenshot">
                                        </ul>
                                    </li>
                                </ul>
                                <h4>Downloading Modification Logs</h4>
                                <ol>
                                    <li>Click the "Download Report" button.</li>
                                    <li>An .xlsx file will be automatically downloaded with detailed modification logs.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/master-modification-download-report.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Filtering by Date</h4>
                                <ol>
                                    <li>Use the start date and end date fields to filter data by date.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/master-modification-by date-sorting.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Show Entries</h4>
                                <ol>
                                    <li>Use the "Show Entries" dropdown to select the number of entries displayed per page (25, 50, 100).
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/master-modification-entity.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Search</h4>
                                <ol>
                                    <li>Use the search bar to find specific modification logs.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/master-modification-search.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="bookingmenu4">
                                <h4>Overview of All Bookings</h4>
                                <p>This page includes comprehensive details of all bookings with the following columns:</p>
                                <ul>
                                    <li><strong>User Code: </strong> The code assigned to the user.</li>
                                    <li><strong>User Email:</strong> The email of the user.</li>
                                    <li><strong>Alternate Email:</strong> The alternate email of the user.</li>
                                    <li><strong>Full Name:</strong> The full name of the user.</li>
                                    <li><strong>Booking Status:</strong> The status of the booking.</li>
                                    <li><strong>Dates:</strong> Columns for each trip date.</li>
                                    <li><strong>Modified Date:</strong> The date when the booking was last modified.</li>
                                    <li><strong>Action:</strong> Actions available for each entry.
                                        <h5>Viewing Reservation Details</h5>
                                        <ol>
                                            <li>Click the "View" button in the "Action" column to view detailed reservation information for a specific user.</li>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/all-booking.jpg" alt="screenshot">
                                        </ol>
                                    </li>
                                </ul>
                                <h4>Downloading Booking Reports</h4>
                                <ol>
                                    <li>Click the "Download Report" button.</li>
                                    <li>An .xlsx file will be automatically downloaded with comprehensive booking details.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/all-booking-download-report.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Filtering by Date and Status</h4>
                                <ol>
                                    <li>Use the start date and end date fields to filter data by date.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/all-booking-filter-date-sorting.jpg" alt="screenshot"></ul>
                                    </li>
                                    <li>Use the status filter to select specific booking statuses.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/all-booking-status-filter.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Show Entries</h4>
                                <ol>
                                    <li>Use the "Show Entries" dropdown to select the number of entries displayed per page (25, 50, 100).
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/all-booking-show-entity.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Search</h4>
                                <ol>
                                    <li>Use the search bar to find specific bookings.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/all-booking-searchbar.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>View and Detail View</h4>
                                <ol>
                                    <li>Toggle between list view and detail view for different levels of information.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/all-booking-view-detail-sorting.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="bookingmenu5">
                                <h4>Overview of Accepted Reservations</h4>
                                <p>This page includes detailed columns for accepted reservations:</p>
                                <ul>
                                    <li><strong>Confirmation ID:</strong> The code assigned to the user.</li>
                                    <li><strong>Invited Type:</strong> The email of the user.</li>
                                    <li><strong>User Name:</strong> The alternate email of the user.</li>
                                    <li><strong>User Email:</strong> The full name of the user.</li>
                                    <li><strong>Restaurant Name:</strong> The status of the booking.</li>
                                    <li><strong>Date:</strong> Columns for each trip date.</li>
                                    <li><strong>Time:</strong> The date when the booking was last modified.</li>
                                    <li><strong>Skip Days:</strong> Actions available for each entry.</li>
                                    <li><strong>No. of People:</strong> Actions available for each entry.</li>
                                    <li><strong>Deposit:</strong> Actions available for each entry.</li>
                                    <li><strong>Booked Date:</strong> Actions available for each entry.</li>
                                    <li><strong>Booked Time:</strong> Actions available for each entry.</li>
                                    <li><strong>Modified Date: </strong> Actions available for each entry.</li>
                                    <li><strong>Admin Note: </strong> Actions available for each entry.</li>
                                    <li><strong>Action:</strong> Actions available for each entry.
                                        <ul>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/accept-reservations.jpg" alt="screenshot">
                                        </ul>
                                    </li>
                                </ul>
                                <h4>Downloading Accepted Reservation Reports</h4>
                                <ol>
                                    <li>Click the "Download Report" button.</li>
                                    <li>An .xlsx file will be automatically downloaded with details such as confirmation ID, user name, user email, and reservation details.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/accept-reservation-download-report.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Filtering by Date and Status</h4>
                                <ol>
                                    <li>Use the start date and end date fields to filter data by date.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/accepted-reservation-date-sorting.jpg" alt="screenshot"></ul>
                                    </li>
                                    <li>Use the status filter to select specific booking statuses.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/accepted-reservation-status-filter.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Show Entries</h4>
                                <ol>
                                    <li>Use the "Show Entries" dropdown to select the number of entries displayed per page (25, 50, 100).
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/accepted-reservation-entity-filter.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Search</h4>
                                <ol>
                                    <li>Use the search bar to find specific reservations.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/accepted-reservation-search.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>View and Detail View</h4>
                                <ol>
                                    <li>Toggle between list view and detail view for different levels of information.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/accepted-reservation-view-detail.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="bookingmenu6">
                                <h4>Overview of Non-Responders</h4>
                                <p>This page includes the following columns for non-responders:</p>
                                <ul>
                                    <li><strong>User Email:</strong> The email of the user.</li>
                                    <li><strong>User Name:</strong> The name of the user.</li>
                                    <li><strong>User Contact:</strong> The contact details of the user.</li>
                                    <li><strong>Reservation Status:</strong> The status of the reservation.
                                        <ul>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/non-responders.jpg" alt="screenshot">
                                        </ul>
                                    </li>
                                </ul>
                                <h4>Booking for Non-Responders</h4>
                                <ol>
                                    <li>In the "Reservation Status" column, click on the "No Response" link to book the restaurant for the user.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/non-responder-no-responce-btn.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Downloading Non-Responder Reports</h4>
                                <ol>
                                    <li>Click the "Download Report" button.</li>
                                    <li>An .xlsx file will be automatically downloaded with details such as user email, user name, and reservation status.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/non-responder-download-report.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Show Entries</h4>
                                <ol>
                                    <li>Use the "Show Entries" dropdown to select the number of entries displayed per page (25, 50, 100).
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/non-responder-entity.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Search</h4>
                                <ol>
                                    <li>Use the search bar to find specific non-responders.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/non-responder-search.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="bookingmenu7">
                                <h4>Overview of Partial Reservations</h4>
                                <p>This page includes detailed columns for partial reservations:</p>
                                <ul>
                                    <li><strong>Confirmation ID:</strong> The confirmation ID of the reservation.</li>
                                    <li><strong>Invited Type:</strong> The type of invite.</li>
                                    <li><strong>User Name:</strong> The name of the user.</li>
                                    <li><strong>User Email:</strong> The email of the user.</li>
                                    <li><strong>Restaurant Name:</strong> The name of the restaurant.</li>
                                    <li><strong>Date</strong> The date of the reservation.</li>
                                    <li><strong>Time:</strong> The time of the reservation.</li>
                                    <li><strong>Skip Days:</strong> The days skipped.</li>
                                    <li><strong>No. of People:</strong> The number of people.</li>
                                    <li><strong>Deposit:</strong> The deposit amount.</li>
                                    <li><strong>Booked Date:</strong> The date the reservation was booked.</li>
                                    <li><strong>Booked Time:</strong> The time the reservation was booked.</li>
                                    <li><strong>Modified Date:</strong> The date when the reservation was last modified.</li>
                                    <li><strong>Admin Note:</strong> Admin notes.</li>
                                    <li><strong>Action:</strong> Actions available for each entry.
                                        <ul>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/partial-reservation.jpg" alt="screenshot">
                                        </ul>
                                    </li>
                                </ul>
                                <h4>Downloading Partial Reservation Reports</h4>
                                <ol>
                                    <li>Click the "Download Report" button.</li>
                                    <li>An .xlsx file will be automatically downloaded with details such as confirmation ID, user name, user email, and reservation details.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/partial-reservation-download-report.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Filtering by Date and Status</h4>
                                <ol>
                                    <li>Use the start date and end date fields to filter data by date.
                                    <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/partial-reservation-filtering-date.jpg" alt="screenshot"></ul>
                                    </li>
                                    <li>Use the status filter to select specific reservation statuses.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/partial-reservation-status-filter.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Show Entries</h4>
                                <ol>
                                    <li>Use the "Show Entries" dropdown to select the number of entries displayed per page (25, 50, 100).
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/partial-reservation-entries.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Search</h4>
                                <ol>
                                    <li>Use the search bar to find specific reservations.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/partial-reservation-search.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>View and Detail View</h4>
                                <ol>
                                    <li>Toggle between list view and detail view for different levels of information.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/partial-reservation-view-detail.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="bookingmenu8">
                                <h4>Overview of Canceled Reservations</h4>
                                <p>This page includes detailed columns for canceled reservations:</p>
                                <ul>
                                    <li><strong>Confirmation ID:</strong> The confirmation ID of the reservation.</li>
                                    <li><strong>User Name:</strong> The name of the user.</li>
                                    <li><strong>User Email:</strong> The email of the user.</li>
                                    <li><strong>Restaurant Name:</strong> The name of the restaurant.</li>
                                    <li><strong>Date</strong> The date of the reservation.</li>
                                    <li><strong>Time:</strong> The time of the reservation.</li>
                                    <li><strong>Skip Days:</strong> The days skipped.</li>
                                    <li><strong>No. of People:</strong> The number of people.</li>
                                    <li><strong>Deposit:</strong> The deposit amount.</li>
                                    <li><strong>Canceled Date:</strong> The date the reservation was canceled.</li>
                                    <li><strong>Canceled Time:</strong> The time the reservation was canceled.</li>
                                    <li><strong>Action:</strong> Actions available for each entry.
                                        <ul>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/cancel-reservation.jpg" alt="screenshot">
                                        </ul>
                                    </li>
                                </ul>
                                <h4>Downloading Canceled Reservation Reports</h4>
                                <ol>
                                    <li>Click the "Download Report" button.</li>
                                    <li>An .xlsx file will be automatically downloaded with details such as confirmation ID, user name, user email, and reservation details.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/cancel-reservation-download.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Show Entries</h4>
                                <ol>
                                    <li>Use the "Show Entries" dropdown to select the number of entries displayed per page (25, 50, 100).
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/cancel-reservation-entries.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Search</h4>
                                <ol>
                                    <li>Use the search bar to find specific reservations.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/cancel-reservation-search.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="bookingmenu9">
                                <h4>Overview of Invite List</h4>
                                <p>This page includes the following columns:</p>
                                <ul>
                                    <li><strong>From Name:</strong> The name of the inviter.</li>
                                    <li><strong>To Name:</strong> The name of the invitee.</li>
                                    <li><strong>Restaurant Name:</strong> The name of the restaurant.</li>
                                    <li><strong>Booking Date:</strong> The date of the booking.</li>
                                    <li><strong>Booking Pax:</strong> The number of people booked.</li>
                                    <li><strong>Status:</strong> The status of the booking.
                                        <ul>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/invite-list.jpg" alt="screenshot">
                                        </ul>
                                    </li>
                                </ul>
                                <h4>Downloading Invite List Reports</h4>
                                <ol>
                                    <li>Click the "Download Report" button.</li>
                                    <li>An .xlsx file will be automatically downloaded with details such as from name, to name, restaurant name, booking date, booking pax, and status.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/invite-list-download-report.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Show Entries</h4>
                                <ol>
                                    <li>Use the "Show Entries" dropdown to select the number of entries displayed per page (25, 50, 100).
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/invite-list-entries.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Search</h4>
                                <ol>
                                    <li>Use the search bar to find specific invites.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/invite-list-search.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="bookingmenu10">
                                <h4>Overview of Unauthorized User Emails</h4>
                                <p>This page includes the following columns:</p>
                                <ul>
                                    <li><strong>User Email:</strong> The email of the unauthorized user.</li>
                                    <li><strong>IP Address:</strong> The IP address of the unauthorized user.
                                        <ul>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/unauthorized-user-email.jpg" alt="screenshot">
                                        </ul>
                                    </li>
                                </ul>
                                <h4>Downloading Unauthorized User Email Reports</h4>
                                <ol>
                                    <li>Click the "Download Report" button.</li>
                                    <li>An .xlsx file will be automatically downloaded with details such as user email and IP address.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/unauthorize-user-email-download-report.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Show Entries</h4>
                                <ol>
                                    <li>Use the "Show Entries" dropdown to select the number of entries displayed per page (25, 50, 100).
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/unauthorize-user-email-entries.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                                <h4>Search</h4>
                                <ol>
                                    <li>Use the search bar to find specific unauthorized users.
                                        <ul><img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/unauthorized-user-email-search.jpg" alt="screenshot"></ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="content" id="bookingmenu11">
                                <h4>How to Send Credit Card Details</h4>
                                <ol>
                                    <li>Click on the "Send Credit Card Details" box.</li>
                                    <li>An OTP will be sent to the admin's email address.</li>
                                    <li>Enter the OTP to verify.</li>
                                    <li>The .xlsx file with the credit card details will be sent to the admin's email address.
                                        <ul>
                                            <img src="https://phpstack-1074629-4371560.cloudwaysapps.com/uploads/assets/images/credit-card-detail.jpg" alt="screenshot">
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