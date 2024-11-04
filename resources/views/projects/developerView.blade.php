@extends('layouts/layoutMaster')

@section('title', 'Brand-Master')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jkanban/jkanban.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-kanban.css') }}" />
@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="{{ asset('assets/js/app-kanban.js') }}"></script>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>


@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Hour chart  -->
            <div class="card bg-transparent shadow-none my-4 border-0">
                <div class="card-body row p-0 pb-3">
                    <div class="col-12 col-md-12">
                        <h3>Welcome back to the, {{ $projects->name }} 👋🏻</h3>
                        <p class="text-muted">Here's what's happening with your projects today.</p>
                        <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
                            <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
                                <span class="bg-label-primary p-2 rounded">
                                    <i class="ti ti-device-laptop ti-xl"></i>
                                </span>
                                <div class="content-right">
                                    <p class="mb-0">Total Stakeholders</p>
                                    <h4 class="text-primary mb-0">34</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="bg-label-info p-2 rounded">
                                    <i class="ti ti-bulb ti-xl"></i>
                                </span>
                                <div class="content-right">
                                    <p class="mb-0">Total Work Pending</p>
                                    <h4 class="text-info mb-0">82%</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="bg-label-info p-2 rounded">
                                    <i class="ti ti-bulb ti-xl"></i>
                                </span>
                                <div class="content-right">
                                    <p class="mb-0">Total Tasks</p>
                                    <h4 class="text-info mb-0">82%</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="bg-label-warning p-2 rounded">
                                    <i class="ti ti-discount-check ti-xl"></i>
                                </span>
                                <div class="content-right">
                                    <p class="mb-0">Work Completed</p>
                                    <h4 class="text-warning mb-0">14</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Hour chart End  -->
            <hr />

            <!-- Topic and Instructors -->
            <div class="row mb-4 g-4">
                <div class="col-12 col-xl-12">
                    <div class="nav-align-top mb-4">
                        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home"
                                    aria-selected="true">
                                    <i class="tf-icons ti ti-home ti-xs me-1"></i> Overview
                                    {{-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">3</span> --}}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-justified-profile"
                                    aria-controls="navs-pills-justified-profile" aria-selected="false">
                                    <i class="tf-icons ti ti-brand-trello ti-xs me-1"></i> Project Kanban
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-justified-messages"
                                    aria-controls="navs-pills-justified-messages" aria-selected="false">
                                    <i class="tf-icons ti ti-message-dots ti-xs me-1"></i> Messages
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade 
                            {{-- show active --}}
                            "
                                id="navs-pills-justified-home" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="defaultFormControlInput" class="form-label">Project Name</label>
                                        <input type="text" class="form-control" id="defaultFormControlInput"
                                            value="{{ $projects->name }}" aria-describedby="defaultFormControlHelp"
                                            disabled />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="defaultFormControlInput" class="form-label">Project Domain</label>
                                        <input type="text" class="form-control" id="defaultFormControlInput"
                                            value="{{ $projects->domain }}" aria-describedby="defaultFormControlHelp"
                                            disabled />
                                    </div>
                                </div>
                                <div class="col-md mb-4 mb-md-2">
                                    <div class="accordion mt-3" id="accordionExample">
                                        <div class="card accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                                    data-bs-target="#accordionOne" aria-expanded="false"
                                                    aria-controls="accordionOne">
                                                    Project Description
                                                </button>
                                            </h2>

                                            <div id="accordionOne" class="accordion-collapse collapse show"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    {{ $projects->desc }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button type="button" class="accordion-button collapsed"
                                                    data-bs-toggle="collapse" data-bs-target="#accordionTwo"
                                                    aria-expanded="false" aria-controls="accordionTwo">
                                                    Non Functional Requirements
                                                </button>
                                            </h2>
                                            <div id="accordionTwo" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    {{ $projects->non_functional_req }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button type="button" class="accordion-button collapsed"
                                                    data-bs-toggle="collapse" data-bs-target="#accordionThree"
                                                    aria-expanded="false" aria-controls="accordionThree">
                                                    Project Milestone
                                                </button>
                                            </h2>
                                            <div id="accordionThree" class="accordion-collapse collapse"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    {{ $projects->milestone }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card accordion-item">
                                            <h2 class="accordion-header" id="headingFour">
                                                <button type="button" class="accordion-button collapsed"
                                                    data-bs-toggle="collapse" data-bs-target="#accordionFour"
                                                    aria-expanded="false" aria-controls="accordionFour">
                                                    Additional Instructions
                                                </button>
                                            </h2>
                                            <div id="accordionFour" class="accordion-collapse collapse"
                                                aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    {{ $projects->additional_instruction }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fw-large h3 p-3">Development Methods</div>
                                        <ul class="">
                                            <li>{{ $projects->dev_methods }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fw-large h3 p-3">Survey Methods</div>
                                        <ul class="">
                                            <li>{{ $projects->survey_methods }}</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-12 col-xl-6 col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <div class="card-title mb-0">
                                                <h5 class="m-0 me-2">Involved Stakeholders</h5>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-borderless border-top">
                                                <thead class="border-bottom">
                                                    <tr>
                                                        <th>Stakeholders</th>
                                                        <th class="text-end">Role</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- {{dd($projects)}} --}}
                                                    @foreach ($projects->stakeholders as $stakeholders)
                                                        <tr>
                                                            <td class="pt-2">
                                                                <div
                                                                    class="d-flex justify-content-start align-items-center mt-lg-4">
                                                                    <div class="d-flex flex-column">
                                                                        <h6 class="mb-0">{{ $stakeholders->user->name }}
                                                                        </h6>
                                                                        {{-- <small class="text-truncate text-muted">{{$stakeholders->role}}</small> --}}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-end pt-2">
                                                                <div class="user-progress mt-lg-4">
                                                                    <p class="mb-0 fw-medium text-muted">
                                                                        {{ $stakeholders->role }}</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="navs-pills-justified-profile" role="tabpanel">
                                <div class="row">
                                    <!-- To-Do Column -->
                                    <div
                                        class="{{ Auth::user()->role == 'Project Manager' || Auth::user()->role == 'Super Admin' ? 'col-md-3' : 'col-md-4' }}">
                                        <div class="fw-bold h4 p-3">To-Do List</div>
                                        <div id="to-do-list" class="card-container">
                                            {{-- @foreach ($tasks['to_do'] as $task) --}}
                                            <div class="card p-2 mb-2" data-task-id="{{ $task->id ?? '0' }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $task->title ?? 'Task title' }}</h5>
                                                    <p class="card-text">{{ $task->description ?? 'Task Description' }}
                                                    </p>
                                                    {{-- @if (in_array(Auth::user()->role, ['Admin', 'Super Admin'])) --}}
                                                    <p class="card-text"><small>Assigned to:
                                                            {{ $task->assigned_user ?? 'Assigned' }}</small></p>
                                                    {{-- @endif --}}
                                                </div>
                                            </div>
                                            {{-- @endforeach --}}
                                        </div>
                                    </div>

                                    <!-- In Progress Column -->
                                    <div
                                        class="{{ Auth::user()->role == 'Project Manager' || Auth::user()->role == 'Super Admin' ? 'col-md-3' : 'col-md-4' }}">
                                        <div class="fw-bold h4 p-3">In Progress</div>
                                        <div id="in-progress-list" class="card-container">
                                            {{-- @foreach ($tasks['in_progress'] as $task) --}}
                                            <div class="card p-2 mb-2" data-task-id="{{ $task->id ?? '0' }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $task->title ?? 'task-title2' }}</h5>
                                                    <p class="card-text">{{ $task->description ?? 'task-desc2' }}</p>
                                                    {{-- @if (in_array(Auth::user()->role, ['Admin', 'Super Admin'])) --}}
                                                    <p class="card-text"><small>Assigned to:
                                                            {{ $task->assigned_user ?? 'user2' }}</small></p>
                                                    {{-- @endif --}}
                                                </div>
                                            </div>
                                            {{-- @endforeach --}}
                                        </div>
                                    </div>

                                    <!-- Completed Column -->
                                    <div
                                        class="{{ Auth::user()->role == 'Project Manager' || Auth::user()->role == 'Super Admin' ? 'col-md-3' : 'col-md-4' }}">
                                        <div class="fw-bold h4 p-3">Completed</div>
                                        <div id="completed-list" class="card-container">
                                            {{-- @foreach ($tasks['completed'] as $task) --}}
                                            <div class="card p-2 mb-2" data-task-id="{{ $task->id ?? '3' }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $task->title ?? 'task-title23' }}</h5>
                                                    <p class="card-text">{{ $task->description ?? 'task_desc3' }}</p>
                                                    {{-- @if (in_array(Auth::user()->role, ['Admin', 'Super Admin'])) --}}
                                                    <p class="card-text"><small>Assigned to:
                                                            {{ $task->assigned_user ?? '3' }}</small></p>
                                                    {{-- @endif --}}
                                                </div>
                                            </div>
                                            {{-- @endforeach --}}
                                        </div>
                                    </div>

                                    @if (Auth::user()->role == 'Project Manager' || Auth::user()->role == 'Super Admin')
                                        <div class="col-md-3">
                                            <div class="fw-bold h4 p-3">
                                                Add Task
                                            </div>
                                            <!-- Add Task Form or Button -->
                                            <button class="btn btn-primary mt-3" type="button" data-bs-toggle="modal" data-bs-target="#addNewTask">+ Add New Task</button>
                                        </div>
                                    @endif

                                    <div class="modal fade" id="addNewTask" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-simple modal-add-new-task">
                                          <div class="modal-content p-3 p-md-5">
                                            <div class="modal-body">
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              <div class="text-center mb-4">
                                                <h3 class="mb-2">Edit User Information</h3>
                                                <p class="text-muted">Updating user details will receive a privacy audit.</p>
                                              </div>
                                              <form id="editUserForm" action="{{ route('requirements.store')}}" enctype="multipart/form-data" class="row g-3" onsubmit="return false">
                                                <div class="col-12 col-md-12">
                                                  <label class="form-label" for="modalEditUserFirstName">Project Name</label>
                                                  <input
                                                    type="text"
                                                    id="modalEditUserFirstName"
                                                    name="modalEditUserFirstName"
                                                    class="form-control"
                                                    value="{{$projects->name}}" disabled/>
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <label class="form-label" for="modalEditUserFirstName">Requirement Title</label>
                                                    <input
                                                      type="text"
                                                      id="modalEditUserFirstName"
                                                      name="modalEditUserFirstName"
                                                      class="form-control"
                                                      placeholder="Put your Requirement Title"/>
                                                  </div>
                                                <div class="col-12 col-md-12">
                                                    <label class="form-label" for="bootstrap-maxlength-example2">Textarea</label>
                                                    <textarea
                                                      id="bootstrap-maxlength-example2"
                                                      class="form-control bootstrap-maxlength-example"
                                                      rows="3"
                                                      maxlength="255"></textarea>
                                                  </div>
                                                <div class="col-12 col-md-6">
                                                  <label class="form-label" for="modalEditUserStatus">Priority</label>
                                                  <select
                                                    id="modalEditUserStatus"
                                                    name="modalEditUserStatus"
                                                    class="select2 form-select"
                                                    aria-label="Default select example">
                                                    <option selected disabled>Status</option>
                                                    <option value="1">Low</option>
                                                    <option value="2">Medium</option>
                                                    <option value="3">High</option>
                                                  </select>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label" for="modalEditUserStatus">Related Task (Optional)</label>
                                                    <select
                                                      id="modalEditUserStatus"
                                                      name="modalEditUserStatus"
                                                      class="select2 form-select"
                                                      aria-label="Default select example">
                                                      <option selected disabled>Tasks List</option>
                                                      <option value="1">Hello</option>
                                                      <option value="2">Medium</option>
                                                      <option value="3">High</option>
                                                    </select>
                                                  </div>
                                                <div class="col-12 text-center">
                                                  <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                                  <button
                                                    type="reset"
                                                    class="btn btn-label-secondary"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    Cancel
                                                  </button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                                <p>
                                    Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon
                                    gummies
                                    cupcake gummi bears cake chocolate.
                                </p>
                                <p class="mb-0">
                                    Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake.
                                    Sweet
                                    roll icing sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding
                                    jelly
                                    jelly-o tart brownie jelly.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize SortableJS on each column
            const toDoList = document.getElementById('to-do-list');
            const inProgressList = document.getElementById('in-progress-list');
            const completedList = document.getElementById('completed-list');

            // Common options for all columns
            const sortableOptions = {
                group: 'tasks', // Set group to enable drag-and-drop between columns
                animation: 150,
                onEnd: async function(evt) {
                    const taskId = evt.item.dataset.taskId;
                    const newStatus = evt.to.id; // 'to-do-list', 'in-progress-list', 'completed-list'

                    // Determine the new status based on the destination list
                    let status;
                    if (newStatus === 'to-do-list') status = 'to_do';
                    if (newStatus === 'in-progress-list') status = 'in_progress';
                    if (newStatus === 'completed-list') status = 'completed';

                    // Send AJAX request to update task status in the backend
                    try {
                        const response = await fetch(`/tasks/update-status/${taskId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                status: status
                            }),
                        });

                        const result = await response.json();
                        if (!result.success) {
                            console.error("Error updating task status.");
                        }
                    } catch (error) {
                        console.error("Failed to update task status:", error);
                    }
                }
            };

            // Apply Sortable to each column
            new Sortable(toDoList, sortableOptions);
            new Sortable(inProgressList, sortableOptions);
            new Sortable(completedList, sortableOptions);
        });
    </script>



@endsection
