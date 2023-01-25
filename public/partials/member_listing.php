<?php 
?>
                       <div class="is-layout-flex wp-block-columns">
                        
                            <div class="vertical-menu" style="flex-basis:10%">
                              <a href="<?php echo home_url('member-dashboard'); ?>" class="<?php if(home_url($wp->request) == home_url() . '/member-dashboard'){ echo "active";}?>">Dashboard</a>
                              <a href="<?php echo home_url('member-dashboard/profile/'); ?>" class="<?php if(home_url($wp->request) == home_url() . '/member-dashboard/profile'){ echo "active";}?>">Profile</a>
                              <a href="<?php echo home_url('member-dashboard/transaction/'); ?>" class="<?php if(home_url($wp->request) == home_url() . '/member-dashboard/transaction'){ echo "active";}?>">Transaction</a>
                              <a href="<?php echo wp_logout_url('login'); ?>">Logout</a>
                            </div>

                        <div class="is-layout-flow wp-block-column" style="flex-basis:90%;">
                            <?php 
                            if (home_url($wp->request) == home_url() . '/member-dashboard/profile') {
                                include_once(plugin_dir_path(__FILE__) . '/member_profile.php');

                            }else { ?>

                                <table class="table et_pb_with_background et_pb_inner_shadow price" style="width: 100%">
                                <thead class="thead">
                                  <tr class="et_pb_pricing_heading">
                                  <th class="text-center vertical_line" width="10%">ID</th>
                                  <th class="text-center vertical_line" >Name</th>
                                  <th class="text-center vertical_line" >Join Date</th>
                                  <th class="text-center vertical_line" >Address</th>
                                  <th class="text-center vertical_line" >Phone</th>
                                  <th class="text-center vertical_line" >Status</th>
                                  <th class="text-center vertical_line"></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php if($rowcount>0){ foreach($rows as $member){ ?>
                                  <tr class="price">
                                    <td class="text-center vertical_line"><?= $member->member_id; ?></td>
                                    <td class="text-center vertical_line"><?= $member->first_name.' '.$member->last_name; ?></td>
                                    <td class="text-center vertical_line"><?= $member->user_registered; ?></td>
                                    <td class="text-center vertical_line"><?= $member->address_line_1; ?></td>
                                    <td class="text-center vertical_line"><?= $member->primary_phone_no; ?></td>
                                    <td class="text-center vertical_line"><?= $member->membership; ?></td>
                                    <td class="text-center vertical_line"><i class="fa fa-eye"style="font-size:20px;color:deepskyblue"></i></td>
                                  </tr>
                                  <?php }}else{?>
                                    echo "<tr><td colspan='5'>No records found</td></tr>";
                                <?php  } ?>
                                  </tbody>
                                
                                  </table>
                                  <?php

                                    $links = paginate_links( array(
                                        'base' => add_query_arg( 'pagenum', '%#%' ),
                                        'format' => '',
                                        'prev_text' => __( '&laquo;', 'text-domain' ),
                                        'next_text' => __( '&raquo;', 'text-domain' ),
                                        'total' => $num_of_pages,
                                        'current' => $pagenum
                                    ) );

                                    if ( $links ) {
                                        echo '<div class="" style="width: 99%;">
                                              <div class="" style="margin: 1em 0">' . $links . '</div></div>';
                                    }

                                    ?>

                            <?php } ?>
                        </div>
                    </div>
           


    
