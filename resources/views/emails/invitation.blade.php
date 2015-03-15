@extends('layouts.notification')
@section('content')

    <table width="528" border="0" align="center" cellpadding="0" cellspacing="0" class="mainContent">
        <tr><td height="20"></td></tr>
        <tr>
            <td>
                <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="section-item">
                    <tr><td height="6"></td></tr>
                    <tr>
                        <td>
                            <a href="" style="width: 128px; display: block; border-style: none !important; border: 0 !important;">
                                <img width="128" height="128" border="0" style="display: block;" src="<?php echo asset('backend/images/email/image1.png');?>" alt="image" class="section-img" />
                            </a>
                        </td>
                    </tr>
                    <tr><td height="10"></td></tr>
                </table>
                <table border="0" align="left" width="10" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                    <tr><td height="30" width="10"></td></tr>
                </table>
                <table border="0" width="360" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="section-item">
                    <tr>
                        <td style="color: #484848; line-height: 22px; font-size: 16px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                            {{ $invite->user->first_name }} {{ $invite->user->last_name }} vous a envoyé une demande de partage sur RiiingMe
                        </td>
                    </tr>
                    <tr><td height="15"></td></tr>
                    <tr>
                        <td>
                            <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                @if(!empty($partage))
                                    <?php $groupes_titres = array(2 => 'Adresse privé' , 3 => 'Adresse professionnelle');  ?>
                                    <tr valign="top">
                                        <p style="color: #484848; margin: 5px 0 10px 0; line-height: 18px; font-size: 14px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                                            {{ $invite->user->first_name }} souhaiterai obtenir les informations suivantes:
                                        </p>
                                        @foreach($partage as $groupes => $groupe)
                                            <td>
                                                <h4 style="color: #000; margin: 5px 0 10px 0; line-height: 18px; font-size: 14px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">{{ $groupes_titres[$groupes] }}</h4>
                                                <ul style="margin-left: 5px;padding-left: 5px;margin-right: 30px;">
                                                    @foreach($groupe as $type)
                                                        <li style="color: #484848; line-height: 16px; font-size: 12px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">{{ $types[$type] }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endif
                            </table>
                        </td>
                    </tr>
                    <tr><td height="15"></td></tr>
                    <tr>
                        <td style="color: #a4a4a4; line-height: 20px; font-size: 12px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
                            Pour confirmer la demande de partage veuillez suivre ce lien:
                        </td>
                    </tr>
                    <tr><td height="15"></td></tr>
                    <tr>
                        <td>

                            <?php
                                $email = base64_encode($invite->email);
                                $url   = \URL::route('invite', array('token' => $invite->token, 'ref' => $email));
                            ?>

                            <a style="text-align:center;font-size:13px;font-family:arial,sans-serif;font-weight: normal;
                                                color:white;background-color: #3996d3;text-decoration:none;display:inline-block;
                                                min-height:35px;padding-left:15px;padding-right:15px;
                                                line-height:35px;border-radius:2px;" href="{{ $url }}">Accepter le partage</a>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td height="20"></td></tr>
    </table>


@stop