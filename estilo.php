   
<?php

$url = 'https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg';
// Variáveis PHP para definir as cores de fundo
$cor_fundo_hero = "linear-gradient(to right, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.1)), url('$url')"; // Cor de fundo para a seção hero
// Variável PHP para o número de telefone do WhatsApp
$telefone_whatsapp = '(31) 98765-4321'; // Substitua pelo seu número de WhatsApp

?>


   <style>
        /* Cor de fundo do corpo da página */
       

        /* Seção Hero (destaque principal) */
        .hero-section {
            background-image: <?php echo $cor_fundo_hero; ?>;
            background-position: 50% 50%;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100%;
            width: 100%;
        }

      
    </style>