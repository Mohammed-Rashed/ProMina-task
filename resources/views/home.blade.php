@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-secondary" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-3 ">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="card border-secondary mb-3" >
                        <div class="card-header text-secondary bg-transparent border-secondary">All Albums</div>
                        <div class="card-body text-secondary">
                            <h5 class="card-title">{{$albums}} albums</h5>
                            <p class="card-text">You can Show all albums here</p>
                        </div>
                        <div class="card-footer bg-transparent border-secondary"><a href="/albums" class="btn btn bg-secondary text-white">Show Albums</a></div>
                    </div>

                </div>
                <div class="col-md-6 ">
                    <div class="card border-secondary mb-3" >
                        <div class="card-header text-secondary bg-transparent border-secondary">New Album</div>
                        <div class="card-body text-secondary">
                            <h5 class="card-title">New Album</h5>
                            <p class="card-text">Create new Album.</p>
                        </div>
                        <div class="card-footer bg-transparent border-secondary"><a href="/albums/create" class="btn btn-secondary text-white">Create</a></div>
                    </div>

                </div>


                </div>
            </div>
        </div>
    </div>

@endsection
