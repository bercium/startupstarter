<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- If you delete this meta tag, Half Life 3 will never be released. -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>cofinder</title>
	
<style>
  <?php echo @file_get_contents("css/email.css"); ?>
</style>

</head>
 
<body bgcolor="#FFF">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#FFF">
	<tr>
		<td></td>
		<td class="header container" >
				
				<div class="content">
				<table bgcolor="#FFFFFF">
					<tr>
						<td>
              <a href="http://www.cofinder.eu/" style="text-decoration: none;">
                <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/mail-logo.png" alt="cofinder" title="cofinder" style="border: 0;vertical-align: -40%;" border="0" height="38" width="40"></img>
                <span class="logo">
                  co<span>finder</span>
                </span>
              </a>
            </td>
						<td align="right">
              
            </td>
					</tr>
				</table>
				</div>
				
		</td>
		<td></td>
	</tr>
  <tr style="border-top: 1px solid #E8E0DC; ">
    <td></td>
    <td align="center" valign="top" bgcolor="#F0F0F0" class="separator">
      &nbsp;
    </td>
    <td></td>
  </tr>
  
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap">
	<tr>
		<td></td>
		<td class="container" bgcolor="#FFFFFF">

			<div class="content">
			<table>
				<tr>
					<td>
            <?php echo $content; ?>
												
						<!-- social & contact -->
					</td>
				</tr>
			</table>
			</div><!-- /content -->
									
		</td>
		<td></td>
	</tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<table class="footer-wrap">
	<tr>
		<td></td>
		<td class="container">
			
				<!-- content -->
				<div class="content">
				<table>
				<tr>
					<td align="center">
            
            <table class="social" width="100%">
							<tr>
								<td>
									
									<!-- column 1 -->
									<table align="left" class="column-wrap">
										<tr>
											<td>
                        <p class="social-icons">
                          <a href="https://www.facebook.com/cofinder.eu" class="soc-btn fb">f</a>
                          <a href="https://www.linkedin.com/company/cofinder" class="soc-btn in">in</a> 
                        </p>
                        <center style="padding-top:5px;">
												<p>
                          This email was sent from <strong><a href="http://www.cofinder.eu">www.cofinder.eu</a></strong>
                        </p>
                        </center>
											</td>
										</tr>
									</table><!-- /column 1 -->	
				
									
									<span class="clear"></span>	
									
								</td>
							</tr>
						</table><!-- /social & contact -->
            
						<p class="links">
							<a href="http://cofinder.eu/site/terms">Terms</a> |
							<a href="http://cofinder.eu/site/terms#privacy">Privacy</a> |
							<a href="#"><unsubscribe>Unsubscribe</unsubscribe></a>
						</p>
					</td>
				</tr>
			</table>
				</div><!-- /content -->
				
		</td>
		<td></td>
	</tr>
</table><!-- /FOOTER -->

</body>
</html>