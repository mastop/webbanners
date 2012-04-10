<?php
namespace Banner\OrderBundle\Controller\Frontend;

use Mastop\SystemBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Request;
use Banner\OrderBundle\Form\Frontend\OrderType;
use Banner\OrderBundle\Form\Frontend\UploadType;
use Banner\OrderBundle\Form\Frontend\TalkType;
use Banner\UserBundle\Form\Frontend\UserForm;
use Banner\UserBundle\Document\User;
use Banner\OrderBundle\Document\Order;
use Banner\OrderBundle\Document\Talk;
use Banner\OrderBundle\Document\Status;
use Banner\OrderBundle\Document\StatusLog;
use Banner\OrderBundle\Document\Upload;
use Banner\OrderBundle\Document\Banner;

class OrderController extends BaseController
{ 
    /**
     * @Route("/novo", name="_order_order_index")
     * @Template()
     */
    public function indexAction()
    {                      
        $order = new Order();
        $upload = new Upload();
        $user = new User();
        $order->setQuantity(1);
        
        $formOrder = $this->createForm(new OrderType(), $order);
        $formUpload = $this->createForm(new UploadType(), $upload);
        $formUser = $this->createForm(new UserForm(), $user);
        
        return array(
                        'formOrder'  => $formOrder->createView(), 
                        'formUpload' => $formUpload->createView(), 
                        'formUser'   => $formUser->createView(), 
                    );
     }
     
    /**
     * @Route("/designer/{username}", name="_order_order_design", defaults={"username" = ""}
     * )
     * @Template()
     */
    public function designAction($username)
    {   
        $i=0;
        $orders = array();
        $clients = array();
        if($username){
            $user = $this->mongo('BannerUserBundle:User')->findByUsername($username);
        }else{
            $user = $this->get('security.context')->getToken()->getUser();
        }
        if($user == $this->get('security.context')->getToken()->getUser() || ($this->get('security.context')->isGranted('ROLE_SUPERADMIN'))){
            $orders = $this->mongo('BannerOrderBundle:Order')->findUserByDesigner($user);
            foreach($orders as $order){
                if (!in_array($order->getUser(), $clients)) { 
                    $i++;
                    $clients[$i][0] = $order->getUser()->getUsername(); 
                    $clients[$i][1] = $order->getDunread(); 
                }
                else
                {
                    $clients[array_search($order->getUser(), $clients)] += 1;
                }
            }
            //exit(var_dump($clients));
        }
        return array(
                        'clients' => $clients,
                        'orders'  => $orders
                    );
     }
     
    /**
     * @Route("/admin", name="_order_order_admin")
     * @Template()
     */
    public function adminAction()
    {   
        $dm = $this->get('doctrine.odm.mongodb.document_manager');  
        $request = $this->get('request');
        if ($this->get('security.context')->isGranted('ROLE_SUPERADMIN')) {
            $orders = $this->mongo("BannerOrderBundle:Order")->findUnsets();
            $designers = $this->mongo("BannerUserBundle:User")->findBy(array('roles'=>'ROLE_DESIGNER'));
            if ('POST' == $request->getMethod()) {
                foreach($orders as $order){
                    $designer = $this->mongo("BannerUserBundle:User")->findOneById($request->get($order->getId()));
                    $order->setDesigner($designer);
                    $dm->persist($order);
                    $dm->flush();
                }
            }
        }
        else{
            return $this->redirectFlash($this->generateUrl('_home'), "Você não está autorizado para acessar essa página.");
        }
        return array(
                        'orders'  => $orders,
                        'designers'  => $designers
                    );
     }
     
    /**
     * @Route("/cliente/{username}", name="_order_order_client",  defaults={"username" = ""})
     * @Template()
     */
    public function clientAction($username)
    {       
        if($username){
            $user = $this->mongo('BannerUserBundle:User')->findByUsername($username);
            $designer = $this->get('security.context')->getToken()->getUser();
            $orders = $this->mongo('BannerOrderBundle:Order')->findByDesignerUser($designer,$user);
            if(!$orders && ($this->get('security.context')->isGranted('ROLE_SUPERADMIN'))){
                $orders = $this->mongo('BannerOrderBundle:Order')->findByUser($user);
            }
        }else{
            $user = $this->get('security.context')->getToken()->getUser();
            $orders = $this->mongo('BannerOrderBundle:Order')->findByUser($user);
        }
        
        return array(
                        'orders'  => $orders
                    );
     }
     
    /**
     * @Route("/detalhes/{username}-{name}", name="_order_order_edit",  defaults={"username" = null,"name" = null})
     * @Template()
     */
    public function editAction($username= null,$name=null)
    {           
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $request = $this->get('request');
        
        $user = $this->mongo('BannerUserBundle:User')->findByUsername($username);
        $order = $this->mongo('BannerOrderBundle:Order')->findByNameUser($name,$user);
        if ($this->get('security.context')->getToken()->getUser() == $order->getDesigner()) {
            $order->setDunread(0);
        }elseif ($this->get('security.context')->getToken()->getUser() == $order->getUser()) {
            $order->setCunread(0);
        }
        else{
            return $this->redirectFlash($this->generateUrl('_home'), "Você não está autorizado para acessar essa página.");
        }
        $dm->persist($order);
        $dm->flush();
            
        $talk = new Talk();
        $upload = new Upload();
        
        $formTalk  = $this->createForm(new TalkType(), $talk);
        $formUpload  = $this->createForm(new UploadType(), $upload);
        $formUpload1  = $request->files->get("upload");
        
        if ('POST' == $request->getMethod()) {
            $request = $this->get('request');
            $formTalk->bindRequest($request);
            if ($formTalk->isValid()) {
                $talker = $this->get('security.context')->getToken()->getUser();
                $talk->setUser($talker);
                if ($talker == $order->getUser()) {
                    $order->setDunread($order->getDunread()+1);
                }elseif ($talker ==  $order->getDesigner()) {
                    $order->setCunread($order->getCunread()+1);
                }else{
                    $order->setDunread($order->getDunread()+1);
                    $order->setCunread($order->getCunread()+1);
                }
                $dm->persist($talk);
                $dm->flush();
                foreach ($formUpload1 as $upload1){
                    $upload = new Upload();
                    $upload->setUniqpath('order/'.$talker->getUsername().'/talker/');
                    $upload->setFile($upload1);
                    $dm->persist($upload);
                    $talk->addUpload($upload);
                }
                
                $order->addTalk($talk);
                $dm->persist($order);
                $dm->flush();
                return $this->redirectFlash($this->generateUrl('_order_order_edit',array("username"=>($order->getUser()->getUsername()), "name"=>$order->getName())), "Comentário Salvo");
            }
            
        }
        
        return array(
                        'formTalk'  => $formTalk->createView(), 
                        'formUpload'  => $formUpload->createView(), 
                        'order'  => $order,
                        'user'  => $user
                    );
     }
    
     /**
     * @Route("/save", name="_order_order_save")
     * @Template()
     */
    public function saveAction(Request $request){
        
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
            
        $formUser = $request->request->get('Userform');
        $formOrder = $request->request->get('order');
        $formBanner = $request->request->get('banner');
        $formUpload = $request->request->get('upload');
        
        $upload = new Upload();
        $formUpload = $this->createForm(new UploadType(), $upload);
        $formUpload->bindRequest($request); 
        
        if(($formUser["email"] && !$formUser) || !$formOrder || !$formUpload){
            $msg = "Problemas no cadastro, favor conferir.";
            return $this->redirectFlash($this->generateUrl('_order_order_index'), $msg);
        }
        //exit(var_dump($formUpload));
        
        if($this->get('security.context')->isGranted("ROLE_USER") ){
            $user = $this->get('security.context')->getToken()->getUser();
        }
        else
        {
            $user = $this->mongo('BannerUserBundle:User')->findByEmail($formUser["email"]);

            if($user){
                $msg = "E-mail já cadastrado. Efetue o login para solicitar um novo pedido.";
                return $this->redirectFlash($this->generateUrl('_order_order_index'), $msg);
            }

            $user = new User();
            $user->setRoles("ROLE_USER");
            $user->setEmail($formUser["email"]);
            $user->setUsername(str_replace(".", "", str_replace("@", "", $formUser["email"])));
            $user->setName(str_replace(".", "", str_replace("@", "", $formUser["email"])));
            $user->setMailOk(true);
            $user->setStatus(1);
            $user->setCreated(new \DateTime());
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
            $password = $this->random(8);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
            $dm->persist($user);
            $dm->flush();
            $mail = $this->get('mastop.mailer');
            $mail->to($formUser["email"])
                ->subject('Senha gerada - WebBanners')
                ->template('usuario_senhagerada', array('user' => $user,'password'=>$password, 'title' => 'Senha de acesso.'))
                ->send();
            $mail->notify('Senha de acesso', 'A Senha do usuário '.$user->getEmail().' foi enviada com sucesso.');
            
        }
        $upload->setUniqpath('order/'.$user->getUsername().'/');
        
        $status = $this->mongo('BannerOrderBundle:Status')->findOneById(1);
        $statusLog = new StatusLog();
        $statusLog->setStatus($status);
        $statusLog->setUser($user);
        $dm->persist($statusLog);
               
        $order = new Order();
        foreach($formBanner as $fBanner){
            $banner = new Banner();
            $banner->setHeight($fBanner['height']);
            
            $banner->setWidth($fBanner['width']);
            if(sizeof($fBanner)==3){
                $banner->setPsd($fBanner['psd']);
            }
            $order->addBanner($banner);
        }
        //exit(var_dump($order));
                
        $order->setUser($user);
        $order->addUpload($upload);
        $order->setStatus($status);
        $order->addStatusLog($statusLog);
        $order->setName($formOrder['name']);
        $order->setNotes($formOrder['notes']);
        $order->setQuantity($formOrder['quantity']);
        $order->setCunread(0);
        $order->setDunread(0);
        $dm->persist($order);
        $dm->flush();
        
        $mail = $this->get('mastop.mailer');
        
        $mail->to("hideaki.kume@uol.com.br")
            ->subject('Pedido enviado com Sucesso')
            ->template('usuario_novasenha', array('user' => $user, 'title' => 'Pedido enviado com sucesso.'))
            ->send();
        $mail->notify('Pedido solicitado', 'Um pedido foi enviado por '.$user->getEmail(),'leonardo@mastop.com.br');

        //autologin
        $token = new UsernamePasswordToken(     $user,    null,     'main',     array('ROLE_USER'));
        $this->container->get('security.context')->setToken($token);  
        
        $msg = "Pedido efetuado com sucesso!";
        return $this->redirectFlash($this->generateUrl('_order_order_index'), $msg);
        
     }
     
     public function random($quantidade){ 
        $caracteresAceitos = 'abcdefghijklmnopqrstuvxwyz';
        $caracteresAceitos .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $caracteresAceitos .= '0123456789';
        $max = strlen($caracteresAceitos)-1;
        $random = null;
        for($i=0; $i < $quantidade; $i++) {
            $random .= $caracteresAceitos{mt_rand(0, $max)};
        }
        return $random;
     }
}
