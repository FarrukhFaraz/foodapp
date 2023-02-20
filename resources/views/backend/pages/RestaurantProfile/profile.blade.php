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
                <label style="font-size: 30px;">Restaurant Profile</label>
            </div>
            <div style="height: 30px;"></div>
            <div class="cc" style="width: 100%">

                <form action="{{ route('uploadProfile') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <fieldset class="container">

                        <div class="row" style="">

                            <span>
                                <div style="height: 30px;"></div>

                                <span class="row">
                                    <span style="margin-left: 18px"> Name : </span>
                                    <span style="width: 100px"></span>
                                    <span
                                        style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;width: 350px;">
                                        <input type="text" class="form-control inp" name="name" placeholder="name"
                                            value="{{ $restaurant['name'] }}" style="border-bottom: 0px">
                                    </span>
                                </span>

                                <div style="height: 20px;"></div>

                                {{-- //////////////////////////////// --}}

                                <span class="row">
                                    <span style="margin-left: 18px"> Email : </span>
                                    <span style="width: 103px"></span>
                                    <span
                                        style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;width: 350px;">
                                        <input type="text" class="form-control inp" name="email" placeholder="email"
                                            value="{{ $restaurant['email'] }}" style="border-bottom: 0px">
                                    </span>
                                </span>


                                <div style="height: 20px;"></div>

                                <span class="row">
                                    <span style="margin-left: 18px"> Phone No. : </span>
                                    <span style="width: 68px"></span>
                                    <span
                                        style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;width: 350px;">
                                        <input type="text" class="form-control inp" name="phone" placeholder="phone"
                                            value="{{ $restaurant['phone'] }}" style="border-bottom: 0px">
                                    </span>
                                </span>

                            </span>

                            <div style="width: 35%"></div>
                            <div>
                                <img id="image-display" src="{{ asset('uploads/profile/' . $restaurant['logo']) }}"
                                   style="margin-bottom: 10px" width="200px" height="200px">
                            </div>
                        </div>

                        <div style="height: 5px"></div>

                        <div style="text-align: end;width: 100%">
                            <input type="file" name="image" placeholder="" id="image"
                                style=" align-self: end;width: 105px;margin-right: 30px;;">
                        </div>

                        {{-- <div style="height: 20px;"></div> --}}

                        <div class="row">
                            <span> Address : </span>
                            <div style="width: 83px"></div>
                            <textarea name="address" id="address" cols="86" rows="3"> {{ $restaurant['address'] }} </textarea>
                        </div>

                        <div style="height: 20px;"></div>

                        <div class="row" style="width: 100%">
                            <span> Loaction : </span>
                            <div style="width: 93px"></div>

                            <span class="row" style="width: ">

                                <div
                                    style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;width: 350px;">
                                    <input type="number" onchange="setTwoNumberDecimal" step="0.0000000000001"
                                        class="form-control inp" name="lat" placeholder="latitude"
                                        value="{{ $restaurant['lat'] }}" style="border-bottom: 0px">
                                </div>

                                <div style="width: 80px"></div>

                                <div
                                    style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;width: 350px;">
                                    <input type="number" onchange="setTwoNumberDecimal" step="0.0000000000001"
                                        class="form-control inp" name="lng" placeholder="longitude"
                                        value="{{ $restaurant['lng'] }}" style="border-bottom: 0px">
                                </div>

                            </span>

                        </div>

                        <div style="height: 20px;"></div>

                        <div class="row">
                            <span> Delivery Time : </span>

                            <div style="width: 45px"></div>

                            <div
                                style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;width: 350px;">
                                <input type="text" class="form-control inp" name="delivery_time"
                                    value="{{ $restaurant['delivery_time'] }}" placeholder="delivery time"
                                    style="border-bottom: 0px">
                            </div>
                        </div>

                        <div style="height: 20px;"></div>

                        <div class="row" style="width: 100%">
                            <span> Timing : </span>
                            <div style="width: 106px"></div>

                            <span class="row" style="width: ">

                                <div
                                    style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;width: 350px;">
                                    <input type="text" class="form-control inp" name="start_time"
                                        placeholder="strat time" value="{{ $restaurant['start_time'] }}"
                                        style="border-bottom: 0px">
                                </div>
                                <span style="margin-left: 5px"> am</span>

                                <div style="width: 50px"></div>

                                <div
                                    style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;width: 350px;">
                                    <input type="text" class="form-control inp" name="end_time"
                                        placeholder="end time" value="{{ $restaurant['end_time'] }}"
                                        style="border-bottom: 0px">
                                </div>
                                <span style="margin-left: 5px">pm</span>

                            </span>

                        </div>

                        <div style="height: 20px;"></div>

                        <div class="row">
                            <span> About : </span>
                            <div style="width: 97px"></div>
                            <textarea name="about" id="about" cols="94" rows="6"> {{ $restaurant['about'] }} </textarea>
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
