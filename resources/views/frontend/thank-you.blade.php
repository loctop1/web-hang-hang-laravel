@extends('layouts.app')
{{-- Tiêu đề trang web --}}
@section('title', 'Xin chân thành cảm ơn!')
{{-- Bố cục trang web --}}
@section('content')
    <div class="p-4 shadow bg-info">
        <div class="ccontainer">
            <div class="col-md-12 text-center">
                @if (session('message'))
                    <h5 class="alert alert-success">{{ session('message') }}</h5>
                @endif
            </div>
            <h2 class="thank-you">Cảm ơn đã ghé thăm cửa hàng của chúng tôi!</h2>
            <p class="message">Chúng tôi rất trân trọng sự quan tâm của bạn.</p>
            <p class="message">Hãy để chúng tôi biết nếu bạn có bất kỳ câu hỏi hoặc yêu cầu nào.</p>
            <a data-v-5a4f0845="" href="{{ url('/') }}" class="go-back">Quay lại trang chủ</a>
        </div>
    </div>
@endsection
