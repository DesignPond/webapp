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
                <span style="text-decoration: none;color: #465059;">Notification de changement du partage</span>
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

        @if(!empty($data))
            @foreach($data as $datauser)

                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="{{ $marginReset }}{{ $paddingReset }}mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;" class="entryBox messageSection">
                    <tr>
                        <td style="{{ $marginReset }};padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;text-align: center;vertical-align: top;width: 116px;" class="width116 senderProfile alignCenter">
                            <table cellspacing="0" cellpadding="0" border="0" align="center" style="margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;text-align: center;width: 64px;height: 64px;" class="profilePicture">
                                <tr>
                                    <td style="{{ $marginReset }}padding-top: 0;padding-bottom: 14px;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;">
                                        <img src="<?php echo asset('users/'.$datauser['user']->user_photo);?>" width="70" height="70" style="margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;{{ $paddingReset }}height: 70px;width: 70px;line-height: 100%;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" alt="Profil">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td valign="top" align="left" style="{{ $marginReset }}padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;line-height: 0 !important;font-size: 0 !important;" class="emptyCell messageArrow"></td>
                        <td style="{{ $marginReset }}padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;text-align: left;vertical-align: top;width: 380px;" class="width380">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="{{ $marginReset }}{{ $paddingReset }}mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;" class="bubble">
                                <tr>
                                    <td style="{{ $marginReset }}{{ $paddingReset }}border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;background-color: #f6f6f7;line-height: 0 !important;font-size: 0 !important;" class="emptyCell">&nbsp;</td>
                                    <td valign="middle" align="left" style="{{ $marginReset }}padding-top: 12px;padding-bottom: 0;padding-left: 12px;padding-right: 12px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;background-color: #f6f6f7;" class="bubbleContent">
                                        <p style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 14px;{{ $paddingReset }}-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;font-size: 14px;line-height: 22px;text-align: left;color: #54565c;">
                                            <strong>{{ $datauser['user']->name }}</strong> <br/>a changé les informations qu'il/elle partage avec vous
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <table class="quoteTable" width="100%" border="0" cellspacing="0" cellpadding="0" style="{{ $marginReset }}{{ $paddingReset }}margin-bottom:40px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;">
                    <tr>
                        <td style="{{ $marginReset }}padding-top: 10px;padding-bottom: 0;padding-left: 16px;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;color: #82858f;border-left: 6px solid #ebebeb;">

                            @if(isset($datauser['changes']) && !empty($datauser['changes']))
                                <h3 style="color:#82858f;font-size:16px;margin-bottom: 10px;">Informations ajoutés</h3>

                                @include('emails.partials.changes', ['changes' => $datauser['changes']])

                            @endif

                            @if(isset($datauser['revision']) && !empty($datauser['revision']))
                                <h3 style="color:#82858f;font-size:16px;margin-bottom: 10px;">Informations édités</h3>

                                @include('emails.partials.changes', ['changes' => $datauser['revision']])

                            @endif
                        </td>
                    </tr>
                </table>

            @endforeach
        @endif

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