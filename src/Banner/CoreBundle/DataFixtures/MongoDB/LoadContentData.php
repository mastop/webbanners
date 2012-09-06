<?php
/**
 * Banner/CoreBundle/DataFixtures/MongoDB/LoadContentData.php
 *
 * Carrega páginas padrão.
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

namespace Banner\CoreBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Banner\CoreBundle\Document\Content;

class LoadContentData implements FixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $Content = new Content();
        $Content->setTitle("Privacidade");
        $Content->setSeoTitle("privacidade");
        $Content->setContent('<div class="row">
                              <div class="offset1 span10">
                              <h3> Privacidade </h3>
                              <br/>
                              O Webbanner investe em tecnologias avançadas de proteção de dados para oferecer mais segurança a seus clientes.<br/><br/>
                              Os seus dados de cadastro são protegidos e toda a transação com cartões de crédito são feitas em ambiente seguro, protegido por protocolos de segurança. Todas as informações são codificadas pelo softwre SSL e arquivadas em servidores protegidos. Nenhuma informação privada trafega pela rede sem ser criptografada, utilizando os melhores sistemas disponíveis no mercado. A proteção é absoluta.<br/><br/>
                              O Webbanner se compromete com a privacidade e a segurança de seus clientes. Os dados cadastrais dos clientes não são divulgados para terceiros, exceto quando essas informações são necessárias para o processo de entrega, para cobrança, ou para participação em promoções solicitadas pelos clientes.<br/><br/>
                              O Webbanner não promove e não participa de campanhas de e-mail spam.
                              </div>
                              </div>');
        $manager->persist($Content);
        $manager->flush();  $Content = new Content();
        $Content->setTitle("Sobre o WebBanner");
        $Content->setSeoTitle("sobre-o-webBanner");
        $Content->setContent('<div class="row">
                              <div class="offset1 span10">
                              <h3>Sobre o WebBanner</h3>
                              <br/>
                              O WebBanner é uma ferramenta que auxilia o contato com o designer, tendo como objetivo facilitar a vida de nosso clientes. De maneira prática o cliente solicita banners dos tamanhos que deseja e com as informações e em até 72 horas úteis os seus banners estarão disponíveis. <br/><br/>
                              Contamos com uma equipe de designers especializados no desenvolvimento de banners para web, que estarão sempre te auxiliando e prontos para atendê-lo.<br/><br/>
                              Nossos clientes tem um relacionamento de confiança e satisfação conosco, ajudamos nossos clientes a crescerem.
                              </div>
                              </div>');
        $manager->persist($Content);
        $manager->flush();
        $manager->persist($Content);
        $manager->flush();  $Content = new Content();
        $Content->setTitle("Como Comprar");
        $Content->setSeoTitle("como-comprar");
        $Content->setContent('<div class="row">
                              <div class="offset1 span10">
                              <h3>Como Comprar</h3>
                              <br/>
                              Caso já tenha cadastro no WebBanner:
                              <ol>
                              <li>Clique no botão "Login" que fica no canto superior direito da página</li>
                              <li>Digite o Login e a senha</li>
                              <li>Clique em "Novo Pedido" no menu principal</li>
                              <li>Coloque os dados do pedido</li>
                              <li>Clique em Salvar</li>
                              <li>Faça o pagamento com o PAGSEGURO</li>
                              <li>Você retornará ao nosso site e assim que o PAGSEGURO comprovar o pagamento vamos começar a desenvolver seu pedido.</li>
                              </ol>
                              <br/>
                              Caso não tenha cadastro no WebBanner:
                              <ol>
                              <li>Clique em "Novo Pedido" no menu principal</li>
                              <li>Coloque os dados do pedido, incluindo o e-mail.</li>
                              <li>Clique em Salvar</li>
                              <li>Faça o pagamento com o PAGSEGURO</li>
                              <li>Você retornará ao nosso site e assim que o PAGSEGURO comprovar o pagamento vamos começar a desenvolver seu pedido.</li>
                              </ol>
                              </div>
                              </div>');
        $manager->persist($Content);
        $manager->flush();
        $Content = new Content();
        $Content->setTitle("Banners Online");
        $Content->setSeoTitle("banners-online");
        $Content->setContent('<div class="row">
                              <div class="offset1 span10">
                              <h3>Banners online</h3>
                              <br/>
                              Os banners online são direcionados para campanhas publicitária na Internet, propagandas para divulgação de sites e para atrair um usuários através do clique.
                              <br/><br/>
                              No WebBanner disponibilizamos as imagens dos banners em formato .jpg, .png, .gif . Caso queira pode solicitar também o arquivo aberto, você pode setar a opção "PSD" que na conclusão do projeto você receberá o arquivo aberto no Photoshop o que possibilitará a edição do seu banner.
                              <br/><br/>
                              Um banner pode ter várias dimensões. As imagens freqüentemente tem uma forma alongada, na horizontal ou na vertical.<br/>
                              Para potêncializar suas campanhas seguem algumas dicas:
                              <br/><br/>
                              <ul>
                              <li>Formular perguntas</li>
                              <li>Comunicar oferta grátis</li>
                              <li>Uso de lay-out e cores iguais as do navegador</li>
                              <li>Uso de recursos apelativos</li>
                              <li>Qualquer artifício que iluda o visitante com relação ao produto, tem efeito negativo em termos de ação desejada, ou seja você traz mais visitantes, mas terá mais dificuldades em transformá-los em clientes.</li>
                              </ul>
                              <br/>
                              O banner é o elemento mais usado para fazer publicidade na internet. Divulgação e anúncios em banners podem trazer resultados positivos dependendo de diferentes fatores que devem ser planejados previamente, entre eles a criação do banner como formato publicitário com objetivos específicos e concretos. O banner tem que ser o suficientemente estimulante para "seduzir" o maior número possível de visitantes.
                              </div>
                              </div>');
        $manager->persist($Content);
        $manager->flush();
        $Content = new Content();
        $Content->setTitle("Agilidade Na Entrega");
        $Content->setSeoTitle("agilidade-na-entrega");
        $Content->setContent('<div class="row">
                              <div class="offset1 span10">
                              <h3>Agilidade na entrega</h3>
                              <br/>
                              Após a confirmação do pagamento pelo PagSeguro, nossa equipe irá disponibilizar em até X horas úteis três ideias desenvolvidas para a sua campanha.<br/>
                              Você terá o tempo que achar necessário para escolher a idéia que mais lhe agrada, fazer a revisão a que tem direito e postar seus comentários.<br/>
                              Após suas definições, a nossa equipe ira disponibilizar os arquivos finais para download em até X horas úteis.<br/>
                              Nosso trabalho leva até x horas úteis, mas depende do tempo da sua escolha e revisão para ser finalizado.
                              </div>
                              </div>');
        $manager->persist($Content);
        $manager->flush();
        $Content = new Content();
        $Content->setTitle("Alterações no Banner");
        $Content->setSeoTitle("alteracoes-no-banner");
        $Content->setContent('<div class="row">
                              <div class="offset1 span10">
                              <h3>Alterações no Banner</h3>
                              <br/>
                              Caso pense em pequenas alterações futuramente nos banners, aconselhamos que solicite o arquivo PSD.<br/>
                              Disponibilizaremos o arquivo todo separado, com suas camadas e textos, facilitando suas futuras alterações.<br/>
                              Um arquivo PSD pode ser aberto somente no programa Photoshop, uma das melhores ferramentas para edições de imagens, muito utilizada por designers.
                              </div>
                              </div>');
        $manager->persist($Content);
        $manager->flush();
        $Content = new Content();
        $Content->setTitle("Tercerize seu Trabalho");
        $Content->setSeoTitle("tercerize-seu-trabalho");
        $Content->setContent('<div class="row">
                              <div class="offset1 span10">
                              <h3>Tercerize seu Trabalho</h3>
                              <br/>
                              Há alguns momentos no trabalho que a demanda é tão grande que não conseguimos atender todos no prazo certo.  Caso esse seja seu problema, nós temos a solução. A nossa equipe do  WebBanner faz os banners pra você.<br/>
                              Não precisa ficar desesperado com aquele projeto que está atrasado. Temos opções que desenvolvemos seus banners em 24h úteis. Fazendo com que seu trabalho seja desenvolvido rapidamente e com qualidade.
                              </div>
                              </div>');
        $manager->persist($Content);
        $manager->flush();
        $Content = new Content();
        $Content->setTitle("Segurança");
        $Content->setSeoTitle("seguranca");
        $Content->setContent('<div class="row">
                              <div class="offset1 span10">
                              <h3> Segurança </h3>
                              <br/>
                              Para garantir a sua segurança também em outros sites, observe algumas dicas básicas:
                              <br/><br/>
                              <ul>
                              <li> Antes de inserir seus dados, confira se o ambiente é seguro e se o cadeado é exibido na barra inferior do site. Para o Windows XP, a barra inferior é por padrão desabilitada. Deve-se habilitá-la ou verificar se o endereço da página segura começa com http.</li>
                              <li>Mantenha seus softwares antivírus, firewall pessoal, anti-spyware e antispam atualizados.</li>
                              <li>Não forneça seus dados pessoais ou senhas, nem efetue pagamentos em sites não confiáveis e de procedência desconhecida. Verifique sempre se o site possui o selo da Internet Segura.</li>
                              <li>Desconfie de ofertas tentadoras ou mensagens com anexos ou links, principalmente de remetentes desconhecidos.</li>
                              </ul>
                              </div>
                              </div>');
        $manager->persist($Content);
        $manager->flush();
        $Content = new Content();
        $Content->setTitle("Termos e Condições");
        $Content->setSeoTitle("termos-e-condicoes");
        $Content->setContent('<div class="row">
                                <div class="offset1 span10">
                                Termos e Condições de Uso do Webbanner.  Leia com atenção esse Acordo e outras informações  importantes sobre o WebBanner. De tempos em tempos poderemos modificar o Acordo do Usuário, por isso é importante que você sempre o acesse para estar ciente de possíveis modificações.
                                <ol>
                                <li>Direito de usar o WebBanner<br/>
                                O WebBanner  O Conteúdo poderá ser apresentado na forma de informação, texto, dados, imagens, gráficos, ícones de botões, marcas comerciais registradas e não registradas, ilustrações, fotografias, clipes de áudio, música, sons, gravuras, vídeos, softwares ou outras formas e formatos conhecidos e inventados no presente momento ou posteriormente. Ao usar o WebBanner, o usuário precisa respeitar os direitos de propriedade intelectual do WebBanner e de outras empresas, conforme abaixo descritas. O uso não autorizado do Conteúdo por parte do usuário pode violar as leis de direitos autorais, marcas comerciais, privacidade, publicidade, comunicações e outras leis, e tal uso poderá resultar na responsabilidade pessoal do usuário, inclusive em termos judiciais.</li>
                                <li>Direitos autorais<br/>
                                Todo o Conteúdo é protegido pelas leis de direitos autorais, sendo de propriedade ou utilizado com permissão do WebBanner. O WebBanner não se responsabiliza nem garante que o uso não-autorizado do Conteúdo por parte do usuário não infringirá os direitos de terceiros que não sejam de propriedade ou afiliados ao WebBanner</li>
                                <li>O WebBanner respeita os direitos de propriedade intelectual de outras empresas.</li>
                                <li>Marcas Comerciais<br/>
                                As Marcas, Comerciais ou de Serviço, e os logotipos exibidos nesse website são de propriedade do WebBanner e de terceiros, e o código comercial desse website é de propriedade do WebBanner (coletivamente, as “Marcas Comerciais”, que também constituem o Conteúdo). Todas as Marcas Comerciais que não são de propriedade do WebBanner são de propriedade de seus respectivos proprietários e são utilizadas mediante a devida permissão. Nenhuma informação contida nesse website pode ser interpretada como a concessão de direito ou licença para a utilização de qualquer Marca Comercial. </li>
                                <li>Comunicação com o WebBanner; os direitos do WebBanner em relação ao envio de mensagens do usuário<br/>
                                O WebBanner está sempre disposto a ouvir a opinião dos usuários de seus website. No entanto, depois da aprovação do conceito do projeto não poderão mais haver mudanças no projeto. </li>
                                <li>Quando o usuário envia mensagens de e-mail ao WebBanner, ele está se comunicando conosco de maneira eletrônica e consente em receber comunicações do WebBanner eletronicamente. Além disso, o usuário concorda que todos os acordos, notificações, divulgações e outras comunicações que fornecemos ao usuário eletronicamente satisfazem os requerimentos legais para que tal comunicação seja feita por escrito.</li>
                                <li>Restrições ao uso do website<br/>
                                O usuário concorda também que ao usar esse website, não assumirá a identidade de nenhuma pessoa ou entidade.</li>
                                <li>Em relação a qualquer informação ou conteúdo que o usuário enviar eletronicamente , ele assume e garante ao WebBanner que tem o direito e a autorização para assim fazê-lo, sem o consentimento de terceiros. O usuário concorda também em não enviar eletronicamente ou colocar neste website: (a) conteúdo que infrinja direitos autorais.</li>
                                <li>O WebBanner reserva-se o direito de, sem nenhum tipo de limitação: (a) investigar quaisquer violações suspeitas da respectiva segurança do website ou de sua tecnologia da informação ou de outros sistemas ou redes; (b) investigar quaisquer violações suspeitas desse Acordo do Usuário; (c) envolver-se e cooperar com as autoridades para o cumprimento das leis na investigação dessas questões; (d) processar judicialmente os infratores desse Acordo do Usuário ao mais amplo âmbito da lei; e (e) interromper este website a qualquer momento e sem qualquer aviso prévio, sempre zelando por sua segurança e satisfação.</li>
                                <li>Privacidade e medidas de segurança<br/>
                                O WebBanner deve coletar determinadas informações para poder operar esse website e atender às solicitações do usuário ou permitir a participação em determinadas atividades online. No entanto, o WebBanner respeita a privacidade de seus clientes e se preocupa em proteger a privacidade dos que visitam nossos sites. </li>
                                <li>Adotamos medidas razoáveis de segurança visando proteger os usuários contra a perda, o uso incorreto e a alteração das informações pessoais sob o nosso controle. Utilizamos a tecnologia Secure Sockets Layer. Os revendedores, prestadores de serviço e outras pessoas que nos ajudam a criar tanto o website quanto produtos e serviços disponíveis devem assinar acordos de confidencialidade. Esses indivíduos não têm a permissão para utilizar informações pessoais, exceto em relação aos seus respectivos serviços prestados à Mattel.No entanto, no que fugir ao alcance da Mattel ela não se responsabilizará pela completa segurança de suas informações.</li>
                                <li>Isenção de responsabilidade e limitação de responsabilidade<br/>
                                Este website pode eventualmente apresentar imperfeições técnicas ou outros erros de qualquer natureza e o usuário, ao aceitar todos os termos deste, está assumindo o risco decorrente de seu uso.</li>
                                <li> Links feitos pelo usuário a esse website<br/>
                                O usuário tem o direito limitado, não-exclusivo e revogável para criar hiperlinks para esse website, contanto que: (a) os links sejam apenas para a página principal deste website, (b) os links incorporem apenas texto e não usem nenhuma Marca Comercial, (c) os links e o conteúdo relacionado presentes no site do usuário não sugiram nenhuma afiliação ao WebBanner nem causem confusão entre os consumidores, (d) os links e o conteúdo relacionado presentes no site do usuário não representem o WebBanner nem seus respectivos produtos ou serviços de maneira falsa, enganosa, derrogante ou ofensiva.</li>
                                <li>Links nesse website feitos de/para outros sites<br/>
                                Este website poderá conter links para ou de sites de terceiros (“Sites Vinculados”), incluindo, sem limitação, sites operados por anunciantes, licenciantes, licenciados e parceiros promocionais e comerciais do WebBanner. O WebBanner não tem controle do conteúdo apresentado nestes Sites Vinculados e WebBanner não assume nenhuma obrigação para revisar nenhum Site Vinculado. O WebBanner não se responsabiliza por nenhum Site Vinculado, nem nenhum conteúdo, propaganda, informação, material, produto, serviço ou outro item presente ou disponível no site ou a partir dele. Solicitamos aos terceiros e prestadores de serviço responsáveis pelos nossos websites para garantir a privacidade e informações pessoais dos usuários, aderindo às melhores práticas de segurança do mercado para informações pessoais; respeito às propriedades intelectuais do WebBanner e aos direitos dos terceiros; além de operarem de acordo com todas as normas. Qualquer atividade em que o usuário se envolver em relação a um Site Vinculado está sujeita à política de privacidade, às condições de uso e a outros termos impostos pelo operador do Site Vinculado.</li>
                                <li>Banners, publicidade e promoções<br/>
                                Reservamo-nos o direito de colocar banners, publicidade, promoções e conteúdo equivalentes em todo este website. Anunciantes externos e empresas podem trabalhar de acordo com os termos e condições e políticas de privacidade diferentes das do WebBanner.</li>
                                <br/><br/>
                                <strong> Cláusulas independentes</strong><br/>
                                Se alguma provisão deste Acordo do Usuário for considerada ilegal, nula ou incapaz de ser cumprida por qualquer motivo, esta provisão será considerada uma cláusula independente da parte remanescente deste Acordo do Usuário e não afetará a validade ou a aplicabilidade do cumprimento dos termos do restante deste Acordo do Usuário.
                                </div>
                                 </div>');
        $manager->persist($Content);
        $manager->flush();

    }
}