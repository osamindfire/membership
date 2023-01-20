<?php

/**
 * Provide a admin menu - Members view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://odishasociety.org
 * @since      1.0.0
 *
 * @package    Osa_Membership
 * @subpackage Osa_Membership/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap" id="member-ajax-filter-search">
    <h1 class="wp-heading-inline">
        Members</h1>
    <hr class="wp-header-end">


    <h2 class="screen-reader-text">Filter members list</h2>

    <form id="members-filter" method="get">

        <p class="search-box">
            <label class="screen-reader-text" for="post-search-input">Search Members:</label>
            <input type="search" id="member-search-input" name="search" value="">
            <input type="submit" id="search-submit" class="button" value="Search">
        </p>
        <br>

        <input type="hidden" id="_wpnonce" name="_wpnonce" value=""><input type="hidden" name="_wp_http_referer" value="/wp-admin/edit.php">

        <div class="tablenav top">
            <div class="alignleft actions">
                <label class="screen-reader-text" for="cat">Filter by category</label><select name="cat" id="cat" class="postform">
                    <option value="0">All Categories</option>
                    <option class="level-0" value="1">Uncategorized</option>
                </select>
                <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Filter">
            </div>
            <div class="tablenav-pages one-page"><span class="displaying-num">1 item</span>
                <span class="pagination-links"><span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
                    <span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Current Page</label><input class="current-page" id="current-page-selector" type="text" name="paged" value="1" size="1" aria-describedby="table-paging"><span class="tablenav-paging-text"> of <span class="total-pages">1</span></span></span>
                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>
                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span></span>
            </div>
            <br class="clear">
        </div>
        
        <h2 class="screen-reader-text">Members list</h2>
        <!-- <br> -->
        <table class="wp-list-table widefat fixed striped table-view-list members">
            <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
                    <th scope="col" id="member-title" data-type="t1.member_id" class="manage-column column-title column_sort column-primary sortable asc"><a href=""><span>Member ID</span><span class="sorting-indicator"></span></a></th>
                    <th scope="col" id="author" class="manage-column column-author">Name</th>
                    <th scope="col" id="tags" class="manage-column column-tags">Email</th>
                    <th scope="col" id="date-title" data-type="wp_users.user_registered" class="manage-column column-title column_sort column-primary sortable asc"><a href=""><span>Join Date</span><span class="sorting-indicator"></span></a></th>
                    <!-- <th scope="col" id="categories" class="manage-column">Join Date</th> -->
                    <th scope="col" id="tags" class="manage-column">Phone</th>
                    <th scope="col" id="tags" class="manage-column">Status</th>
                    <th scope="col" id="tags" class="manage-column">Action</th>
                </tr>
            </thead>

            <tbody id="the-member-list">

            </tbody>

            <tfoot>
                <tr>
                    <td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></td>
                    <th scope="col" class="manage-column column-primary sortable desc"><a href=""><span>Member ID</span><span class="sorting-indicator"></span></a></th>
                    <th scope="col" class="manage-column column-author">Name</th>
                    <th scope="col" class="manage-column column-tags">Email</th>
                    <th scope="col" class="manage-column">Join Date</th>
                    <th scope="col" class="manage-column">Phone</th>
                    <th scope="col" class="manage-column">Status</th>
                    <th scope="col" class="manage-column">Action</th>
                </tr>
            </tfoot>

        </table>
        <div class="tablenav bottom">

            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-bottom" class="screen-reader-text">Select bulk action</label><select name="action2" id="bulk-action-selector-bottom">
                    <option value="-1">Bulk actions</option>
                    <!-- <option value="" class="hide-if-no-js">Edit</option> -->
                    <!-- <option value="">Move to Trash</option> -->
                </select>
                <input type="submit" id="doaction2" class="button action" value="Apply">
            </div>
            <div class="alignleft actions">
            </div>
            <div class="tablenav-pages " id="pagination">
            </div>
            <br class="clear">
        </div>

        <!-- <div class="">
            <span><a class="dashicons-before dashicons-visibility"></a>  <a class="dashicons-before dashicons-edit"></a></span>
        </div> -->
        

    </form>

    <div id="ajax-response"></div>
    <div class="clear"></div>
</div>