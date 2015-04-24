<tr>
    <td class="highlight_stretch" style="{{ $reset }}background-color: #f6f6f7;">&nbsp;</td>
    <td class="highlight pdTp32" style="{{ $marginReset }}padding-top: 32px;padding-bottom: 0;padding-left: 16px;padding-right: 16px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;width: 512px;text-align: center;background-color: #f6f6f7;">
        <table border="0" align="center" cellpadding="0" cellspacing="0" class="profilePicture" style="margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;{{ $paddingReset }}mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;text-align: center;width: 128px;height: 128px;">
            <tr>
                <td style="{{ $marginReset }}padding-top: 10px;padding-bottom: 6px;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;">
                    <img src="<?php echo asset('emails/images/illustration.png');?>" width="160" height="160" alt="Profile" style="{{ $marginReset }}{{ $paddingReset }}height: 160px;width: auto;line-height: 100%;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;">
                </td>
            </tr>
        </table>
        <p class="profileName" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 24px;{{ $paddingReset }}-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;font-size: 14px;line-height: 22px;color: #a1a2a5;">
            <span style="font-weight: bold;color: #3cbff3;">{{ $name }}</span><br>
            <?php setlocale(LC_ALL, 'fr_FR.UTF-8'); ?>
            {{ strftime("%A %e %B %Y",time()) }}
        </p>
    </td>
    <td class="highlight_stretch" style="{{ $reset }}background-color: #f6f6f7;">&nbsp;</td>
    <!-- end .highlight-->
</tr>
