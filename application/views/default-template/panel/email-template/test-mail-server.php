<html><head></head><body style="margin: 0px">
    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" style="background-color:#f5f7fa;opacity:1;background: #ffffff;" width="100%">
    <tbody><tr>
        <td>
            <table align="center" bgcolor="" border="0" cellpadding="0" cellspacing="0" class="m_-4250512283747525057table680" style="background-color:none;background-image:none;background-position:50% 100%;background-size:cover;max-width:800px" width="100%">
                <tbody>
                <tr>
                    <td>
                        <table align="center" style="margin-bottom:30px;background-color:#ffffff21;opacity:1;/* -webkit-box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); *//* box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); */;" border="0" cellpadding="0" cellspacing="0" class="m_-4250512283747525057table-inner" width="600">
                            <tbody>
                            <tr>
                                <td class="m_-4250512283747525057td_hide" height="30">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center" valign="top"><img alt="img" height="100" label="ph1" src="<?=assets_url('images/humantus/logo-with-below-text.png')?>" style="padding: 0.25rem;display: block;font-size: 0px;line-height: 0px;margin-right: 5px" width="auto" class="CToWUd"></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center" style="padding-left:25px;padding-right:25px;color: #3D3D3D;font-family:'Open Sans',sans-serif;font-size:15px;line-height:25px;padding-top:12px;">
                                    <u></u>
                                    Prueba de envio de correo
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="margin-top: 20px;margin-bottom: 5px;text-align: center;font-family: 'Open Sans',sans-serif;font-size: 14px;">Configuracion utilizada:</div>
                                </td>
                            </tr>
							<tr>
								<td>
									<?php
									echo "<strong>From:</strong> ".$emailFrom."<br><br>";
									foreach ($config as $key => $value)
									{
										if($key == "newline")
										{
											$value = str_replace("\"","",json_encode($value));
										}
										echo "<strong>".$key.":</strong> ".$value."<br>";
									}
									?>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center" style="padding-left:25px;padding-right:25px;color: #3D3D3D;font-family:'Open Sans',sans-serif;font-size:15px;line-height:25px;padding-top:12px;">
									<u></u>
									<?php
									if(isset($sendMessageResponse))
										echo $sendMessageResponse['message'];
									?>
								</td>
							</tr>
                            <tr>
                                <td class="m_-4250512283747525057td_hide" height="30">
                                </td>
                            </tr>
                            <tr>
                                <td height="20">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody></table>
        </td>
    </tr>
    </tbody></table></body></html>
