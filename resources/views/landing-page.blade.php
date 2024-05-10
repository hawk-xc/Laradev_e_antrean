<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tailwind Starter Template - App Landing Page Template: Tailwind Toolbox</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Font Awesome if you need it
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
 -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">

    <!-- Animation CSS-->
    <style>
        /* ----------------------------------------------
  * Generated by Animista
  * w: http://animista.net, t: @cssanimista
  * ---------------------------------------------- */

        .slide-in-bottom {
            -webkit-animation: slide-in-bottom .5s cubic-bezier(.25, .46, .45, .94) both;
            animation: slide-in-bottom .5s cubic-bezier(.25, .46, .45, .94) both
        }

        .slide-in-bottom-h1 {
            -webkit-animation: slide-in-bottom .5s cubic-bezier(.25, .46, .45, .94) .5s both;
            animation: slide-in-bottom .5s cubic-bezier(.25, .46, .45, .94) .5s both
        }

        .slide-in-bottom-subtitle {
            -webkit-animation: slide-in-bottom .5s cubic-bezier(.25, .46, .45, .94) .75s both;
            animation: slide-in-bottom .5s cubic-bezier(.25, .46, .45, .94) .75s both
        }

        .fade-in {
            -webkit-animation: fade-in 1.2s cubic-bezier(.39, .575, .565, 1.000) 1s both;
            animation: fade-in 1.2s cubic-bezier(.39, .575, .565, 1.000) 1s both
        }

        .bounce-top-icons {
            -webkit-animation: bounce-top .9s 1s both;
            animation: bounce-top .9s 1s both
        }

        @-webkit-keyframes slide-in-bottom {
            0% {
                -webkit-transform: translateY(1000px);
                transform: translateY(1000px);
                opacity: 0
            }

            100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                opacity: 1
            }
        }

        @keyframes slide-in-bottom {
            0% {
                -webkit-transform: translateY(1000px);
                transform: translateY(1000px);
                opacity: 0
            }

            100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                opacity: 1
            }
        }

        @-webkit-keyframes bounce-top {
            0% {
                -webkit-transform: translateY(-45px);
                transform: translateY(-45px);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in;
                opacity: 1
            }

            24% {
                opacity: 1
            }

            40% {
                -webkit-transform: translateY(-24px);
                transform: translateY(-24px);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in
            }

            65% {
                -webkit-transform: translateY(-12px);
                transform: translateY(-12px);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in
            }

            82% {
                -webkit-transform: translateY(-6px);
                transform: translateY(-6px);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in
            }

            93% {
                -webkit-transform: translateY(-4px);
                transform: translateY(-4px);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in
            }

            25%,
            55%,
            75%,
            87% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out
            }

            100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
                opacity: 1
            }
        }

        @keyframes bounce-top {
            0% {
                -webkit-transform: translateY(-45px);
                transform: translateY(-45px);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in;
                opacity: 1
            }

            24% {
                opacity: 1
            }

            40% {
                -webkit-transform: translateY(-24px);
                transform: translateY(-24px);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in
            }

            65% {
                -webkit-transform: translateY(-12px);
                transform: translateY(-12px);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in
            }

            82% {
                -webkit-transform: translateY(-6px);
                transform: translateY(-6px);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in
            }

            93% {
                -webkit-transform: translateY(-4px);
                transform: translateY(-4px);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in
            }

            25%,
            55%,
            75%,
            87% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out
            }

            100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
                opacity: 1
            }
        }

        @-webkit-keyframes fade-in {
            0% {
                opacity: 0
            }

            100% {
                opacity: 1
            }
        }

        @keyframes fade-in {
            0% {
                opacity: 0
            }

            100% {
                opacity: 1
            }
        }
    </style>

</head>


<body class="leading-normal tracking-normal text-gray-900" style="font-family: 'Source Sans Pro', sans-serif;">



    <div class="h-screen bg-right bg-cover pb-14"
        style="background-image:url('https://lh3.googleusercontent.com/drive-viewer/AKGpihYK-Z4JsN2Jxk1tUj665OM0Ny8bo3EUXhdX-S2J1_DnIO-xUDTBldI2MpeAx0CVOWx_lqDZJj2jtGn0IXNZ6qVab8loAbJN9tU=s2560');">
        <!--Nav-->
        <div class="container w-full p-6 mx-auto">

            <div class="flex items-center justify-between w-full">
                <img src="{{ asset('images/logo.png') }}" alt="" class="w-40">

                <div class="flex content-center justify-end w-1/2">
                    <a class="inline-block h-10 p-2 text-center text-blue-300 no-underline hover:text-indigo-800 hover:text-underline md:h-auto md:p-4"
                        data-tippy-content="@twitter_handle" href="https://twitter.com/intent/tweet?url=#">
                        <svg class="h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                            <path
                                d="M30.063 7.313c-.813 1.125-1.75 2.125-2.875 2.938v.75c0 1.563-.188 3.125-.688 4.625a15.088 15.088 0 0 1-2.063 4.438c-.875 1.438-2 2.688-3.25 3.813a15.015 15.015 0 0 1-4.625 2.563c-1.813.688-3.75 1-5.75 1-3.25 0-6.188-.875-8.875-2.625.438.063.875.125 1.375.125 2.688 0 5.063-.875 7.188-2.5-1.25 0-2.375-.375-3.375-1.125s-1.688-1.688-2.063-2.875c.438.063.813.125 1.125.125.5 0 1-.063 1.5-.25-1.313-.25-2.438-.938-3.313-1.938a5.673 5.673 0 0 1-1.313-3.688v-.063c.813.438 1.688.688 2.625.688a5.228 5.228 0 0 1-1.875-2c-.5-.875-.688-1.813-.688-2.75 0-1.063.25-2.063.75-2.938 1.438 1.75 3.188 3.188 5.25 4.25s4.313 1.688 6.688 1.813a5.579 5.579 0 0 1 1.5-5.438c1.125-1.125 2.5-1.688 4.125-1.688s3.063.625 4.188 1.813a11.48 11.48 0 0 0 3.688-1.375c-.438 1.375-1.313 2.438-2.563 3.188 1.125-.125 2.188-.438 3.313-.875z">
                            </path>
                        </svg>
                    </a>
                    <a class="inline-block h-10 p-2 text-center text-blue-300 no-underline hover:text-indigo-800 hover:text-underline md:h-auto md:p-4 "
                        data-tippy-content="#facebook_id" href="https://www.facebook.com/sharer/sharer.php?u=#">
                        <svg class="h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                            <path d="M19 6h5V0h-5c-3.86 0-7 3.14-7 7v3H8v6h4v16h6V16h5l1-6h-6V7c0-.542.458-1 1-1z">
                            </path>
                        </svg>
                    </a>
                </div>

            </div>

        </div>

        <!--Main-->
        <div class="container flex flex-col flex-wrap items-center px-6 pt-20 mx-auto md:flex-row">

            <!--Left Col-->
            <div class="flex flex-col justify-center w-full overflow-y-hidden xl:w-2/5 lg:items-start md:pl-20">
                <h1
                    class="my-4 text-2xl font-bold leading-tight text-center text-purple-800 md:text-5xl md:text-left slide-in-bottom-h1">
                    Service komputer berbasis digital</h1>
                <p class="mb-8 text-base leading-normal text-center md:text-xl md:text-left slide-in-bottom-subtitle">
                    Jadilah pengguna digital, Temukan kemudahan layanan komputer dengan sekali sign in. Service komputer
                    jadi jelas dan berkualitas.
                </p>

                <p class="pb-8 font-bold text-center text-blue-400 lg:pb-6 md:text-left fade-in">Register dengan google
                    akun :</p>
                <div class="flex justify-center w-full pb-24 md:w-36 md:justify-start lg:pb-0 fade-in">
                    <a href="auth/google/redirect" class="w-full text-xl btn btn-outline hover:bg-slate-50">
                        <img src="https://www.gstatic.com/images/branding/googlelogo/svg/googlelogo_clr_74x24px.svg"
                            alt="Google Logo" class="w-max h-7">
                    </a>
                </div>

            </div>

            <!--Right Col-->
            <div class="w-full py-6 overflow-y-hidden xl:w-3/5 md:pr-20">
                {{-- <img class="" src="{{ asset('images/devices.svg') }}"> --}}

                <svg class="w-5/6 mx-auto lg:mr-0 slide-in-bottom" width="897px" height="452px" viewBox="0 0 897 452"
                    version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <!-- Generator: Sketch 3.0.4 (8054) - http://www.bohemiancoding.com/sketch -->
                    <title>IPAD 2</title>
                    <desc>Created with Sketch.</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                        sketch:type="MSPage">
                        <g id="IPAD" sketch:type="MSLayerGroup" transform="translate(681.000000, 55.000000)"
                            stroke="#7E89A3">
                            <path
                                d="M202.986,317 L12.097,317 C5.462,317 0.083,311.623 0.083,304.99 L0.083,12.093 C0.083,5.46 5.461,0.083 12.097,0.083 L202.986,0.083 C209.622,0.083 215,5.46 215,12.093 L215,304.99 C215,311.623 209.622,317 202.986,317 Z"
                                id="bezel" stroke-width="2" fill="#FDFDFD" sketch:type="MSShapeGroup"></path>
                            <path
                                d="M202.986,317 L12.097,317 C5.462,317 0.083,311.623 0.083,304.99 L0.083,12.093 C0.083,5.46 5.461,0.083 12.097,0.083 L202.986,0.083 C209.622,0.083 215,5.46 215,12.093 L215,304.99 C215,311.623 209.622,317 202.986,317 Z"
                                id="bezel-2" stroke-width="2" fill="#FDFDFD" sketch:type="MSShapeGroup"></path>
                            <rect id="screen" fill="#FFFFFF" sketch:type="MSShapeGroup" x="17" y="32" width="181.999"
                                height="252.917"></rect>
                            <circle id="lock" sketch:type="MSShapeGroup" cx="108.021" cy="300.021" r="8.021">
                            </circle>
                            <circle id="camera" sketch:type="MSShapeGroup" cx="106.99" cy="16.99" r="2.99">
                            </circle>
                        </g>
                        <g id="Laptop" sketch:type="MSLayerGroup" transform="translate(1.000000, 1.000000)"
                            stroke="#8492A5">
                            <path
                                d="M594,0 L98,0 C84.50415,0 73,11.0738184 73,24.7901127 L73,351.027995 L619,351.027985 L619,24.7901127 C618.999971,11.0728209 607.537479,0 594,0 Z"
                                id="bezel" stroke-width="2" fill="#FEFEFE" sketch:type="MSShapeGroup"></path>
                            <circle id="webcam" stroke-width="2" sketch:type="MSShapeGroup" cx="347"
                                cy="19" r="4"></circle>
                            <g id="bottom" transform="translate(0.000000, 351.000000)" sketch:type="MSShapeGroup">
                                <path
                                    d="M640.812,31.01 L51.288,31.01 C20.641,31.01 0,20.494 0,16.022 L0,2.428 C0,1.084 1.335,0 2.995,0 L689.104,0 C690.766,0 692.103,1.084 692.103,2.428 L692.103,16.557 C692.096,20.092 676.112,31.01 640.812,31.01 Z"
                                    id="Shape" stroke-width="2" fill="#FDFDFD"></path>
                                <path d="M0.5,14.5 L690.242676,14.5" id="Line" stroke-linecap="square"></path>
                            </g>
                            <rect id="screen" fill="#FFFFFF" sketch:type="MSShapeGroup" x="95" y="39"
                                width="501.073853" height="292.009"></rect>
                            <path
                                d="M421,352 L421,355.087 C421,357.288 416.666719,357.952714 413.386719,357.952714 L278.815286,357.952714 C275.364286,357.952714 271,357.289 271,355.087 L271,352"
                                id="touchpad" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                        </g>
                        <g id="iphone" sketch:type="MSLayerGroup" transform="translate(576.000000, 177.000000)"
                            stroke="#7E89A3">
                            <path
                                d="M130,257.964 C130,266.797 122.809,273.956 113.938,273.956 L16.063,273.956 C7.192,273.956 0.001,266.797 0.001,257.964 L0.001,16.073 C0.001,7.24 7.192,0.081 16.063,0.081 L113.938,0.081 C122.809,0.081 130,7.24 130,16.073 L130,257.964 L130,257.964 Z"
                                id="bezel" stroke-width="2" fill="#FDFDFD" sketch:type="MSShapeGroup"></path>
                            <rect id="screen" fill="#FFFFFF" sketch:type="MSShapeGroup" x="9" y="36"
                                width="111.93" height="199.084"></rect>
                            <path
                                d="M77,25.746 C77,26.381 76.561,26.893 76.02,26.893 L55.918,26.893 C55.376,26.893 54.938,26.38 54.938,25.746 L54.938,23.166 C54.938,22.531 55.377,22.019 55.918,22.019 L76.02,22.019 C76.561,22.019 77,22.532 77,23.166 L77,25.746 L77,25.746 Z"
                                id="speaker" sketch:type="MSShapeGroup"></path>
                            <circle id="camera" sketch:type="MSShapeGroup" cx="66" cy="12" r="3">
                            </circle>
                            <ellipse id="lock" sketch:type="MSShapeGroup" cx="65.04" cy="254.001"
                                rx="10.04" ry="10.001"></ellipse>
                        </g>
                    </g>
                </svg>
            </div>

            <!--Footer-->
            <div class="w-full pt-16 pb-6 text-sm text-center md:text-left fade-in md:pl-20">
                <a class="text-gray-500 no-underline hover:no-underline" href="#">&copy; Team Sistem Informasi E
                    Antrean</a>
            </div>

        </div>


    </div>


    <!-- jQuery if you need it
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  -->

</body>

</html>
