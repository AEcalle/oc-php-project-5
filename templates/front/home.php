<?php

ob_start();

?>
<!-- Page Header-->
<header class="masthead" style="background-image: url('../../public/assets/img/home-bg.jpg')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>Aurélien Ecalle</h1>
                    <span class="subheading">Le développeur qu'il vous faut !</span>
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
                <a href="post.html">
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
                <a href="post.html">
                    <h2 class="post-title">Titre d'un article</h2>
                    <h3 class="post-subtitle">Chapô</h3>
                </a>
                <p class="post-meta">
                    Publié par
                    <a href="#!">Aurélien Ecalle</a>
                    16/08/2021
                </p>
            </div>                    
            <!-- Pager-->
            <div class="d-flex justify-content-end mb-4"><a class="btn btn-primary text-uppercase" href="#!">Tous les Posts →</a></div>
        </div>
    </div>
    <div class="row gx-4 gx-lg-5 py-5 justify-content-center border-top">
        <div class="col-md-10 col-lg-8 col-xl-7">
            <h2>Contact</h2>
            <form id="contactForm" method="post">
                <div class="form-floating">
                    <input class="form-control" id="name" type="text" placeholder="Nom et prénom" required />
                    <label for="name">Nom Prénom</label>                            
                </div>
                <div class="form-floating">
                    <input class="form-control" id="email" type="email" placeholder="Email" required />
                    <label for="email">Email</label>                            
                </div>      
                <div class="form-floating">
                    <textarea class="form-control" id="message" placeholder="Message" style="height: 12rem" required></textarea>
                    <label for="message">Message</label>                            
                </div>                                               
                <button class="btn btn-primary my-5 text-uppercase" id="submitButton" type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</div>

<?php 

$content = ob_get_clean();

require('template.php');
       
