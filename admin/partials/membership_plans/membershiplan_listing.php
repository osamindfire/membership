<?php ?>
<div class="wrap member_list">
<?php if (isset($_GET['success'])) { ?>
                <div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible">
                    <p><strong>Membership plan added successfully.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                </div>
            <?php } ?>
<div class="postbox" id="heading">
                <h1><strong>Membership Plans </strong><?php echo $membershipPlan->membership; ?>
                <?php $addurl="?page=membershipplan-add";?>
        <a class="vers dashicons-before button button-primary" title="Add" href="<?= $addurl;?>">+ Add Membership Plan</a><br></h1>
            </div>
    <hr class="wp-header-end">

    <h2 class="screen-reader-text">Members list</h2>
    <!-- <br> -->
    <table id="members" class="wp-list-table widefat fixed striped table-view-list users">
    
        <thead>
            <tr>
                <th>SNo.</th>
                <th>Membership</th>
                <th>Type</th>
                <th>Fee</th>
                <th>Total Days</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody id="the-member-list">
            <?php $sno=1;foreach($membershipPlans as $plan) {?>
            <tr id="member-1" class="iedit author-self level-0 member-1 type-post status-publish format-standard hentry category-uncategorized "> 			
            <td><?= $sno;?> </td>   																			
            <td><?= $plan->membership;?> </td>   											
            <td><?php if($plan->type == 1) { echo "Single"; }elseif($plan->type == 2){ echo "Family";}else{ echo "Other";} $plan->type;?></td>  											
            <td><?= $plan->fee;?></td> 	
            <td><?= $plan->total_days;?></td> 	
            <td><?php if($plan->status == 1) { echo "Active"; }elseif($plan->status == 0){ echo "Not Active";} ?></td>											
            <td> 
                <?php $url="?page=membershipplan-edit&id=".$plan->membership_type_id;?>
                <a class="vers dashicons-before dashicons-edit" title="Edit" href="<?= $url;?>" ></a> </td> 										
             </tr>
             <?php $sno++; } ?>
        </tbody>

    </table>    
</div>