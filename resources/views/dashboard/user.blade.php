@extends ('layouts.navbar')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-12">
            <h2 class="content-title">User</h2>
            <h5 class="content-desc mb-4">Track the flow</h5>
        </div>
        <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-sm btn-primary view-user-btn px-3" type="button" data-bs-toggle="modal" data-bs-target="#adduser">Tambah</button>
            <a href="{{ route('export.users') }}" class="btn btn-outline-success btn-sm ms-3 px-3">Download</a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="document-card">
                <div class="table-responsive">
                    <table class="table caption-top align-middle table-hover">
                        <caption>List of users</caption>
                        <thead>
                            <tr>
                                <th scope="col" style="width: 80px ">Foto</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Signature</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach ($users as $user)
                            <tr class=" align-items-center">
                                <th scope="row" class="d-flex justify-content-start align-items-center new-document">
                                    <img class="img-fluid" src="{{ Storage::url($user->profile_photo_path) }}" alt="">
                                </th>
                                <td>
                                    <h2 class="document-title"> {{$user->username}} </h2>
                                    <span class="document-desc"> {{$user->jabatan}} </span>
                                </td>
                                <td>
                                    <h2 class="document-title">{{$user->email}}</h2>
                                </td>
                                <td>
                                    <h2 class="document-title">{{$user->role}}</h2>
                                </td>
                                <td>
                                    @if ($user->signature_photo_path)
                                    <h2 class="document-title">secret</h2>
                                    @else
                                    <h2 class="document-title">-</h2>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success col-12 view-user-btn px-3" style="border-radius: 14px;" type="button" data-bs-toggle="modal" data-bs-target="#viewuser" data-user-id="{{ $user->id }}">view</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection