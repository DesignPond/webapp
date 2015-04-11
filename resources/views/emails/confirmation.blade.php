
@extends('emails.layouts.notification')
@section('content')

    <table width="528" border="0" align="center" cellpadding="0" cellspacing="0" class="mainContent">
        <tr><td height="20"></td></tr>
        <tr>
            <td>
                <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="section-item">
                    <tr><td height="6"></td></tr>
                    <tr>
                        <td>
                            <a href="{{ url('/') }}" style="width: 88px; display: block; border-style: none !important; border: 0 !important;">
                                <img width="88" height="88" border="0" style="display: block;" src="<?php echo asset('backend/images/email/image1.png');?>" alt="image" class="section-img" />
                            </a>
                        </td>
                    </tr>
                    <tr><td height="10"></td></tr>
                </table>
                <table border="0" align="left" width="10" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                    <tr><td height="30" width="10"></td></tr>
                </table>
                <table border="0" width="400" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="section-item">
                    <tr>
                        <td style="color: #484848; line-height: 22px; font-size: 16px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                            <h3 style="font-family: arial, sans-serif;">Inscription sur RiiingMe</h3>
                            <p style="font-size:13px;font-family: arial, sans-serif;">Bonjour <strong>{{ $name }}</strong>, <br/>Pour confirmer votre inscription sur RiiingMe veuillez suivre ce lien:</p>
                        </td>
                    </tr>
                    <tr><td height="5"></td></tr>
                    <tr>
                        <td>
                            <a style="text-align:center;font-size:13px;font-family:arial,sans-serif;font-weight: normal;
                                                color:white;background-color: #3996d3;text-decoration:none;display:inline-block;
                                                min-height:35px;padding-left:15px;padding-right:15px;
                                                line-height:35px;border-radius:2px;" href="{{ url('activation?token='.$token) }}">Confirmer l'adresse email</a>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td height="20"></td></tr>
    </table>

@stop
