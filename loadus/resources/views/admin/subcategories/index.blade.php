@extends('adminlte::page')

@section('title', "$title")

@section('content_header')
<?php //echo ActionButton(1); ?>
<h1>{{ $title }}</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">{{ $title }}</a></li>    
</ol>
<?php //echo CreateButton(); ?>

<div class="clearfix cbutton">
    <div class="pull-right">
        <a href="{{url('admin/sub-categories/add/'.$id)}}"><button class="btn btn-success btn-flat" data-toggle="tooltip" title="" data-original-title="Create Page">Create Sub Categories</button></a>
    </div> 
</div>


@stop

@section('content')
<div id="success"></div>
<div id="failed"></div>

<div class="box box-success color-palette-box">

    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> {{ $title }}</h3>
        <!--<button class="btn btn-success btn-flat pull-right">Add </button>-->
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $a=1; @endphp
                    @foreach($categories as $category)
                <tr>
                    <td>{{$a}}</td>
                    <td>{{$category->title}}</td>
                    <td>@if($category->status=='1') Active @else Inactive @endif</td>
                    <td>{{$category->created_at}}</td>
                    <td>
                        <a href="{{url('admin/sub-categories/edit/'.$category->id)}}" class="btn btn-success">Edit</a>
                        <a href="{{url('admin/sub-categories/delete/'.$category->id)}}" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                    @php $a++; @endphp
                    @endforeach
                </tbody>
            </table>
            <?php echo $categories->render(); ?>
        </div>
    </div>
</div>


@stop