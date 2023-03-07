<?php ?>
<table class="table et_pb_with_background et_pb_inner_shadow price" style="width: 100%">
    <thead class="thead">
        <tr class="et_pb_pricing_heading">
            <th class="text-center vertical_line">Membership Plan</th>
            <th class="text-center vertical_line">Fee</th>
            <th class="text-center vertical_line">Start Date</th>
            <th class="text-center vertical_line">End Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($membershipInfo as $membership) { ?>
        <tr class="price">
            <td class="vertical_line" style="text-align:center;"><strong><?= $membership->membership;?></strong></td>
            <td class="vertical_line" style="text-align:center;"><?= $membership->fee;?></td>
            <td class="vertical_line" style="text-align:center;"><?= date('m-d-Y',strtotime($membership->start_date));?></td>
            <td class="vertical_line" style="text-align:center;"><?php if($membership->membership_type_id == 3) { echo "N/A";}else{ echo date('m-d-Y',strtotime($membership->end_date));}?></td>
        </tr>
        <?php } ?>
    </tbody>

</table>