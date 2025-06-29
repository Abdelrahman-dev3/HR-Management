@extends('layout.main')

@section('title', 'Departments')

@section('content')
{{-- start update --}}
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
background: rgba(0, 0, 0, 0.5); z-index: 9999;align-items: center; justify-content: center;">

    <div class="card shadow" style="width: 400px;">
        <div class="card-header bg-success text-white">
            <strong id="formTitle">✎ Update Department</strong>
        </div>
        <div class="card-body">
            <form id="DepartmentForm" method="POST" action="{{route('department.update')}}">
                @method('PUT')
                @csrf
                <input type="hidden" id="DepartmentId" name="id">

                <div class="mb-3">
                    <label for="DepartmentName" class="form-label">Department Name *</label>
                    <input type="text" class="form-control" id="DepartmentName" name="Department_name" placeholder="Enter Department name" required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-check"></i> Update Department
                </button>
                <button type="button" class="btn btn-secondary w-100 mt-2" onclick="closeModal()">Cancel</button>
            </form>
        </div>
    </div>
</div>

{{-- end update --}}
<div class="container my-5">
    <div class="row">
        <!-- Departments List -->
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-building me-2"></i>
                        Departments List
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($departments as $department)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                    <span class="fw-bold">{{ $department->id }} . {{ $department->department }}</span>
                                    <div>
                                        <button class="btn btn-sm btn-warning me-1" onclick="editDepartment({{ $department->id }}, '{{ $department->department }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form class="d-inline" action="{{route('department.destroy', $department->id )}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                        <button  class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        </form>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Department -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Add New Department
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('department.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="department_name" class="form-label fw-bold">Department Name *</label>
                            <input type="text" class="form-control @error('department_name') is-invalid @enderror" 
                                   id="department_name" name="department_name" 
                                   value="{{ old('department_name') }}" 
                                   placeholder="Enter department name" required>
                            @error('department_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-info w-100 text-white">
                            <i class="fas fa-plus me-2"></i>
                            Add Department
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border-bottom: none;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #ddd;
}

.form-control:focus {
    border-color: #0dcaf0;
    box-shadow: 0 0 0 0.2rem rgba(13, 202, 240, 0.25);
}

.btn {
    border-radius: 8px;
    padding: 8px 20px;
}

.border.rounded {
    border-radius: 10px !important;
    transition: all 0.3s ease;
}

.border.rounded:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}
</style>
@endsection 
@section('script')
<script>

    function editDepartment(id, name) {
        document.getElementById('editModal').style.display = 'flex';
        document.getElementById('DepartmentId').value = id;
        document.getElementById('DepartmentName').value = name;
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    window.addEventListener('click', function(e) {
        const modal = document.getElementById('editModal');
        if (e.target === modal) {
            closeModal();
        }
    });
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "timeOut": "7000",
        "extendedTimeOut": "3000"   
    };

    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>

@endsection 