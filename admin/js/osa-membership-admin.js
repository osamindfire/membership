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

	$(window).load(function () {

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
			console.log('filteronchange');
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
				"Country" : "country",
				"State" : "state",
				"City" : "city",
				"Chapter" : "chapter",
				"Membership" : "membership"
			}

			//let form_el_count = $("#members-filter").children().length;
			let form_el_count = $("#members-filter").children().last().find('.member_filter_option').attr('data-filter-id');
			

			for (let i = 0; i <= form_el_count; i++) {
				if ($("#members-filter").find("#category_filter_"+i).length) {
					let option = $("#category_filter_" + i).find(":selected").text();
					//console.log(option);
					delete filter_opt_dict[option];
				}
			}

			console.log(filter_opt_dict);
            
			if( Object.keys(filter_opt_dict).length !== 0){
			let html = '<div class="tablenav top"> \
						<div class="alignleft actions"> \
							<span id="filter_input_area_'+ add_index + '"> \
								<select name="filter_option" id="category_filter_'+ add_index + '" data-filter-id="' + add_index + '" class="postform member_filter_option"> \
									<option value="0" disabled selected>Select</option> ' ;

									for (let key in filter_opt_dict)	{
										html += '<option class="level-0" value="'+filter_opt_dict[key]+'">'+key+'</option>' ;
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
				if ($("#members-filter").find("#category_filter_"+i).length) {
					if($("#members-filter").find("#category_filter_" + i).val() == 'state'){
						$("#members-filter").find('#filter_input_id_' + i).remove();
						populateState(i);
					}
			    }
			}
		});

		$("body").on('change', '.state_input', function () {
			// alert('statein');
			let form_el_count = $("#members-filter").children().last().find('.member_filter_option').attr('data-filter-id') ;

			for (let i = 0; i <= form_el_count; i++) {
				if ($("#members-filter").find("#category_filter_"+i).length) {
					if($("#members-filter").find("#category_filter_" + i).val() == 'chapter'){
						$("#members-filter").find('#filter_input_id_' + i).remove();
						populateChapter(i);
					}
				}
			}
		});

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
			console.log('hii country');

			let data = {
				action: "country_ajax_action",
				country: 'yes',
			}

			$.ajax({
				url: ajax_info.ajax_url,
				data: data,
				success: function (response) {

					if (response) {

						let html = '<select name="filter_input" id="filter_input_id_' + id + '" class="postform country_input">'

						for (let i = 0; i < response.length; i++) {
							html += '<option class="level-0" value="' + response[i]['country_type_id'] + '">' + response[i]['country'] + '</option>';
						}

						html += '</select>';

						$("body").find("#filter_input_area_" + id).append(html);

					}
				},
				error: function (e, response) {
					console.log("error");
				}
			});

		};

		function populateState(id) {
			console.log('hii state');

			let country = '' ;

			let form_el_count = $("#members-filter").children().last().find('.member_filter_option').attr('data-filter-id'); 

			for (let i = 0; i <= form_el_count; i++) {
				if ($("#members-filter").find("#category_filter_"+i).length) {
					if($("#members-filter").find("#category_filter_" + i).val() == 'country'){
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
				url: ajax_info.ajax_url,
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
					console.log("error");
				}
			});
		};

		function populateChapter(id) {
			console.log('hii chapter');

			let state = '' ;

			let form_el_count = $("#members-filter").children().last().find('.member_filter_option').attr('data-filter-id');

			for (let i = 0; i <= form_el_count; i++) {
				if ($("#members-filter").find("#category_filter_"+i).length) {
					if($("#members-filter").find("#category_filter_" + i).val() == 'state'){
						state = $("#members-filter").find('#filter_input_id_' + i).val();
					}
				}
			}

			let data = {
				action: "chapter_ajax_action",
				chapter: 'yes',
				state: state,
			}

			$.ajax({
				url: ajax_info.ajax_url,
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
					console.log("error");
				}
			});

		};

		function populateMembership(id) {
			console.log('hii membership');

			let data = {
				action: "membership_ajax_action",
				membership: 'yes',
			}

			$.ajax({
				url: ajax_info.ajax_url,
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
					console.log("error");
				}
			});

		};
		//Filters ends here


		/**
		 * Ajax function to retrive member details
		 */
		function filteredData(e, activepage = 1, orderby = 'DESC', type = '') {
			console.log("form submitted");

			let mafs = $("#member-ajax-filter-search");

			//for search
			let search = '';
			if (mafs.find("#member-search-input").val().length !== 0) {
				search = mafs.find("#member-search-input").val();
			}

			//for filter
			let form_el_count = $("#members-filter").children().last().find('.member_filter_option').attr('data-filter-id') ;
			console.log("l-" + form_el_count);

			let filter_option = [];
			let filter_input = [];

			for (let i = 0; i <= form_el_count; i++) {
				if (mafs.find("#category_filter_"+i).length) {
					if (mafs.find("#category_filter_" + i).val() !== null) {
						filter_option.push(mafs.find("#category_filter_" + i).val());
					}
					if (mafs.find("#filter_input_id_" + i).val() !== 0) {
						filter_input.push(mafs.find("#filter_input_id_" + i).val());
					}
				}
			}

			let data = {
				action: "member_ajax_action",
				search: search,
				page: activepage,
				orderby: orderby,
				type: type,
				filter_option: filter_option,
				filter_input: filter_input,

			}

			$.ajax({
				url: ajax_info.ajax_url,
				data: data,
				success: function (result) {

					let response = result.data;

					mafs.find("#the-member-list").empty();
					mafs.find("#pagination").empty();
					mafs.find(".displaying-num").empty();
					mafs.find("#ajax_error_response").empty();

					if (result.totalrows == 0) {
						console.log('No data');
						mafs.find("#ajax_error_response").append('No Records Found');
					}
					else if (response) {

						// pagination code
						let results_per_page = 20;

						let number_of_result = result.totalrows;

						//determine the total number of pages available  
						let number_of_page = Math.ceil(number_of_result / results_per_page);
						console.log("pages" + number_of_page);

						//determine which page number visitor is currently on  
						let pagen = activepage;

						// determine the sql LIMIT starting number for the results on the displaying page
						let page_first_result = (pagen - 1) * results_per_page;

						for (let i = 0; i < response.length; i++) {

							if (response[i]['membership_expiry_date'] === null) {
								response[i]['membership_expiry_date'] = 'N/A';
							}
							if (response[i]['primary_phone_no'] === null) {
								response[i]['primary_phone_no'] = 'N/A';
							}
							if (response[i]['membership'] === null) {
								response[i]['membership'] = 'N/A'
							}

							let html = '<tr id="member-1" class="iedit author-self level-0 member-1 type-post status-publish format-standard hentry category-uncategorized"> \
											<th scope="row" class="check-column"> <label class="screen-reader-text" for="cb-select-1"> \
													Select Hello world! </label> \
												<input id="cb-select-1" type="checkbox" name="post[]" value="1"> \
												<div class="locked-indicator"> \
													<span class="locked-indicator-icon" aria-hidden="true"></span> \
													<span class="screen-reader-text"> \
														“Hello world!” is locked </span> \
												</div> \
											</th> \
											<td class="title column-title has-row-actions column-primary page-title" data-colname="Title"> \
												<div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div> \
												<strong><a class="row-title" href="">'+ response[i]['member_id'] + '</a></strong> \
											</td> \
											<td class="author column-author" data-colname="Author">'+ response[i]['first_name'] + ' ' + response[i]['last_name'] + ' </td>  \
											<td class="categories column-categories" data-colname="Categories"><a class="" href="">'+ response[i]['user_email'] + ' </a></td> \
											<td class="categories column-categories" data-colname="Categories">'+ response[i]['user_registered'] + ' </td> \ \
											<td class="categories column-categories" data-colname="Categories">'+ response[i]['membership_expiry_date'] + ' </td> \ \
											<td class="categories column-categories" data-colname="Categories">'+ response[i]['primary_phone_no'] + ' </td> \
											<td class="categories column-categories" data-colname="Categories">'+ response[i]['membership'] + ' </td> \
											<td class="categories column-categories" data-colname="Categories"> <a class="dashicons-before dashicons-visibility" title="View" href="?page=member-view&mid='+ response[i]['member_id'] + '&id=' + response[i]['id'] + '"></a><a class="vers dashicons-before dashicons-edit" title="Edit"></a> </td> \
										</tr>';

							mafs.find("#the-member-list").append(html);

						}

						mafs.find("#pagination").append('<div class="tablenav-page one-page"> \
						                                    <span class="displaying-num">'+ number_of_result + ' items</span> \
															<span class="member-pagination-links">\
															    <span id="first" class="tablenav-pages-navspan button " aria-hidden="true">«</span> \
																<span id="prev" class="tablenav-pages-navspan button " aria-hidden="true">‹</span> \
																<span id="current" data-current="'+ pagen + '" class="screen-reader-text">Current Page</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">' + pagen + ' of <span class="total-pages">' + number_of_page + '</span></span></span> \
																<span id="next" class="tablenav-pages-navspan button " aria-hidden="true">›</span> \
																<span id="last" class="tablenav-pages-navspan button " aria-hidden="true">»</span></span> \
														</div> \
													');

					}
				},
				error: function (e, response) {
					console.log("error");
				}
			});
		}

	});


})(jQuery);


