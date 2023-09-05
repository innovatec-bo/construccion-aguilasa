<html style=""><head><meta http-equiv="Content-Type" content="text/html; charset=gb18030"></head>
<body style="">
    <table align="center" border="0" cellpadding="0" cellspacing="0" data-bgcolor="background" data-module="module1" data-thumb="https://gallery.mailchimp.com/8422eaf214b6ca56027a72439/images/d5fc20ae-79d7-458e-98f2-54d6ac5296b6.png" style="background: url(<?=base_url("assets/images/bg-body.jpg")?>);opacity: 1;position: relative;z-index: 0;" width="100%" class="">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="table680" data-bg="bg-photo1" data-bgcolor="body1" style="background-image: none;background-position: 50% 100%;background-size: cover;max-width: 1000px;" width="100%">
                        <tbody>
                            <tr>
                                <td style="padding-top:35px;">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="table680" bgcolor="#000" style="background-color: #0F263A;max-width: 800px;" data-bgcolor="module1-inner-bg1" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="padding-top:25px;padding-bottom:25px;">
                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="table-inner" width="900">
                                                        <tbody>
                                                            <tr>
                                                                <td class="td_600" valign="top">
                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="table1" width="auto">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td valign="top" align="left" class="padding_bottom1" data-color="module1_text1" data-size="module1_text1" mc:edit="ab1" style="color: rgb(255, 255, 255); font-family: 'Open Sans', sans-serif; font-size: 22px; font-weight: 800;line-height: 18px;text-align: center"><multiline label="ab1"><?=$subject?></multiline></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table align="center" style="background-color: #fff;opacity: 1;" border="0" cellpadding="0" cellspacing="0" class="table-inner" width="900">
                                        <tbody>
                                            <tr>
                                                <td class="td_hide" height="30">
                                                </td>
                                            </tr>
                                            <!-- Image -->
                                            <tr>
                                                <td align="center" valign="top" colspan="2"><img alt="img" data-crop="false" editable="" label="ph1" mc:edit="ph1" src="<?=base_url("assets/images/favicon.png")?>" style="border: 0px; display: block; font-size: 0px; line-height: 0px;" width="80"></td>
                                            </tr>
                                            <!-- End Image -->
                                            <!-- Content -->
                                            <?php
                                            $row = "";
                                            $i = 1;
                                            $totalAmount = 0;
                                            usort($projectList, function($a, $b) {
                                                return $b['static_days'] - $a['static_days'];
                                            });
                                            foreach ($projectList as $project)
                                            {
                                                //#ff0000 danger
                                                //#FFA87D warning
                                                //#404E67 default
//                                                echo"<pre>";var_dump($project);exit;
                                                $staticDays = $project["static_days"];
                                                if($staticDays < 7)
                                                    $color = "#404E67";
                                                if($staticDays >= 7 && $staticDays < 14)
                                                    $color = "#FFA87D";
                                                if($staticDays >= 14)
                                                    $color = "#ff0000";
                                                $date = new DateTime($project[$shipmentDate]);
                                                $date = $date->format("d-m-Y");
                                                $row .= '
                                                                                <tr style="font-size: 12px; color:'.$color.'">
                                                                                    <td style="border: 1px solid #b5babf;text-align: center;line-height: 16px;">
                                                                                        '.$i.'
                                                                                    </td>
                                                                                    <td style="border: 1px solid #b5babf;text-align: right;line-height: 16px;">
                                                                                        '.$project["code_pro"].'
                                                                                    </td>
                                                                                    <td style="border: 1px solid #b5babf;text-align: right;line-height: 16px;">
                                                                                        '.$project["final_contract_number_con"].'
                                                                                    </td>
                                                                                    <td style="border: 1px solid #b5babf;text-align: right;line-height: 16px;">
                                                                                        '.$date.'
                                                                                    </td>
                                                                                    <td style="border: 1px solid #b5babf;text-align: right;line-height: 16px;">
                                                                                        '.$project['static_days'].'
                                                                                    </td>
                                                                                    <td style="border: 1px solid #b5babf;text-align: left;line-height: 16px;">
                                                                                        '.$project['cre_fiscal_pro'].'
                                                                                    </td>
                                                                                    <td style="border: 1px solid #b5babf;text-align: left;line-height: 16px;">
                                                                                        '.$project['address_pro'].'
                                                                                    </td>
                                                                                    <td style="border: 1px solid #b5babf;text-align: right;line-height: 16px;">
                                                                                        '.number_format($project['total_approved'],2,",",".").'
                                                                                    </td>
                                                                                </tr>
                                                                            ';
                                                $totalAmount += $project['total_approved'];
                                                $i++;
                                            }
                                            $totalAmount = number_format($totalAmount,2,",",".");
                                            ?>
                                            <tr style="display: block">
                                                <td align="center" data-color="module1_text3" data-size="module1_text3" mc:edit="ab5" style="padding-left:25px;padding-right:25px;color: #404E67;font-family: 'Open Sans', sans-serif;font-size: 15px;line-height: 25px;padding-top: 12px;">
                                                    <multiline label="ab5">
                                                        Estimado,<br>
                                                        SEREBO le detalla los <?=strtolower($subject)?>.
                                                    </multiline>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" data-color="module1_text3" data-size="module1_text3" mc:edit="ab5" style="width: 50%;padding-left:44px;padding-right:25px;color: #404E67;font-family: 'Open Sans', sans-serif;font-size: 15px;line-height: 25px;padding-top: 12px;">
                                                        <span style="color: #404E67;font-weight: bold;text-decoration: underline;">Prioridad</span><br>
                                                        <span style="color:#ff0000;font-weight: bold">Alta: </span>Dias estatico mayor o igual a 14<br>
                                                        <span style="color:#FFA87D;font-weight: bold">Media: </span>Dias estaticos mayor o igual a 7 y menor a 14 <br>
                                                    <span style="color:#404E67;font-weight: bold">Baja: </span>Dias estaticos menor a 7
                                                </td>
                                                <td align="left" data-color="module1_text3" data-size="module1_text3" mc:edit="ab5" style="width: 50%;padding-right:44px;color: #404E67;font-family: 'Open Sans', sans-serif;font-size: 15px;line-height: 25px;padding-top: 12px;text-align:right">
                                                    <span style="font-size: 25px">Bs. <?=$totalAmount?></span><br>
                                                    <span style="color: #404E67;">Monto aprobado</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" data-color="module1_text4" data-size="module1_text4" mc:edit="ab6" style="color: #000; font-family: 'Open Sans', sans-serif;  font-weight: 500; line-height: 26px; padding-top: 10px;" colspan="2">
                                                    <table style="width:90%;border:1px solid #b5babf;color:#000;border-collapse: collapse;" cellpadding="5px" cellspacing="0">
                                                        <thead>
                                                        <tr style="background: #f6f6f6;font-size: 12px;">
                                                            <th style="border: 1px solid #b5babf;color: #404E67;">#</th>
                                                            <th style="border: 1px solid #b5babf;color: #404E67;text-align: left">COD</th>
                                                            <th style="border: 1px solid #b5babf;color: #404E67;text-align: left">NRO. CONTRATO</th>
                                                            <th style="border: 1px solid #b5babf;color: #404E67;text-align: left">FECHA</th>
                                                            <th style="border: 1px solid #b5babf;color: #404E67;text-align: left">DIAS ESTATICO</th>
                                                            <th style="border: 1px solid #b5babf;color: #404E67;text-align: left">FISCAL<br> DE CRE</th>
                                                            <th style="border: 1px solid #b5babf;color: #404E67;text-align: left">DIRECCION</th>
                                                            <th style="border: 1px solid #b5babf;color: #404E67;text-align: left">MONTO<br>APROBADO</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?=$row;?>
                                                        </tbody>
                                                        <tfoot>
                                                        </tfoot>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- End Content -->
                                            <tr>
                                                <td align="center" data-color="module1_text3" data-size="module1_text3" mc:edit="ab5" style="padding-left:25px;padding-right:25px;color: #404E67;font-family: 'Open Sans', sans-serif;font-size: 15px;line-height: 25px;padding-top: 12px;" colspan="2">
                                                    <multiline label="ab5">
                                                        Serebo.Admin
                                                    </multiline>
                                                </td>
                                            </tr>
                                            <!-- End Content -->
                                            <tr>
                                                <td class="td_hide" height="30" colspan="2">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="35" style="background: url(<?=base_url("assets/images/bg-body.jpg")?>);" colspan="2">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
<br>
</body>
</html>