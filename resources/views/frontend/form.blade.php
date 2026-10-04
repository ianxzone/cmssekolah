@extends('frontend.layouts.app')

@section('title', $form->title . ' - ' . config('app.name'))
@section('meta_description', $form->description ?? 'Securely submit your information using our online form.')

@section('content')
    @include('frontend.partials.form-embed')
@endsection
