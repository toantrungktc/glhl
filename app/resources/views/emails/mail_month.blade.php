@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    This is table one
    @component('mail::table')

    | Key              | Loại                       | Kích Hoạt                  |Hết Hạn                   |
    | --------------- |:--------------------------:| :-------------------------:|:------------------------:|
	@foreach($keys as $key)
     |{{ $key->name }} | {{ $key->loaikeys->name }} | {{ $key->ngay_kich_hoat }} | {{ $key->ngay_het_han }} |
	@endforeach
	
	| Laravel           | Table     | Example  | Example  |
    | ----------------- |:---------:| --------:| --------:|
    
	@foreach($keys as $key)
    | {{ $key->name }}      | {{ $key->loaikeys->name }} | {{ $key->ngay_kich_hoat }}  | {{ $key->ngay_het_han }}  |	
	@endforeach
	
	@endcomponent


    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent