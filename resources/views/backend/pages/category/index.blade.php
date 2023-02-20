@extends('backend.layouts.app')


@section('title', $title)
@php
    $id = $userData['id'];
    $name = $userData['name'];
    $email = $userData['email'];
@endphp
@section('name', $name)
@section('id', $id)
@section('email', $email)

@section('title', $title)

@section('content')

    <style>
        .update_class {
            background-color: green;
            color: white;
            padding-left: 6px;
            padding-right: 6px;
            padding-top: 6px;
            padding-bottom: 6px;
            border-radius: 6px;
            border: none;
            text-align: center;
            font-size: 12px;
        }

        .delete_class {
            background-color: red;
            color: white;
            padding-left: 6px;
            padding-right: 6px;
            padding-top: 6px;
            padding-bottom: 6px;
            border-radius: 6px;
            border: none;
            text-align: center;
            font-size: 12px;
        }

        .btn:hover {
            color: white;
            background-color: yellow
        }
    </style>

    <div class="col-xs-12 main">
        <div class="page-on-top">

            @include('sweetalert::alert')

            <!-- tables/default -->
            <div class="row m-b-20">
                <div style="width: 100%">

                    <div class="container" style="width: 100%">
                        <div class="row justify-content-center" style="width: 100%">
                            <div class="col-2-ms" style="width: 70%;margin-left: 16px;">
                                <form action="{{ route('category.index') }}">
                                    <input type="search" name="search" placeholder="search by name"
                                        style="padding-left: 10px;width: 100%;padding: 4px;" value="{{ $search }}" />
                                    <div style="height: 10px;"></div>
                                    <div style="text-align: start;">
                                        <button class="update_class btn" class="submit" type="submit"
                                            style="padding-left: 16px;padding-right: 16px; color: white;">Search</button>

                                        <a href="{{ route('category.index') }}" class="update_class btn" type="submit"
                                            style="padding-left: 16px;padding-right: 16px;">Reset
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <div style="width: 10%"></div>

                            <div class="col-ms">
                                <a href="{{ route('createCategory') }}" class="update_class btn"
                                    style="padding-left: 16px;padding-right: 16px;">Add
                                </a>
                            </div>
                        </div>

                        <table class="table table-bordered project-data-table">
                            <thead align="center">
                                <tr>
                                    <th>Image</th>
                                    <th style="width: 30%">Name</th>
                                    <th style="width: 25%;text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $item)
                                    <tr
                                        style="font-size: 14px; font-weight: lighter;color: rgba(16, 18, 13, 0.827); text-align: center;">
                                        <th> <img id="image-display"
                                                src="{{ asset('uploads/categories/'.$item->image)
                                                 }}"
                                                style="margin-bottom: 10px" height="100px">{{ asset('uploads/categories/'.$item->image) }} </th>
                                        <th style="text-align: center">{{ $item->name }}</th>
                                        <th style="text-align: center;" colspan="2">

                                            <a href="{{ route('updateCategory', [
                                                'id' => $item->id,
                                                'name' => $item->name,
                                                'image' =>$item->image,
                                            ]) }}"
                                                class="update_class btn " style="color: white;">Update</a>

                                            <a class="delete_class btn" style="color: white"
                                                onclick="deleteRecord(`{{ $item->id }}`, `{{ $item->name }}`)">Delete</a>

                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <span><label for="total">Total : {{ $projects->total() }}</label></span>
                        {{ $projects->onEachSide(2)->links() }}


                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function deleteRecord(id, name) {
            var check = confirm('Are you want to delete this Category\n \nid:' + id + '\nname:' + name);
            if (check) {
                loadAjaxFunction(id);
            }
        }

        function loadAjaxFunction(id) {

            let xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ url('admin/categorydelete') }}/' + id, true);
            xhr.send();

            xhr.onload = function() {
                if (xhr.status == 210) {

                    alert('Data is deleted successfully');
                    window.location.reload();
                } else if (xhr.status == 250) {
                    alert('No record found with this Id');
                } else if (xhr.status == 240) {
                    alert('Something went wrong!');
                } else if (xhr.status == 260) {
                    alert('Data can not be deleted');
                }else if (xhr.status == 230) {
                    alert('Data can not be deleted');
                } else {
                    alert(`Error ${xhr.status}: ${xhr.statusText}`);
                }
            };

            xhr.onerror = function() {
                alert("Request failed");
            };
        }
    </script>




@endsection
