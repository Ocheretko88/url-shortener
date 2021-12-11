<!DOCTYPE html>
<html lang="">
<head>
    <title>Url Shortener</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./css/main.css" />

</head>

<script type="text/javascript">
$(document).ready(function (){


    $("#customShortUrl").click(function (){
        if ($(this).is(':checked')){
            $("#custom_short_key").show();
        }
    });

    $("#randomShortUrl").click(function (){
        if ($(this).is(':checked')){
            $("#custom_short_key").hide();
        }
    });

});

</script>


<body>


<div class="container fluid shadow-sm p-3 mb-5 bg-white rounded">
    <br>
    <h1><i class="fa fa-link"></i>&nbsp;Url Shortener</h1>
    <br>

    <div class="card shadow-sm p-3 mb-5 bg-white rounded">
        <div class="card-header ">
            <form method="POST" action="{{ route('create.short.url') }}">
                @csrf
                <div class="input-group mb-3 ">
                    <input type="text" name="url" class="form-control" placeholder="Enter URL" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">Create Short Url</button>
                    </div>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="shortUrlMethod" id="randomShortUrl" checked>
                    <label class="form-check-label" for="randomShortUrl">
                        Random short url
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="shortUrlMethod" id="customShortUrl">
                    <label class="form-check-label" for="customShortUrl">
                        Custom short url
                    </label>
                </div>
                <input type="text" id="custom_short_key" name="custom_short_key" class="form-control" placeholder="Enter custom URL" aria-describedby="basic-addon2">
            </form>
        </div>
        <div class="card-body">

            @if (Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ Session::get('success') }}</p>
                </div>
            @endif

                <div class="table-responsive">
                    <table class="table table-hover table-sm shadow-sm p-3 mb-5 bg-white rounded">
                        <thead>
                        <tr class="">
                            <th>ID</th>
                            <th>Short Url</th>
                            <th>Custom Url</th>
                            <th>Long Url</th>
                            <th>Status</th>
                            <th>Clicks</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shortUrls as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td><a href="{{ route('shorten.url', $row->short_key) }}" target="_blank">{{ route('shorten.url', $row->short_key) }}</a></td>
                                <td><a href="{{ route('shorten.url', $row->custom_short_key) }}" target="_blank">{{ route('shorten.url', $row->custom_short_key) }}</a></td>
                                <td>{{ $row->url }}</td>
                                <td>@if($row->is_enabled) <div style="color: green;">Active</div> @else <div style="color: red;">Expired</div> @endif</td>
                                <td>{{ $row->clicks }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>

</div>

</body>
</html>
