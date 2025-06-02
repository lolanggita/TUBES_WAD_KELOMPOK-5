@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
    </div>

    <!-- Profile Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User Profile</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="https://source.unsplash.com/random/300x300/?profile" alt="Profile Picture" class="img-thumbnail rounded-circle">
                </div>
                <div class="col-md-8">
                    <h5>{{ Auth::user()->name }}</h5>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Role:</strong> {{ Auth::user()->role }}</p>
                    <a href="#" class="btn btn-primary">Edit Profile</a> 
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
        </div>
        <div class="card-body">
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-badge"><i class="fas fa-check"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">Event Created</h4>
                        </div>
                        <div class="timeline-body">
                            <p>Successfully created a new event.</p>
                        </div>
                    </div>
                </div>
                <!-- More timeline items... -->
            </div>
        </div>
    </div>
</div>
@endsection