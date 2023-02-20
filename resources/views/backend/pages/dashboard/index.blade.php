{{-- this is main file for dashboard display --}}

@extends('backend.layouts.app')
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



    <div class="container-fluid" style="width: 70%;margin-left: 25%;padding-bottom: 20px;padding-top: 20px;">


        <div class="row">
            <div style="font-size: 36px;font-weight: bolder;width: 500px;">{{ $restaurantName }}</div>
            <div style="width: 20%"></div>
            <div style="font-size: 22px;font-weight: bold;width: 300px;">
            <label for="">Total Income: {{ $price }}</label>
            <label for="">Recieved Amount: {{ $receivedAmount }}</label>
            </div>
        </div>

        <div style="height: 40px;"></div>

        <div class="row justify-content-center">

            <div style="height: 10px;"></div>

            <div class="col-lg-4 col-md-12"
                style="background-color: rgba(4, 49, 184, 0.807);padding: 10px;border-radius: 10px; margin-right: 10px;">
                <div class="white-box analytics-info">
                    <h4 class="box-title"><a style="color: white;">Category Items</a></h4>
                    <div style="text-align: end">
                        <label style="font-size: 24px; color: darkturquoise">{{ $category }}</label>
                    </div>
                </div>
            </div>

            <div style="height: 10px;"></div>

            <div class="col-lg-4 col-md-12"
                style="background-color: rgba(4, 49, 184, 0.807);padding: 10px;border-radius: 10px; margin-left: 10px;">
                <div class="white-box analytics-info">
                    <h4 class="box-title"><a style="color: white;">Product Items</a></h4>
                    <div style="text-align: end">
                        <label
                            style="font-size: 24px; color: darkturquoise;   ">{{ $product }}</label>
                    </div>
                </div>
            </div>

        </div>

        <div style="height: 20px;"></div>

        <div class="row justify-content-center">
            <div style="height: 10px;"></div>

            <div class="col-lg-4 col-md-12"
                style="background-color: rgba(4, 49, 184, 0.807);padding: 10px;border-radius: 10px; margin-right: 10px;">
                <div class="white-box analytics-info">
                    <h4 class="box-title"><a style="color: white;">Total Orders</a>
                    </h4>
                    <div style="text-align: end">
                        <label style="font-size: 24px; color: darkturquoise">{{ $orders }}</label>
                    </div>
                </div>
            </div>

            <div style="height: 10px;"></div>

            <div class="col-lg-4 col-md-12"
                style="background-color: rgba(4, 49, 184, 0.807);padding: 10px;border-radius: 10px; margin-left: 10px;">
                <div class="white-box analytics-info">
                    <h4 class="box-title"><a style="color: white;">Delivered Orders</a></h4>
                    <div style="text-align: end">
                        <label
                            style="font-size: 24px; color: darkturquoise;   ">{{ $deliveredOrder }}</label>
                    </div>
                </div>
            </div>

        </div>

        <div style="height: 20px;"></div>

        <div class="row justify-content-center">
            <div style="height: 10px;"></div>

            <div class="col-lg-4 col-md-12"
                style="background-color: rgba(4, 49, 184, 0.807);padding: 10px;border-radius: 10px; margin-right: 10px;">
                <div class="white-box analytics-info">
                    <h4 class="box-title"><a href="" style="color: white;">Pending Order</a></h4>
                    <div style="text-align: end">
                        <label style="font-size: 24px; color: darkturquoise">{{ $pendingOrder }}</label>
                    </div>
                </div>
            </div>
            <div style="height: 10px;"></div>

            <div class="col-lg-4 col-md-12"
                style="background-color: rgba(4, 49, 184, 0.807);padding: 10px;border-radius: 10px; margin-left: 10px;">
                <div class="white-box analytics-info">
                    <h4 class="box-title"><a href="" style="color: white;">Total Users</a></h4>
                    <div style="text-align: end">
                        <label
                            style="font-size: 24px; color: darkturquoise;  ">{{ $users }}</label>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
