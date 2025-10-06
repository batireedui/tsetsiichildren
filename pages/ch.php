<!DOCTYPE html>
<html>

<head>
    <title>Гэр айлчлал</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body,
        html {
            height: 100%;
        }

        .item {
            margin: auto;
            text-align: center;
            padding: 30px;
            border: 3px solid;
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row" style="margin: 30px;">
            <div class="col-12" style="text-align: center;">
                <img src="/assets/img/favicon/logo.png" width="200px" />
                <div>
                    <h3 style="color: #0739a9; margin-top: 20px">Гэр айлчлал</h3>
                    <p style="color: #0739a9;"><?=$pageTitle?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-4">
                        <a href="/school/login">
                            <div class="item">
                                <img src="/assets/img/home/group.png" width="150px" />
                                <div>Нийгмийн ажилтан</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="/teacher/login">
                            <div class="item">
                                <img src="/assets/img/home/teacher.png" width="150px" />
                                <div>Багш</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="/adminpanel/login">
                            <div class="item">
                                <img src="/assets/img/home/university.png" width="150px" />
                                <div>Боловсролын газар</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
    </div>
</body>

</html>