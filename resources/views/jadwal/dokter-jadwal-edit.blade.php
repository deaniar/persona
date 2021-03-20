    @extends('layouts.main-master')
    @section('content')
        <div class="content">
            <a href="{{ route('jadwal', ['id' => $id_dokter]) }}"><i class="fa fa-angle-left"></i> Back</a>
            <hr>
            @include('layouts.flash-alert')

            <div class="row">
                <div class="col-md-6">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-sm-7 col-6">
                                <h4 class="card-title">Edit Jadwal</h4>
                            </div>
                        </div>
                        <form action="{{ route('jadwal.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $jadwal['id'] }}">
                            <div class="form-group">
                                <label>Jam <span class="text-danger">*</span></label>
                                <div class="d-flex flex-md-row flex-sm-column flex-column">
                                    <div class="w-100">
                                        <div class="time-icon">
                                            <input
                                                class="form-control timepicker {{ $errors->has('jam_buka') ? 'is-invalid' : '' }}"
                                                type="text" name="jam_buka" value="{{ $jadwal['jam_buka'] }}">
                                        </div>
                                        @if ($errors->has('jam_buka'))
                                            <span class="text-danger">{{ $errors->first('jam_buka') }}</span>
                                        @endif
                                    </div>
                                    <div class="p-2">s/d</div>
                                    <div class="w-100">
                                        <div class="time-icon">
                                            <input
                                                class="form-control timepicker {{ $errors->has('jam_tutup') ? 'is-invalid' : '' }}"
                                                type="text" name="jam_tutup" value="{{ $jadwal['jam_tutup'] }}">
                                        </div>
                                        @if ($errors->has('jam_tutup'))
                                            <span class="text-danger">{{ $errors->first('jam_tutup') }}</span>
                                        @endif
                                    </div>
                                </div>
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
