@extends('layouts.app')
@section('title', 'Admin FAQ')
@section('content')
<h1 class="mb-6 text-2xl font-semibold">FAQ theo nhóm khách hàng</h1>
<x-admin.marketplace.table :items="$faqs" :columns="['audience_type' => 'Nhóm', 'question' => 'Câu hỏi', 'answer' => 'Trả lời', 'is_active' => 'Active']" />
@endsection
