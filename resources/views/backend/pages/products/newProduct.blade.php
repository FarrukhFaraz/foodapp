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
        input:focus,
        textarea:focus,
            {
            border: 1px solid #000000;
            -webkit-box-shadow: 0 0 6px #007eff;
            -moz-box-shadow: 0 0 5px #007eff;
            box-shadow: 0 0 5px #007eff;
            padding: 4px;
        }

        .namefield {
            border: 2px solid #000000;
            outline: solid 2px #000000;
            border-style: solid;
            border-radius: 4px;
            margin-left: 40pxs;

        }
    </style>
    <div class="col-xs-12 main">
        <div class="page-on-top">
            <div style="text-align: center">
                <label style="font-size: 30px;">Create New Product</label>
            </div>
            <div style="height: 30px;"></div>
            <div class="cc" style="width: 100%">

                <form action="{{ route('productsCreated') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <fieldset class="container">

                        <div class="row" style="">

                            <span>
                                <div style="height: 30px;"></div>

                                <span class="row">
                                    <span style="margin-left: 18px"> Product Name : </span>
                                    <span style="width: 60px"></span>
                                    <span
                                        style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;width: 350px;">
                                        <input type="text" class="form-control inp" name="name" placeholder="name"
                                            style="border-bottom: 0px">
                                    </span>
                                </span>
                                @error('name')
                                    <span class="text_danger" style="color: red;font-size: 12px; margin-left: 175px;">
                                        {{ 'Name is required' }}
                                    </span>
                                @enderror

                                <div style="height: 20px;"></div>

                                {{-- //////////////////////////////// --}}

                                <span class="row">
                                    <span style="margin-left: 18px"> Category : </span>
                                    <span style="width: 97px"></span>
                                    <select name="category_id"
                                        style="border: 1px solid #000000;padding: 6px;border-radius: 6px;width: 350px;">
                                        <option value=""></option>
                                        @foreach ($category as $item)
                                            <option value=" {{ $item->id }} ">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </span>
                                @error('category_id')
                                    <span class="text_danger" style="color: red;font-size: 12px;margin-left: 175px;">
                                        {{ 'First select any category' }}
                                    </span>
                                @enderror


                                <div style="height: 20px;"></div>

                                <span class="row">
                                    <span style="margin-left: 18px"> Price : </span>
                                    <span style="width: 123px"></span>
                                    <span
                                        style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;width: 350px;">
                                        <input type="text" class="form-control inp" name="price" placeholder="price"
                                            style="border-bottom: 0px">
                                    </span>


                                </span>
                                @error('price')
                                    <span class="text_danger" style="color: red;font-size: 12px;margin-left: 175px;">
                                        {{ 'Price is required' }}
                                    </span>
                                @enderror



                            </span>

                            <div style="width: 32%"></div>
                            <div>
                                <img id="image-display" src="" style="margin-bottom: 10px" width="200px"
                                    height="200px">
                            </div>
                        </div>

                        <div style="height: 5px"></div>

                        <div style="text-align: end;width: 100%">
                            <input type="file" name="image" placeholder="" id="image"
                                style=" align-self: end;width: 105px;margin-right: 30px;">
                            <br>
                            <span class="text_danger" style="color: red;font-size: 12px;margin-right: 35px;">
                                @error('image')
                                    {{ 'Image is required' }}
                                @enderror
                            </span>

                        </div>

                        {{-- <div style="height: 20px;"></div> --}}

                        <div class="row">
                            <span> Description : </span>
                            <div style="width: 83px"></div>
                            <textarea name="description" id="description" cols="86" rows="5"> </textarea>
                        </div>

                        <div style="height: 40px;"></div>

                        <div style="text-align: center">
                            <button type="submit" class="btn btn-success mt-4" , style="border-radius:10px; ">
                                Update
                            </button>
                        </div>


                    </fieldset>
                </form>
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
