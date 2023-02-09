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



        $(document).on('click', '.isChecked', function (e) {

            var DeactivateArr = [];

            $("input:checkbox[name=member_id]:checked").each(function () {
                DeactivateArr.push($(this).val());
            });
         
            let del_ele = $('#delete_member').length;

            if (this.checked && del_ele === 0) {
                // let html = '<a id="delete_member" class="dashicons-before dashicons-trash vers" title="Deactivate Members " href=""></a>';
                let html = ' <input type="button" name="" id="delete_member" class="button" value="Deactivate Member" />  ';
                $('#members-filter').find('.actions').append(html);
            }
            else if(DeactivateArr.length === 0){
                $('#members-filter .actions').find('#delete_member').remove();
            }

        });

        $(document).on('click', '#delete_member', function (e) {
            e.preventDefault();

            var DeactivateArr = [];

            $("input:checkbox[name=member_id]:checked").each(function () {
                DeactivateArr.push($(this).val());
            });

            if(DeactivateArr.length === 0){
                alert('No members selected');
            }
            else{

            if (confirm("Are you sure you want to deactivate this Members?")) {

                //alert(DeactivateArr);

                let data = {
                    action: "member_deactivate",
                    memberID: DeactivateArr,
                    isDeleted: 1,
                }

                $.ajax({
                    url: ajax_url,
                    data: data,
                    success: function (response) {

                        if (response) {
                            
                            location.reload();

                        }

                    },
                    error: function (e, response) {
                        console.log("error");
                    }
                });
            }
            else{
                location.reload();
            }
        }

        });





    });


})(jQuery);