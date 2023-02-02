<?php ?>
<table class="table et_pb_with_background et_pb_inner_shadow price" style="width: 100%">
    <thead class="thead">
        <tr class="et_pb_pricing_heading">
            <th class="text-center vertical_line" width="30%"></th>
            <th class="text-center vertical_line" style="text-align:left;">Details</th>
        </tr>
    </thead>
    <tbody>
        <tr class="price">
            <td class="vertical_line" style="text-align:left;"><strong>Member ID</strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($memberInfo[0]->member_id) ? $memberInfo[0]->member_id : 'N/A'; ?></td>
        </tr>
        <tr class="price">
            <td class="vertical_line" style="text-align:left;"><strong>Member Name</strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($memberInfo[0]->first_name) ? $memberInfo[0]->first_name.' '.$memberInfo[0]->last_name : 'N/A'; ?></td>
        </tr>
        <tr class="price">
            <td class="vertical_line" style="text-align:left;"><strong>Member Email</strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($memberInfo[0]->user_email) ? $memberInfo[0]->user_email : 'N/A'; ?></td>
        </tr>
        <tr class="price">
            <td class="vertical_line" style="text-align:left;"><strong>Partner Name</strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($memberInfo['oth_member_info'][0]->first_name) ? $memberInfo['oth_member_info'][0]->first_name.' '.$memberInfo['oth_member_info'][0]->last_name : 'N/A'; ?></td>
        </tr>
        <tr class="price">
            <td class="vertical_line" style="text-align:left;"><strong>Partner Email</strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($memberInfo['oth_member_info'][0]->user_email) ? $memberInfo['oth_member_info'][0]->user_email : 'N/A'; ?></td>
        </tr>
        <tr class="price">
            <td class="vertical_line" style="text-align:left;"><strong>Primary Phone No.</strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($memberInfo[0]->primary_phone_no) ? $memberInfo[0]->primary_phone_no : 'N/A'; ?></td>
        </tr>
        <tr class="price">
            <td class="vertical_line" style="text-align:left;"><strong>Secondary Phone No.</strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($memberInfo[0]->secondary_phone_no) ? $memberInfo[0]->secondary_phone_no : 'N/A'; ?></td>
        </tr>
        <tr class="price">
            <td class="vertical_line" style="text-align:left;"><strong>Address Line 1</strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($memberInfo[0]->address_line_1) ? $memberInfo[0]->address_line_1 : 'N/A'; ?></td>
        </tr>
        <tr class="price">
            <td class="vertical_line" style="text-align:left;"><strong>Address Line 2</strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($memberInfo[0]->address_line_2) ? $memberInfo[0]->address_line_2 : 'N/A'; ?></td>
        </tr>
        <tr class="price">
            <td class="vertical_line" style="text-align:left;"><strong>Country</strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($memberInfo[0]->country) ? $memberInfo[0]->country : 'N/A'; ?></td>
        </tr>
        <tr class="price">
            <td class="vertical_line" style="text-align:left;"><strong>State</strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($memberInfo[0]->state) ? $memberInfo[0]->state : 'N/A'; ?></td>
        </tr>
        <tr class="price">
            <td class="vertical_line" style="text-align:left;"><strong>Chapter</strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($memberInfo[0]->chapter_name) ? $memberInfo[0]->chapter_name : 'N/A'; ?></td>
        </tr>
        <tr class="price">
            <td class="vertical_line" style="text-align:left;"><strong>City</strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($memberInfo[0]->city) ? $memberInfo[0]->city : 'N/A'; ?></td>
        </tr>
        <?php $count=1;foreach($memberInfo['oth_member_info'] as $childValues){ if($childValues->type !=='parent'){?>
        <tr class="price">
         <td class="vertical_line" style="text-align:left;"><strong>Child <?=$count;?></strong></td>
            <td class="vertical_line" style="text-align:left;"><?= !empty($childValues->first_name) ? $childValues->first_name.' '.$childValues->last_name : 'N/A'; ?></td>
        </tr>
        <?php } }?>
    </tbody>

</table>