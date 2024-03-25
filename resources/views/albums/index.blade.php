@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Albums</li>
                </ol>
            </nav>
            <div class="bg-white p-5 rounded">
                <table class="table-striped  text-center table-bordered table">
                    <thead>
                    <tr>
                        <td>
                            ID
                        </td>
                        <td>
                            NAME
                        </td>
                        <td>
                            ACTIONS
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($albums as $album)
                        <tr>
                            <td>
                                {{$album->id}}
                            </td>
                            <td>
                                {{$album->name}}
                            </td>
                            <td>
                                <a class="btn btn-primary" href="/albums/{{$album->id}}/edit">Edit</a>
                                <a class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr >
                            <td colspan="3">
                                <div  class="text-center">
                                    <p>No albums!</p>
                                    <a href="/albums/create" class="btn btn-success">Create New</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>
@endsection
