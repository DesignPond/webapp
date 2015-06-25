
@extends('emails.layouts.master')
@section('content')

<?php

    $paddingReset = 'padding: 0;';
    $marginReset  = 'margin: 0;';
    $reset = $marginReset.$paddingReset.'border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;';
    $empty = '<td class="emptyCell" style="'.$reset.'background-color: #4f7dbb;line-height: 0 !important;font-size: 0 !important;">&nbsp;</td>';

?>

<tr>
    <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
    <td class="eBody alignCenter pdTp32" style="{{ $marginReset }}padding-top: 32px;padding-bottom: 0;padding-left: 16px;padding-right: 16px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;text-align: center;width: 512px;color: #54565c;background-color: #ffffff;">
        <h1 style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 5px;{{ $paddingReset }}-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;font-size: 20px;line-height: 36px;font-weight: bold;color: #465059;">
            <span style="color: #465059;">Votre demande de partage</span>
        </h1>

        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="{{ $marginReset }}{{ $paddingReset }}mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;" class="entryBox messageSection">
            <tr>
                <td style="{{ $marginReset }};padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;text-align: center;vertical-align: top;width: 116px;" class="width116 senderProfile alignCenter">
                    <table cellspacing="0" cellpadding="0" border="0" align="center" style="margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;text-align: center;width: 64px;height: 64px;" class="profilePicture">
                        <tr>
                            <td style="{{ $marginReset }}padding-top: 0;padding-bottom: 14px;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;">
                                <img src="<?php echo asset('users/'.$invited->user_photo);?>" width="70" height="70" style="margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;{{ $paddingReset }}height: 70px;width: 70px;line-height: 100%;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" alt="Profil">
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
                                    <strong>{{ $invited->name }}</strong> <br/>{{ trans('text.accepted') }}
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <p style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 24px;{{ $paddingReset }}-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;text-align: center;font-size: 16px;line-height: 22px;">&nbsp;</p>

        @include('emails.partials.button', ['url' => url('user'), 'titre' => trans('text.seeprofile') ])

    </td>
    <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
    <!-- end .eBody-->
</tr>
<tr>
    <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
    <td class="bottomCorners" style="{{ $reset }}height: 16px;background-color: #ffffff;">&nbsp;</td>
    <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
</tr>

@stop
