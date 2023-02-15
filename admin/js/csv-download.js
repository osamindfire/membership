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

            var TableArray = [];

            $('.member_list').find('table#members tbody tr').each(function () {
                var arrayOfThisRow = [];
                var tableData = $(this).find('td');
                if (tableData.length > 0) {
                    tableData.each(function () { arrayOfThisRow.push('"'+$(this).text()+'"'); });
                    TableArray.push(arrayOfThisRow);
                }
            });

           console.log(TableArray);


            const rows = [
                ["MEMBER ID", "NAME", "EMAIL", "JOIN DATE", "EXPIRY DATE", 
                "PRIMARY PHONE", "SECONDARY PHONE", "ADDRESS LINE 1", "ADDRESS LINE 2",
                "COUNTRY", "STATE", "CHAPTER", "CITY","POSTAL CODE", "MEMBERSHIP", "-"],
            ];

            let data_rows = rows.concat(TableArray);
            console.log(data_rows);

            let csvContent = "data:text/csv;charset=utf-8,";

            // let data = '';
            data_rows.forEach(function (rowArray) {                        
                let data = rowArray.join(",");              
                csvContent += data + "\r\n";
            });

            console.log(data_rows);

            // var encodedUri = encodeURI(csvContent);
            // window.open(encodedUri);

            var encodedUri = encodeURI(csvContent).replaceAll('#', '%23');
            
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "osa_members_list.csv");
            document.body.appendChild(link); // Required for FF

            link.click();

        });


    });


})(jQuery);