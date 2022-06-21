<!DOCTYPE html>
<html>
<head>
 <title>Có Key hết hạn</title>
</head>
<body>
 
 <h1>Có key sắp hết hạn</h1>
 </br>
 <br>{{ $key->name }} sắp hết hạn</br>
 <br>Loại Key: {{ $key->loaikeys->name }}</br>
 <br>Ngày hết hạn: {{ date('d/m/Y', strtotime($key->ngay_het_han )) }}</br>
 <br>
 <button style="background-color:#4761f5; border-color:blue; color:black">
   <a href="{{ url("key/show/$key->id") }}" style="color:inherit" > CHI TIẾT </a>
 </button>
</br>
</body>
</html>