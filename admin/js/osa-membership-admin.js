(function ($) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	// 

	$(window).load(function () {

		populateMembershipPlan();
		$("#membership_type_id").change(function(){
			populateMembershipPlan();
		});
		function populateMembershipPlan(){

			let membership_type_id = $("#membership_type_id").val() || 0;
			if(membership_type_id){
			let data = {
				action: "get_membership_plan_ajax_action",
				id: membership_type_id,
			}
			
			$.ajax({
				url: "/wp-admin\/admin-ajax.php",
				data: data,
				success: function (response) {

					if (response) {

						console.log(response[0]['fee']);
						$("#fee").val(response[0]['fee']);
						$("#total_days").val(response[0]['total_days']);


					}
				},
				error: function (e, response) {
					 console.log("error");
				}
			});
		}
		};

		// $('.loader').hide();
		// Call member data when window loaded
		filteredData();

		let mafs = $("#member-ajax-filter-search");
		let mafsForm = mafs.find("#members-search");

		mafsForm.submit(function (e) {
			e.preventDefault();
			filteredData(e);
		});

		/**
		 * Sorting code starts
		 */
		$(document).on('click', '.column_sort a', function (e) {
			e.preventDefault();

			let page = $("#member-ajax-filter-search").find("#pagination #current").attr('data-current');

			let cls = $(this).parent().attr('class').split(' ');
			//let cls = $("#member-ajax-filter-search").find(".column_sort").attr('class').split(' ');

			let orderby = cls[cls.length - 1].toUpperCase();

			let type = $(this).parent().attr('data-type');

			if (orderby == 'ASC') {
				cls[cls.length - 1] = 'desc';
				let newcls = cls.join(' ');
				$(this).parent().attr('class', newcls)
				// alert(cls);
				orderby = cls[cls.length - 1].toUpperCase();
			}
			else {
				cls[cls.length - 1] = 'asc';
				let newcls = cls.join(' ');
				$(this).parent().attr('class', newcls)
				orderby = cls[cls.length - 1].toUpperCase();
			}

			$("#member-ajax-filter-search").find(".column_sort").removeAttr('orderby');
			$(this).parent().attr('orderby', 'active');

			//alert(test);
			filteredData(e, page, orderby, type);
		});
		//sorting code ends

		/**
		 * Pagination code starts
		 */
		$(document).on('click', '#pagination a', function (e) {
			e.preventDefault();
			filteredData(e, $(this).html());
		});

		$(document).on('click', '.member-pagination-links span', function (e) {
			e.preventDefault();

			let currentPage = $(this).parent().find("#current").attr('data-current');
			let currentId = $(this).attr('id');
			let lastPage = $(this).parent().find(".total-pages").html();
			//sort 
			let orderby = "DESC";
			let type = "member_id";

			if ($("[orderby=active]").length) {
				let cls = $("[orderby=active]").attr('class').split(' ');
				orderby = cls[cls.length - 1].toUpperCase();
				type = $("[orderby=active]").attr('data-type');
			}

			//alert(test);

			//let cls = $("#member-ajax-filter-search").find(".column_sort").attr('class').split(' ');
			//let orderby = cls[cls.length-1].toUpperCase();

			if (currentId == 'first') {
				currentPage = 1;
			} else if (currentId == 'prev') {
				if (currentPage != 1) {
					currentPage--;
				}
			} else if (currentId == 'next') {
				if (currentPage != lastPage) {
					currentPage++;
				}
			} else if (currentId == 'last') {
				currentPage = lastPage;
			}

			filteredData(e, currentPage, orderby, type);
		});
		// Pagination code ends here


		/**
		 * Filters code starts
		 */
		let filterForm = mafs.find("#members-filter");

		$("body").on('change', '.member_filter_option', function () {
			let el = $(this);
			let filter_id = $(this).attr('data-filter-id');
			let filter_input = $(this).parent().find('#filter_input_id_' + filter_id);

			if (el.val() === "country") {
				filter_input.remove();
				populateCountry(filter_id);

			} else if (el.val() === "state") {
				filter_input.remove();
				populateState(filter_id);

			} else if (el.val() === "chapter") {
				filter_input.remove();
				populateChapter(filter_id);

			} else if (el.val() === "membership") {
				filter_input.remove();
				populateMembership(filter_id);

			} else if (el.val() === "member_status") {
				filter_input.remove();
				populateMemberStatus(filter_id);

			} else if (el.val() === "is_member") {
				filter_input.remove();
				populateStatus(filter_id);
				
            } else {
				filter_input.remove();
				$(this).parent().append('<input type="text" name="filter_input" id="filter_input_id_' + filter_id + '" class="" value="">');
			}
		});

		//Add more criteria
		let add_index = 1;
		$("body").on('click', '#add_more_criteria', function () {
			let el = $(this);
			//alert('addmore');
			let filter_opt_dict = {
				"Email" : "email",
				"First Name" : "first_name",
				"Last Name" : "last_name",
				"Is Member" : "is_member",
				"Country": "country",
				"State": "state",
				"City": "city",
				"Chapter": "chapter",
				"Membership": "membership",
				"Member Status": "member_status"
			}

			//let form_el_count = $("#members-filter").children().length;
			let form_el_count = $("#members-filter").children().last().find('.member_filter_option').attr('data-filter-id');


			for (let i = 0; i <= form_el_count; i++) {
				if ($("#members-filter").find("#category_filter_" + i).length) {
					let option = $("#category_filter_" + i).find(":selected").text();
					//console.log(option);
					delete filter_opt_dict[option];
				}
			}


			if (Object.keys(filter_opt_dict).length !== 0) {
				let html = '<div class="tablenav top"> \
						<div class="alignleft actions"> \
							<span id="filter_input_area_'+ add_index + '"> \
								<select name="filter_option" id="category_filter_'+ add_index + '" data-filter-id="' + add_index + '" class="postform member_filter_option"> \
									<option value="0" disabled selected>Select</option> ' ;

				for (let key in filter_opt_dict) {
					html += '<option class="level-0" value="' + filter_opt_dict[key] + '">' + key + '</option>';
				}

				html += '           </select> \
							</span> \ \
							<input type="button" name="" id="removeBtn" class="button removeBtn" value="Remove"> \
						</div> \
						<br class="clear"> \
					</div>' ;

				$('#members-filter').append(html);
			}

			add_index++;
		});

		$("body").on('change', '.country_input', function () {
			let form_el_count = $("#members-filter").children().last().find('.member_filter_option').attr('data-filter-id');

			for (let i = 0; i <= form_el_count; i++) {
				if ($("#members-filter").find("#category_filter_" + i).length) {
					if ($("#members-filter").find("#category_filter_" + i).val() == 'state') {
						$("#members-filter").find('#filter_input_id_' + i).remove();
						populateState(i);
					}
				}
			}
		});

		// $("body").on('change', '.state_input', function () {
		// 	// alert('statein');
		// 	let form_el_count = $("#members-filter").children().last().find('.member_filter_option').attr('data-filter-id');

		// 	for (let i = 0; i <= form_el_count; i++) {
		// 		if ($("#members-filter").find("#category_filter_" + i).length) {
		// 			if ($("#members-filter").find("#category_filter_" + i).val() == 'chapter') {
		// 				$("#members-filter").find('#filter_input_id_' + i).remove();
		// 				populateChapter(i);
		// 			}
		// 		}
		// 	}
		// });

		// Remove row from multiple filter
		$("body").on('click', '.removeBtn', function () {
			$(this).parent().parent().remove();
		});



		filterForm.submit(function (e) {
			e.preventDefault();
			//alert("fired");
			filteredData(e);
		});

		function populateCountry(id) {

			let data = {
				action: "country_ajax_action",
				country: 'yes',
			}

			$.ajax({
				url: "/wp-admin\/admin-ajax.php",
				data: data,
				success: function (response) {

					if (response) {

						let html = '<select name="filter_input" id="filter_input_id_' + id + '" class="postform country_input">'
						html += '<option class="level-0" value="0" disabled selected>Select</option>';

						for (let i = 0; i < response.length; i++) {
							html += '<option class="level-0" value="' + response[i]['country_type_id'] + '">' + response[i]['country'] + '</option>';
						}

						html += '</select>';

						$("body").find("#filter_input_area_" + id).append(html);

					}
				},
				error: function (e, response) {
					//console.log("error");
				}
			});

		};

		function populateState(id) {

			let country = '';

			let form_el_count = $("#members-filter").children().last().find('.member_filter_option').attr('data-filter-id');

			for (let i = 0; i <= form_el_count; i++) {
				if ($("#members-filter").find("#category_filter_" + i).length) {
					if ($("#members-filter").find("#category_filter_" + i).val() == 'country') {
						country = $("#members-filter").find('#filter_input_id_' + i).val();
					}
				}
			}
			// if (id !== 0 && $("body").find("#category_filter_" + (id - 1)).val() === 'country') {
			// 	country = $("body").find("#filter_input_id_" + (id - 1)).val();
			// }

			let data = {
				action: "state_ajax_action",
				state: 'yes',
				country: country,
			}

			$.ajax({
				url: "/wp-admin\/admin-ajax.php",
				data: data,
				success: function (response) {

					if (response) {

						let html = '<select name="filter_input" id="filter_input_id_' + id + '" class="postform state_input">'

						for (let i = 0; i < response.length; i++) {
							html += '<option class="level-0" value="' + response[i]['state_type_id'] + '">' + response[i]['state'] + '</option>';
						}

						html += '</select>';

						mafs.find("#filter_input_area_" + id).append(html);


					}
				},
				error: function (e, response) {
					// console.log("error");
				}
			});
		};

		function populateChapter(id) {

			// let state = '';

			// let form_el_count = $("#members-filter").children().last().find('.member_filter_option').attr('data-filter-id');

			// for (let i = 0; i <= form_el_count; i++) {
			// 	if ($("#members-filter").find("#category_filter_" + i).length) {
			// 		if ($("#members-filter").find("#category_filter_" + i).val() == 'state') {
			// 			state = $("#members-filter").find('#filter_input_id_' + i).val();
			// 		}
			// 	}
			// }

			let data = {
				action: "chapter_ajax_action",
				chapter: 'yes',
				// state: state,
			}

			$.ajax({
				url: "/wp-admin\/admin-ajax.php",
				data: data,
				success: function (response) {

					if (response) {

						let html = '<select name="filter_input" id="filter_input_id_' + id + '" class="postform">'

						for (let i = 0; i < response.length; i++) {
							html += '<option class="level-0" value="' + response[i]['chapter_type_id'] + '">' + response[i]['name'] + '</option>';
						}

						html += '</select>';

						mafs.find("#filter_input_area_" + id).append(html);

					}
				},
				error: function (e, response) {
					// console.log("error");
				}
			});

		};

		function populateMembership(id) {

			let data = {
				action: "membership_ajax_action",
				membership: 'yes',
			}

			$.ajax({
				url: "/wp-admin\/admin-ajax.php",
				data: data,
				success: function (response) {

					if (response) {

						let html = '<select name="filter_input" id="filter_input_id_' + id + '" class="postform">'

						for (let i = 0; i < response.length; i++) {
							html += '<option class="level-0" value="' + response[i]['membership_type_id'] + '">' + response[i]['membership'] + '</option>';
						}

						html += '</select>';

						mafs.find("#filter_input_area_" + id).append(html);

					}
				},
				error: function (e, response) {
					// console.log("error");
				}
			});

		};

		function populateMemberStatus(id){

			let html = '<select name="filter_input" id="filter_input_id_' + id + '" class="postform">'
			html += '<option class="level-0" value="0">Active</option>';
			html += '<option class="level-0" value="1">Inactive</option>';
			html += '</select>';

			mafs.find("#filter_input_area_" + id).append(html);
		}

		function populateStatus(id){

			let html = '<select name="filter_input" id="filter_input_id_' + id + '" class="postform">'
			html += '<option class="level-0" value="1">Alive</option>';
			html += '<option class="level-0" value="0">Deceased</option>';
			html += '</select>';

			mafs.find("#filter_input_area_" + id).append(html);
		}
		//Filter ends here

		//On change row limit per page
		$(document).on('change', '#row_limit',function (e) {
			filteredData(e);
		});


		/**
		 * Ajax function to retrive member details
		 */
		function filteredData(e, activepage = 1, orderby = 'DESC', type = '') {

			let mafs = $("#member-ajax-filter-search");

			//for search
			let search = '';
			if (mafs.length) {
				if (mafs.find("#member-search-input").val().length !== 0) {
					search = mafs.find("#member-search-input").val();
				}
			}

			//for filter
			let form_el_count = $("#members-filter").children().last().find('.member_filter_option').attr('data-filter-id');

			let filter_option = [];
			let filter_input = [];

			for (let i = 0; i <= form_el_count; i++) {
				if (mafs.find("#category_filter_" + i).length) {
					if (mafs.find("#category_filter_" + i).val() !== null) {
						filter_option.push(mafs.find("#category_filter_" + i).val());
					}
					if (mafs.find("#filter_input_id_" + i).val() !== 0) {
						filter_input.push(mafs.find("#filter_input_id_" + i).val());
					}
				}
			}

			// $('.loader').show();
			// loader
			mafs.find("#the-member-list").empty();
			if (!mafs.find("#the-member-list .loader").length) {
				mafs.find("#the-member-list").append('<tr></tr><tr><td></td><td></td><td></td><td></td><td><div class="lds-dual-ring loader"></div></td></tr>');
			}

			//row limit
			let rowLimit = $("#row_limit").val();

			let data = {
				action: "member_ajax_action",
				search: search,
				page: activepage,
				orderby: orderby,
				type: type,
				filter_option: filter_option,
				filter_input: filter_input,
				row_limit: rowLimit
			}

			$.ajax({
				//url: ajax_info.ajax_url,
				url: "/wp-admin\/admin-ajax.php",
				data: data,
				success: function (result) {

					let response = result.data;

					mafs.find("#the-member-list").empty();
					mafs.find("#pagination").empty();
					mafs.find(".displaying-num").empty();
					mafs.find("#ajax_error_response").empty();

					if (result.totalrows == 0) {
						mafs.find("#ajax_error_response").append('No Records Found');
					}
					else if (response) {

						// pagination code
						let results_per_page = rowLimit;

						let number_of_result = result.totalrows;

						//determine the total number of pages available  
						let number_of_page = Math.ceil(number_of_result / results_per_page);

						//determine which page number visitor is currently on  
						let pagen = activepage;

						// determine the sql LIMIT starting number for the results on the displaying page
						let page_first_result = (pagen - 1) * results_per_page;

						for (let i = 0; i < response.length; i++) {

							if (response[i]['membership_expiry_date'] == null) {
								response[i]['membership_expiry_date'] = 'N/A';
							}
							if (response[i]['phone_no'] == null) {
								response[i]['phone_no'] = 'N/A';
							}
							if (response[i]['membership'] == null) {
								response[i]['membership'] = 'N/A'
							}
							if (response[i]['address_line_2'] == null) {
								response[i]['address_line_2'] = 'N/A'
							}
							if (response[i]['membership_type_id'] == 3 ) {
								response[i]['membership_expiry_date'] = 'N/A';
							}

							let dActivateClass = '';
							let display_icon='';
							// let disabled = '';
							if (response[i]['is_deleted'] == 1) {
								dActivateClass = 'out-red';
								display_icon = 'style="display:none"';
								// disabled = "disabled";
							}
							let addMembership='';
							/* let addMembership = '<a class="vers dashicons-before dashicons-plus" title="Add Membership" href="?page=assign-membership&mid=' + response[i]['member_id'] + '&id=' + response[i]['id'] + '"></a>'; */
							if (response[i]['membership_type']) {
								 addMembership = '<a '+display_icon+' class="vers dashicons-before dashicons-admin-users" title="Update Membership Plan" href="?page=update-membership&mid=' + response[i]['member_id'] + '&id=' + response[i]['id'] + '"></a>';
							}else{
								 addMembership = '<a '+display_icon+' class="vers dashicons-before dashicons-plus" title="Add Membership" href="?page=assign-membership&mid=' + response[i]['member_id'] + '&id=' + response[i]['id'] + '"></a>';
							}



							let html = '<tr id="member-1" class="iedit author-self level-0 member-1 type-post status-publish format-standard hentry category-uncategorized memberList ' + dActivateClass + '"> \
											<th scope="row" class="check-column"> <label class="screen-reader-text" for="cb-select-1"> \
													Select Hello world! </label> \
												<input  class="isChecked" name="member_id" data-user-id="' + response[i]['user_id'] + '" value="' + response[i]['member_id'] + '" type="checkbox"> \
											</th> \
											<td class="title column-title has-row-actions column-primary page-title" data-colname="Title"><a class="row-title" href="?page=member-view&mid='+ response[i]['member_id'] + '&id=' + response[i]['id'] + '">' + response[i]['member_id'] + '</a></td> \
											<td class="author column-author" data-colname="Author">'+ response[i]['first_name'] + ' ' + response[i]['last_name'] + ' </td>  \
											<td class="categories column-categories" data-colname="Categories"><a class="" href="mailto: '+ response[i]['user_email'] + '">' + response[i]['user_email'] + ' </a></td> \
											<td class="categories column-categories" data-colname="Categories">'+ response[i]['user_registered'] + ' </td> \ \
											<td class="categories column-categories" data-colname="Categories">'+ response[i]['membership_expiry_date'] + ' </td> \ \
											<td class="categories column-categories" data-colname="Categories">'+ response[i]['phone_no'] + ' </td> \
											<td class="categories hidden column-categories" data-colname="Categories">'+ response[i]['address_line_1'] + ' </td> \
											<td class="categories hidden column-categories" data-colname="Categories">'+ response[i]['address_line_2'] + ' </td> \
											<td class="categories hidden column-categories" data-colname="Categories">'+ response[i]['country'] + ' </td> \
											<td class="categories hidden column-categories" data-colname="Categories">'+ response[i]['state'] + ' </td> \
											<td class="categories hidden column-categories" data-colname="Categories">'+ response[i]['chapter_name'] + ' </td> \
											<td class="categories hidden column-categories" data-colname="Categories">'+ response[i]['city'] + ' </td> \
											<td class="categories hidden column-categories" data-colname="Categories">'+ response[i]['postal_code'] + ' </td> \
											<td class="categories column-categories" data-colname="Categories">'+ response[i]['membership'] + ' </td> \
											<td class="categories column-categories actions" data-colname="Categories"> <a class="dashicons-before dashicons-visibility" title="View" href="?page=member-view&mid='+ response[i]['member_id'] + '&id=' + response[i]['id'] + '"></a><a class="vers dashicons-before dashicons-edit" title="Edit" href="?page=member-edit&mid=' + response[i]['member_id'] + '&id=' + response[i]['id'] + '"></a><a class="vers dashicons-before dashicons-trash" title="Delete" id="trash_member" data-member-id="'+response[i]['member_id']+'" href=""></a>'+addMembership+'</td> \
										</tr>';

							mafs.find("#the-member-list").append(html);

						}

						mafs.find("#pagination").append('<div class="tablenav-page one-page"> \
						                                    <span class="displaying-num">'+ number_of_result + ' items</span> \
															<span class="member-pagination-links">\
															    <span id="first" class="tablenav-pages-navspan button " aria-hidden="true">??</span> \
																<span id="prev" class="tablenav-pages-navspan button " aria-hidden="true">???</span> \
																<span id="current" data-current="'+ pagen + '" class="screen-reader-text">Current Page</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">' + pagen + ' of <span class="total-pages">' + number_of_page + '</span></span></span> \
																<span id="next" class="tablenav-pages-navspan button " aria-hidden="true">???</span> \
																<span id="last" class="tablenav-pages-navspan button " aria-hidden="true">??</span></span> \
														</div> \
													');

					}
					// $('.loader').hide();
				},
				error: function (e, response) {
					// console.log("error");
				}
			});
		}

	});


})(jQuery);


