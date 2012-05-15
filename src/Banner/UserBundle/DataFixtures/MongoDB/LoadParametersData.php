<?php

namespace Banner\UserBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Mastop\SystemBundle\Document\Parameters;
use Mastop\SystemBundle\Document\Children;
use Banner\UserBundle\Document\User;

class LoadParametersData implements FixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $param = new Parameters();
        $param->setName('all');
        $param->setTitle('Usuários');
        $param->setDesc('Configurações para usuários do site');
        $param->setBundle('user');
        $param->setRole('ROLE_ADMIN');
        $param->setOrder(1);

        $child = new Children();
        $child->setName('allownew');
        $child->setTitle('Permitir novos cadastros');
        $child->setDesc('Permitir que novos usuários se cadastrem.');
        $child->setValue(1);
        $child->setFieldtype('checkbox');
        $child->setOrder(0);
        $param->addChildren($child);

        $child = new Children();
        $child->setName('mailnotify');
        $child->setTitle('Notificar Novos Cadastros');
        $child->setDesc('Digite endereços de e-mail, separados por vírgula, que serão notificados quando novos usuários se cadastrarem.');
        $child->setValue('meu@email.com');
        $child->setOrder(1);
        $param->addChildren($child);

        $child = new Children();
        $child->setName('autoactive');
        $child->setTitle('Ativação');
        $child->setDesc('Tipo de ativação de novos cadastros');
        $child->setValue('auto');
        $child->setFieldtype('choice');
        $child->setOpts(array('choices' => array('auto' => 'Automático', 'email' => 'E-mail', 'admin' => 'Aprovação Manual')));
        $child->setOrder(2);
        $param->addChildren($child);

        $child = new Children();
        $child->setName('typeclient');
        $child->setTitle('Tipo Cliente');
        $child->setDesc('Tipo cliente que irá ser criado');
        $child->setValue('ROLE_CLIENT');
        $child->setFieldtype('choice');
        $child->setOpts(array('choices' => array('ROLE_CLIENT' => 'Somente Cliente', 'ROLE_DESIGNER' =>'Somente Designer', 'ROLE_USER' => 'Somente Usuário', 'ROLE_ADMIN' => 'Administrador', 'ROLE_SUPERADMIN' => 'Super-Administrador')));
        $child->setOrder(3);
        $param->addChildren($child);

        $child = new Children();
        $child->setName('selfdelete');
        $child->setTitle('Deletar Conta');
        $child->setDesc('Permitir que os usuários deletem o próprio cadastro.');
        $child->setValue('0');
        $child->setFieldtype('checkbox');
        $child->setOrder(4);
        $param->addChildren($child);
        
        $child = new Children();
        $child->setName('faceappid');
        $child->setTitle('ID do Aplicativo Facebook');
        $child->setDesc('Código do aplicativo criado no facebook developers');
        $child->setValue('108342115933418');
        $child->setOrder(5);
        $param->addChildren($child);
        
        $child = new Children();
        $child->setName('faceappsecret');
        $child->setTitle('Código Secret do App criado no Facebook');
        $child->setDesc('Código gerado no site de developers do Facebook.');
        $child->setValue('f3872f946c36c127f4effbb4e6a918b3');
        $child->setOrder(6);
        $param->addChildren($child);
        
        $child = new Children();
        $child->setName('twitterappid');
        $child->setTitle('ID Consumer key do Twitter');
        $child->setDesc('Código do aplicativo criado no twitter developers');
        $child->setValue('G1WitELkS2NakPjyEsuAtw');
        $child->setOrder(7);
        $param->addChildren($child);
        
        $child = new Children();
        $child->setName('twitterappsecret');
        $child->setTitle('Código Consumer secret no Twitter');
        $child->setDesc('Código gerado no site de developers do Twitter.');
        $child->setValue('mEiNe46crzEhxhyQs4lUHxP8ka3WxKjNIcAn8rruAM');
        $child->setOrder(8);
        $param->addChildren($child);
        
        $manager->persist($param);
        $manager->flush();
        
        $param = new Parameters();
        $param->setName('all');
        $param->setTitle('Pedido');
        $param->setDesc('Configurações para pedido no site');
        $param->setBundle('order');
        $param->setRole('ROLE_ADMIN');
        $param->setOrder(2);

        $child = new Children();
        $child->setName('defaultstatus');
        $child->setTitle('Status padrão');
        $child->setDesc('Qual Status que o pedido virá ao ser criado.');
        $child->setValue("1");
        $child->setFieldtype('text');
        $child->setOrder(0);
        $param->addChildren($child);

        $child = new Children();
        $child->setName('BannersOrder');
        $child->setTitle('Máximo de Banners');
        $child->setDesc('Máximo de Banners que podem ser solicitados por pedido.');
        $child->setValue(10);
        $child->setFieldtype('number');
        $child->setOrder(1);
        $param->addChildren($child);

        $child = new Children();
        $child->setName('UploadOrder');
        $child->setTitle('Máximo de Uploads');
        $child->setDesc('Máximo de uploads por pedido.');
        $child->setValue(10);
        $child->setFieldtype('number');
        $child->setOrder(2);
        $param->addChildren($child);

        $child = new Children();
        $child->setName('FirstBanner');
        $child->setTitle('Valor para o 1º banner');
        $child->setDesc('Valor para o 1º banner.');
        $child->setValue(30.00);
        $child->setFieldtype('number');
        $child->setOrder(3);
        $param->addChildren($child);

        $child = new Children();
        $child->setName('OthersBanner');
        $child->setTitle('Valor os outros banners');
        $child->setDesc('Valor para os outros banners.');
        $child->setValue(20.00);
        $child->setFieldtype('number');
        $child->setOrder(3);
        $param->addChildren($child);

        $child = new Children();
        $child->setName('PSDBanner');
        $child->setTitle('Valor para o PSD do Banner');
        $child->setDesc('Valor para o PSD do Banner.');
        $child->setValue(5.00);
        $child->setFieldtype('number');
        $child->setOrder(3);
        $param->addChildren($child);
        
        $manager->persist($param);
        $manager->flush();
    }

}