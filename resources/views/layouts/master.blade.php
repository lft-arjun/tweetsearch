<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Search Tweets</title>
        <style>
          /*html, body {
            height: 100%;
            margin: 0;
            padding: 0;
          }*/
          #map {
            height: 80%;
          }
          .tweets-page{
            position:  relative;
          }
         .tweets-page h1{
    position: absolute;
    left: 50%;
    z-index: 1;
    transform: translateX(-50%);
}
.tweets-page .form-group .form-control{
  box-shadow: 0;
  border: 1px solid #c8c8c8;
  padding:5px;
  border-radius: 0;

}
.tweets-page button{
  border-radius: 0;
  background: #4285f4;
  color: #fff;
  width: 48.7%;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;

}

.custom-input{
  width: 80%;
}
.no-h-padding{
padding-left: 0 !important;
padding-right: 0 !important;
}

        </style>
 
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>

         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
   </body>
</html>