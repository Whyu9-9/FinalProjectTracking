@extends('layouts.project_manager')

@section('title','Project List')

@section('style')
    <link rel="stylesheet" href="{{ asset('templates/stisla/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/stisla/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/stisla/node_modules/select2/dist/css/select2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('templates/stisla/node_modules/bootstrap-daterangepicker/daterangepicker.css') }}"/>
@endsection

@section('content')
    <div class="section-header">
        <h1>Projects</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Project List</h4>
                    <div class="card-header-action">
                        <a href="{{ route('project_manager.projects.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
                    </div>
                </div>
                <div class="card-body">
                    <form role="form" method="GET">
                        <div class="form-row">
                            <div class="form-group col-md-3 col-lg-3">
                                <label>Start - End Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input
                                      type="text"
                                      name="start_end_date"
                                      class="form-control daterange-cus"
                                      value="{{ $request->start_end_date }}"
                                    />
                                </div>
                            </div>
                            <div class="form-group col-md-3 col-lg-3">
                                <label>User Assignee</label>
                                <select class="form-control select2" name="user[]" multiple="">
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            @if(!empty($request->user))
                                                @foreach($request->user as $requested)
                                                    @if($employee->id == $requested)
                                                        selected
                                                    @endif
                                                @endforeach
                                            @endif
                                        >
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3 col-lg-3">
                                <label>Project Manager</label>
                                <select class="form-control select2" name="project_manager">
                                    <option value="no_filter">All</option>
                                    @foreach($projectManagers as $projectManager)
                                        <option value="{{ $projectManager->id }}" @if($projectManager->id == $request->project_manager) selected @endif>
                                            {{ $projectManager->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2 col-lg-2">
                                <label>Role Assignee</label>
                                <select class="form-control select2" name="role[]" multiple="">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" 
                                            @if(!empty($request->role))
                                                @foreach($request->role as $requested)
                                                    @if($role->id == $requested)
                                                        selected
                                                    @endif
                                                @endforeach
                                            @endif
                                        >
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-1 col-lg-1">
                                <button type="submit" class="btn btn-lg btn-primary position-absolute" style="bottom: 0"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Estimated <br> Start Date</th>
                                    <th>Estimated <br> End Date</th>
                                    <th>Total <br> Estimated Days</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                    @if(!empty($request->user) 
                                        && !empty($request->role) 
                                        && !array_diff($request->user, $project->userAssignments()->pluck('user_id')->toArray())
                                        && !array_diff($request->role, $project->roles())
                                    )
                                        <tr>
                                            <td>
                                                {{ $project->name }}
                                            </td>
                                            <td>
                                                {{ $project->start_date->format('d-m-Y') }}
                                            </td>
                                            <td>
                                                {{ $project->end_date->format('d-m-Y') }}
                                            </td>
                                            <td>
                                                {{ $project->total_estimated_days }} days
                                            </td>
                                            <td>
                                                @if($project->projectVersions->count() > 1)
                                                    <div class="badge badge-info">Maintenance</div>
                                                @elseif(!empty($project->launch_date))
                                                    <div class="badge badge-success">Launch</div>
                                                @elseif($project->projectVersions->last()->projectDetails()->whereDoneOrOnProgress()->count() > 0)
                                                    <div class="badge badge-warning">Development</div>
                                                @else
                                                    <div class="badge badge-danger">Listed</div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('project_manager.projects.detail', $project) }}" class="btn btn-light mr-1" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a>

                                                @if($project->user_id == Auth::user()->id)
                                                    <a href="{{ route('project_manager.projects.edit', $project->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="#" onclick="deleteConfirm('del{{ $project->id }}')" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    <form id="del{{ $project->id }}" action="{{ route('project_manager.projects.destroy', $project) }}" method="POST">
                                                        @method('delete')
                                                        @csrf
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                        @if(empty($request->role) && empty($request->user))
                                            <tr>
                                                <td>
                                                    {{ $project->name }}
                                                </td>
                                                <td>
                                                    {{ $project->start_date->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    {{ $project->end_date->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    {{ $project->total_estimated_days }} days
                                                </td>
                                                <td>
                                                    @if($project->projectVersions->count() > 1)
                                                        <div class="badge badge-info">Maintenance</div>
                                                    @elseif(!empty($project->launch_date))
                                                        <div class="badge badge-success">Launch</div>
                                                    @elseif($project->projectVersions->last()->projectDetails()->whereDoneOrOnProgress()->count() > 0)
                                                        <div class="badge badge-warning">Development</div>
                                                    @else
                                                        <div class="badge badge-danger">Listed</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('project_manager.projects.detail', $project) }}" class="btn btn-light mr-1" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a>

                                                    @if($project->user_id == Auth::user()->id)
                                                        <a href="{{ route('project_manager.projects.edit', $project->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="#" onclick="deleteConfirm('del{{ $project->id }}')" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                        <form id="del{{ $project->id }}" action="{{ route('project_manager.projects.destroy', $project) }}" method="POST">
                                                            @method('delete')
                                                            @csrf
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @elseif(empty($request->user) && !array_diff($request->role, $project->roles()))
                                            <tr>
                                                <td>
                                                    {{ $project->name }}
                                                </td>
                                                <td>
                                                    {{ $project->start_date->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    {{ $project->end_date->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    {{ $project->total_estimated_days }} days
                                                </td>
                                                <td>
                                                    @if($project->projectVersions->count() > 1)
                                                        <div class="badge badge-info">Maintenance</div>
                                                    @elseif(!empty($project->launch_date))
                                                        <div class="badge badge-success">Launch</div>
                                                    @elseif($project->projectVersions->last()->projectDetails()->whereDoneOrOnProgress()->count() > 0)
                                                        <div class="badge badge-warning">Development</div>
                                                    @else
                                                        <div class="badge badge-danger">Listed</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('project_manager.projects.detail', $project) }}" class="btn btn-light mr-1" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a>

                                                    @if($project->user_id == Auth::user()->id)
                                                        <a href="{{ route('project_manager.projects.edit', $project->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="#" onclick="deleteConfirm('del{{ $project->id }}')" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                        <form id="del{{ $project->id }}" action="{{ route('project_manager.projects.destroy', $project) }}" method="POST">
                                                            @method('delete')
                                                            @csrf
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @elseif(empty($request->role) && !array_diff($request->user, $project->userAssignments()->pluck('user_id')->toArray()))
                                            <tr>
                                                <td>
                                                    {{ $project->name }}
                                                </td>
                                                <td>
                                                    {{ $project->start_date->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    {{ $project->end_date->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    {{ $project->total_estimated_days }} days
                                                </td>
                                                <td>
                                                    @if($project->projectVersions->count() > 1)
                                                        <div class="badge badge-info">Maintenance</div>
                                                    @elseif(!empty($project->launch_date))
                                                        <div class="badge badge-success">Launch</div>
                                                    @elseif($project->projectVersions->last()->projectDetails()->whereDoneOrOnProgress()->count() > 0)
                                                        <div class="badge badge-warning">Development</div>
                                                    @else
                                                        <div class="badge badge-danger">Listed</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('project_manager.projects.detail', $project) }}" class="btn btn-light mr-1" data-toggle="tooltip" title="View"><i class="fas fa-eye"></i></a>

                                                    @if($project->user_id == Auth::user()->id)
                                                        <a href="{{ route('project_manager.projects.edit', $project->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="#" onclick="deleteConfirm('del{{ $project->id }}')" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                        <form id="del{{ $project->id }}" action="{{ route('project_manager.projects.destroy', $project) }}" method="POST">
                                                            @method('delete')
                                                            @csrf
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('templates/stisla/node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('templates/stisla/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('templates/stisla/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('templates/stisla/node_modules/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('templates/stisla/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('templates/stisla/node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script>
        $('.daterange-cus').daterangepicker({
            locale: {format: 'DD-MM-YYYY'},
            drops: 'down',
            opens: 'right',
            autoUpdateInput: false
        });

        $('.daterange-cus').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('.daterange-cus').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    </script>
    @if (Session::has('success'))
        <script>
            swal("Success!", "{{ Session::get('success') }}", "success").then(function(){
                window.location.reload(window.location.href)
            });
        </script>
    @endif
    @if($errors->any())
        <script>
            var msg = "{{ implode(' \n', $errors->all(':message')) }}";
            swal("Error!", msg , "error");
        </script>
    @endif
    <script>
        window.deleteConfirm = function(formId) {
            swal({
                title: 'Delete Confirmation',
                icon: 'warning',
                text: 'Do you want to delete this?',
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $('#'+formId).submit();
                }
            });
        }
    </script>
    <script>
        $("#table-1").dataTable({
            
        });
    </script>
    <script>
        $(".btn-add").click(function(){
            let action = $(this).data('action');
            $('#title').text('Add Role')
            $('#form').attr('action', action);
            $("#form").attr("method", "post");
        });

        $(".btn-edit").click(function(){
            let action = $(this).data('action');
            let detail = $(this).data('detail');
            $('#title').text('Edit Role')
            $('#form').attr('action', action);
            $("#form").attr("method", "post");
            $("#method").attr("value", "put");
            $.get(detail, function (data) {
                $('#roleName').val(data.name);
                $('#privilege').val(data.privilege);
            });
        });
    </script>
@endsection