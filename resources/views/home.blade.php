@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <p>You are logged in!</p>
                    <button type="button" class="btn btn-primary" v-on:click="loadUser">
                        Click to Load Your Data
                    </button>
                    <p><pre>@{{ user }}</pre></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Get Users Data</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Params</label>
                            <textarea class="form-control" v-model="query"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" v-on:click="users">
                           Load
                        </button>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item" v-for="user in api.users">
                            <pre>@{{ user | stringify }}</pre>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <api-box
                    header-text="Post Users Data"
                    req-type="post"
                    uri="/api/v1/users"
                    >
                    <template slot="result-area" scope="props">
                        <div class="panel-body" v-if="(! _.isEmpty(props.data))">
                            <pre>@{{ props.data }}</pre>
                        </div>
                    </template>
                </api-box>
            </div>
        </div>
    </div>
</div>
@endsection
