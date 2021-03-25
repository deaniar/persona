@extends('layouts.main-master')
@section('content')

    <div class="content">
        @include('layouts.flash-alert')
        @isset($_GET['add'])
            <div class="row">
                <div class="col-md-6">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-sm-7 col-6">
                                <h4 class="card-title">Tambah Kategori</h4>
                            </div>
                            <div class="col-sm-5 col-6 text-right m-b-30">
                                <a href="{{ route('kategori') }}">
                                    Cencel
                                </a>
                            </div>
                        </div>
                        <form action="{{ route('kategori.create') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('kategori') ? 'is-invalid' : '' }}" type="text"
                                    name="kategori">
                                @if ($errors->has('kategori'))
                                    <span class="text-danger">{{ $errors->first('kategori') }}</span>
                                @endif
                            </div>
                            <div class="text-center m-t-20">
                                <button class="btn btn-primary submit-btn" type="submit">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endisset

        <div class="row">
            <div class="col-md-6">
                <div class="card-box">
                    <div class="row">
                        <div class="col-sm-4 col-3">
                            <h4 class="card-title">kategori</h4>
                        </div>
                        <div class="col-sm-8 col-9 text-right m-b-20">
                            @if (empty(isset($_GET['add'])))
                                <a href="{{ route('kategori') }}?add"
                                    class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add
                                    kategori</a>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table">
                                    <thead>
                                        <tr>
                                            <th>Kategori</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kategoris as $kategori)
                                            <tr>
                                                <td class="text-capitalize">{{ $kategori['kategori'] }}</td>
                                                <td class="text-right">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-ellipsis-v"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="{{ route('kategori.edit', ['id' => $kategori['id']]) }}"><i
                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                                data-target="#delete_kategori{{ $kategori['id'] }}"><i
                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div id="delete_kategori{{ $kategori['id'] }}" class="modal fade delete-modal"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('assets/img/sent.png') }}" alt=""
                                                                width="50" height="46">
                                                            <h3>Anda yakin ingin menghapus kategori
                                                                {{ $kategori['hari'] }}?</h3>
                                                            <div class="m-t-20"> <a href="#" class="btn btn-white"
                                                                    data-dismiss="modal">Close</a>
                                                                <form action="{{ route('kategori.delete') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $kategori['id'] }}">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
