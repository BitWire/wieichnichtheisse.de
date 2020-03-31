<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>WieIchNichtHeisse.de</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <script>
            var counter = 1;
            var limit = 50;

            function addInput()
            {
                if (counter == limit)  {
                    alert("You have reached the limit of adding " + counter + " inputs");
                }
                else {
                    var newdiv = document.createElement('div');
                    newdiv.innerHTML = " <br><input type='text' name='altNames[]'>";
                    document.getElementById("AddInput").appendChild(newdiv);
                    counter++;
                }
            }
        </script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 94vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
            <form id="nameForm" action="/update-page" method="POST">
                @csrf
                <input type="hidden" name="csrfWorks" value="yes">
                <label for="name">Deine ID:</label><br>
                <input type="text" id="uuid" name="uuid" value=""><br><br>
                <label for="altname">Mehr Alternative Schreibweisen:</label><br>
                <input type="text"  name="altNames[]" value="Jon"><br>
                <div id="AddInput"></div>
                <input type="button" id="addField" onClick="addInput();" value="+" /><br>
                <br>
                <input type="submit" value="Speichern">
                <input type="reset" value="Reset">
            </form> 
            <a href="{{ url('') }}">zurück</a>
            </div>
        </div>
        @include('partials.footer')
    </body>
</html>
