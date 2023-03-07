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


    $(function () {

        $(document).on('click', '#csv_download', function (e) {
            e.preventDefault();
            csvData();


            //     var TableArray = [];
            //     $('.member_list').find('table#members tbody tr').each(function () {
            //         var arrayOfThisRow = [];
            //         var tableData = $(this).find('td');
            //         if (tableData.length > 0) {
            //             tableData.each(function () { arrayOfThisRow.push('"'+$(this).text()+'"'); });
            //             TableArray.push(arrayOfThisRow);
            //         }
            //     });
            // //    console.log(TableArray);
            //     const rows = [
            //         ["MEMBER ID", "NAME", "EMAIL", "JOIN DATE", "EXPIRY DATE", 
            //         "PRIMARY PHONE", "SECONDARY PHONE", "ADDRESS LINE 1", "ADDRESS LINE 2",
            //         "COUNTRY", "STATE", "CHAPTER", "CITY","POSTAL CODE", "MEMBERSHIP", "-"],
            //     ];

            //     let data_rows = rows.concat(TableArray);
            //     // console.log(data_rows);
            //     let csvContent = "data:text/csv;charset=utf-8,";
            //     // let data = '';
            //     data_rows.forEach(function (rowArray) {                        
            //         let data = rowArray.join(",");              
            //         csvContent += data + "\r\n";
            //     });
            //     // console.log(data_rows);

            //     // var encodedUri = encodeURI(csvContent);
            //     // window.open(encodedUri);
            //     var encodedUri = encodeURI(csvContent).replaceAll('#', '%23');           
            //     var link = document.createElement("a");
            //     link.setAttribute("href", encodedUri);
            //     link.setAttribute("download", "osa_members_list.csv");
            //     document.body.appendChild(link); // Required for FF
            //     link.click();

        });

        /**
         * Ajax function to retrive member details for csv downloads
         */
        function csvData(e) {

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

            let data = {
                action: "csv_download_action",
                search: search,
                filter_option: filter_option,
                filter_input: filter_input,
            }

            $.ajax({
                //url: ajax_info.ajax_url,
                url: "/wp-admin\/admin-ajax.php",
                data: data,
                success: function (response) {

                    // console.log("csvvvvv");
                    // console.log(response);

                    let resArray = [];

                    // resArray.push(1,2,3, 'pooja');
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

                        resArray.push([
                            response[i]['member_id'],
                            response[i]['first_name'] + ' ' + response[i]['last_name'],
                            response[i]['user_email'],
                            response[i]['user_registered'],
                            response[i]['membership_expiry_date'],
                            response[i]['phone_no'],
                            '"'+response[i]['address_line_1']+'"',
                            '"'+response[i]['address_line_2']+'"',
                            response[i]['country'],
                            response[i]['state'],
                            response[i]['chapter_name'],
                            '"'+response[i]['city']+'"',
                            response[i]['postal_code'],
                            response[i]['membership'],
                            response[i]['souvenir']
                        ])
                    }

                    //    console.log(resArray);

                    const rows = [
                        ["MEMBER ID", "NAME", "EMAIL", "JOIN DATE", "EXPIRY DATE",
                            "PHONE NUMBER", "ADDRESS LINE 1", "ADDRESS LINE 2",
                            "COUNTRY", "STATE", "CHAPTER", "CITY", "POSTAL CODE", "MEMBERSHIP", "SOUVENIR"],
                    ];

                    let data_rows = rows.concat(resArray);

                    let csvContent = "data:text/csv;charset=utf-8,";

                    data_rows.forEach(function (rowArray) {
                        let data = rowArray.join(",");
                        csvContent += data + "\r\n";
                    });

                    var encodedUri = encodeURI(csvContent).replaceAll('#', '%23');
                    var link = document.createElement("a");
                    link.setAttribute("href", encodedUri);
                    link.setAttribute("download", "osa_members_list.csv");
                    document.body.appendChild(link); // Required for FF
                    link.click();
                },
                error: function (e, response) {
                    // console.log("error");
                }
            });
        }


    });


})(jQuery);