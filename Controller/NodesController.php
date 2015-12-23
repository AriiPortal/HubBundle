<?php

namespace Arii\HubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Yaml\Parser;

class NodesController extends Controller
{

    public function indexAction()
    {
        return $this->render('AriiHubBundle:Nodes:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiHubBundle:Nodes:grid_toolbar.xml.twig',array(), $response );
    }
    
    // Arborescence des noeuds
    public function listAction()
    {
        $exec = $this->container->get('arii_core.exec'); 
        $date = $this->container->get('arii_core.date');
        
        $Nodes = $exec->getNodes();

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= "<rows>\n";
        $list .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        foreach ($Nodes as $node) {
            $list .= '<row id="'.$node['ID'].'" style="background-color: '.$node['COLOR'].';">';
            $list .= '<cell>'.$node['CATEGORY'].'</cell>';
            $list .= '<cell>'.$node['NAME'].'</cell>';
            $list .= '<cell>'.$node['TITLE'].'</cell>';
            $list .= '<cell>'.$node['DESCRIPTION'].'</cell>';
            $list .= '<cell>'.$node['STATUS'].'</cell>';
            $time = $date->Time2Local($node['HEARTBEAT']);
            $list .= '<cell>'.$time.'</cell>';
            $list .= '</row>';            
        } 
        $list .= "</rows>\n";
        $response->setContent( $list );
        return $response;
    }

    // Arborescence des noeuds
    public function gridAction()
    {
        $exec = $this->container->get('arii_core.exec');        
        $Nodes = $exec->getNodes();

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= "<rows>\n";
        $list .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        foreach ($Nodes as $node) {
            $list .= '<row id="'.$node['ID'].'" style="background-color: '.$color.';">';
            $list .= '<cell>'.$node['NAME'].'</cell>';
            $list .= '<cell>'.$node['CATEGORY'].'</cell>';
            $list .= '</row>';            
        } 
        $list .= "</rows>\n";
        $response->setContent( $list );
        return $response;
    }

}
