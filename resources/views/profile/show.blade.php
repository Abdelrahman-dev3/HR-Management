@extends('layout.main')

@section('title' , 'Profile')

@section('content')
<div class="container py-5">
    <div class="card shadow mx-auto" style="max-width: 600px;">
        <div class="card-body text-center">
            <img src="{{ $user->profile_image ?? 'https://i.pravatar.cc/150?img=3' }}" class="rounded-circle border border-primary mb-3" style="width: 150px; height: 150px; object-fit: cover;">
            <h3>{{ $user->name }}</h3>
            <p class="text-muted">{{ $user->email }}</p>
        </div>
    </div>
</div>
@endsection
