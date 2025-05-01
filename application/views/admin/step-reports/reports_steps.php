<div class="main-content">
	<div class="page-content">
		<!--Hiiden form to hold values for Predefined Filter Values-->
		<?php 
		if($definedfilters){
			?>
			<div class="hidden-form-contianer" style="display:none">
				<form action="<?php echo site_url('admin/report_generate'); ?>" id="predefine_filter_form" method="post">
					<?php
						$unSerializedFilterValues = unserialize($definedfilters);
						$defined_select_days = $unSerializedFilterValues['select_days'];
						$defined_sel_attend_type = $unSerializedFilterValues['sel_attend_type'];
						$defined_sel_status = $unSerializedFilterValues['booking_status'];
						$defined_sel_property_type = $unSerializedFilterValues['sel_property_type'];
						$defined_restaurants = $unSerializedFilterValues['restaurants'];
						$defined_generic_columns = $unSerializedFilterValues['generic_columns'];
						$defined_days_columns = $unSerializedFilterValues['days_columns'];

						if(!empty($defined_select_days)){
							foreach ($defined_select_days as $key => $value) {
								echo '<input type="hidden" name="select_days[]" value="'.$value.'">';
							}
						}
						if(!empty($defined_sel_attend_type)){
							foreach ($defined_sel_attend_type as $key => $value) {
								echo '<input type="hidden" name="sel_attend_type[]" value="'.$value.'">';
							}
						}
						if(!empty($defined_sel_status)){
							foreach ($defined_sel_status as $key => $value) {
								echo '<input type="hidden" name="booking_status[]" value="'.$value.'">';
							}
						}
						if(!empty($defined_sel_property_type)){
							foreach ($defined_sel_property_type as $key => $value) {
								echo '<input type="hidden" name="sel_property_type[]" value="'.$value.'">';
							}
						}
						if(!empty($defined_restaurants)){
							foreach ($defined_restaurants as $key => $value) {
								echo '<input type="hidden" name="restaurants[]" value="'.$value.'">';
							}
						}
						if(!empty($defined_generic_columns)){
							foreach ($defined_generic_columns as $key => $value) {
								echo '<input type="hidden" name="generic_columns[]" value="'.$value.'">';
							}
						}
						if(!empty($defined_days_columns)){
							foreach ($defined_days_columns as $date => $dtvalue) {
								foreach ($dtvalue as $key => $value) {
								echo '<input type="hidden" name="days_columns['.$date.'][]" value="'.$value.'">';
								}
							}
						}
					?>
				</form>
			</div>
			<?php
		}
		?>
		<!--Hiiden form to hold values for Predefined Filter Values END-->
		<div class="container-fluid">
			<div class="reports-step">
				<div class="left-col">
					<img src="<?php echo base_url(); ?>uploads/assets/images/Frame.png">
				</div>
				<div class="right-col">
					<div id="report-step-form" class="add_restro">
						<form id="step_report_form" action="<?php echo site_url('admin/report_generate'); ?>" method="POST" enctype="multipart/form-data">
							<div class="restroBookRight">
								<!-- restroBookProgress -->
								<div class="restroBookProgress">
									<div class="progressStep">
										<div class="stepItem active">
											<div class="stepItemInner">
												<div class="stepImgbox">
													<div class="stepImg">
														<h4>1</h4>
													</div>
												</div>
											</div>
										</div>
										<div class="stepItem">
											<div class="stepItemInner">
												<div class="stepImgbox">
													<div class="stepImg">
														<h4>2</h4>
													</div>
												</div>
											</div>
										</div>
										<div class="stepItem">
											<div class="stepItemInner">
												<div class="stepImgbox">
													<div class="stepImg">
														<h4>3</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
									<div class="restro_info">
										<div class="white-bg">
											<div class="restro_info_row active">
												<div class="start-step">
													<h2>Begin Restaurant Report Analysis</h2>
													<h5>Generate your report in 3 easy steps...</h5>
													<ul>
														<li>Choose the report type</li>
														<li>Choose the columns for your report</li>
														<li>Finally, View and download your report</li>
													</ul>

													<div class="file-icon">
														<svg xmlns="http://www.w3.org/2000/svg" width="158" height="174" viewBox="0 0 158 174" fill="none">
															<path d="M133.142 40.2324H168.742L131.273 3.43091V38.366C131.273 39.3946 132.111 40.2324 133.142 40.2324Z" fill="black"/>
															<path d="M133.142 51.9741C125.638 51.9741 119.532 45.8696 119.532 38.366V0.0234375H21.9055C9.82628 0.0234375 0 9.84972 0 21.9289V178.509C0 190.588 9.82628 200.414 21.9055 200.414H150.305C162.386 200.414 172.211 190.588 172.211 178.509V51.9741H133.142ZM119.722 151.882H44.1045C40.8621 151.882 38.2337 149.254 38.2337 146.011C38.2337 142.769 40.8621 140.14 44.1045 140.14H119.722C122.966 140.14 125.593 142.769 125.593 146.011C125.593 149.254 122.966 151.882 119.722 151.882ZM38.2337 122.528C38.2337 119.285 40.8621 116.657 44.1045 116.657H111.582C114.826 116.657 117.453 119.285 117.453 122.528C117.453 125.77 114.823 128.399 111.582 128.399H44.1045C40.8621 128.399 38.2337 125.77 38.2337 122.528ZM126.861 104.915H44.1045C40.8621 104.915 38.2337 102.287 38.2337 99.0446C38.2337 95.8022 40.8621 93.1738 44.1045 93.1738H126.861C130.103 93.1738 132.732 95.8022 132.732 99.0446C132.732 102.287 130.103 104.915 126.861 104.915Z" fill="black"/>
														</svg>
													</div>
												</div>
											</div>

											<div class="restro_info_row ">
												<div class="step-title">
													<h5>Select values to generate report</h5>
												</div>
												<div class="step-body">
													<?php if (!empty($dates)) : ?>
													<div class="form-group d-flex flex-wrap">
														<div class="form-label">
															<label>Select Days:</label>
														</div>
														<div class="form-info-list">
															<ul class="no-listed ul-check-list">
																<?php foreach ($dates as $key => $date) :
																?>
																	<li>
																		<label class="checkbox-label" for="sel_days<?php echo $key; ?>">
																			<input type="checkbox" name="select_days[]" class="radio trip-date-filter-item" data-date="<?php echo $key; ?>" value="<?php echo $date['date']; ?>" id="sel_days<?php echo $key; ?>" <?php //if($key==0){echo('required');} ?>>DAY <?php echo $key + 1; ?> (<?php echo date('m-d-Y', strtotime($date['date'])); ?>)
																		</label>
																	</li>
																<?php endforeach; ?>
															</ul>
														</div>
													</div>
													<?php endif; ?>
													<div class="form-group d-flex flex-wrap">
														<div class="form-label">
															<label>Select attendee type:</label>
														</div>
														<div class="form-info-list">
															<ul class="no-listed ul-check-list">
																<li>
																	<label class="checkbox-label" for="sel_attend_type_1"><input type="checkbox" name="sel_attend_type[]" class="radio" value="guest" id="sel_attend_type_1">GUEST</label>
																</li>
																<li>
																	<label class="checkbox-label" for="sel_attend_type_2"><input type="checkbox" name="sel_attend_type[]" class="radio" value="host" id="sel_attend_type_2" checked>Primary</label>
																</li>
															</ul>
														</div>
													</div>
													<div class="form-group d-flex flex-wrap">
														<div class="form-label">
															<label>Booking status:</label>
														</div>
														<div class="form-info-list">
														<ul class="no-listed ul-check-list">
																<li>
																	<label class="checkbox-label" for="booking_status_change_1"><input type="checkbox" name="booking_status[]" class="radio"  value="booked" id="booking_status_change_1">Booked</label>
																</li>
																<li>
																	<label class="checkbox-label" for="booking_status_change_2"><input type="checkbox" name="booking_status[]" class="radio"  value="skip" id="booking_status_change_2">Skip</label>
																</li>
																<li>
																	<label class="checkbox-label" for="booking_status_change_3"><input type="checkbox" name="booking_status[]" class="radio"  value="cancel" id="booking_status_change_3">Cancel</label>
																</li>
																<li>
																	<label class="checkbox-label link-only"><a href="<?php echo base_url(); ?>admin/pending_booking_list">NO RESPONSE</a></label>
																</li>
															</ul>
															
														</div>
													</div>
													<div class="form-group d-flex flex-wrap reservation-hide">
														<div class="form-label">
															<label>Select Property Type:</label>
														</div>
														<div class="form-info-list">
															<ul class="no-listed ul-check-list">
																<li>
																	<label class="checkbox-label" for="sel_property_type_1"><input type="checkbox" name="sel_property_type[]" class="radio" checked value="on" id="sel_property_type_1">On-property restaurant</label>
																</li>
																<li>
																	<label class="checkbox-label" for="sel_property_type_2"><input type="checkbox" name="sel_property_type[]" class="radio" checked value="off" id="sel_property_type_2">Off-property restaurant</label>
																</li>
															</ul>
														</div>
													</div>
													<?php if (!empty($restaurants)) : ?>
														<div class="form-group d-flex flex-wrap reservation-hide">
															<div class="form-label">
																<label>Select Restaurants:</label>
																<span>(You can select multiple restaurants)</span>
															</div>
															<div class="form-info-list">
																<select class="form-controls cmnSelect multi-step-slect-rest-names" name="restaurants[]" multiple="multiple">
																	<?php foreach ($restaurants as $rest) :
																	?>
																		<option value="<?php echo $rest['id']; ?>"><?php echo $rest['restaurant_name']; ?></option>
																	<?php endforeach; ?>
																</select>
															</div>
														</div>
													<?php endif; ?>
												</div>
											</div>

											<div class="restro_info_row second-step">
												<div class="step-title">
													<h5>Choose your report columns</h5>
												</div>
												<div class="step-body">
													<div class="form-group">
														<div class="form-label">
															<label>Generic columns </label> <label class="mu-step-label">Select All</label>
														</div>
														<ul class="no-listed ul-check-list">
															<li>
																<label class="checkbox-label" for="generic_columns_1"><input type="checkbox" name="generic_columns[]" class="radio" value="first_name" id="generic_columns_1">First Name</label>
															</li>
															<li>
																<label class="checkbox-label" for="generic_columns_2"><input type="checkbox" name="generic_columns[]" class="radio" value="last_name" id="generic_columns_2">Last Name</label>
															</li>
															<li>
																<label class="checkbox-label" for="generic_columns_3"><input type="checkbox" name="generic_columns[]" class="radio" value="email" id="generic_columns_3">Email Address</label>
															</li>
															<li>
																<label class="checkbox-label" for="generic_columns_4"><input type="checkbox" name="generic_columns[]" class="radio" value="response_status" id="generic_columns_4">Response status</label>
															</li>
														</ul>
													</div>
													<?php if (!empty($dates)) :
														foreach($dates as $key => $date):
														?>
														<div class="form-group trip-days-values-container parent-day-fields-<?php echo $key ?>">
															<div class="form-label">
																<label>Day <?php echo $key+1;?> columns</label> <label class="mu-step-label">Select All</label>
															</div>
															<ul class="no-listed ul-check-list">
																<li>
																	<label class="checkbox-label" for="days_columns_1_<?php echo $key;?>"><input type="checkbox" name="days_columns['<?php echo $date['date'];?>'][]" class="radio" value="status" id="days_columns_1_<?php echo $key;?>">Status</label>
																</li>
																<li>
																	<label class="checkbox-label" for="days_columns_2_<?php echo $key;?>"><input type="checkbox" name="days_columns['<?php echo $date['date'];?>'][]" class="radio" value="role" id="days_columns_2_<?php echo $key;?>">role</label>
																</li>
																<li>
																	<label class="checkbox-label" for="days_columns_3_<?php echo $key;?>"><input type="checkbox" name="days_columns['<?php echo $date['date'];?>'][]" class="radio" value="date" id="days_columns_3_<?php echo $key;?>">Date</label>
																</li>
																<li>
																	<label class="checkbox-label" for="days_columns_4_<?php echo $key;?>"><input type="checkbox" name="days_columns['<?php echo $date['date'];?>'][]" class="radio" value="time" id="days_columns_4_<?php echo $key;?>">Time</label>
																</li>
																<li>
																	<label class="checkbox-label" for="days_columns_5_<?php echo $key;?>"><input type="checkbox" name="days_columns['<?php echo $date['date'];?>'][]" class="radio" value="restaurant_name" id="days_columns_5_<?php echo $key;?>">Restaurant Name</label>
																</li>
																<li>
																	<label class="checkbox-label" for="days_columns_6_<?php echo $key;?>"><input type="checkbox" name="days_columns['<?php echo $date['date'];?>'][]" class="radio" value="property_type" id="days_columns_6_<?php echo $key;?>">Property Type</label>
																</li>
																<li>
																	<label class="checkbox-label" for="days_columns_7_<?php echo $key;?>"><input type="checkbox" name="days_columns['<?php echo $date['date'];?>'][]" class="radio" value="pax" id="days_columns_7_<?php echo $key;?>">Pax</label>
																</li>
																<li>
																	<label class="checkbox-label" for="days_columns_8_<?php echo $key;?>"><input type="checkbox" name="days_columns['<?php echo $date['date'];?>'][]" class="radio" value="guests" id="days_columns_8_<?php echo $key;?>">Guests</label>
																</li>
																<li>
																	<label class="checkbox-label" for="days_columns_9_<?php echo $key;?>"><input type="checkbox" name="days_columns['<?php echo $date['date'];?>'][]" class="radio" value="admin_note" id="days_columns_9_<?php echo $key;?>">Admin Note</label>
																</li>
																<li>
																	<label class="checkbox-label" for="days_columns_10_<?php echo $key;?>"><input type="checkbox" name="days_columns['<?php echo $date['date'];?>'][]" class="radio" value="last_updated" id="days_columns_10_<?php echo $key;?>">Last Updated</label>
																</li>
															</ul>
														</div>
													<?php
													endforeach;
													endif; ?>
												</div>
											</div>
										</div>
	
										<div class="submitForm">
											<?php 
											if($definedfilters){
												?>
											<a title="Quickly generate your report by using last selection values."  class="btn btn-primary text-capitalize predefined_report_filter_values" href="javascript:;">
												<img src="<?php echo base_url(); ?>uploads/assets/images/file-icon.svg" alt=""> Quick Report
											</a>
												<?php
											}
											?>
											<a  class="start-report-btn btn btn-primary text-capitalize nextBtn" href="javascript:;">
												<img src="<?php echo base_url(); ?>uploads/assets/images/file-icon.svg" alt=""> Start Report
											</a>
											<a href="javascript:;"  class="btn btn-primary text-capitalize prevBtn"><img src="<?php echo base_url(); ?>uploads/assets/images/button-arrow.svg" alt=""> Prev</a>
											<a href="javascript:;" class="btn btn-primary text-capitalize nextBtn">Next <img src="<?php echo base_url(); ?>uploads/assets/images/button-arrow.svg" alt=""></a>
											<button type="button" class="submit btn btn-primary text-capitalize" id="submitBtn"><img src="<?php echo base_url(); ?>uploads/assets/images/file-icon.svg" alt=""> Generate Report</button>
										</div>
									</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
