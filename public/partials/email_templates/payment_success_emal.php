<?php 
$memberName = isset($data['user_login']) ? $data['user_login'] : '';
$memberEmail = isset($data['user_email']) ? $data['user_email'] : '';
$memberPlan = isset($data['user_membership']->membership) ? $data['user_membership']->membership : '';
$memberFee = isset($data['user_membership']->fee) ? $data['user_membership']->fee : '';
$emailBody='<!doctype html>
		<html>
		  <head>
			<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>Simple Transactional Email</title>
			<style>
			  img {
				border: none;
				-ms-interpolation-mode: bicubic;
				max-width: 100%; 
			  }
		
			  body {
				background-color: #f6f6f6;
				font-family: sans-serif;
				-webkit-font-smoothing: antialiased;
				font-size: 14px;
				line-height: 1.4;
				margin: 0;
				padding: 0;
				-ms-text-size-adjust: 100%;
				-webkit-text-size-adjust: 100%; 
			  }
		
			  table {
				border-collapse: separate;
				mso-table-lspace: 0pt;
				mso-table-rspace: 0pt;
				width: 100%; }
				table td {
				  font-family: sans-serif;
				  font-size: 14px;
				  vertical-align: top; 
			  }
		
			  /* -------------------------------------
				  BODY & CONTAINER
			  ------------------------------------- */
		
			  .body {
				background-color: #f6f6f6;
				width: 100%; 
			  }
		
			  /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
			  .container {
				display: block;
				margin: 0 auto !important;
				/* makes it centered */
				max-width: 580px;
				padding: 10px;
				width: 580px; 
			  }
		
			  /* This should also be a block element, so that it will fill 100% of the .container */
			  .content {
				box-sizing: border-box;
				display: block;
				margin: 0 auto;
				max-width: 580px;
				padding: 10px; 
			  }
		
			  /* -------------------------------------
				  HEADER, FOOTER, MAIN
			  ------------------------------------- */
			  .main {
				background: #ffffff;
				border-radius: 3px;
				width: 100%; 
			  }
		
			  p,
			  ul,
			  ol {
				font-family: sans-serif;
				font-size: 14px;
				font-weight: normal;
				margin: 0;
				margin-bottom: 15px; 
				text-align:left;
				margin-left:25px;
			  }
		
		
			  hr {
				border: 0;
				border-bottom: 1px solid #f6f6f6;
				margin: 20px 0; 
			  }
		
			  /* -------------------------------------
				  RESPONSIVE AND MOBILE FRIENDLY STYLES
			  ------------------------------------- */
			  @media only screen and (max-width: 620px) {
				table.body h1 {
				  font-size: 28px !important;
				  margin-bottom: 10px !important; 
				}
				table.body p,
				table.body ul,
				table.body ol,
				table.body td,
				table.body span,
				table.body a {
				  font-size: 16px !important; 
				}
				table.body .wrapper,
				table.body .article {
				  padding: 10px !important; 
				}
				table.body .content {
				  padding: 0 !important; 
				}
				table.body .container {
				  padding: 0 !important;
				  width: 100% !important; 
				}
				table.body .main {
				  border-left-width: 0 !important;
				  border-radius: 0 !important;
				  border-right-width: 0 !important; 
				}
				table.body .btn table {
				  width: 100% !important; 
				}
				table.body .btn a {
				  width: 100% !important; 
				}
				table.body .img-responsive {
				  height: auto !important;
				  max-width: 100% !important;
				  width: auto !important; 
				}
			  }
		

			  .header_color{
				background-color:#c41919;
				color:#fff
			  }
		
			</style>
		  </head>
		  <body>
			<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
			  <tr>
				<td>&nbsp;</td>
				<td class="container">
				  <div class="content">
					<!-- START CENTERED WHITE CONTAINER -->
					<table role="presentation" class="main">
		
					  <!-- START MAIN CONTENT AREA -->
					  <tr><td><a href="'.HOME_URL.'" target="_blank"><img src="'.DIR_URL.'/OSA-logo-small.png" style="float:left;"/></a>
					  <a href="#" target="_blank"><img src="'.DIR_URL.'/facebook.png" alt="" style="float:right;padding-right:4px;"/></a>
						<a href="#" target="_blank"><img src="'.DIR_URL.'/twitter.png" alt="" style="float:right;padding-right:4px;"/></a>
						<a href="#" target="_blank"><img src="'.DIR_URL.'/linkedin.png" alt="" style="float:right;padding-right:4px;"/></a>
						<a href="#" target="_blank"><img src="'.DIR_URL.'/googleplus.png" alt="" style="float:right;padding-right:4px;"/></a></td>
					  </tr>
					  <tr>
					  <th><img src="'.DIR_URL.'/Banner.png"></th></tr>	

				 
					  <tr>
						<td class="wrapper">
						  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
							<tr>
							  <td>
							  <p>Hi <strong>'.$memberName.'</strong>,<br>Your payment was successful.Please login to continue.</p>
							  <p><strong>Email</strong>: '.$memberEmail.' <br><strong>Membership Plan</strong>:'.$memberPlan.'<br><strong>Membership Fee</strong>:$'.$memberFee.'</p>
							  </td>
							 
							</tr>
							<tr>
							<td><p>If you have any queries, feel free to <a target="_blank" href="'.CONTACT_US_URL.'">Contact Us</a></p></td>
							</tr>
						  </table>
						  <tr class="header_color"><td style="text-align:center">'.COPYRIGHT_TEXT.'</td></tr>	
						</td>
					  </tr>
		
					<!-- END MAIN CONTENT AREA -->
					</table>
					<!-- END CENTERED WHITE CONTAINER -->
		
		
				  </div>
				</td>
				<td>&nbsp;</td>
			  </tr>
			</table>
		  </body>
		</html>';