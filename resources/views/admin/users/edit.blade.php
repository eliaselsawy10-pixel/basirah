@extends('admin.layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@push('style')
<style>
    .edit-user-card {
        max-width: 720px;
        margin: 0 auto;
    }
    .form-section-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid rgba(59,130,246,0.1);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-section-title i {
        font-size: 0.9rem;
    }
    .avatar-upload-area {
        width: 120px;
        height: 120px;
        border: 2px dashed #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        overflow: hidden;
        position: relative;
        margin: 0 auto 8px;
    }
    .avatar-upload-area:hover {
        border-color: var(--accent);
        background: rgba(59,130,246,0.03);
    }
    .avatar-upload-area img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .avatar-upload-area .upload-placeholder {
        text-align: center;
        color: var(--text-secondary);
    }
    .avatar-upload-area .upload-placeholder i {
        font-size: 1.5rem;
        margin-bottom: 4px;
        display: block;
    }
    .avatar-upload-area .upload-placeholder span {
        font-size: 0.7rem;
        font-weight: 500;
    }
    .specialization-hint {
        font-size: 0.72rem;
        color: var(--text-secondary);
        margin-top: 4px;
    }
    .price-prefix {
        position: relative;
    }
    .price-prefix .admin-input {
        padding-left: 28px;
    }
    .price-prefix::before {
        content: '$';
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.9rem;
    }
    #doctorFields {
        animation: fadeInFields 0.3s ease;
    }
    @keyframes fadeInFields {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="edit-user-card">
    <div class="admin-card">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            @if($errors->any())
            <div class="admin-alert admin-alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            {{-- ── Account Information ── --}}
            <div class="form-section-title">
                <i class="fas fa-user-shield"></i> Account Information
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="admin-label">Name *</label>
                    <input type="text" name="name" class="admin-input" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="admin-label">Email *</label>
                    <input type="email" name="email" class="admin-input" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="admin-label">Role *</label>
                    <select name="role" id="roleSelect" class="admin-input admin-select" required>
                        @foreach(['patient' => 'Patient', 'doctor' => 'Doctor', 'admin' => 'Admin'] as $val => $label)
                        <option value="{{ $val }}" {{ old('role', $user->role) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="admin-label">New Password</label>
                    <input type="password" name="password" class="admin-input" placeholder="Leave blank to keep current">
                </div>
            </div>

            {{-- ── Doctor-Specific Fields ── --}}
            <div id="doctorFields" style="{{ old('role', $user->role) === 'doctor' ? '' : 'display:none' }}">

                {{-- Avatar --}}
                <div class="text-center mb-4">
                    <div class="avatar-upload-area" onclick="document.getElementById('imageInput').click()">
                        @if($user->image)
                        <img id="avatarPreview" src="{{ asset($user->image) }}" alt="{{ $user->name }}">
                        <div class="upload-placeholder" id="uploadPlaceholder" style="display:none">
                            <i class="fas fa-camera"></i>
                            <span>Change Photo</span>
                        </div>
                        @else
                        <div class="upload-placeholder" id="uploadPlaceholder">
                            <i class="fas fa-camera"></i>
                            <span>Upload Photo</span>
                        </div>
                        <img id="avatarPreview" src="" alt="Preview" style="display:none">
                        @endif
                    </div>
                    <input type="file" name="image" id="imageInput" accept="image/*" style="display:none">
                    <div class="specialization-hint">Optional · JPG, PNG or WebP · Max 2MB</div>
                </div>

                {{-- Professional Details --}}
                <div class="form-section-title">
                    <i class="fas fa-stethoscope"></i> Professional Details
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="admin-label">Professional Title *</label>
                        <input type="text" name="title" class="admin-input" value="{{ old('title', $user->title) }}" placeholder="e.g. Senior Optometrist">
                    </div>
                    <div class="col-md-6">
                        <label class="admin-label">Session Price *</label>
                        <div class="price-prefix">
                            <input type="number" name="price" class="admin-input" value="{{ old('price', $user->price) }}" step="0.01" min="0" placeholder="45.00">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="admin-label">Biography *</label>
                        <textarea name="bio" class="admin-input" rows="3" placeholder="Brief professional biography...">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="admin-label">Specializations</label>
                        <input type="text" name="specializations" class="admin-input"
                            value="{{ old('specializations', is_array($user->specializations) ? implode(', ', $user->specializations) : $user->specializations) }}"
                            placeholder="e.g. Vision Therapy, Dry Eye Specialist">
                        <div class="specialization-hint">Separate multiple specializations with commas</div>
                    </div>
                </div>

                {{-- Ratings --}}
                <div class="form-section-title">
                    <i class="fas fa-star"></i> Ratings & Reviews
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="admin-label">Rating (0 – 5)</label>
                        <input type="number" name="rating" class="admin-input" value="{{ old('rating', $user->rating) }}" step="0.1" min="0" max="5">
                    </div>
                    <div class="col-md-6">
                        <label class="admin-label">Review Count</label>
                        <input type="number" name="review_count" class="admin-input" value="{{ old('review_count', $user->review_count) }}" min="0">
                    </div>
                </div>
            </div>

            {{-- ── Actions ── --}}
            <div class="d-flex justify-content-end gap-3 pt-3" style="border-top:1px solid #f1f5f9">
                <a href="{{ route('admin.users.index') }}" class="btn-admin btn-admin-outline">Cancel</a>
                <button type="submit" class="btn-admin btn-admin-primary"><i class="fas fa-save"></i> Update User</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
// Toggle doctor fields based on role selection
$('#roleSelect').on('change', function() {
    if ($(this).val() === 'doctor') {
        $('#doctorFields').slideDown(250);
    } else {
        $('#doctorFields').slideUp(250);
    }
});

// Avatar preview
$('#imageInput').on('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#avatarPreview').attr('src', e.target.result).show();
            $('#uploadPlaceholder').hide();
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
