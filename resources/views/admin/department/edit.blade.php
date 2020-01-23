@extends('layouts.app')

@section('page-title')
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
            <li><a href="{{ route('admin.department.index') }}">{{ $pageTitle }}</a></li>
            <li class="active">@lang('app.addNew')</li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/icheck/skins/all.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}">
@endpush

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">@lang('app.update') @lang('app.team')</div>

            <p class="text-muted font-13"></p>

            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            {!! Form::open(['id'=>'createCurrency','class'=>'ajax-form','method'=>'PUT']) !!}
                            <div class="form-group">
                                <label for="company_name">@lang('app.team')</label>
                                <input type="text" class="form-control" id="team_name" name="team_name"
                                    value="{{ $group->team_name }}">
                            </div>

                            <button type="submit" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
                                @lang('app.save')
                            </button>
                            {!! Form::close() !!}
                            <hr>

                        </div>
                    </div>
                    <div class="row">


                        <div class="col-md-12">
                            <h3 class="box-title m-b-0">@lang('modules.projects.members')</h3>

                            @forelse($group->team_members as $member)
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-xs-2 col-md-2 p-10">
                                        {!! ($member->user->image) ? '<img src="'.asset_url('avatar/'.$member->user->image).'"
                                            alt="user" class="img-circle" width="40">' : '<img
                                            src="'.asset('img/default-profile-2.png').'" alt="user" class="img-circle" width="40">'
                                        !!}
            
                                    </div>
                                    <div class="col-xs-10 col-md-10">
                                        <h5>{{ ucwords($member->user->name) }}</h5>
                                        <h6>{{ $member->user->email }}</h6>
                                    </div>
                                </div>
                            </div>
                            
                            @empty
                            @lang('messages.noRecordFound')
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .row -->

@endsection

@push('footer-script')
<script src="{{ asset('js/cbpFWTabs.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
<script>
    $(".select2").select2();

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.department.update', [$group->id])}}',
                container: '#createCurrency',
                type: "POST",
                redirect: true,
                data: $('#createCurrency').serialize()
            })
        });

        $('body').on('click', '.delete-members', function(){
            var id = $(this).data('member-id');
            swal({
                title: "Are you sure?",
                text: "This will remove the member from the team.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "{{ route('admin.employee-teams.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'DELETE',
                        url: url,
                        data: {'_token': token},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        });

</script>
@endpush