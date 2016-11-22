<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
        <meta http-equiv="X-UA-Compatible" content="IE=10">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Chatelet</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
         <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

        

    <!-- Bootstrap -->
    <?php
      echo $this->Html->css('bootstrap.min');
      echo $this->Html->css('bootstrap');
      echo $this->Html->css('bootstrapValidator.min');
      echo $this->Html->css('jquery.growl');
      echo $this->Html->css('animate');
      echo $this->Html->css('custom');
      echo $this->Html->css('chatelet'); 

    
      
      echo $this->fetch('meta');
      echo $this->fetch('css');
      echo $this->Html->script('vendor/modernizr-2.8.3.min.js');
      echo $this->fetch('script');
    ?>


  </head>
  <body>
