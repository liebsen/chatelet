<html>
 <body>
 	<table>
		<tr>
		    <td>
		        <table id="welcome" cellpadding="0" cellspacing="0" align="center">
		            <tr width="600" height="100" style="font-weight:bold;text-align:center;color:black;font-size: 15px;" bgcolor="f9fbfa"> 
		                <td style="padding:15px"> 
		                 <?php echo $this->html->image(Router::url('/',true)."images/logo.jpg"); ?>
		                </td>	
		                <td style="padding:15px">
		                    <br /><br /><br /> 	
		                    <?php echo strtoupper($data['name']); ?>, 
		                    <br /><br />
		                    Su nueva contraseña es :
                            <br />
                            <?php echo $data['password'] ; ?> 
                            <br /><br />
                            <br /><br />
                            Le recordamos que editando su usuario, puede cambiar la contraseña.
		                    <br/><br/>
		                </td>
		                  <br/><br/><br/>
		                    &copy; <?php echo date('Y',time()); ?> Copyright Chatelet;
		                    <p>All rights reserved.</p>
                          <br/><br/><br/>
		            </tr>
		        </table>
		    </td>
		</tr>
	</table>
 </body>
</html>


