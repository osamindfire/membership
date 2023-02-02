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
        let ajax_url = "/wp-admin\/admin-ajax.php";


        $(document).on('click', '#member_edit .notice-dismiss', function (e) {
            e.preventDefault();
            //alert('close');
            $(this).parent().remove() ;
        });

        $(document).on('change', '#editCountry', function (e) {
            e.preventDefault();
            let country_id = $(this).val();
            //alert(country_id);
            populateStateData(country_id);
        });

        function populateStateData(country_id) {

            let data = {
                action: "state_ajax_action",
                state: 'yes',
                country: country_id,
            }

            $.ajax({
                url: ajax_url,
                data: data,
                success: function (response) {

                    if (response) {
                        //alert(response);
                        $("#editState").empty();

                        let html = '<option value="" disabled selected>Select</option>';
                        if (response.length == 0) {
                            html = '<option value="" disabled selected>No data</option>';
                        }

                        for (let i = 0; i < response.length; i++) {
                            html += '<option class="level-0" value="' + response[i]['state_type_id'] + '">' + response[i]['state'] + '</option>';
                        }

                        $("#editState").append(html);
                    }

                },
                error: function (e, response) {
                    console.log("error");
                }
            });
        }
        


    });


})(jQuery);