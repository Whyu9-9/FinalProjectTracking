@extends('layouts.admin')

@section('content')
<div class="section-header">
    <h1>Profile</h1>
</div>
<div class="section-body">
    <h2 class="section-title">Hi, Ujang!</h2>
    <p class="section-lead">
    Change information about yourself on this page.
    </p>

    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-5">
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="{{asset('templates/stisla/assets/img/avatar/avatar-1.png')}}" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Blog Posts</div>
                            <div class="profile-widget-item-value">187</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Total Views</div>
                            <div class="profile-widget-item-value">6,8K</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Total Project</div>
                            <div class="profile-widget-item-value">2,1K</div>
                        </div>
                    </div>
                </div>
                <div class="profile-widget-description">
                    <div class="profile-widget-name">Ujang Maman 
                        <div class="text-muted d-inline font-weight-normal">
                            <div class="slash"></div> Web Developer</div>
                        </div>
                    Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>.
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
                <form method="post" class="needs-validation" novalidate="">
                    <div class="card-header">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" value="Ujang" required="">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <select id="memberGender" name="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                @error('gender')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-7 col-12">
                                <label>Email</label>
                                <input name="email" type="email" class="form-control" value="ujang@maman.com" required="">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-5 col-12">
                                <label>Phone</label>
                                <input name="phone" type="tel" class="form-control" value="">
                                @error('gender')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Bio</label>
                                <textarea class="form-control summernote-simple">Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>.</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection