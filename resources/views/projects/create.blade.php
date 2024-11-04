@extends('layouts/layoutMaster')

@section('title', 'Brand-Master')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css" />
    {{-- <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script> --}}
@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="{{ asset('assets/js/forms-editors.js') }}"></script>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endsection

@section('content')
    <div class="card">
        {{-- <h5 class="card-header">Applicable Categories</h5> --}}
        <div class="card-body">
            <div class="content">


                <div class="content-header mb-4">
                    <h3 class="mb-1">Create Project</h3>
                </div>
                <form method="post" action="{{ url('/projects') }}" enctype="multipart/form-data" id="project-form">
                    @csrf
                    <div class="row">
                        <!-- Project Basic Details -->
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="projectName">Project Name</label>
                                    <input type="text" id="projectName" name="name" class="form-control"
                                        value="{{ old('name') }}" placeholder="Project Name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="domainName">Domain</label>
                                    <select id="domainName" name="domain[]" class="form-select">
                                        <option value="Healthcare">Healthcare</option>
                                        <option value="Educational">Educational</option>
                                        <option value="Social Networking">Social Networking</option>
                                        <!-- Add other relevant domains -->
                                    </select>
                                </div>
                            </div>

                            <!-- Project Description -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="projectDescription">Project Description</label>
                                <textarea id="projectDescription" name="desc" class="form-control" rows="3"
                                    placeholder="Describe the project..."></textarea>
                            </div>

                            <!-- Tech Stack -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="techStack">Tech Stack</label>
                                <input type="text" id="techStack" name="tech_stack" class="form-control"
                                    placeholder="e.g., Laravel, React, MySQL" />
                            </div>

                            <div class="row">
                                <!-- Development Methods -->
                                <div class="col-md-6">
                                    <label class="form-label" for="developmentMethods">Development Methods</label>
                                    <select id="developmentMethods" name="dev_methods[]" class="form-select">
                                        <option value="Agile">Agile</option>
                                        <option value="Scrum">Scrum</option>
                                        <option value="Waterfall">Waterfall</option>
                                        <option value="DevOps">DevOps</option>
                                        <!-- Add other relevant methodologies -->
                                    </select>
                                </div>

                                <!-- Requirements Gathering -->
                                <div class="col-md-6 mb-4">
                                    <label for="select2Multiple" class="form-label">Select Surveys Methods</label>
                                    <select id="select2Multiple" name="surveyMethod[]" class="select2 form-select" multiple>
                                        <option value="Interviews">Interviews</option>
                                        <option value="Workshops">Workshops</option>
                                        <option value="Surveys">Surveys</option>
                                        <option value="Observation">Observation</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Non-Functional Requirements -->
                            <div class="col-md-12">
                                <label class="form-label" for="nonFunctional">Non-Functional Requirements</label>
                                <textarea id="nonFunctional" name="nonFunctional" class="form-control" rows="2"
                                    placeholder="Performance, scalability, security, etc."></textarea>
                            </div>

                            <!-- Stakeholders -->
                            <h5 class="card-header mt-4">Stakeholders</h5>
                            <div id="stakeholderRepeater">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="form-label" for="stakeholder_name_0">Stakeholder</label>
                                        <select id="stakeholder_name_0" name="stakeholderName[]" class="form-select"
                                            onchange="setRole(this)">
                                            <option value="" disabled selected>Select Stakeholder</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" data-role="{{ $user->role }}">
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label" for="stakeholder_role_0">Role</label>
                                        <input type="text" id="stakeholder_role_0" name="stakeholderRole[]"
                                            class="form-control" disabled />
                                    </div>

                                    <div class="col-md-1 mt-4 text-center">
                                        <button type="button" class="btn btn-primary" onclick="addStakeholderRow()">
                                            <i class="ti ti-plus me-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Milestones -->
                            <div class="col-md-12 mt-3">
                                <label class="form-label" for="milestones">Project Milestones</label>
                                <textarea id="milestones" name="milestone" class="form-control" rows="2"
                                    placeholder="Define key milestones..."></textarea>
                            </div>

                            <!-- Additional Instructions -->
                            <div class="col-md-12 mt-3">
                                <label class="form-label" for="instructions">Additional Instructions</label>
                                <textarea id="instructions" name="additional_instruction" class="form-control" rows="2"
                                    placeholder="Provide any other relevant details..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
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

    <script>
        var counter = 0;
    
        function addStakeholderRow() {
            counter++;
            // Create a new div element with the specified HTML code
            var newDiv = document.createElement("div");
            newDiv.className = "col-md-12 mt-3";
            newDiv.id = "item_" + counter;
            newDiv.innerHTML = `
                <div class="row">
                    <div class="col-md-5">
                        <label class="form-label" for="stakeholder_name_${counter}">Stakeholder</label>
                        <select id="stakeholder_name_${counter}" name="stakeholderName[]" class="form-select" onchange="setRole(this)">
                            <option value="" disabled selected>Select Stakeholder</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" data-role="{{ $user->role }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label" for="stakeholder_role_${counter}">Role</label>
                        <input type="text" id="stakeholder_role_${counter}" name="stakeholderRole[]" class="form-control" disabled />
                    </div>
                    <div class="col-md-1 mt-4 text-center">
                        <button type="button" class="btn btn-danger" onclick="removeStakeholderRow(${counter})">
                            <i class="ti ti-trash me-1"></i>
                        </button>
                    </div>
                </div>
            `;
    
            // Append the new div to the container
            document.getElementById("stakeholderRepeater").appendChild(newDiv);
        }
    
        // Function to remove the row
        function removeStakeholderRow(counter) {
            var elementToRemove = document.getElementById("item_" + counter);
            if (elementToRemove) {
                elementToRemove.remove();
            }
        }
    
        // Function to set role based on selected stakeholder
        function setRole(selectElement) {
            const role = selectElement.options[selectElement.selectedIndex].getAttribute('data-role');
            const roleInput = selectElement.closest('.row').querySelector('input[name="stakeholderRole[]"]');
            roleInput.value = role || ""; // Set the role in the disabled text field
        }
    </script>

    <script>
        function setRole(selectElement) {
            const role = selectElement.options[selectElement.selectedIndex].getAttribute('data-role');
            const roleInput = selectElement.closest('.row').querySelector('input[name="stakeholderRole[]"]');
            roleInput.value = role || ""; // Set the role in the disabled text field
        }
    </script>

@endsection
