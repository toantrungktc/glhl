<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>
    </title>
    <style>
        body {
            line-height: 108%;
            font-family: Calibri;
            font-size: 11pt
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            margin: 0pt 0pt 8pt
        }

        table {
            margin-top: 0pt;
            margin-bottom: 8pt
        }

        h1 {
            margin-top: 24pt;
            margin-bottom: 6pt;
            page-break-inside: avoid;
            page-break-after: avoid;
            line-height: 108%;
            font-size: 24pt;
            font-weight: bold
        }

        h2 {
            margin-top: 18pt;
            margin-bottom: 4pt;
            page-break-inside: avoid;
            page-break-after: avoid;
            line-height: 108%;
            font-size: 18pt;
            font-weight: bold
        }

        h3 {
            margin-top: 14pt;
            margin-bottom: 4pt;
            page-break-inside: avoid;
            page-break-after: avoid;
            line-height: 108%;
            font-size: 14pt;
            font-weight: bold
        }

        h4 {
            margin-top: 12pt;
            margin-bottom: 2pt;
            page-break-inside: avoid;
            page-break-after: avoid;
            line-height: 108%;
            font-size: 12pt;
            font-weight: bold
        }

        h5 {
            margin-top: 11pt;
            margin-bottom: 2pt;
            page-break-inside: avoid;
            page-break-after: avoid;
            line-height: 108%;
            font-size: 11pt;
            font-weight: bold
        }

        h6 {
            margin-top: 10pt;
            margin-bottom: 2pt;
            page-break-inside: avoid;
            page-break-after: avoid;
            line-height: 108%;
            font-size: 10pt;
            font-weight: bold
        }

        .Subtitle {
            margin-top: 18pt;
            margin-bottom: 4pt;
            page-break-inside: avoid;
            page-break-after: avoid;
            line-height: 108%;
            font-family: Georgia;
            font-size: 24pt;
            font-style: italic;
            color: #666666
        }

        .Title {
            margin-top: 24pt;
            margin-bottom: 6pt;
            page-break-inside: avoid;
            page-break-after: avoid;
            line-height: 108%;
            font-size: 36pt;
            font-weight: bold
        }
        @media print
        {
            @page
            {
                size: 8.5cm 5cm;
                margin: 0cm;
            }
        }
        .page-break-tr {
            page-break-after: always;
        }  

    </style>
</head>

<body onload="window.print()">
    
    <?php $b='GL'; ?>
    <?php $i=1; ?>
    @foreach ($data as $value)

    <p style="margin-bottom:0pt; line-height:normal; widows:0; orphans:0; font-size:5pt;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
    <table style="width:213pt; margin-right:auto; margin-left:auto; margin-bottom:0pt; border-collapse:collapse;">
        <tbody>
            <tr style="height:38.7pt;">
                <td style="width:49.65pt; border:0.75pt solid #000000; vertical-align:middle;">
                    <p style="margin-left:7.05pt; margin-bottom:0pt; line-height:normal; font-size:13pt;"><strong><span style="font-family:'Times New Roman';">M&aacute;c thuốc&nbsp;</span></strong></p>
                </td>
                <td colspan="2" style="width:161.1pt; border-top:0.75pt solid #000000; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; widows:0; orphans:0; font-size:15pt;"><strong><span style="font-family:'Times New Roman';">{{$b}}.{{ $log->congthuc->blend->name }}</span></strong></p>
                </td>
            </tr>
            <tr style="height:19.35pt;">
                <td style="width:49.65pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #000000; border-bottom:0.75pt solid #000000; vertical-align:middle;">
                    <p style="margin-left:7.05pt; margin-bottom:0pt; line-height:normal; font-size:10pt;"><strong><span style="font-family:'Times New Roman';">Ngày pha</span></strong></p>
                </td>
                <td style="width:75.95pt; border-top:0.75pt solid #000000; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; widows:0; orphans:0; font-size:10pt;"><strong><span style="font-family:'Times New Roman';">{{ date('d/m/Y', strtotime($log->ngay_pha)) }}</span></strong></p>
                </td>
                <td rowspan="4" style="width:84.15pt; border:1pt solid #000000; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; widows:0; orphans:0;"><span style="font-family:'Times New Roman';">{!! QrCode::size(90)->generate(route('show_xuat',$log->id)); !!}</span></p>
                </td>
            </tr>
            <tr style="height:19.35pt;">
                <td style="width:49.65pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #000000; border-bottom:0.75pt solid #000000; vertical-align:middle;">
                    <p style="margin-left:7.05pt; margin-bottom:0pt; line-height:normal; font-size:10pt;"><strong><span style="font-family:'Times New Roman';">KL</span></strong></p>
                </td>
                <td style="width:75.95pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:10pt;"><strong><span style="font-family:'Times New Roman';">{{ $value }}</span></strong></p>
                </td>
            </tr>
            <tr style="height:19.35pt;">
                <td style="width:49.65pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #000000; border-bottom:0.75pt solid #000000; vertical-align:middle;">
                    <p style="margin-left:7.05pt; margin-bottom:0pt; line-height:normal; font-size:10pt;"><strong><span style="font-family:'Times New Roman';">NV pha</span></strong></p>
                </td>
                <td style="width:75.95pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:10pt;"><strong><span style="font-family:'Times New Roman';">&nbsp;</span></strong></p>
                </td>
            </tr>
            <tr style="height:19.35pt;">
                <td style="width:49.65pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #000000; border-bottom:0.75pt solid #000000; vertical-align:middle;">
                    <p style="margin-left:7.05pt; margin-bottom:0pt; line-height:normal; font-size:10pt;"><strong><span style="font-family:'Times New Roman';">Th&ugrave;ng số</span></strong></p>
                </td>
                <td style="width:75.95pt; border-top:0.75pt solid #cccccc; border-right:0.75pt solid #000000; border-left:0.75pt solid #cccccc; border-bottom:0.75pt solid #000000; vertical-align:middle;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:10pt;"><strong><span style="font-family:'Times New Roman';">{{ $i }}</span></strong></p>
                </td>
            </tr>
        </tbody>
    </table>
    <p class="page-break-tr" style="margin-bottom:0pt; line-height:normal; font-size:2pt;"><span style="font-family:Arial;">&nbsp;</span></p>
    <?php $i++; ?>
    @endforeach
</body>

</html>