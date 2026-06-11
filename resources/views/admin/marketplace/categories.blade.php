@extends('layouts.app')
@section('title', 'Admin danh mục template')
@section('content')
<x-admin.marketplace.simple-create title="Danh mục template" action="{{ route('admin.marketplace.categories.store') }}" :fields="['name' => 'Tên danh mục', 'description' => 'Mô tả']" />
<x-admin.marketplace.table :items="$categories" :columns="['name' => 'Tên', 'slug' => 'Slug', 'is_active' => 'Active']" />
@endsection
