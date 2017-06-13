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
                <api-box req-type="post" uri="/api/v1/storage" multipart="true" file-upload-name="file">
                    <template slot="header-text">POST Storage</template>
                    <template slot="result-area" scope="props">
                        <div class="panel-body">
                            <pre>@{{ props.data.data.link }}</pre>
                        </div>
                        <ul class="list-group">
                            <!-- <li class="list-group-item" v-for="user in props.data.data.users">
                                <pre>@{{ user }}</pre>
                            </li> -->
                        </ul>
                    </template>
                </api-box>
            </div>
            <div class="col-md-4">
                <api-box req-type="post" uri="/api/v1/users">
                    <template slot="header-text">POST User</template>
                    <template slot="result-area" scope="props">
                        <div class="panel-body">
                            <pre>@{{ props.data.data.user }}</pre>
                        </div>
                    </template>
                </api-box>
            </div>
            <div class="col-md-4">
                <api-box req-type="put" uri="/api/v1/users/19">
                    <template slot="header-text">PUT User/19</template>
                    <template slot="result-area" scope="props">
                        <div class="panel-body">
                            <pre>@{{ props.data.data.user }}</pre>
                        </div>
                    </template>
                </api-box>
            </div>
        </div>
    </div>
</div>
@endsection
