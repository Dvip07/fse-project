@extends('layouts/layoutMaster')

@section('title', 'Brand-Master')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light float-left">Master / Brand /</span> Add
    </h4>
    <!-- Invoice List Widget -->


    <div class="card">
        {{-- <h5 class="card-header">Applicable Categories</h5> --}}
        <div class="card-body">
            <div class="content">


                <div class="content-header mb-4">
                    <h3 class="mb-1">Brand Create</h3>
                </div>
                <form method="post" action="{{ url('/projects')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="projectName">Project Name</label>
                                    <input type="text" id="projectName" name="projectName" class="form-control"
                                        value="{{ old('projectName') }}" placeholder="Project Name" />
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="select2Stakeholders" class="form-label">Select Stakeholders</label>
                                    <select id="select2Stakeholders" name="stakeholders[]" class="select2 form-select" multiple>
                                        <option value="AK">Alaska</option>
                                        <option value="HI">Hawaii</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="projectDescription">Project Description</label>
                                    <input type="text" id="projectDescription" name="projectDescription" class="form-control"
                                        value="{{ old('projectDescription') }}" placeholder="Project Description" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row px-0 mt-3">
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-primary d-grid w-100">Save</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>



@endsection
