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
    <div class="col-xs-12 main">
        <div class="page-on-top">

            <div class="container " style="width: 40%;">
                <div class="row">
                    <div class="cc" style="width: 100%">
                        <form action="{{ route('taskUpdated') }}" method="post">
                            @csrf
                            <fieldset class="container" style="width: 100%">
                                <legend class="container" style="text-align: center">Update Task</legend>

                                <div class="container">
                                    <label> Id :</label>
                                    <div
                                        style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;">
                                        <input type="text" class="form-control inp" name="id" placeholder="id"
                                            style="border-bottom: 0px" value="{{ old('id') }}">
                                    </div>
                                    <span class="text_danger">
                                        @error('id')
                                            <label for="error"
                                                style="font-size: 12px; color: red;">{{ $message }}</label>
                                        @enderror
                                    </span>
                                </div>
                                <div style="height: 20px;"></div>

                                <div class="container">
                                    <label>Task Name :</label>
                                    <div
                                        style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;">
                                        <input type="text" class="form-control inp" name="task_name" placeholder="name"
                                            style="border-bottom: 0px" value="{{ old('task_name') }}">
                                    </div>
                                    <span class="text_danger">
                                        @error('task_name')
                                            <label for="error"
                                                style="font-size: 12px; color: red;">{{ $message }}</label>
                                        @enderror
                                    </span>
                                </div>

                                <div style="height: 20px;"></div>

                                <div class="container">
                                    <label for="project_id"> Select Project :</label>

                                    <select name="project_id" value="{{ old('project_name') }}"
                                        style="border: 1px solid #000000; border-radius: 6px;padding-left:4px; ">
                                        <option value=""></option>
                                        @foreach ($projects as $item)
                                            <option value=" {{ $item->id }} ">{{ $item->project_name }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <span class="text_danger" style="color: red;font-size: 12px;">
                                        @error('project_id')
                                            {{ 'First select any project' }}
                                        @enderror
                                    </span>
                                </div>

                                <div style="height: 20px;"></div>
                                <div class="container">
                                    <label> Task Description :</label>

                                    <div
                                        style="border: 1px solid #000000;padding-top: 4px;padding-left: 4px;padding-right: 4px;border-radius: 6px;">
                                        <textarea type="text" class="form-control" name="description"
                                            style="outline: none;border-bottom: none; height: 100px;max-height: 150px;"></textarea>

                                    </div>
                                </div>

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
@endsection
