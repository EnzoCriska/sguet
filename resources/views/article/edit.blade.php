@extends('scaffold-interface.layouts.defaultMaterialize')
@section('title','Edit')
@section('content')

<div class = 'container'>
    <h1>
        Edit article
    </h1>
    <form method = 'get' action = '{!!url("article")!!}'>
        <button class = 'btn blue'>article Index</button>
    </form>
    <br>
    <form method = 'POST' action = '{!! url("article")!!}/{!!$article->
        id!!}/update'> 
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="input-field col s6">
            <input id="title" name = "title" type="text" class="validate" value="{!!$article->
            title!!}"> 
            <label for="title">title</label>
        </div>
        <div class="input-field col s6">
            <input id="content" name = "content" type="text" class="validate" value="{!!$article->
            content!!}"> 
            <label for="content">content</label>
        </div>
        <div class="input-field col s6">
            <input id="image_url" name = "image_url" type="text" class="validate" value="{!!$article->
            image_url!!}"> 
            <label for="image_url">image_url</label>
        </div>
        <div class="input-field col s6">
            <input id="short_description" name = "short_description" type="text" class="validate" value="{!!$article->
            short_description!!}"> 
            <label for="short_description">short_description</label>
        </div>
        <button class = 'btn red' type ='submit'>Update</button>
    </form>
</div>
@endsection