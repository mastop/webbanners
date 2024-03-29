<?php
/**
 * Reurbano/OrderBundle/DataFixtures/MongoDB/LodParametersData.php
 *
 * Preferências do Bundle de Vendas
 *  
 * 
 * @copyright 2011 Mastop Internet Development.
 * @link http://www.mastop.com.br
 * @author Fernando Santos <o@fernan.do>
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace Banner\OrderBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mastop\SystemBundle\Document\Parameters;
use Mastop\SystemBundle\Document\Children;

class LoadParametersData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $param = new Parameters();
        $param->setName('sell');
        $param->setTitle('Vendas');
        $param->setDesc('Configurações para o módulo de vendas');
        $param->setBundle('order');
        $param->setRole('ROLE_ADMIN');
        $param->setOrder(4);

        $child = new Children();
        $child->setName('ordermail');
        $child->setTitle('E-mail para notificações');
        $child->setDesc('Insira o e-mail que receberá notificações de novas vendas e alterações de vendas.');
        $child->setValue('suporte@mastop.com.br');
        $child->setOrder(0);
        $param->addChildren($child);
        
        $child = new Children();
        $child->setName('gateway');
        $child->setTitle('Gateway de Pagamento');
        $child->setDesc('Selecione o gateway de pagamento');
        $child->setValue('PagSeguro');
        $child->setFieldtype('choice');
        $child->setOpts(array('choices' => array('PagSeguro' => 'PagSeguro', 'Braspag' => 'Braspag', 'Moip' => 'Moip')));
        $child->setOrder(1);
        $param->addChildren($child);
        
        $manager->persist($param);
        $manager->flush();
    }

    public function getOrder() {
        return 1;
    }

}