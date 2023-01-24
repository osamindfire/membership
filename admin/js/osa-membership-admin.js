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

		$("body").on('change', '#category_filter', function () {
			let el = $(this);

			if (el.val() === "country") {
				$(document).find('#filter_input_id').remove();
				populateCountry();

			} else if (el.val() === "state") {
				$(document).find('#filter_input_id').remove();
				populateState();

			} else if (el.val() === "chapter") {
				$(document).find('#filter_input_id').remove();
				populateChapter();

			} else if (el.val() === "membership") {
				$(document).find('#filter_input_id').remove();
				populateMembership();

			} else {
				$(document).find('#filter_input_id').remove();
				$("#filter_input_area").append('<input type="text" name="filter_input" id="filter_input_id" class="" value="">');
			}
		});

		 //Add more criteria
		 $("body").on('click', '#add_more_criteria', function () {
			 let el = $(this);
			alert('addmore');
		  });

		

		filterForm.submit(function (e) {
			e.preventDefault();


			//alert("fired");
			filteredData(e);
		});

		function populateCountry() {
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

						let html = '<select name="filter_input" id="filter_input_id" class="postform">'

						for (let i = 0; i < response.length; i++) {
							html += '<option class="level-0" value="'+response[i]['country_type_id']+'">'+response[i]['country']+'</option>';
						}
    					
						html +=	'</select>';

						mafs.find("#filter_input_area").append(html);

					}
				},
				error: function (e, response) {
					console.log("error");
				}
			});
			
		};

		function populateState() {
			console.log('hii state');

			let data = {
				action: "state_ajax_action",
				state: 'yes',
				//country: country,
			}

			$.ajax({
				url: ajax_info.ajax_url,
				data: data,
				success: function (response) {

					if (response) {

						let html = '<select name="filter_input" id="filter_input_id" class="postform">'

						for (let i = 0; i < response.length; i++) {
							html += '<option class="level-0" value="'+response[i]['state_type_id']+'">'+response[i]['state']+'</option>';
						}
    					
						html +=	'</select>';

						mafs.find("#filter_input_area").append(html);

					}
				},
				error: function (e, response) {
					console.log("error");
				}
			});
		};

		function populateChapter() {
			console.log('hii chapter');

			let data = {
				action: "chapter_ajax_action",
				chapter: 'yes',
			}

			$.ajax({
				url: ajax_info.ajax_url,
				data: data,
				success: function (response) {

					if (response) {

						let html = '<select name="filter_input" id="filter_input_id" class="postform">'

						for (let i = 0; i < response.length; i++) {
							html += '<option class="level-0" value="'+response[i]['name']+'">'+response[i]['name']+'</option>';
						}
    					
						html +=	'</select>';

						mafs.find("#filter_input_area").append(html);

					}
				},
				error: function (e, response) {
					console.log("error");
				}
			});
			
		};

		function populateMembership() {
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

						let html = '<select name="filter_input" id="filter_input_id" class="postform">'

						for (let i = 0; i < response.length; i++) {
							html += '<option class="level-0" value="'+response[i]['membership']+'">'+response[i]['membership']+'</option>';
						}
    					
						html +=	'</select>';

						mafs.find("#filter_input_area").append(html);

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

			// let mm= mafs.find("#category_filter").val();
			// console.log('here...'+mm);
			//for filter
			let filter_option = '';
			if (mafs.find("#category_filter").val() !== null) {
				filter_option = mafs.find("#category_filter").val();
			}

			let filter_input = '';
			if (mafs.find("#filter_input_id").val() !== null) {
				filter_input = mafs.find("#filter_input_id").val();
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
											<td class="categories column-categories" data-colname="Categories"> <a class="dashicons-before dashicons-visibility" href="?page=member-view&id='+ response[i]['member_id'] + '&name=' + response[i]['first_name'] + '"></a><a class="vers dashicons-before dashicons-edit"></a> </td> \
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

	$(function () {

		// $(document).on('click', '#mem_detail', function (e) {
		// 	alert('clicked');
		// 	e.preventDefault();
		// 	MembersData();
		// });

	});

})(jQuery);


