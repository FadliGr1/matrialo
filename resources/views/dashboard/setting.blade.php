@extends('layouts.navbar')
@section('content')
    <div class="content">
        <div class="document-card">
            <div class="row">
                <div class="col-12">
                        <h2 class="content-title">Setting</h2>
                        <h5 class="content-desc mb-4">Manage your app</h5>
                </div>
            </div>
            <div class="row" style="margin-top: -50px;">
                <div class="col">
                    @include('component.tabs.navtabs')
                </div>
            </div>
        </div>
    </div>
@endsection