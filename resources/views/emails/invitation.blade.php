@extends('emails.layouts.master')
@section('content')

<?php

    $paddingReset = 'padding: 0;';
    $marginReset  = 'margin: 0;';
    $reset = $marginReset.$paddingReset.'border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;';
    $empty = '<td class="emptyCell" style="'.$reset.'background-color: #4f7dbb;line-height: 0 !important;font-size: 0 !important;">&nbsp;</td>';

?>
<tr>
    <td class="highlight_stretch" style="{{ $reset }}background-color: #f6f6f7;">&nbsp;</td>
    <td class="highlight pdTp32" style="{{$marginReset}}padding-top: 32px;padding-bottom: 0;padding-left: 16px;padding-right: 16px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;width: 512px;text-align: center;background-color: #f6f6f7;">
        <h1 style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 5px;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;font-size: 24px;line-height: 36px;font-weight: bold;color: #465059;">
            <a href="#" style="padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;color: #235daa;">
                <span style="text-decoration: none;color: #465059;">Demande de partage</span>
            </a>
        </h1><br/>
    </td>
    <td class="highlight_stretch" style="{{ $reset }}background-color: #f6f6f7;">&nbsp;</td>
    <!-- end .highlight-->
</tr>
<tr>
    <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
    <td class="bottomCorners" style="{{ $reset }}height: 16px;background-color: #ffffff;">&nbsp;</td>
    <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
</tr>
<tr>
    <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
    <td class="eBody" style="{{ $marginReset }}padding-top: 16px;padding-bottom: 0;padding-left: 16px;padding-right: 16px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;width: 512px;color: #54565c;background-color: #ffffff;">
        <p style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 24px;{{ $paddingReset }}-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;font-size: 14px;line-height: 22px;text-align: left;">
            <strong>{{ $invite->user->first_name }} {{ $invite->user->last_name }}</strong> souhaite partager ses informations avec vous.
        </p>
        <table class="quoteTable" width="100%" border="0" cellspacing="0" cellpadding="0" style="{{ $marginReset }}{{ $paddingReset }}mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;">
            <tr>
                <td style="{{ $marginReset }}padding-top: 10px;padding-bottom: 0;padding-left: 16px;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;color: #82858f;border-left: 6px solid #ebebeb;">

                    @if(!empty($partage))

                        <?php
                            $groupes_titres = [
                                    2 => 'Adresse privé' ,
                                    3 => 'Adresse professionnelle' ,
                                    4 => 'Adresse privé temporaire' ,
                                    5 => 'Adresse professionnelle temporaire',
                                    6 => 'Adresse entreprise',
                                    7 => 'Adresse entreprise temporaire'
                            ];
                        ?>
                        <br/>
                        <p style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 24px;{{ $paddingReset }}-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;font-size: 14px;line-height: 22px;text-align: left;">
                            {{ $invite->user->first_name }} souhaiterai obtenir les informations suivantes:
                        </p>

                        @foreach($partage as $groupes => $groupe)
                            <h4 style="color: #000; margin: 5px 0 10px 0; line-height: 18px; font-size: 14px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">{{ $groupes_titres[$groupes] }}</h4>
                            <ul style="margin-left: 5px;padding-left: 5px;margin-right: 30px;">
                                @foreach($groupe as $type)
                                    <li style="color: #484848; line-height: 16px; font-size: 12px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">{{ $types[$type] }}</li>
                                @endforeach
                            </ul>
                        @endforeach
                    @endif

                </td>
            </tr>
        </table>
        <br/>
        <p style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 24px;{{ $paddingReset }}-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;text-align: left;font-size: 14px;line-height: 22px;">
            Pour confirmer la demande de partage veuillez suivre ce lien:
        </p>
        <?php  $url = url('invite?token='.$invite->token.'&ref='.base64_encode($invite->email).''); ?>
        @include('emails.partials.button', ['url' => $url, 'titre' => 'Accepter le partage' ])

    </td>
    <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
    <!-- end .eBody -->
</tr>
<tr>
    <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
    <td class="bottomCorners" style="{{ $reset }}height: 16px;background-color: #ffffff;">&nbsp;</td>
    <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
</tr>

@stop