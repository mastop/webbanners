<?php
namespace Banner\OrderBundle\Controller\Frontend;

use Mastop\SystemBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Request;
use Banner\OrderBundle\Form\Frontend\Order1Type;
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
     * @Route("/novo", name="_order_order_index", defaults={"name"=""})
     * @Route("/alterar/{name}", name="_order_order_alter")
     * @Template()
     */
    public function indexAction($name="")
    {                      
        if ($name) {
            $order = $this->mongo("BannerOrderBundle:Order")->findOneByName($name);
            $order->setQuantity($order->getQuantity());
            $formOrder = $this->createForm(new OrderType(), $order);
        }else{
            $order = new Order();
            $order->setQuantity(1);
            $formOrder = $this->createForm(new OrderType(), $order);
        }
        $upload = new Upload();
        $user = new User();
        
        $formUpload = $this->createForm(new UploadType(), $upload);
        $formUser = $this->createForm(new UserForm(), $user);
        
        return array(
                        'formOrder'  => $formOrder->createView(), 
                        'formUpload' => $formUpload->createView(), 
                        'formUser'   => $formUser->createView(), 
                        'order'      => $order,
                    );
     }

     /**
     * @Route("/modificar/{name}", name="_order_order_modify")
     * @Template()
     */
    public function modifyAction($name="")
    {          
        $dm = $this->get('doctrine.odm.mongodb.document_manager');             
        $request = $this->get('request');
        $formOrder = $request->request->get('order');
        $formBanner = $request->request->get('banner');
        if ($name) {
            $order = $this->mongo("BannerOrderBundle:Order")->findOneByName($name);
            $quantity = $order->getQuantity();
            if($quantity != $order->getQuantity()){
                $order->setAproved("false");
            }
            $order->setQuantity($formOrder['quantity']);
            $i = 0;
            foreach($formBanner as $fBanner){
                $i++;
                if($i>$quantity){
                    $banner = new Banner();
                    $banner->setHeight($fBanner['height']);

                    $banner->setWidth($fBanner['width']);
                    if(sizeof($fBanner)==3){
                        $banner->setPsd($fBanner['psd']);
                    }
                    $order->addBanner($banner);
                }
            }
            $mail = $this->get('mastop.mailer');
                        $mail->to($order->getUser()->getEmail())
                            ->subject('Alteração de pedido - WebBanners')
                            ->template('pedido_alteracao', array('user' => $order->getUser(),'order'=>$order))
                            ->send();
                        $mail->to($order->getDesigner()->getEmail())
                            ->subject('Alteração de pedido - WebBanners')
                            ->template('pedido_alteracao', array('user' => $order->getDesigner(),'order'=>$order))
                            ->send();
                        $mail->notify('Foi alterado o pedido '.$order->getId().' do usuário '.$order->getUser()->getCode().'-'.$order->getUser()->getName().' e designer '.$order->getDesigner()->getCode().'-'.$order->getDesigner()->getName());
            $dm->persist($order);
            $dm->flush();
            
        }
        
        
        return $this->redirectFlash($this->generateUrl('_order_order_edit',array("username"=>($order->getUser()->getUsername()), "name"=>$order->getName(),'pgatual'=>'pedido')), "Alteração no pedido feita");
     }
     
    /**
     * @Route("/designer/{pgatual}", name="_order_order_design", defaults={"pgatual" = "aberto"}
     * )
     * @Template()
     */
    public function designAction($pgatual="aberto")
    {   
        $orders = array();
        $user = $this->get('security.context')->getToken()->getUser();
        if($user == $this->get('security.context')->getToken()->getUser() || ($this->get('security.context')->isGranted('ROLE_SUPERADMIN'))){
            $orders = $this->mongo('BannerOrderBundle:Order')->findByOpenDesigner($user);
            $finals = $this->mongo('BannerOrderBundle:Order')->findByDoneDesigner($user);
        }
        return array(
                        'orders'  => $orders,
                        'finals'  => $finals,
                        'pgatual' => $pgatual
                    );
     }
     
    /**
     * @Route("/admin/{pgatual}", name="_order_order_admin", defaults= {"pgatual"="design"}
     * )
     * @Template()
     */
    public function adminAction($pgatual="design")
    {   
        $dm = $this->get('doctrine.odm.mongodb.document_manager');  
        $request = $this->get('request');
        //exit(var_dump(($request->attributes)));
        if ($this->get('security.context')->isGranted('ROLE_SUPERADMIN')) {
            $unsets = $this->mongo("BannerOrderBundle:Order")->findUnsets();
            $sets = $this->mongo("BannerOrderBundle:Order")->findSets();
            $orders = $this->mongo("BannerOrderBundle:Order")->findByOpen();
            $finals = $this->mongo("BannerOrderBundle:Order")->findByDone();
            $designers = $this->mongo("BannerUserBundle:User")->findBy(array('roles'=>'ROLE_DESIGNER'));
            if ('POST' == $request->getMethod()) {
                foreach($orders as $order){
                    $designer = $this->mongo("BannerUserBundle:User")->findByCode($request->get($order->getId()));
                    if($designer){
                        $order->setDesigner($designer);
                        $dm->persist($order);
                        $dm->flush();

                        $mail = $this->get('mastop.mailer');
                        $mail->to($designer->getEmail())
                            ->subject('Novo projeto no seu nome - WebBanners')
                            ->template('pedido_designer', array('user' => $designer,'order'=>$order))
                            ->send();
                        $mail->notify('O pedido '.$order->getId().' foi escolhido para '.$designer->getName(), 'O pedido '.$order->getId().' foi escolhido para '.$designer->getName().' pelo admnistrador do sistema.');
                    }
                }
                return $this->redirectFlash($this->generateUrl('_order_order_admin',array("pgatual"=>"alterar")), "Foi selecionado os designers para os projetos.");
            }
        }
        else{
            return $this->redirectFlash($this->generateUrl('_home'), "Você não está autorizado para acessar essa página.");
        }
        return array(
                        'sets'      => $sets,
                        'unsets'    => $unsets,
                        'orders'    => $orders,
                        'finals'    => $finals,
                        'designers' => $designers,
                        'pgatual'   => $pgatual,
                    );
     }
     
    /**
     * @Route("/cliente/{pgatual}", name="_order_order_client",  defaults={"pgatual" = "aberto"})
     * @Template()
     */
    public function clientAction($pgatual="aberto")
    {       
        $orders = array();
        $finals = array();
        
        $user = $this->get('security.context')->getToken()->getUser();
        if($user && $user != "anon."){
            $orders = $this->mongo('BannerOrderBundle:Order')->findByOpenUser($user);
            $finals = $this->mongo('BannerOrderBundle:Order')->findByDoneUser($user);
        }
        
        return array(
                        'orders'  => $orders,
                        'finals'  => $finals,
                        'pgatual' => $pgatual
                    );
     }
     
    /**
     * @Route("/detalhes/{username}-{name}/{pgatual}", name="_order_order_edit")
     * @Template()
     */
    public function editAction($username,$name,$pgatual)
    {           
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $request = $this->get('request');
        
        $user = $this->mongo('BannerUserBundle:User')->findByUsername($username);
        $order = $this->mongo('BannerOrderBundle:Order')->findByNameUser($name,$user);
        if ($this->get('security.context')->getToken()->getUser() == $order->getDesigner()) {
            $order->setDunread(0);
        }elseif ($this->get('security.context')->getToken()->getUser() == $order->getUser()) {
            $order->setCunread(0);
        }elseif (!$this->get('security.context')->isGranted("ROLE_ADMIN")){
            return $this->redirectFlash($this->generateUrl('_home'), "Você não está autorizado para acessar essa página.");
        }
        $dm->persist($order);
        $dm->flush();
        
        $pendings = array();
        $aproves = array();
        $lvisus = array();
        foreach ($order->getPreview() as $pending){
            if ($pending->getAproved() == "true") {
               $aproves[] = $pending; 
            }else{
                $pendings[] = $pending;
            }
        } 
        foreach ($order->getVLanguage() as $lvisu){
            if ($lvisu->getAproved() == "true") {
               $lvisus[] = $lvisu; 
            }
        } 
        
            
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
                $mail = $this->get('mastop.mailer');
                if ($talker == $order->getUser()) {
                    $order->setDunread($order->getDunread()+1);
                    if($order->getDesigner()){
                        $mail->to($order->getDesigner()->getEmail())
                            ->subject('Comentário - WebBanners')
                            ->template('comment_new', array('to' => $order->getDesigner(), 'from' => $order->getUser()))
                            ->send();
                    }else{
                        $mail->notify("O pedido ".$order->getId()." está sem designer e o cliente enviou um comentário.");
                    }
                }elseif ($talker ==  $order->getDesigner()) {
                    $order->setCunread($order->getCunread()+1);
                    $mail->to($talker->getEmail())
                        ->subject('Comentário - WebBanners')
                        ->template('comment_new', array('from' => $order->getDesigner(), 'to' => $order->getUser()))
                        ->send();
                }else{
                    $order->setDunread($order->getDunread()+1);
                    $order->setCunread($order->getCunread()+1);
                    $mail->to($talker->getEmail())
                        ->subject('Comentário - WebBanners')
                        ->template('comment_new', array('to' => $order->getDesigner(), 'from' => $talker))
                        ->send();
                    $mail->to($talker->getEmail())
                        ->subject('Comentário - WebBanners')
                        ->template('comment_new', array('to' => $order->getUser(), 'from' => $talker))
                        ->send();
                }
                $dm->persist($talk);
                $dm->flush();
                foreach ($formUpload1 as $upload1){
                    if($upload1){
                        $upload = new Upload();
                        $upload->setUniqpath('order/'.$talker->getUsername().'/talker/');
                        $upload->setFile($upload1);
                        $dm->persist($upload);
                        $talk->addUpload($upload);
                    }
                }
                
                $order->addTalk($talk);
                $dm->persist($order);
                $dm->flush();
                return $this->redirectFlash($this->generateUrl('_order_order_edit',array("username"=>($order->getUser()->getUsername()), "name"=>$order->getName(), "pgatual" => "historico")), "Comentário Salvo");
            }
            
        }
        
        return array(
                        'formTalk'  => $formTalk->createView(), 
                        'formUpload'=> $formUpload->createView(), 
                        'order'     => $order,
                        'user'      => $user,
                        'aproves'   => $aproves,
                        'pendings'  => $pendings,
                        'lvisus'    => $lvisus,
                        'pgatual'   => $pgatual
                    );
    }
        /**
     * @Route("/final", name="_order_order_final")
     * @Template()
     */
    public function finalAction()
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $request = $this->get('request');
        $name  = $request->request->get("order");
        $final  = $request->files->get("final");
        $order = $this->mongo('BannerOrderBundle:Order')->findOneByName($name);
        if($final->guessExtension() == "zip"){
            $upload = new Upload();
            $upload->setFile($final);
            $order->setFinal($upload);
            $mail = $this->get('mastop.mailer');
            $mail->to($order->getUser()->getEmail())
                ->subject('Arquivo Final - WebBanners')
                ->template('pedido_arquivo_final', array('user' => $order->getUser(),'order'=>$order))
                ->send();
            $mail->notify('Arquivo Final - WebBanners', 'O pedido '.$order->getId().' foi finalizado e colocado o arquivo final.');
            $dm->persist($order);
            $dm->flush();
        }else{
            return $this->redirectFlash($this->generateUrl('_order_order_edit',array("username"=>($order->getUser()->getUsername()), "name"=>$order->getName(), "pgatual"=>"aprovados")), "Favor enviar um arquivo zipado");
        }
        return $this->redirectFlash($this->generateUrl('_order_order_edit',array("username"=>($order->getUser()->getUsername()), "name"=>$order->getName(), "pgatual"=>"aprovados")), "Arquivo final aceito");
    }
     
    /**
     * @Route("/linguagem", name="_order_order_vlanguage")
     * @Template()
     */
    public function vlanguageAction()
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $request = $this->get('request');
        $lvisual  = $request->request->get("lvisual");
        $name  = $request->request->get("order");
        $order = $this->mongo('BannerOrderBundle:Order')->findOneByName($name);
        foreach ($order->getVLanguage() as $vlanguage){  
            if($vlanguage->getId() == $lvisual){
                $vlanguage->setAproved("true");
                $mail = $this->get('mastop.mailer');
                $mail->to($order->getDesigner()->getEmail())
                    ->subject('Linguagem visual aceita - WebBanners')
                    ->template('ling_accept', array('to' => $order->getDesigner(), 'from' => $order->getUser(), 'order' => $order))
                    ->send();
                $mail->notify('Linguagem visual do pedido '.$order->getId().' aceita ', 'O pedido '.$order->getId().' teve a linguagem visual aceita.');
            }else{
                $vlanguage->setAproved("false");
            }
        }
        $dm->persist($order);
        $dm->flush();
        return $this->redirectFlash($this->generateUrl('_order_order_edit',array("username"=>($order->getUser()->getUsername()), "name"=>$order->getName(), "pgatual"=>"aprovacao")), "Linguagem Visual aceita");
    }
    
    /**
     * @Route("/banner", name="_order_order_banner")
     * @Template()
     */
    public function bannerAction()
    {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $request = $this->get('request');
        $name  = $request->request->get("order");
        $order = $this->mongo('BannerOrderBundle:Order')->findOneByName($name);
        $justifics = array();
        $count = 0;
        $banners = count($order->getBanner());
        foreach ($order->getPreview() as $upload){  
            if($upload->getAproved() != "true" && $upload->getAproved() !=  "false"){
                $banner  = $request->request->get($upload->getId());
                if($banner == "false" ){
                    $justifics  = $request->request->get("just");
                    $upload->setJustify($justifics[$upload->getId()]);
                }
                $upload->setAproved($banner);
            }
            if($upload->getAproved()=="true"){
                $count = $count + 1;
            }
        }
        if($count == $banners){
            $order->setAproved("true");
        }
        $mail = $this->get('mastop.mailer');
        $mail->to($order->getUser()->getEmail())
            ->subject('Arquivo Final - WebBanners')
            ->template('pedido_arquivo_final', array('user' => $order->getUser(),'order'=>$order))
            ->send();
        $mail->notify('Arquivo Final - WebBanners', 'O pedido '.$order->getId().' foi finalizado e colocado o arquivo final.');
        $dm->persist($order);
        $dm->flush();
        return $this->redirectFlash($this->generateUrl('_order_order_edit',array("username"=>($order->getUser()->getUsername()), "name"=>$order->getName(), "pgatual"=>"aprovacao")), "Banners avaliados");
    }
    
    /**
     * @Route("/preview", name="_order_order_preview")
     * @Template()
     */
    public function previewAction()
    { 
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $request = $this->get('request');
        $formUpload  = $request->files->get("banner");
        $name  = $request->request->get("order");
        $order = $this->mongo('BannerOrderBundle:Order')->findOneByName($name);  
        //exit(var_dump($order));
        
        if ('POST' == $request->getMethod()) {
            foreach ($formUpload as $upload){
                if($upload){
                    $upload1 = new Upload();
                    $upload1->setFile($upload);
                    $upload1->setUniqpath('order/'.($order->getUser()->getUsername()).'/preview');
                    $dm->persist($upload1);
                    $order->addPreview($upload1);
                }
            }
            $mail = $this->get('mastop.mailer');
            $mail->to($order->getUser()->getEmail())
                ->subject('Banner - WebBanners')
                ->template('pedido_banners', array('user' => $order->getUser(),'order'=>$order))
                ->send();
            $mail->notify('Banner - WebBanners', 'Foi incluido um banner no pedido '.$order->getId().'.');
            $dm->persist($order);
            $dm->flush();
            return $this->redirectFlash($this->generateUrl('_order_order_edit',array("username"=>($order->getUser()->getUsername()), "name"=>$order->getName(), "pgatual"=>"aprovacao")), "Preview Salvo");
            
        }
                return $this->redirectFlash($this->generateUrl('_order_order_edit',array("username"=>($order->getUser()->getUsername()), "name"=>$order->getName(), "pgatual"=>"aprovacao")), "Preview Não Salvo");
     }
     
    /**
     * @Route("/lvisual", name="_order_order_lvisual")
     * @Template()
     */
    public function lvisualAction()
    { 
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $request = $this->get('request');
        $formUpload  = $request->files->get("ling");
        $name  = $request->request->get("order");
        $order = $this->mongo('BannerOrderBundle:Order')->findOneByName($name);  
        //exit(var_dump($order));
        
        if ('POST' == $request->getMethod()) {
            foreach ($formUpload as $upload){
                if($upload){
                    $upload1 = new Upload();
                    $upload1->setFile($upload);
                    $upload1->setUniqpath('order/'.($order->getUser()->getUsername()).'/lvisual');
                    $dm->persist($upload1);
                    $order->addVLanguage($upload1);
                }
            }
            $dm->persist($order);
            $dm->flush();
            return $this->redirectFlash($this->generateUrl('_order_order_edit',array("username"=>($order->getUser()->getUsername()), "name"=>$order->getName(), "pgatual"=>"aprovacao")), "Preview Salvo");
            
        }
                return $this->redirectFlash($this->generateUrl('_order_order_edit',array("username"=>($order->getUser()->getUsername()), "name"=>$order->getName(), "pgatual"=>"aprovacao")), "Preview Não Salvo");
     }
    
     /**
     * @Route("/save", name="_order_order_save")
     * @Template()
     */
    public function saveAction(Request $request){
        
        $msg = "";
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
            
        $formUser = $request->request->get('Userform');
        $formOrder = $request->request->get('order');
        $formBanner = $request->request->get('banner');
        $formUpload = $request->request->get('upload');
        
        $upload = new Upload();
        $formUpload = $this->createForm(new UploadType(), $upload);
        $formUpload->bindRequest($request); 
        $formUpload1  = $request->files->get("upload");
        
        if(($formUser["email"] && !$formUser) || !$formOrder || !$formUpload){
            $msg = "Problemas no cadastro, favor conferir.";
            return $this->redirectFlash($this->generateUrl('_order_order_index'), $msg);
        }
        
        if($this->get('security.context')->isGranted("ROLE_USER") ){
            $user = $this->get('security.context')->getToken()->getUser();
            
            $order = $this->mongo('BannerOrderBundle:Order')->findByNameUser($formOrder['name'],$user);

            if($order){
                $msg = "Já existe um projeto com esse nome. Crie um novo nome.";
                return $this->redirectFlash($this->generateUrl('_order_order_index'), $msg);
            }
        }
        else
        {
            $user = $this->mongo('BannerUserBundle:User')->findByEmail($formUser["email"]);

            if($user){
                $msg = "E-mail já cadastrado. Efetue o login para solicitar um novo pedido.";
                return $this->redirectFlash($this->generateUrl('_order_order_index'), $msg);
            }

            $user = new User();
            $user->setRoles("ROLE_CLIENT");
            $user->setEmail($formUser["email"]);
            $user->setUsername(str_replace(".", "", str_replace("@", "", $formUser["email"])));
            $user->setName(str_replace(".", "", str_replace("@", "", $formUser["email"])));
            $user->setMailOk(true);
            $user->setStatus(1);
            $user->setCreated(new \DateTime());
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
            $password = $this->random(8);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
            $code = $this->mastop()->generateCode();
            while($this->mongo('BannerUserBundle:User')->has('code', $code)){
                $code = $this->mastop()->generateCode();
            }
            $user->setCode($code);
            
            $dm->persist($user);
            $dm->flush();
            $mail = $this->get('mastop.mailer');
            $mail->to($formUser["email"])
                ->subject('Senha gerada - WebBanners')
                ->template('usuario_senhagerada', array('user' => $user,'password'=>$password, 'title' => 'Senha de acesso.'))
                ->send();
            $mail->notify('Senha de acesso', 'A Senha do usuário '.$user->getName().' foi enviada com sucesso para o email '.$user->getEmail().'.');
            
            $msg = "Um email foi enviado com sua senha.";
        }
        $status = $this->mongo('BannerOrderBundle:Status')->findOneById((int)$this->get('mastop')->param('order.all.defaultstatus'));
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
        foreach ($formUpload1 as $upload1){
            if($upload1){
                $upload = new Upload();
                $upload->setUniqpath('order/'.$user->getUsername().'/talker/');
                $upload->setFile($upload1);
                $dm->persist($upload);
                $order->addUpload($upload);
            }
        }
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
        
        $mail->to($user->getEmail())
            ->subject('Pedido solicitado com Sucesso')
            ->template('pedido_novo', array('user' => $user, 'order' => $order, 'title' => 'Pedido solicitado com sucesso.'))
            ->send();
        $mail->notify('Pedido solicitado', 'O pedido '.$order->getId().' foi criado e enviado para o e-mail '.$user->getEmail());

        //autologin
        //$token = new UsernamePasswordToken(     $user,    null,     'main',     array('ROLE_USER'));
        //$this->container->get('security.context')->setToken($token);  
        
        $msg = $msg." Pedido efetuado com sucesso! Foi enviado um e-mail.";
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
