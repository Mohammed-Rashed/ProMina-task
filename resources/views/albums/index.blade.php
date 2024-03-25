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

                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{$album->id}}">
                                    Delete
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{$album->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Album</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="delete{{$album->id}}" action="/albums/{{$album->id}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            @if($album->pictures!=null)
                                                                <h5  class="form-label text-left d-block">Delete All Pictures?</h5>
                                                                <div class="d-flex mt-3">
                                                                    <div>
                                                                        <label for="yes">Yes</label>
                                                                        <input checked id="yes" data-id="{{$album->id}}" type="radio" value="1" class="" name="delete_type" >
                                                                    </div>
                                                                    <div class="mx-4">
                                                                        <label for="no">Transfer to another album</label>
                                                                        <input id="no" data-id="{{$album->id}}" type="radio" value="2" class="" name="delete_type" >
                                                                    </div>
                                                                </div>
                                                                <div style="display: none" class="albums-select form-group">
                                                                    <label>Transfer pictures to album:</label>
                                                                    <select class="form-control" name="album_id">
                                                                        @foreach($albums->where('id','!=',$album->id) as $select_album)
                                                                            <option value="{{$select_album->id}}">#{{$select_album->id}} {{$select_album->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            @else
                                                                <h5  class="form-label text-left d-block">Are you sure to delete album?</h5>

                                                            @endif

                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" form="delete{{$album->id}}"   class="btn btn-primary">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
@section('script')
    <script>
        $(function (){
            $('input[name=delete_type]').on('change',function (e){
                var album_id=$(this).data('id')
                if($(this).val()==2){
                    $('#exampleModal'+album_id+' .albums-select').show()
                }else{
                    $('#exampleModal'+album_id+' .albums-select').hide()
                }
            })
        })
    </script>
    @endsection
