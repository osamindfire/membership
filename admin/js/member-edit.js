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
            let id = $('#member_info').find('#id').val();
            let mid = $('#member_info').find('#mid').val();
            window.location = '/wp-admin/admin.php?page=member-edit&mid='+mid+'&id='+id+'';
        });

    //     setTimeout(function(){
    //         $('#member_edit .notice-dismiss').parent().remove();
    //         let id = $('#member_info').find('#id').val();
    //         let mid = $('#member_info').find('#mid').val();
    //         window.location = '/wp-admin/admin.php?page=member-edit&mid='+mid+'&id='+id+'';
    //    },3000);

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

        $(document).on('change', '.idDeleted', function (e) {
            e.preventDefault();                 
        });

        $(document).on('click', '.success-notice-dismiss', function (e) {
            e.preventDefault();
            //alert('close');
            $(this).parent().remove() ;
        });

        //highlight hidden sub menu's parent menu 
        let hiddenMenu = [];
        hiddenMenu['member-view'] = 'members' ;
        hiddenMenu['member-edit'] = 'members' ;
        hiddenMenu['membershipplan-edit'] = 'membershipplan-listing' ;
        hiddenMenu['membershipplan-add'] = 'membershipplan-listing' ;

        let url = window.location.href;
        
        Object.keys(hiddenMenu).forEach(function (key) {
            if(url.indexOf('?page='+key+'') > 0){
                $('.wp-submenu').find('li a[href="admin.php?page='+hiddenMenu[key]+'"]').parent().addClass('current');
    
            } 
        });
        //

        $('#main_phone_no, #spouse_phone_no, #add_spouse_phone_no').change(function (e) {
            let phoneNo = $(this).val();
            let firsttwodigit = phoneNo.substring(0, 2);
            if(firsttwodigit == '+1')
            {
                phoneNo = phoneNo.slice(2);
            }
                phoneNo = phoneNo.replace(/\D+/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '+1-$1-$2-$3');
                phoneNo = phoneNo.substring(0, 15);
            
            let id = $(this).attr('id');
            $('#'+id).val(phoneNo);
        });

    });


})(jQuery);