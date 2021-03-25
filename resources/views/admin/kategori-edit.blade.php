@extends('layouts.main-master')
@section('content')
    <div class="content">
        @include('layouts.flash-alert')
        <div class="row">
            <div class="col-md-6">
                <div class="card-box">
                    <div class="row">
                        <div class="col-sm-7 col-6">
                            <h4 class="card-title">Edit kategori</h4>
                        </div>
                        <div class="col-sm-5 col-6 text-right m-b-30">
                            <a href="{{ route('kategori') }}">
                                Cencel
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('kategori.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $kategori['id'] }}">
                        <div class="form-group">
                            <label>Kategori <span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('kategori') ? 'is-invalid' : '' }}" type="text"
                                name="kategori" value="{{ $kategori['kategori'] }}">
                            @if ($errors->has('kategori'))
                                <span class="text-danger">{{ $errors->first('kategori') }}</span>
                            @endif
                        </div>
                        <div class="text-center m-t-20">
                            <button class="btn btn-primary submit-btn" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
