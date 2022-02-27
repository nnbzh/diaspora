@extends('Auth.layout.AuthParentHTML')

@section('page-title') Войти в Админ панель @endsection

@section('page-body')

<nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{route('dashboard')}}">
            <img src="{{asset('storage/img/brand/diaspora.png')}}">
        </a>
        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
            <div class="navbar-collapse-header">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{route('dashboard')}}">
                            <img src="{{asset('storage/img/brand/blue.png')}}">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Войти</button> -->
    </div>
</nav>
<!-- Main content -->
<div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
        <div class="container">
        </div>
        <!-- <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div> -->
    </div>
    <!-- Page content -->
    <!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> -->


   

    <div class="robots-block" style="margin-top: -6%;">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="robots-block-main">
                        <div class="robots-block-text-p">
                            <h4 class="robots-block-text dowd">Скачать мобильное приложение</h4>
                            <!-- <img class="robot-img-1" src="{{asset('storage/img/brand/app_store.png')}}" style="width: 70%;"> -->
                           <a href="https://play.google.com/store/apps/details?id=kz.diaspora&hl=ru&gl=US"> <img class="robot-img" src="{{asset('storage/img/brand/google_play.png')}}" style="width: 70%;"></a>
                           <img class="robot-img-1" src="{{asset('storage/img/brand/qr-code.gif')}}" style="width: 70%;">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="robots-block-main">
                        <div class="robots-block-text-p">
                            <h4 class="robots-block-text">Платформа для поиска и общения соотечественников за границей.</h4>
                            <p class="robots-block-p">Если Вы вдали от дома или только планируете
                                поехать за рубеж, чтобы работать, учиться,
                                проживать или путешествовать, то данное
                                приложение обязательно будет полезным для Вас.
                                Здесь Вы сможете найти Ваших
                                земляков и легче интегрироваться в общество,
                                комфортно провести время, а также спросить совета и помощи.
                                Вместе нам лучше! Расстояние нас сближает!
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
 



    <style>
        .robots-block-main {
            width: 100%;
            border-radius: 16px;
            z-index: 100001;
            color: #fff;
        }

        .robots-block-text {
            font-family: inherit;
            line-height: 1.5;
            margin-bottom: 2.5rem;
            color: #ffff;
            font-size: 27px;
            font-weight: bold;
        }

        .robots-block-p {
            font-family: inherit;
            font-weight: 600;
            margin-bottom: 3.5rem;
            color: #ffff;
            font-size: 22px;
        }

        .robot-img-1 {
            margin-bottom: 1 .5rem;
        }

        .robot-img {
            margin-bottom: 2.5rem;
        }
        @media(max-width:767px) {
            .robots-block-text {
                font-family: inherit;
                line-height: 1.5;
                margin-bottom: 1.5rem;
                color: #ffff;
                font-size: 24px;
                font-weight: bold;
            }

            .dowd {
                margin-top: -15%;
            }

            .robots-block-p {
                font-family: 'Open Sans';
                margin-bottom: 3.5rem;
                color: #ffff;
                font-size: 18px;
            }
        }
    </style>

    @endsection