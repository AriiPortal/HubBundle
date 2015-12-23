<?php

namespace Arii\HubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class NodeController extends Controller
{

    public function indexAction()
    {
        return $this->render('AriiHubBundle:Node:index.html.twig');
    }

    public function cronAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->query->get( 'id' );
        
        $exec = $this->container->get('arii_core.exec');        
        $crontab = $exec->ExecNodeID($id, "crontab -l");

        $cron = $this->container->get('arii_core.cron');        
        $Infos = $cron->Tab2Array($crontab);
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= "<rows>\n";
        $list .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        foreach ($Infos as $info) {
            $list .='<row>';
            $list .='<cell>'.$info['min'].'</cell>';
            $list .='<cell>'.$info['hour'].'</cell>';
            $list .='<cell>'.$info['wday'].'</cell>';
            $list .='<cell>'.$info['mon'].'</cell>';
            $list .='<cell>'.$info['mday'].'</cell>';
            $list .='<cell>'.$info['task'].'</cell>';
            $list .='<cell>'.$info['stdout'].'</cell>';
            $list .='<cell>'.$info['stderr'].'</cell>';            
            $list .='<cell>'.$info['append'].'</cell>';
            $list .='<cell><![CDATA['.$info['comment'].']]></cell>';
            $list .='</row>';
            $rem = '';
        }        
        $list .= "</rows>\n";  
        $response->setContent( $list );
        return $response;
    }

    public function checkAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->query->get( 'id' );
        
        $exec = $this->container->get('arii_core.exec');
        $check = $exec->ExecNodeID($id, "hostname");
        
        print $check;
        exit();
    }
    
    public function fileAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->query->get( 'id' );
        $file = $request->query->get( 'file' );
        
        $exec = $this->container->get('arii_core.exec');   
        $script = $exec->ExecNodeID($id, "cat $file");

        print '<pre>'.$script.'</pre>';
        exit();
    }
    
}
