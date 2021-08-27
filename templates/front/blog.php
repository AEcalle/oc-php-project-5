<?php

ob_start();

?>

<!-- Page Header-->
<header class="masthead" style="background-image: url('assets/img/home-bg.jpg')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>Blog</h1>
                    <span class="subheading">Les actus du développement web</span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content-->
<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            <!-- Post preview-->
            <div class="post-preview">
                <a href="post.php">
                    <h2 class="post-title">Titre d'un article</h2>
                    <h3 class="post-subtitle">Chapô</h3>
                </a>
                <p class="post-meta">
                    Publié par
                    <a href="#!">Aurélien Ecalle</a>
                    16/08/2021
                </p>
            </div>
            <!-- Divider-->
            <hr class="my-4" />
            <!-- Post preview-->
            <div class="post-preview">
                <a href="post.php">
                    <h2 class="post-title">Titre d'un article</h2>
                    <h3 class="post-subtitle">Chapô</h3>
                </a>
                <p class="post-meta">
                    Publié par
                    <a href="#!">Aurélien Ecalle</a>
                    16/08/2021
                </p>
            </div>
            <!-- Post preview-->
            <div class="post-preview">
                <a href="post.php">
                    <h2 class="post-title">Titre d'un article</h2>
                    <h3 class="post-subtitle">Chapô</h3>
                </a>
                <p class="post-meta">
                    Publié par
                    <a href="#!">Aurélien Ecalle</a>
                    16/08/2021
                </p>
            </div>
            <!-- Post preview-->
            <div class="post-preview">
                <a href="post.php">
                    <h2 class="post-title">Titre d'un article</h2>
                    <h3 class="post-subtitle">Chapô</h3>
                </a>
                <p class="post-meta">
                    Publié par
                    <a href="#!">Aurélien Ecalle</a>
                    16/08/2021
                </p>
            </div>                    
            
        </div>
    </div>
</div>

<?php 

$content = ob_get_clean();

require('template.php');