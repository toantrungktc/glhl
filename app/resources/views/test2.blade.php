<!DOCTYPE html>
<html lang="en-GB">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>
    </title>
    <style>
        body {
            line-height: 108%;
            font-family: Calibri;
            font-size: 11pt;
       
        }

        p {
            margin: 0pt 0pt 8pt
        }

        li,
        table {
            margin-top: 0pt;
            margin-bottom: 8pt;
            page-break-inside: auto
        }

        .ListParagraph {
            margin-left: 36pt;
            margin-bottom: 8pt;
            line-height: 108%;
            font-size: 11pt
        }

        .page-header, .page-header-space {
        height: 149px;
        }
        

        .page-footer, .page-footer-space {
        height: 50px;

        }

        

        .page-header {
        position: fixed;
        top: 0.5mm;
        width: 100%;
        /* counter-increment: page; */
        }

        .page {
        page-break-after: always;
        
        
        }
        /* s */
        @media print {
            thead {display: table-header-group;} 
            tfoot {display: table-footer-group;}
            
            button {display: none;}
            
            body {margin: 0;}
            @page
            {
                size: A4;
                
            }
        }

        .page-header {
            counter-increment: pageTotal; 
            }
        .page-number:after{
        content:counter(pageTotal);
        }
        

 
    </style>

    

</head>

<body>
<div class="page-header" style="text-align: center">
    <table style="width:539pt; margin-bottom:0pt; border:0.75pt solid #000000; border-collapse:collapse;">
        <tbody>
            <tr style="height:15.75pt;">
                <td rowspan="4" style="width:80.55pt; border-right:0.75pt solid #000000; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong><span style="font-family:'times-new-roman';">NMTL&nbsp;</span></strong><br><strong><span style="font-family:'times-new-roman';">KHATOCO&nbsp;</span></strong><br><strong><span style="font-family:'times-new-roman';">KH&Aacute;NH H&Ograve;A</span></strong></p>
                </td>
                <td rowspan="4" style="width:257.75pt; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:14pt;"><strong><span style="font-family:'times-new-roman'; background-color:#ffffff;">BẢNG QUYẾT TO&Aacute;N SỬ DỤNG GL-HL</span></strong></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong><span style="font-family:'times-new-roman';">Từ ngày {{ date('d/m/Y', strtotime($date1)) }} đến ngày {{ date('d/m/Y', strtotime($date2)) }}</span></strong></p>
                </td>
                <td style="width:80.55pt; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; line-height:normal;"><em><span style="font-family:'times-new-roman';">K&yacute; hiệu t&agrave;i liệu</span></em></p>
                </td>
                <td style="width:101.85pt; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span style="font-family:'times-new-roman';">CN-CB-HD02 &ndash;F02</span></p>
                </td>
            </tr>
            <tr style="height:15.75pt;">
                <td style="width:80.55pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; line-height:normal;"><em><span style="font-family:'times-new-roman';">Lần ban h&agrave;nh:</span></em></p>
                </td>
                <td style="width:101.85pt; border-top:0.75pt solid #cccccc; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span style="font-family:'times-new-roman';">30/ 06 / 2020</span></p>
                </td>
            </tr>
            <tr style="height:15.75pt;">
                <td style="width:80.55pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; line-height:normal;"><em><span style="font-family:'times-new-roman';">Lần sửa đổi:</span></em></p>
                </td>
                <td style="width:101.85pt; border-top:0.75pt solid #cccccc; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; line-height:normal;"><em><span style="font-family:'times-new-roman';">&nbsp;</span></em></p>
                </td>
            </tr>
            <tr style="height:15.75pt;">
                <td style="width:80.55pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; line-height:normal;"><em><span style="font-family:'times-new-roman';">Trang:</span></em></p>
                </td>
                <td style="width:101.85pt; border-top:0.75pt solid #cccccc; border-left:0.75pt solid #cccccc; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p id="trang" style="margin-bottom:0pt; text-align:center; line-height:normal;"><span class="page-number" style="font-family:'times-new-roman';"> </span></p>
                </td>
            </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <table style="width:539.45pt; margin-bottom:0pt; border:0.75pt solid #000000; border-collapse:collapse;">
        <tbody>
                <tr style="height:15.75pt; border-top:0.75pt solid #000000;">
                    <td style="width:27pt; border-right:0.75pt solid #000000; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle; background-color:#ffffff;">
                        <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><strong><span style="font-family:'times-new-roman';">STT</span></strong></p>
                    </td>
                    <td style="width:65.25pt; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle; background-color:#ffffff;">
                        <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><strong><span style="font-family:'times-new-roman';">M&atilde; số</span></strong></p>
                    </td>
                    <td style="width:151.4pt; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle; background-color:#ffffff;">
                        <p style="margin-bottom:0pt; line-height:normal; font-size:12pt;"><strong><span style="font-family:'times-new-roman';">T&ecirc;n vật tư</span></strong></p>
                    </td>
                    <td style="width:30.95pt; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle; background-color:#ffffff;">
                        <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><strong><span style="font-family:'times-new-roman';">ĐVT</span></strong></p>
                    </td>
                    <td style="width:46.85pt; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle; background-color:#ffffff;">
                        <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><strong><span style="font-family:'times-new-roman';">Tồn đầu</span></strong></p>
                    </td>
                    <td style="width:46.9pt; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle; background-color:#ffffff;">
                        <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><strong><span style="font-family:'times-new-roman';">Nhập</span></strong></p>
                    </td>
                    <td style="width:46.9pt; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle; background-color:#ffffff;">
                        <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><strong><span style="font-family:'times-new-roman';">Xuất</span></strong></p>
                    </td>
                    <td style="width:46.9pt; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle; background-color:#ffffff;">
                        <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><strong><span style="font-family:'times-new-roman';">Tồn cuối</span></strong></p>
                    </td>
                    <td style="width:38pt; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; padding:1.12pt 1.88pt; vertical-align:middle; background-color:#ffffff;">
                        <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><strong><span style="font-family:'times-new-roman';">Ghi ch&uacute;</span></strong></p>
                    </td>
                </tr>
        </tbody>
    </table>
</div>


    
    <table style="width:539pt; margin-bottom:0pt; border:0.75pt solid #000000; border-collapse:collapse;">
    <thead>
      <tr style="border-left:0.75pt solid white; border-right:0.75pt solid white; border-bottom:0.75pt solid #000000; border-top:0.75pt solid white; ">
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>
    <tbody>
    @foreach ($data->sortBy('stt') as $index => $detail)
            <tr  style="height:15.75pt;">
                <td style="width:27pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-bottom:0.75pt dashed #000000; padding:1.12pt 1.88pt; vertical-align:middle; background-color:#ffffff;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><span style="font-family:'times-new-roman';">{{ $detail->stt }}</span></p>
                </td>
                <td style="width:65.25pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt dashed #000000; padding:1.12pt 1.88pt; vertical-align:middle; background-color:#ffffff;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><span style="font-family:'times-new-roman';">{{ $detail->code2 }}</span></p>
                </td>
                <td style="width:151.4pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt dashed #000000; padding:1.12pt 1.88pt; vertical-align:middle; background-color:#ffffff;">
                    <p style="margin-bottom:0pt; line-height:normal; font-size:12pt;"><span style="font-family:'times-new-roman';">{{ $detail->name }}</span></p>
                </td>
                <td style="width:30.95pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt dashed #000000; padding:1.12pt 1.88pt; vertical-align:middle; background-color:#ffffff;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><span style="font-family:'times-new-roman';">{{ $detail->dvt }}</span></p>
                </td>
                <td style="width:46.85pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt dashed #000000; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><span style="font-family:'times-new-roman';">{{ number_format($detail->ton,1) }}</span></p>
                </td>
                <td style="width:46.9pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt dashed #000000; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><span style="font-family:'times-new-roman';">{{ number_format($detail->nhap,1) }}</span></p>
                </td>
                <td style="width:46.9pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt dashed #000000; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><span style="font-family:'times-new-roman';">{{ number_format($detail->xuat,1) }}</span></p>
                </td>
                <td style="width:46.9pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt dashed #000000; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><span style="font-family:'times-new-roman';">{{ number_format($detail->ton + $detail->nhap - $detail->xuat,1) }}</span></p>
                </td>
                <td style="width:38pt; border-top:0.75pt solid #cccccc; border-left:0.75pt solid #cccccc; border-bottom:0.75pt dashed #000000; padding:1.12pt 1.88pt; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:12pt;"><span style="font-family:'times-new-roman';">&nbsp;</span></p>
                </td>
            </tr>
            @endforeach
        
        </tbody>
    </table>
    <p>&nbsp;</p>
    <div class="page-footer" style="text-align: center">
    <span > </span>
    </div>
</body>

</html>