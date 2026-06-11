@extends('layouts.app')

@section('title', 'Tạo tài khoản - Web Template Studio')
@section('meta_description', 'Tạo tài khoản Web Template Studio để theo dõi yêu cầu riêng khi cần.')

@section('content')
    <div class="mx-auto max-w-3xl rounded-lg border border-zinc-200 bg-white p-6 shadow-sm md:p-8">
        <p class="inline-flex rounded-full bg-rose-50 px-3 py-1 text-sm font-semibold text-rose-700 ring-1 ring-inset ring-rose-100">Tài khoản Web Template Studio</p>
        <h1 class="mt-5 text-3xl font-semibold leading-tight text-zinc-950">Tạo tài khoản để theo dõi yêu cầu khi cần.</h1>
        <p class="mt-3 text-sm leading-6 text-zinc-600">Bạn không bắt buộc phải đăng ký để gửi yêu cầu. Tài khoản này phù hợp khi cần theo dõi trao đổi riêng hoặc được cấp quyền truy cập.</p>

        <form class="mt-6 space-y-5" method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-zinc-900" for="name">Họ và tên</label>
                <input id="name" class="mt-2 block w-full rounded-md border border-zinc-300 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:border-rose-600 focus:ring-2 focus:ring-rose-600/10" name="name" value="{{ old('name') }}" autocomplete="name" required autofocus>
                @error('name')
                    <p class="mt-2 text-sm font-medium text-rose-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-zinc-900" for="email">Email</label>
                <input id="email" class="mt-2 block w-full rounded-md border border-zinc-300 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:border-rose-600 focus:ring-2 focus:ring-rose-600/10" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
                @error('email')
                    <p class="mt-2 text-sm font-medium text-rose-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-zinc-900" for="password">Mật khẩu</label>
                <input id="password" class="mt-2 block w-full rounded-md border border-zinc-300 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:border-rose-600 focus:ring-2 focus:ring-rose-600/10" name="password" type="password" autocomplete="new-password" required>
                @error('password')
                    <p class="mt-2 text-sm font-medium text-rose-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-zinc-900" for="password_confirmation">Nhập lại mật khẩu</label>
                <input id="password_confirmation" class="mt-2 block w-full rounded-md border border-zinc-300 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:border-rose-600 focus:ring-2 focus:ring-rose-600/10" name="password_confirmation" type="password" autocomplete="new-password" required>
            </div>

            <button class="inline-flex w-full items-center justify-center rounded-md bg-rose-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-rose-700" type="submit">
                Tạo tài khoản
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-zinc-600">
            Đã có tài khoản?
            <a class="font-semibold text-rose-700 underline-offset-4 hover:underline" href="{{ route('login') }}">Đăng nhập</a>
        </p>
    </div>
@endsection
