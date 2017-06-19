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
                <api-box req-type="get" uri="/api/v1/questions">
                    <template slot="header-text">GET Question</template>
                    <template slot="result-area" scope="props">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="question in props.data.data.questions">
                                <pre>@{{ question }}</pre>
                            </li>
                        </ul>
                    </template>
                </api-box>
            </div>
            <div class="col-md-4">
                <api-box req-type="post" uri="/api/v1/attempts/2/answers">
                    <template slot="header-text">POST Attempts/2/Answers</template>
                    <template slot="result-area" scope="props">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="answer in props.data.data.answers">
                                <pre>@{{ answer }}</pre>
                            </li>
                        </ul>
                    </template>
                </api-box>
            </div>
            <div class="col-md-4">
                <api-box req-type="post" uri="/api/v1/import" multipart="true" file-upload-name="file">
                    <template slot="header-text">POST Import</template>
                    <template slot="result-area" scope="props">
                        <div class="panel-body">
                            <pre>@{{ props.data.data }}</pre>
                        </div>
                    </template>
                </api-box>
            </div>
        </div>
    </div>
</div>
@endsection
