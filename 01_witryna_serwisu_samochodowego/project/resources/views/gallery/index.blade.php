<x-app-layout>
    <style>
        *, *:after, *:before {
            padding:0;
            margin:0;
            font-family:Arial;
        }
        ul {
            position:absolute;
            top:0;
            bottom:0;
            left:0;
            right:0;
            margin:auto;
            list-style:none;
            width:1250px;
            height:450px;
            border-radius:3px;
            overflow:hidden;
            box-shadow:1px 1px 3px 1px;
        }
        li {
            position:relative;
            width:250px;
            height:450px;
            float:left;
            border-left:1px solid white;
            -webkit-transition:all 0.7s;
            -moz-transition:all 0.7s;
            transition:all 0.7s;
            box-shadow:-2px 0 10px 2px;
        }
        ul li:first-child {
            border:none;
        }
        img {
            width:800px;
            height:450px;
            filter: grayscale(1);
        }
        img:hover{
            filter: grayscale(0);
        }
        ul:hover li {
            width:125px;
        }
        ul li:hover {
            width:750px;
        }
    </style>
    {{-- adapted from resources/views/components/auth-card.blade.php --}}
    <ul>
        <li>
            <img src='staticImages/Obrazek1.jpg'/></li>
        <li>
            <img src='staticImages/Obrazek2.jpg'/></li>
        <li>
            <img src='staticImages/Obrazek3.jpg'/></li>
        <li>
            <img src='staticImages/Obrazek4.jpg'/></li>
        <li>
            <img src='staticImages/Obrazek5.jpg'/></li>
    </ul>

</x-app-layout>
