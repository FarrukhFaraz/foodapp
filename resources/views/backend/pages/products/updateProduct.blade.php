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
            <div style="text-align: center">
                <label style="font-size: 30px;">Create New Product</label>
            </div>
            <div style="height: 30px;"></div>
            <div class="cc" style="width: 100%">

                <form action="{{ route('productUpdated') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <fieldset class="container">

                        <div class="row" style="">

                            <span>
                                <div style="height: 30px;"></div>

                                <span class="row">
                                    <span style="margin-left: 18px"> Product Id : </span>
                                    <span style="width: 90px"></span>
                                    <span
                                        style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;width: 350px;">
                                        <input type="text" class="form-control inp" name="id" placeholder="id"
                                            readonly value="{{ $products['id'] }}" style="border-bottom: 0px">
                                    </span>
                                </span>
                                @error('id')
                                    <span class="text_danger" style="color: red;font-size: 12px; margin-left: 175px;">
                                        {{ 'Id is required' }}
                                    </span>
                                @enderror

                                <div style="height: 20px;"></div>

                                <span class="row">
                                    <span style="margin-left: 18px"> Product Name : </span>
                                    <span style="width: 60px"></span>
                                    <span
                                        style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;width: 350px;">
                                        <input type="text" class="form-control inp" name="name" placeholder="name"
                                            value="{{ $products['name'] }}" style="border-bottom: 0px">
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
                                    <select name="category_id" value="{{ $products['category_id'] }}"
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
                                            value="{{ $products['price'] }}" style="border-bottom: 0px">
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
                                <img id="image-display" src="{{ asset('uploads/products/' . $products['image']) }}"
                                    style="margin-bottom: 10px" width="200px" height="200px">
                            </div>
                        </div>

                        <div style="height: 5px"></div>

                        <div style="text-align: end;width: 100%">
                            <input type="file" name="image" placeholder="" id="image"
                                style=" align-self: end;width: 105px;margin-right: 30px;">
                        </div>

                        {{-- <div style="height: 20px;"></div> --}}

                        <div class="row">
                            <span> Description : </span>
                            <div style="width: 83px"></div>
                            <textarea name="description" id="description" cols="86" rows="5"> {{ $products['description'] }}</textarea>
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
