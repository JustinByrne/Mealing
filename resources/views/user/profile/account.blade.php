@extends('layouts.app')

@section('title', $user->getFullName() . ' - Profile Settings')

@include('user.profile.sidebar')

@section('content')
    <h1 class="font-sans break-normal text-gray-900 pt-6 pb-4 text-xl">Account Settings</h1>
@endsection