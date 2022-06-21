<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Send mail</title>
    <style>
         table, td, th {
            border: 1px solid black;  
         }
    </style>
</head>
<body>
    <div class="container m-1">
        <h1 class="lead mt-3">Danh sách Key sắp hết hạn tháng {{ date('m')+1 }}</h1>
        <div class="row">
            <div class="md-12">
                <div class="card">
                    <div class="class-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    
                                    <th width="240px">Key</th>
                                    <th width="40px">Loại</th>
                                    <th width="120px">Ngày kích hoạt</th>
                                    <th width="120px">Ngày hết hạn</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($keys as $key)
                                <tr>
                                    
                                    <td>{{ $key->name }}</td>
                                    <td style="text-align:center" >{{ $key->loaikeys->name }}</td>
                                    <td style="text-align:center">{{ date('d/m/Y', strtotime($key->ngay_kich_hoat )) }}</td>
                                    <td style="text-align:center">{{ date('d/m/Y', strtotime($key->ngay_het_han )) }}</td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
