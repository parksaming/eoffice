<?php
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=danh-sach-dang-ky-lich-tuan.doc");
    header("Pragma: no-cache");
    header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style type="text/css">
            body{
                padding: 0px;
                margin: 0px;
                font-family: Times New Roman;
                font-size: 10pt;
            }
            h3 {
                margin: 0;
            }
            .container{
                width: 888pt;
                padding-left: 5px
            }
            table {
                background-color: transparent;
                border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
            }
            table.border th {
                border: 1pt solid windowtext;
                color: #000000;
                padding: 1px 0;
                text-align: center;
                font-size: 11pt;
                font-weight: normal;
                font-family: Times New Roman;
                font-weight: 600;
            }
            table.border tr td {
                border: 1pt solid windowtext;
                padding : 2px;
                font-size: 11pt;
                height: 20px;
                font-family: Times New Roman;
                vertical-align: middle;
                text-align: left;  
            }
            table.border tr.first-hand td {
                border-bottom: 0;
            }
            table.border tr.second-hand td {
                border-top: 1pt dashed windowtext;
                border-bottom: 0;
            }
            table.border tr.third-hand td {
                border-top: 1pt dashed windowtext;
                border-bottom: 1pt solid windowtext;
            }
            table.border tr.four-hand td {
                border-top: 1pt solid windowtext;
                border-bottom: 1pt solid windowtext;
            }

            @page container {
                size: 29.7cm 21cm;
                margin: 1cm 1cm 1cm 1cm;
                mso-page-orientation: landscape;
                mso-footer: f1;
            }
            div.container { page:container;}
        </style>
    </head>
    <body>
        <div class="container">
            <div style="margin-bottom: 30px;">
                <table class="title_top">
                    <tr>
                        <td style="width: 250px; text-align: center;">
                            <h4>B??? GI??O D???C V?? ????O T???O</h4>
                        </td>
                        <td style="text-align: center;">
                            <h4 style="color:red">L???CH SINH HO???T C??NG T??C TU???N {{ $weekInYear }}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; text-align: center;vertical-align: top;">
                            <h4 style="margin-top: 5px; margin-bottom: 0;">?????I H???C ???? N???NG</h4>
                        </td>
                        <td style="text-align: center;">
                            <h4 style="margin-top: 5px; margin-bottom: 8px;">{{ date('d/m/Y', strtotime($firstDateInWeek)) }} ?????n {{ date('d/m/Y', strtotime($lastDateInWeek)) }}</h4>
                            <h4 style="margin: 0;">N??m h???c {{ date('Y', strtotime($firstDateInWeek)) }}-{{ date('Y', strtotime('+1 year', strtotime($firstDateInWeek))) }}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'></td>
                    </tr>
                </table>
            </div>

            <div>
                @if ($type === '' || $type === '1')
                    <div>
                        <h4 style="text-align: center; margin: 30px 0 10px 0;"> </h4>
                    </div>
                    <table class="border">
                        <thead>
                            <tr>
                                <th>TH???/NG??Y</th>
                                <th>TH???I GIAN</th>
                                <th>N???I DUNG</th>
                                <th>TH??NH PH???N</th>
                                <th>?????A ??I???M</th>
                                <th>CH??? TR??</th>
                            </tr>
                        </thead>
                        <tbody style="border-bottom: 1pt solid windowtext;">
                        @if(isset($dataDHDN) && sizeof($dataDHDN))
                            @php $stt = 1 @endphp
                            @foreach ($dataDHDN as $ngay => $data)
                                @php $val = $data[0] @endphp
                                <tr class="{{ sizeof($data) > 1 ? 'first-hand' : 'four-hand' }}">
                                    <td style="text-align: center; width: 110px; white-space: nowrap; border-bottom: 1pt solid windowtext;" rowspan="{{ sizeof($data) }}">{{ $ngay }}</td>
                                    <td style="text-align: center; font-weight: bold; width: 90px;">{{ $val->gio }}</td>
                                    <td style="text-align: center; width: 300px;">{!! nl2br($val->noidung) !!}</td>
                                    <td style="text-align: justify; padding: 0 8px; width: 300px;">{!! nl2br($val->thanhphan) !!}</td>
                                    <td style="text-align: center; width: 110px;">{{ (isset($val->phonghop) && $val->phonghop)? $val->phonghop->tenphonghop : $val->diadiem }}</td>
                                    <td style="text-align: center; font-weight: bold;">{{ $val->chutri }}</td>
                                </tr>

                                @for ($i = 1, $l = sizeof($data); $i < $l; $i++)
                                    @php $val = $data[$i] @endphp
                                    <tr class="{{ $i == ($l-1) ? 'third-hand' : 'second-hand' }}">
                                        <td style="text-align: center; font-weight: bold; width: 90px;">{{ $val->gio }}</td>
                                        <td style="text-align: center; width: 300px;">{!! nl2br($val->noidung) !!}</td>
                                        <td style="text-align: justify; padding: 0 8px; width: 300px;">{!! nl2br($val->thanhphan) !!}</td>
                                        <td style="text-align: center; width: 110px">{{ (isset($val->phonghop) && $val->phonghop)? $val->phonghop->tenphonghop : $val->diadiem }}</td>
                                        <td style="text-align: center; font-weight: bold;">{{ $val->chutri }}</td>
                                    </tr>
                                @endfor
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                @endif
            </div>

            <div>
                @if ($type === '' || $type === '2')
                    <div>
                        <h4 style="text-align: center; margin: 30px 0 10px 0;">L???CH SINH HO???T C??NG T??C C?? QUAN ?????I H???C ???? N???NG</h4>
                    </div>

                    <table class="border">
                        <thead>
                            <tr>
                                <th>TH???/NG??Y</th>
                                <th>TH???I GIAN</th>
                                <th>N???I DUNG</th>
                                <th>TH??NH PH???N</th>
                                <th>?????A ??I???M</th>
                                <th>CH??? TR??</th>
                            </tr>
                        </thead>
                        <tbody style="border-bottom: 1pt solid windowtext;">
                        @if(isset($dataCoquan) && sizeof($dataCoquan))
                            @php $stt = 1 @endphp
                            @foreach ($dataCoquan as $ngay => $data)
                                @php $val = $data[0] @endphp
                                <tr class="{{ sizeof($data) > 1 ? 'first-hand' : 'four-hand' }}">
                                    <td style="text-align: center; width: 110px; white-space: nowrap; border-bottom: 1pt solid windowtext;" rowspan="{{ sizeof($data) }}">{{ $ngay }}</td>
                                    <td style="text-align: center; font-weight: bold; width: 90px;">{{ $val->gio }}</td>
                                    <td style="text-align: center; width: 300px;">{!! nl2br($val->noidung) !!}</td>
                                    <td style="text-align: justify; padding: 0 8px; width: 300px;">{!! nl2br($val->thanhphan) !!}</td>
                                    <td style="text-align: center; width: 110px;">{{ (isset($val->phonghop) && $val->phonghop)? $val->phonghop->tenphonghop : $val->diadiem }}</td>
                                    <td style="text-align: center; font-weight: bold;">{{ $val->chutri }}</td>
                                </tr>

                                @for ($i = 1, $l = sizeof($data); $i < $l; $i++)
                                    @php $val = $data[$i] @endphp
                                    <tr class="{{ $i == ($l-1) ? 'third-hand' : 'second-hand' }}">
                                        <td style="text-align: center; font-weight: bold; width: 90px;">{{ $val->gio }}</td>
                                        <td style="text-align: center; width: 300px;">{!! nl2br($val->noidung) !!}</td>
                                        <td style="text-align: justify; padding: 0 8px; width: 300px;">{!! nl2br($val->thanhphan) !!}</td>
                                        <td style="text-align: center; width: 110px">{{ (isset($val->phonghop) && $val->phonghop)? $val->phonghop->tenphonghop : $val->diadiem }}</td>
                                        <td style="text-align: center; font-weight: bold;">{{ $val->chutri }}</td>
                                    </tr>
                                @endfor
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                @endif
            </div>

            <div style="display: flex; margin-top: 30px; font-size: 13px;">
                <div style="white-space: nowrap; text-decoration: underline; margin-right: 15px;font-size: 14px;font-weight: bold;font-style: italic;">Ghi ch??:</div>
                <div>
                    <div style="font-size: 14px;margin-bottom: 3px !important">1. V??? vi???c ????ng k?? xe: C??c ????n v??? ch???c n??ng thu???c C?? quan ??H??N c?? nhu c???u s??? d???ng xe ph???c v??? cho ho???t ?????ng c???a ????n v??? c???n c?? l???ch xin xe ri??ng g???i cho V??n ph??ng ??H??N qua ??/c H??? Phan Hi???u ??? Ph?? Ch??nh V??n ph??ng (D??: 0905169900; ??T: 3832678);</div>
                    <div style="font-size: 14px;margin-bottom: 3px !important">2. V??? vi???c ????? xe ?? t?? trong C?? quan ??H??N: ????? ngh??? kh??ng ????? xe ??? C?? quan qua ????m.</div>
                    <div style="font-size: 14px;margin-bottom: 3px !important">3. ????? ngh??? Th??? tr?????ng c??c ????n v??? c?? c??c bi???n ph??p ti???t ki???m ??i???n,  nh???c c??n b???, nh??n vi??n t???t ??i???n, ??i???u h??a khi ra kh???i ph??ng.</div>
                </div>
            </div>
        </div>
    </body>
</html>