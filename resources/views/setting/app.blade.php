@extends('layouts.navbar')
@section('content')
    <div class="content">
        <div class="document-card">
            <div class="row">
                <div class="col-12">
                        <h2 class="content-title">App</h2>
                        <h5 class="content-desc mb-4">Configure your App</h5>
                </div>
            </div>
            <div class="row" style="margin-top: -50px;">
                <div class="col">
                    @include('component.tabs.navtabs')
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <h2 class="document-title">
                        Manage your App
                    </h2>
                </div>
            </div>
        </div>
    </div>
@endsection