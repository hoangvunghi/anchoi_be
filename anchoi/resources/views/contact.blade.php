@extends('layouts.app')

@section('title', 'Liên hệ | Ăn chơi nét')
@section('description', 'Liên hệ với Ăn chơi nét để được hỗ trợ, góp ý hoặc hợp tác.')

@section('content')
    <div class="mx-auto max-w-3xl text-center">
        <h1 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">Liên hệ</h1>
        <p class="mx-auto mt-3 max-w-xl text-gray-500 dark:text-gray-400">
            Có vấn đề kỹ thuật, muốn góp ý hoặc hợp tác? Hãy liên hệ với chúng tôi.
        </p>
    </div>

    <div class="mx-auto mt-10 grid max-w-4xl grid-cols-1 gap-6 sm:grid-cols-3">
        @foreach ([['Số điện thoại', '0971578680'], ['Họ tên', 'Hoàng Vũ Nghị'], ['Email', 'hoangvunghi2004@gmail.com']] as [$label, $value])
            <div class="rounded-xl bg-white p-6 text-center shadow-sm ring-1 ring-black/5 dark:bg-gray-800 dark:ring-white/10">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $label }}</p>
                <p class="mt-1 font-semibold break-words">{{ $value }}</p>
            </div>
        @endforeach
    </div>
@endsection
