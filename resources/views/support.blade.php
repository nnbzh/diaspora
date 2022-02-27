<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <title>Техподдержка</title>
        <style media="screen">
            form {
               /* width: 40%;*/
                margin-left: 10%;
                display: flex;
                flex-direction: column;
                margin-right: 10%;
                margin-top: 20%;
            }
            input, textarea {
                margin-top: 15px;
                font-size: 14px;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="section">
            <div class="row">
                <div class="col-md-12">
            <form action="/send" method="post">
            {{ csrf_field() }}
            <center>
                <h4>Запрос в техподдержку!</h4>
            </center>
            <input style="border-color: #e3e3e3" type="text" name="login" placeholder="Логин">
            <textarea style="border-color: #e3e3e3" name="text" rows="8" cols="80"></textarea>
            <input style="height: 40px;" type="submit">
        </form>
        </div>
            </div>
        </div>
    </body>
</html>
