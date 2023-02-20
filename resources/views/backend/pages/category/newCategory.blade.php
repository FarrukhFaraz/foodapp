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
    @include('sweetalert::alert')
    <style>
        .inp {
            outline: 4px;
            border: 2px;

            border-radius: 8px;
        }
    </style>
    <div class="col-xs-12 main">
        <div class="page-on-top">

            <div class="container " style="width: 40%;">
                <div class="row">
                    <div class="cc" style="width: 100%">
                        <form action="{{ route('categoryCreated') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <fieldset class="container" style="width: 100%">
                                <legend class="container" style="text-align: center">Create New Category</legend>

                                <div class="container">
                                    <label>Category Name :</label>
                                    <div
                                        style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;">
                                        <input type="text" class="form-control inp" name="name"
                                            placeholder="name" style="border-bottom: 0px" value="{{ old('name') }}">
                                    </div>
                                    <span class="text_danger">
                                        @error('name')
                                            <label for="error"
                                                style="font-size: 12px; color: red;">{{ $message }}</label>
                                        @enderror
                                    </span>
                                </div>

                                <div style="height: 20px;"></div>

                                <div>
                                    <img id="image-display" src="" style="margin-bottom: 10px" height="150px">
                                </div>

                                <div style="">
                                    <input type="file" name="image" placeholder="" id="image" >
                                </div>
                                <span class="text_danger">
                                    @error('image')
                                        <label for="error"
                                            style="font-size: 12px; color: red;">{{ $message }}</label>
                                    @enderror
                                </span>

                                <div style="height: 40px;"></div>
                                <div style="text-align: center">
                                    <button type="submit" class="btn btn-success mt-4" , style="border-radius:10px; ">
                                        Create
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const input = document.getElementById('image');
        const display = document.getElementById('image-display');

        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            const url = URL.createObjectURL(file);
            display.src = url;
        });
    </script>
@endsection
