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
                <api-box req-type="post" uri="/api/v1/keys/2/users" >
                    <template slot="header-text">POST Key/2/User</template>
                    <template slot="result-area" scope="props">
                        <div class="panel-body">
                            <pre>@{{ props.data.data }}</pre>
                        </div>
                        <!-- multipart="true" file-upload-name="file" -->
                        <!-- <ul class="list-group">
                            <li class="list-group-item" v-for="user in props.data.data.users">
                                <pre>@{{ user }}</pre>
                            </li>
                         --></ul>
                    </template>
                </api-box>
            </div>
            <div class="col-md-4">
                <api-box req-type="get" uri="/api/v1/keys/2/users">
                    <template slot="header-text">GET Key/2/User</template>
                    <template slot="result-area" scope="props">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="user in props.data.data.users">
                                <pre>@{{ user }}</pre>
                            </li>
                        </ul>
                    </template>
                </api-box>
            </div>
            <div class="col-md-4">
                <api-box req-type="delete" uri="/api/v1/keys/1">
                    <template slot="header-text">DELETE Key/1</template>
                    <template slot="result-area" scope="props">
                        <div class="panel-body">
                            <pre>@{{ props.data.data.key }}</pre>
                        </div>
                    </template>
                </api-box>
            </div>
        </div>
    </div>
</div>
@endsection
