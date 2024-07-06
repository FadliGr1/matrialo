@extends('layouts.navbar')
@section('content')
    <div class="content">
        <div class="document-card">
            <div class="row">
                <div class="col-12">
                        <h2 class="content-title">Integration</h2>
                        <h5 class="content-desc mb-4">Boost your App</h5>
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
                        <div class="">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="document-title">Aws s3 Compatible</h2>
                                    <p class="document-desc">Connect your app to Aws s3 Compatible</p>
                                </div>
                                <div class="div">
                                    <button class="btn btn-sm btn-outline-warning px-3 ms-2" data-bs-toggle="modal" data-bs-target="#aws">Connect</button>
                                    <form action="{{ route('aws.testConnection') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary ms-3 px-3 d-none d-md-inline" id="connectButton">
                                            Test Connection
                                        </button>
                                    </form>
                                </div>
                                
                                @include('component.modal.aws')
                            </div>
                        </div>
                    </h2>
                </div>
            </div>
        </div>
    </div>
@endsection