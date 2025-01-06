<?php
error_reporting(0);
ini_set("display_errors", 0 );
include 'login/painel/conn.php';
include 'login/painel/conn.php';
include 'login/painel/estilo.php';
include 'login/painel/css_de_icones.php';
include 'login/painel/config_dados.php';
include 'login/painel/funcoes.php';
include 'login/painel/menu.php';

 $icon = 'login/painel/'.$icon; 
$logo = 'login/painel/'.$logo; 

$sql_busca_config = "SELECT * FROM config";
$query_busca_config = mysqli_query($conn, $sql_busca_config);
$total_busca_config = mysqli_num_rows($query_busca_config);

while($rows_config = mysqli_fetch_array($query_busca_config)) {
    $chave  = $rows_config['chave'];
    $validade  = $rows_config['validade'];
    $link_pagamento =$rows_config['link_pagamento'];
     $preco  = $rows_config['preco'];
      $telefone  = $rows_config['telefone'];

}


$telefone_whatsapp_2 = $telefone;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?=$titulo;?></title>
    <!-- Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Landing page template for creative dashboard">
    <meta name="keywords" content="Landing page template">
    <!-- Favicon icon -->
<link rel="icon" href="<?=$icon;?>" type="image/png" sizes="16x16">
<link rel="icon" href="<?=$icon;?>" type="image/x-icon"> <!-- Para navegadores que suportam .ico -->
<link rel="apple-touch-icon" href="<?=$icon;?>" sizes="180x180"> <!-- Para dispositivos Apple -->
<link rel="shortcut icon" href="<?=$icon;?>" type="image/png"> <!-- Para navegadores antigos -->

    <!-- Bootstrap -->
    <link href="assets\css\bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,300,500,700,600" rel="stylesheet" type="text/css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="assets\css\animate.css">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="assets\css\owl.carousel.css">
    <link rel="stylesheet" href="assets\css\owl.theme.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="assets\css\magnific-popup.css">
    <!-- Full Page Animation -->
    <link rel="stylesheet" href="assets\css\animsition.min.css">
    <!-- Ionic Icons -->
    <link rel="stylesheet" href="assets\css\ionicons.min.css">
    <!-- Main Style css -->
    <link href="assets\css\style.css" rel="stylesheet" type="text/css" media="all">
 
</head>
<?php

include 'estilo.php';

?>
<body>

    <div class="wrapper animsition" data-animsition-in-class="fade-in" data-animsition-in-duration="1000" data-animsition-out-class="fade-out" data-animsition-out-duration="1000">
        <div class="container">
             <nav class="navbar navbar-expand-lg navbar-light navbar-default navbar-fixed-top" role="navigation">
                <div class="container">
<a class="navbar-brand page-scroll" href="#main">
    <img src="<?=$logo;?>" alt="Adminity Logo" style="max-width: 150px; height: auto;">
</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                       <ul class="navbar-nav mr-auto"></ul>
                        <ul class="navbar-nav my-2 my-lg-0">
                            <li class="nav-item">
                                <a class="nav-link page-scroll" href="#main">Início</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link page-scroll" href="#services">Importante</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link page-scroll" href="#features">Benefícios</a>
                            </li>
                         
                            <li class="nav-item">
                                <a class="nav-link page-scroll" href="#pricing">Preços</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link page-scroll" href="#contact">Contato</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        

  <div class="main" id="main" style="background: url('https://img.freepik.com/vetores-gratis/fundo-de-wireframe-geometrico-abstrato_52683-59421.jpg') no-repeat center center; background-size: cover;">
    <!-- Seção Principal -->
    <div class="hero-section app-hero">
        <div class="container">
            <div class="hero-content app-hero-content text-center" style="color: white;">
                <div class="row justify-content-md-center">
                    <div class="col-md-10">
<h1 class="wow fadeInUp" data-wow-delay="0s" style="color: white;">Sistema de Agendamento Inteligente com IA</h1>
                        <p class="wow fadeInUp"style="color: white;"  data-wow-delay="0.2s">
                            Simplifique sua gestão de agendamentos com nosso sistema que entende texto, áudio, imagens e muito mais. <br class="hidden-xs"> A escolha perfeita para otimizar seu atendimento.
                        </p>
                        <a class="btn btn-primary btn-action" data-wow-delay="0.2s" href="login/painel/login.php">Fazer Login</a>
                        <a class="btn btn-primary btn-action" data-wow-delay="0.2s" href="login/painel/cadastro_conta.php">Cadastrar Agora</a>
                    </div>
                    <div class="col-md-12">
                        <div class="hero-image">
                            <img class="img-fluid" src="assets/images/aapp_hero_1.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <div class="services-section text-center" id="services">

          <div class="services-section text-center" id="services">
    <!-- Services section (small) with icons -->
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="services-content">
                    <h1 class="wow fadeInUp" data-wow-delay="0s">Sistema Inteligente de Agendamentos</h1>
                    <p class="wow fadeInUp" data-wow-delay="0.2s">
                        Nosso sistema utiliza inteligência artificial para compreender áudio, texto e imagens, oferecendo agendamentos e cancelamentos de forma prática e automatizada.
                    </p>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <div class="services">
                    <div class="row">
                        <div class="col-sm-4 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="services-icon">
                                <img src="assets/logos/icon1.png" height="60" width="60" alt="Service">
                            </div>
                            <div class="services-description">
                                <h1>Reconhecimento Multimodal</h1>
                                <p>
                                    O sistema é capaz de entender comandos de áudio, texto e imagem, tornando a interação mais natural e eficiente para seus usuários.
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-4 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="services-icon">
                                <img class="icon-2" src="assets/logos/icon2.png" height="60" width="60" alt="Service">
                            </div>
                            <div class="services-description">
                                <h1>Automação Inteligente</h1>
                                <p>
                                    Realize agendamentos e cancelamentos em poucos segundos com a ajuda de nossa IA, que processa dados de forma precisa e rápida.
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-4 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="services-icon">
                                <img class="icon-3" src="assets/logos/icon3.png" height="60" width="60" alt="Service">
                            </div>
                            <div class="services-description">
                                <h1>Interface Intuitiva</h1>
                                <p>
                                    Uma plataforma moderna e de fácil uso, projetada para proporcionar a melhor experiência ao usuário, com design responsivo e funcional.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            <div class="flex-features" id="features">
                <div class="container">
                    <div class="flex-split">
                        <div class="f-left wow fadeInUp" data-wow-delay="0s">
                            <div class="left-content">
                                <img class="img-fluid" src="assets\images\feature_1.png" alt="">
                            </div>
                        </div>
                     <div class="f-right wow fadeInUp" data-wow-delay="0.2s">
    <div class="right-content">
        <h2>Assistente Inteligente para Agendamentos</h2>
        <p>
            Nosso sistema atua como um funcionário virtual, capaz de entender comandos de áudio, texto e imagens, oferecendo uma experiência prática e humanizada para gerenciar seus agendamentos.
        </p>
        <ul>
            <li><i class="ion-android-checkbox-outline"></i>Compreensão natural de linguagem.</li>
            <li><i class="ion-android-checkbox-outline"></i>Processamento eficiente e rápido.</li>
            <li><i class="ion-android-checkbox-outline"></i>Pronto para atender a qualquer momento.</li>
        </ul>
<a href="login/painel/cadastro_conta.php">
    <button class="btn btn-primary btn-action btn-fill">Cadastre Agora</button>
</a>
    </div>
</div>

                    
                </div>
            </div>
          
            <!-- Feature Image Big -->
            
       
                  <div style="white-space: pre-line;">
   
</div>

         
            <!-- Pricing Section -->
           <?php
// Variáveis PHP para customizar o conteúdo
$imagem_cart = 'assets/logos/cart2.png'; // Caminho da imagem
$link_compra = 'login/painel/cadastro_conta.php'; // Link do botão de compra
?>

<!-- Seção de Preços -->
<!-- Seção de Preços -->
<!-- Seção de Preços -->
<div class="pricing-section no-color text-center" id="pricing">
    <div class="container">
        <div class="row justify-content-center"> <!-- Centraliza o conteúdo -->
            <div class="col-md-6"> <!-- Define a largura da coluna -->
                <div class="table-left wow fadeInUp" data-wow-delay="0.4s">
                    <div class="icon text-center">
                        <!-- Exibe a imagem dinamicamente -->
                        <img src="<?php echo $imagem_cart; ?>" alt="Ícone" style="max-width: 100px;">
                    </div>
                    <div class="pricing-details text-center">
                        <h2>Plano Premium</h2>
                        <!-- Exibe o preço dinamicamente -->
                        <span><?php echo $preco; ?></span>
                        <p>
                            Garanta acesso completo ao sistema com benefícios exclusivos:
                        </p>
                        <ul>
                            <li><i class="ion-android-checkbox-outline"></i> Atendimento humanizado com inteligência artificial.</li>
                            <li><i class="ion-android-checkbox-outline"></i> Reconhecimento de texto, áudio, imagens e contatos.</li>
                            <li><i class="ion-android-checkbox-outline"></i> Gerenciamento completo de datas e agendas.</li>
                            <li><i class="ion-android-checkbox-outline"></i> Suporte para profissionais ilimitados.</li>
                            <li><i class="ion-android-checkbox-outline"></i> Cadastro de clientes ilimitados.</li>
                            <li><i class="ion-android-checkbox-outline"></i> Sistema de lembretes automáticos para agendamentos.</li>
                        </ul>
                        <!-- Botão com link dinâmico -->
                        <a href="<?php echo $link_compra; ?>" class="btn btn-primary btn-action btn-fill">Assinar Agora</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


            <!-- Client Section -->
           




<!-- Seção de Contato via WhatsApp -->
<div class="cta-sub text-center no-color">
    <div class="container" id="contact">
        <br><br><br><br><br><br>
        <h1 class="wow fadeInUp" data-wow-delay="0s" style="font-size: 36px; color: #0073AA;">Precisa de ajuda? Fale conosco no WhatsApp!</h1>
        <p class="wow fadeInUp" data-wow-delay="0.2s" style="font-size: 18px; color: #333;">
            Estamos disponíveis para responder suas dúvidas ou fornecer mais informações. Clique no botão abaixo para falar diretamente conosco via WhatsApp.
        </p>
        <div class="wow fadeInUp" data-wow-delay="0.4s">
            <a href="https://wa.me/<?php echo str_replace(['(', ')', ' ', '-'], '', $telefone_whatsapp_2); ?>" target="_blank">
                <button class="btn btn-primary btn-action btn-fill" style="font-size: 20px; padding: 10px 20px; background-color: #25D366; border-color: #25D366; color: #0073AA;">
                    <i class="ion ion-social-whatsapp" style="font-size: 24px; margin-right: 10px;"></i> Fale pelo WhatsApp
                </button>
            </a>
        </div>
        <p class="wow fadeInUp" data-wow-delay="0.5s" style="font-size: 16px; color: #666;">
            Nosso número de contato: <strong><?php echo $telefone_whatsapp_2; ?></strong>
        </p>
    </div>
</div>


<!-- Seção de Rodapé -->
<div class="footer">
    <div class="container">
        <div class="col-md-12 text-center">
<div style="text-align: center;">
    <img src="<?=$logo;?>" alt="Adminity Logo" style="max-width: 150px; height: auto;">
</div>
            <ul class="footer-menu">
               
            </ul>
            <div class="footer-text">
                <p>
                    Copyright © 2024. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </div>
</div>

            <!-- Scroll To Top -->
            <a id="back-top" class="back-to-top page-scroll" href="#main">
                <i class="ion-ios-arrow-thin-up"></i>
            </a>
            <!-- Scroll To Top Ends-->
        </div>
        <!-- Main Section -->
    </div>
    <!-- Wrapper-->

    <!-- Jquery and Js Plugins -->
    <script type="text/javascript" src="assets\js\jquery-2.1.1.js"></script>
    <script type="text/javascript" src="assets\js\bootstrap.min.js"></script>
    <script type="text/javascript" src="assets\js\plugins.js"></script>
    <script type="text/javascript" src="assets\js\menu.js"></script>
    <script type="text/javascript" src="assets\js\custom.js"></script>
</body>

</html>
