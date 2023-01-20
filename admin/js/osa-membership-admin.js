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

		var mafs = $("#member-ajax-filter-search");
		var mafsForm = mafs.find("#members-filter");

		// var current_page = $(document).find(".member-pagination-links #current").attr('data-current');
		// var current_page = $('.member-pagination-links').find("#current").html();

		var cls = $("#member-ajax-filter-search").find("#member-title").attr('class').split(' ');
    	let orderby = cls[cls.length-1].toUpperCase();
		

		mafsForm.submit(function (e) {
			e.preventDefault();
			filteredData(e);
		});

		//sorting
		$(document).on('click', '#member-title a', function (e) {
			let page = $("#member-ajax-filter-search").find("#pagination #current").attr('data-current');

			var cls = $("#member-ajax-filter-search").find("#member-title").attr('class').split(' ');
    		let orderby = cls[cls.length-1].toUpperCase();
			e.preventDefault();
			if(orderby== 'ASC'){
				cls[cls.length-1]='desc';
				let newcls = cls.join(' ');
				$("#member-ajax-filter-search").find("#member-title").attr('class',newcls)
				// alert(cls);
				orderby = cls[cls.length-1].toUpperCase();
			}
			else{
				cls[cls.length-1]='asc';
				let newcls = cls.join(' ');
				$("#member-ajax-filter-search").find("#member-title").attr('class',newcls)
				orderby = cls[cls.length-1].toUpperCase();
			}

			//alert(test);
			filteredData(e, page , orderby);
		});

		//sorting date
		// $(document).on('click', '#date-title a', function (e) {
		// 	let page = $("#member-ajax-filter-search").find("#pagination #current").attr('data-current');

		// 	var cls_date = $("#member-ajax-filter-search").find("#date-title").attr('class').split(' ');
    	// 	let orderbydate = cls[cls.length-1].toUpperCase();
		// 	e.preventDefault();
		// 	if(orderbydate== 'ASC'){
		// 		cls_date[cls_date.length-1]='desc';
		// 		let newcls = cls_date.join(' ');
		// 		$("#member-ajax-filter-search").find("#date-title").attr('class',newcls)
		// 		// alert(cls);
		// 		orderbydate = cls_date[cls_date.length-1].toUpperCase();
		// 	}
		// 	else{
		// 		cls_date[cls_date.length-1]='asc';
		// 		let newcls_date = cls_date.join(' ');
		// 		$("#member-ajax-filter-search").find("#date-title").attr('class',newcls_date)
		// 		orderbydate = cls_date[cls_date.length-1].toUpperCase();
		// 	}

		// 	//alert(test);
		// 	filteredData(e, page ,null ,orderbydate );
		// });

		$(document).on('click', '#pagination a', function (e) {
			e.preventDefault();
			filteredData(e, $(this).html());
		});

		$(document).on('click', '.member-pagination-links span', function (e) {
			e.preventDefault();
			let currentPage = $(this).parent().find("#current").attr('data-current');
			let currentId = $(this).attr('id');
			let lastPage = $(this).parent().find(".total-pages").html();
			//member-id
			var cls = $("#member-ajax-filter-search").find("#member-title").attr('class').split(' ');
    		let orderby = cls[cls.length-1].toUpperCase();
			//date
			var cls_date = $("#member-ajax-filter-search").find("#date-title").attr('class').split(' ');
    		let orderbydate = cls_date[cls_date.length-1].toUpperCase();

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

			filteredData(e, currentPage, orderby, orderbydate);
		});


		// ajax for member data
		function filteredData(e, activepage = 1, orderby='ASC') {
			console.log("form submitted");

			var mafs = $("#member-ajax-filter-search");

		    let search='';
			if (mafs.find("#member-search-input").val().length !== 0) {
				search = mafs.find("#member-search-input").val();
		    } 

			var data = {
				action: "member_ajax_action",
				search: search, 
				page: activepage,
				orderby: orderby,
				//orderbydate: orderbydate,
			}

			$.ajax({
				url: ajax_info.ajax_url,
				data: data,
				success: function (result) {

					let response = result.data;

					mafs.find("#the-member-list").empty();
					mafs.find("#pagination").empty();
					mafs.find(".displaying-num").empty();

					if (result.totalrows == 0) {
						console.log('No data');
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

						for (var i = 0; i < response.length; i++) {

							var html = '<tr id="member-1" class="iedit author-self level-0 member-1 type-post status-publish format-standard hentry category-uncategorized"> \
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
											<td class="categories column-categories" data-colname="Categories">'+ response[i]['primary_phone_no'] + ' </td> \
											<td class="categories column-categories" data-colname="Categories">'+ response[i]['membership'] + ' </td> \
											<td class="categories column-categories" data-colname="Categories"> <a class="dashicons-before dashicons-visibility" href="/wp-admin/admin.php?page=member_view&id='+ response[i]['member_id'] +'"></a><a class="vers dashicons-before dashicons-edit"></a> </td> \
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

	$(function() {

		// $(document).on('click', '#mem_detail', function (e) {
		// 	alert('clicked');
		// 	e.preventDefault();
		// 	MembersData();
		// });
		
	});

})(jQuery);


// var gallerySortable, gallerySortableInit, sortIt, clearAll, w, desc = false;

// 	gallerySortableInit = function() {
// 		gallerySortable = $('#media-items').sortable( {
// 			items: 'div.media-item',
// 			placeholder: 'sorthelper',
// 			axis: 'y',
// 			distance: 2,
// 			handle: 'div.filename',
// 			stop: function() {
// 				// When an update has occurred, adjust the order for each item.
// 				var all = $('#media-items').sortable('toArray'), len = all.length;
// 				$.each(all, function(i, id) {
// 					var order = desc ? (len - i) : (1 + i);
// 					$('#' + id + ' .menu_order input').val(order);
// 				});
// 			}
// 		} );
// 	};

// 	sortIt = function() {
// 		var all = $('.menu_order_input'), len = all.length;
// 		all.each(function(i){
// 			var order = desc ? (len - i) : (1 + i);
// 			$(this).val(order);
// 		});
// 	};

// 	clearAll = function(c) {
// 		c = c || 0;
// 		$('.menu_order_input').each( function() {
// 			if ( this.value === '0' || c ) {
// 				this.value = '';
// 			}
// 		});
// 	};

// 	$('#asc').on( 'click', function( e ) {
// 		e.preventDefault();
// 		desc = false;
// 		sortIt();
// 	});
// 	$('#desc').on( 'click', function( e ) {
// 		e.preventDefault();
// 		desc = true;
// 		sortIt();
// 	});
