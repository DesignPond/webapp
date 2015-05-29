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
                    <span style="text-decoration: none;color: #465059;">{{ trans('text.password_rappel') }}</span>
                </a>
            </h1><br/>
        </td>
        <td class="highlight_stretch" style="{{ $reset }}background-color: #f6f6f7;">&nbsp;</td>
    </tr>
    <tr>
        <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
        <td class="bottomCorners" style="{{ $reset }}height: 16px;background-color: #ffffff;">&nbsp;</td>
        <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
    </tr>
    <tr>
        <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
        <td class="eBody" style="{{ $marginReset }}padding-top: 16px;padding-bottom: 0;padding-left: 16px;padding-right: 16px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;width: 512px;color: #54565c;background-color: #ffffff;">

            <p style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 24px;{{ $paddingReset }}-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;text-align: center;font-size: 16px;line-height: 22px;">
                {{ trans('text.password_text') }}
            </p>

            <?php  $url = url('password/reset/'.$token); ?>
            @include('emails.partials.button', ['url' => $url, 'titre' => trans('text.password_button') ])

        </td>
        <td class="eBody_stretch" style="{{ $reset }}min-width: 16px;background-color: #ffffff;">&nbsp;</td>
    </tr>
@stop
