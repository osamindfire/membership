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


        /**
         * Bulk action for Delete and Deactivate member
         */
        $(document).on('click', '.isChecked', function (e) {

            var DeactivateArr = [];

            $("input:checkbox[name=member_id]:checked").each(function () {
                DeactivateArr.push($(this).val());
            });

            let del_ele = $('#deactivate_member').length;

            if (this.checked && del_ele === 0) {
                // let html = '<a id="deactivate_member" class="dashicons-before dashicons-trash vers" title="Deactivate Members " href=""></a>';
                let html = ' <input type="button" name="" id="deactivate_member" class="button" value="Deactivate Member" />  ';
                html += '<input type="button" name="" id="delete_member" class="button" value="Delete Member" /> ';
                $('#members-filter').find('.actions').append(html);
            }
            else if (DeactivateArr.length === 0) {
                $('#members-filter .actions').find('#deactivate_member , #delete_member').remove();
            }

        });

        /**
         * Deactivate Member Process
         */
        $(document).on('click', '#deactivate_member', function (e) {
            e.preventDefault();

            var DeactivateArr = [];

            $("input:checkbox[name=member_id]:checked").each(function () {
                DeactivateArr.push($(this).val());
            });

            if (DeactivateArr.length === 0) {
                alert('No members selected');
            }
            else {

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
                else {
                    location.reload();
                }
            }

        });


        /**
         * Delete Member Process
         */
        $(document).on('click', '#delete_member, #trash_member', function (e) {
            e.preventDefault();

            var DeleteArr = [];

            $("input:checkbox[name=member_id]:checked").each(function () {
                DeleteArr.push($(this).val());
            });


           if(($(this).attr('id')) == 'trash_member'){
             DeleteArr.push($(this).attr('data-member-id'));
           }

            if (confirm("Are you sure you want to delete this Member? All the data related to Partner, Child and Membersip has been deleted and can not be recovered again.")) {

                let data = {
                    action: "member_delete",
                    memberId: DeleteArr,
                }

                $.ajax({
                    url: ajax_url,
                    data: data,
                    success: function (response) {
                        // console.log(response);

                        if (response) {
                            // location.reload();
                            // $('#alertMessage').html('<p>Member Deleted Successfully!</p>'); 
                            alert('Member Deleted Successfully!');
                            setTimeout(function(){
                            location.reload(); 
                            }, 8000);
                        }

                    },
                    error: function (e, response) {
                        console.log("error");
                    }
                });
            }
            else {
                location.reload();
            }

        });

    });



})(jQuery);