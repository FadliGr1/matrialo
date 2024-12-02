@extends('layouts.navbar')
@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="content-title">Statistics</h2>
        <h5 class="content-desc mb-4">Your business growth</h5>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
        <div class="statistics-card">
            <x-user-stats />
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
        <div class="statistics-card">
            <x-vendor-stats />
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
        <div class="statistics-card">
            <x-project-stats />
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 col-lg-6">
            <h2 class="content-title">History</h2>
            <h5 class="content-desc mb-4">Track the flow</h5>
        
            <div class="document-card">
                @foreach ($activities as $activity)
                    <div class="document-item">
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="document-icon globe">
                                <img src="{{asset('img/home/document/twitch.svg')}}" alt="">
                            </div>
                            <div class="d-flex flex-column justify-content-between align-items-start">
                                <h2 class="document-title">{{ $activity->user->username ?? 'Activity'}}</h2>
                                <span class="document-desc text-black" 
                                      data-bs-toggle="tooltip" 
                                      data-bs-placement="top" 
                                      title="{{ $activity->description }}">
                                    {{ implode(' ', array_slice(explode(' ', $activity->description), 0, 6)) }}...
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
