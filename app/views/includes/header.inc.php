<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $data['title'] . ' | DIT Bookstore'; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Load Bootstrap styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
    <!-- <link rel="stylesheet" href="<?php // echo $data['root'] . 'public/bootstrap/css/bootstrap.min.css'?>">  -->

    <!-- Apply custom styling. MUST APPEAR AFTER the Bootstrap css is loaded -->
    <link rel="stylesheet" href="<?php echo $data['root'] . 'public/css/layout.css'?>">
    <!-- <link rel="icon" href="demo_icon.gif" type="image/gif" sizes="16x16">  -->
</head>

<body id="myPage">
    <!-- Navigation Panel -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
                <!-- Reroutes to the Home page -->
                <a class="navbar-brand" href="<?php echo $data['root'] . 'public/home/'?>">Logo</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <!-- Show Sign In if user has not logged in. Otherwise Sign Out. -->
                <li><a href="<?php if (!$data['isLoggedIn']) { echo $data['root'] . 'public/signin/'; } else { echo $data['root'] . 'public/signout/'; } ?>"><?php if (!$data['isLoggedIn']) { echo 'SIGN IN'; } else { echo 'SIGN OUT'; } ?></a></li>
            </ul>
            </div>
        </div>
    </nav> 