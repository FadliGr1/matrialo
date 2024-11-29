@extends('layouts.navbar')
@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="content-title">Statistics</h2>
        <h5 class="content-desc mb-4">Your business growth</h5>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
        <div class="statistics-card">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column justify-content-between align-items-start">
                    <h5 class="content-desc">Employees</h5>
                    <h3 class="statistics-value">18,500,000</h3>
                </div>

                <button class="btn-statistics">
                    <img src="./assets/img/global/times.svg" alt="">
                </button>
            </div>

            <div class="statistics-list">
                <img class="statistics-image" src="./assets/img/home/history/photo-4.png" alt="">
                <img class="statistics-image" src="./assets/img/home/history/photo-3.png" alt="">
                <img class="statistics-image" src="./assets/img/home/history/photo.png" alt="">
                <img class="statistics-image" src="./assets/img/home/history/photo-1.png" alt="">
                <img class="statistics-image" src="./assets/img/home/history/photo-2.png" alt="">
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
        <div class="statistics-card">

            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column justify-content-between align-items-start">
                    <h5 class="content-desc">Teams</h5>

                    <h3 class="statistics-value">122,000</h3>
                </div>

                <button class="btn-statistics">
                    <img src="./assets/img/global/times.svg" alt="">
                </button>
            </div>

            <div class="statistics-list">
                <div class="statistics-icon award">
                    <img src="./assets/img/home/team/award.svg" alt="">
                </div>
                <div class="statistics-icon globe">
                    <img src="./assets/img/home/team/globe.svg" alt="">
                </div>
                <div class="statistics-icon target">
                    <img src="./assets/img/home/team/target.svg" alt="">
                </div>
                <div class="statistics-icon box">
                    <img src="./assets/img/home/team/box.svg" alt="">
                </div>
            </div>

        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
        <div class="statistics-card">

            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column justify-content-between align-items-start">
                    <h5 class="content-desc">Projects</h5>

                    <h3 class="statistics-value">150,000,000</h3>
                </div>

                <button class="btn-statistics">
                    <img src="./assets/img/global/times.svg" alt="">
                </button>
            </div>

            <div class="statistics-list">
                <div class="statistics-icon one">
                    <span>SK</span>
                </div>
                <div class="statistics-icon two">
                    <span>DW</span>
                </div>
                <div class="statistics-icon three">
                    <span>FJ</span>
                </div>
                <div class="statistics-icon four">
                    <span>AP</span>
                </div>
                <div class="statistics-icon five">
                    <span>ML</span>
                </div>
                <!-- <img src="./assets/img/home/icon-1.png" alt=""><img src="./assets/img/home/icon-2.png" alt=""><img src="./assets/img/home/icon-3.png" alt=""><img src="./assets/img/home/icon-4.png" alt=""><img src="./assets/img/home/icon-5.png" alt=""> -->
            </div>

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
