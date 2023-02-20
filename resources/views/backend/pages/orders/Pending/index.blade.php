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
                            {{-- <div class="col-2-ms" style="width: 70%;margin-left: 16px;">
                                <form action="{{ route('products.index') }}">
                                    <input type="search" name="search" placeholder="search by name"
                                        style="padding-left: 10px;width: 100%;padding: 4px;" value="{{ $search }}" />
                                    <div style="height: 10px;"></div>
                                    <div style="text-align: start;">
                                        <button class="update_class btn" class="submit" type="submit"
                                            style="padding-left: 16px;padding-right: 16px; color: white;">Search</button>

                                        <a href="{{ route('products.index') }}" class="update_class btn" type="submit"
                                            style="padding-left: 16px;padding-right: 16px;">Reset
                                        </a>
                                    </div>
                                </form>
                            </div> --}}
                            {{-- <div style="width: 10%"></div>

                            <div class="col-ms">
                                <a href="{{ route('createProducts') }}" class="update_class btn"
                                    style="padding-left: 16px;padding-right: 16px;">Add
                                </a>
                            </div> --}}
                        </div>

                        <table class="table table-bordered project-data-table">
                            <thead align="center">
                                <tr>
                                    <th style=" width: 4%;text-align: center;">Id</th>
                                    <th style="width:12%; text-align: center; ">User Name</th>
                                    <th style="width:12%; text-align: center; ">Price</th>
                                    <th style="width:21% ; text-align: center; ">Phone No.</th>
                                    <th style="width:23% ; text-align: center; ">Address</th>
                                    <th style="width:23% ; text-align: center; ">Order Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $item)
                                    <tr
                                        style="font-size: 14px; font-weight: lighter;color: rgba(16, 18, 13, 0.827); text-align: center;height: 120px;">
                                        <th style="text-align: center;">{{ $item->id }}</th>
                                        <th style="text-align: center;">{{ $item->customer_name }}</th>
                                        <th style="text-align: center;">{{ $item->totalPrice }}</th>
                                        <th style="text-align: center;">{{ $item->phone_number }}</th>
                                        <th style="text-align: center;">{{ $item->address }}</th>
                                        <th style="text-align: center;">{{ $item->extraInfo }}</th>
                                        <th style="text-align: center;" colspan="2">

                                            <a href="{{ route('order_accepted', [
                                                'id' => $item->id,
                                            ])  }}"
                                                class="update_class btn " style="color: white;">Accept</a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="height: 6px"></div>
                        <div>{{ $orders->count() }}</div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
