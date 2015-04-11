<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- Define Charset -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Responsive Meta Tag -->
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <title>Riiingme | Notifications</title><!-- Responsive Styles and Valid Styles -->

    <style type="text/css">

        body{
            width: 100%;
            background-color: #4c4e4e;
            margin:0;
            padding:0;
            -webkit-font-smoothing: antialiased;
        }

        html{
            width: 100%;
        }

        table{
            font-size: 14px;
            border: 0;
        }

        /* ----------- responsivity ----------- */
        @media only screen and (max-width: 640px){

            .container{width: 440px !important;}
            .container-middle{width: 420px !important;}
            .mainContent{width: 400px !important;}
            /*------ sections ---------*/
            .section-item{width: 400px !important;}
            .section-img{width: 400px !important; height: auto !important;}

            /*------- prefooter ------*/
            .prefooter-header{padding: 0 10px !important; line-height: 24px !important;}
            /*------- footer ------*/
        }

        @media only screen and (max-width: 479px){

            /*------ top header ------ */
            .top-header-left{width: 260px !important; text-align: center !important;}
            .top-header-right{width: 260px !important;}

            /*------- header ----------*/
            .logo{width: 260px !important;}
            .nav{width: 260px !important;}

            /*----- --features ---------*/

            .container{width: 280px !important;}
            .container-middle{width: 260px !important;}
            .mainContent{width: 240px !important;}

            /*------ sections ---------*/
            .section-item{width: 240px !important;}
            .section-img{width: 240px !important; height: auto !important;}

            /*------- prefooter ------*/
            .prefooter-header{padding: 0 10px !important;line-height: 28px !important;}

        }

    </style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
    <tr><td height="30"></td></tr>
    <tr bgcolor="#4c4e4e">
        <td width="100%" align="center" valign="top" bgcolor="#4c4e4e">

            <!---------   top header   ------------>
            <table border="0" width="600" cellpadding="0" cellspacing="0" align="center" class="container">
                <tr bgcolor="243266"><td height="15"></td></tr>
                <tr bgcolor="243266">
                    <td align="center">
                        <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
                            <tr>
                                <td>
                                    <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="top-header-left">
                                        <tr>
                                            <td align="center">
                                                <table border="0" cellpadding="0" cellspacing="0" class="date">
                                                    <tr>
                                                        <td>
                                                            <img editable="true" mc:edit="icon1" width="13" height="13" style="display: block;" src="<?php echo asset('backend/images/email/icon-cal.png');?>" alt="icon" />
                                                        </td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td style="color: #fefefe; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                                                            {{ date('d/m/Y') }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="top-header-right">
                                        <tr><td width="30" height="20"></td></tr>
                                    </table>
                                    <table border="0" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="top-header-right">
                                        <tr><td align="center"></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr bgcolor="243266"><td height="10"></td></tr>
            </table>

            <!----------    end top header    ------------>
            <!----------   main content----------->
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="container" bgcolor="ececec">

                <!--------- Header  ---------->
                <tr bgcolor="ececec"><td height="30"></td></tr>
                <tr>
                    <td>
                        <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
                            <tr>
                                <td>
                                    <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="logo">
                                        <tr>
                                            <td align="center">
                                                <a href="" style="display: block; border-style: none !important; border: 0 !important;">
                                                    <img editable="true" mc:edit="logo" width="150" height="40" border="0" style="display: block;" src="<?php echo asset('backend/images/email/logo.png');?>" alt="logo" /></a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="nav">
                                        <tr>
                                            <td height="20" width="20"></td>
                                        </tr>
                                    </table>
                                    <table border="0" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="nav">
                                        <tr><td height="10"></td></tr>
                                        <tr>
                                            <td align="center" mc:edit="navigation" style="font-size: 13px; font-family: Helvetica, Arial, sans-serif;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr bgcolor="ececec"><td height="20"></td></tr>
                <!---------- end header --------->
                <!--------- section 1 --------->
                <tr>
                    <td>
                        <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
                            <tr><td align="center" style="line-height: 6px;"></td>
                            </tr>
                            <tr bgcolor="ffffff">
                                <td>
                                    <!-- Contenu -->
                                    @yield('content')
                                    <!-- Fin contenu -->
                                </td>
                            </tr>
                            <tr><td align="center" style="line-height: 6px;"></td></tr>
                        </table>
                    </td>
                </tr><!--------- end section 1 --------->
            </table>
            <!---------- prefooter  --------->
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="container" bgcolor="ececec">
                <tr><td height="30"></td></tr>
                <tr>
                    <td align="center" mc:edit="copy1" style="color: #939393; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;" class="prefooter-header">
                        Ceci est un email automatique envoyé par
                        <a href="http//www.riiingme.ch" style="color: #243266; font-size: 10px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">www.riiingme.ch</a>
                    </td>
                </tr>
                <tr><td height="30"></td></tr>
            </table>
            <!------------ end main Content ----------------->
            <!---------- footer  --------->
            <table border="0" width="600" cellpadding="0" cellspacing="0" align="center" class="container">
                <tr bgcolor="243266"><td height="14"></td></tr>
                <tr bgcolor="243266">
                    <td align="center" style="color: #cecece; font-size: 10px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                        RiiingMe © Copyright {{ date('Y') }}. All Rights Reserved
                    </td>
                </tr>
                <tr bgcolor="243266"><td height="14"></td></tr>
            </table>
            <!---------  end footer --------->
        </td>
    </tr>
    <tr><td height="30"></td></tr>
</table>

</body>
</html>
