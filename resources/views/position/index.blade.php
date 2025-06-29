@extends('layout.main')

@section('title', 'Positions')

@section('content')
{{-- start update --}}
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
background: rgba(0, 0, 0, 0.5); z-index: 9999;align-items: center; justify-content: center;">

    <div class="card shadow" style="width: 400px;">
        <div class="card-header bg-success text-white">
            <strong id="formTitle">✎ Update Position</strong>
        </div>
        <div class="card-body">
            <form id="positionForm" method="POST" action="{{route('position.update')}}">
                @method('PUT')
                @csrf
                <input type="hidden" id="positionId" name="id">

                <div class="mb-3">
                    <label for="positionName" class="form-label">Position Name *</label>
                    <input type="text" class="form-control" id="positionName" name="position_name" placeholder="Enter position name" required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-check"></i> Update Position
                </button>
                <button type="button" class="btn btn-secondary w-100 mt-2" onclick="closeModal()">Cancel</button>
            </form>
        </div>
    </div>
</div>

{{-- end update --}}
<div class="container my-5">
    <div class="row">
        <!-- Positions List -->
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-briefcase me-2"></i>
                        Positions List
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($positions as $position)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                    <span class="fw-bold">{{ $position->id}} . {{ $position->positions}}</span>
                                    <div>
                                        <button class="btn btn-sm btn-warning me-1" onclick="editPosition({{ $position->id }}, '{{ $position->positions }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form class="d-inline" action="{{route('position.destroy', $position->id )}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                        <button  class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Position -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Add New Position
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('position.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="position_name" class="form-label fw-bold">Position Name *</label>
                            <input type="text" class="form-control" 
                                   id="position_name" name="position_name" 
                                   value="{{ old('position_name') }}" 
                                   placeholder="Enter position name" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-plus me-2"></i>
                            Add Position
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
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
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
    function editPosition(id, name) {
        document.getElementById('editModal').style.display = 'flex';
        document.getElementById('positionId').value = id;
        document.getElementById('positionName').value = name;
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