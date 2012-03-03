<?php

require_once __DIR__.'/silex.phar';

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;



$app = new Silex\Application();


$app->register(new Silex\Extension\TwigExtension(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/vendor/twig/lib',
));


$app->get('/', function () use ($app) {
    
    return $app['twig']->render('home.twig', array(
        'title' => 'Generador aleatorio',
    ));    
   
});


$app->get('/random', function () use ($app) {

    $request = $app['request'];
   
    $from = $request->get('Desde');
    $to = $request->get('Hasta');
    $howmany = $request->get('Cuantos');
   
    if ((( $to-$from) < ($howmany - 1 )))
    {        
            return $app['twig']->render('error.twig', array(
           'title' => 'Error - Mal - Wrong!',     
           'error' =>'Con estos parámetros, no se puede ejecutar la tarea, alma de Dios. '
            ));
              
        }
    
    $results = array();
    $got =0;
    
    while ($got   < $howmany)
    {
        $num = mt_rand($from,$to);

             if ( !in_array($num, $results) )                
                {
                
                array_push($results,$num);
                $got++;        
            
                } 
    }
    
    return $app['twig']->render('random.twig', array(
        'title' => 'Resultado',
        'results' => $results,
        'from' => $from,
        'to' => $to,
        'howmany' => $howmany
    ));
});

   $app->run();
   
?>
