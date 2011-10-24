<?php
/**
 *                                              ,d                              
 *                                              88                              
 * 88,dPYba,,adPYba,   ,adPPYYba,  ,adPPYba,  MM88MMM  ,adPPYba,   8b,dPPYba,   
 * 88P'   "88"    "8a  ""     `Y8  I8[    ""    88    a8"     "8a  88P'    "8a  
 * 88      88      88  ,adPPPPP88   `"Y8ba,     88    8b       d8  88       d8  
 * 88      88      88  88,    ,88  aa    ]8I    88,   "8a,   ,a8"  88b,   ,a8"  
 * 88      88      88  `"8bbdP"Y8  `"YbbdP"'    "Y888  `"YbbdP"'   88`YbbdP"'   
 *                                                                 88           
 *                                                                 88           
 * 
 * Tuvais/CoreBundle/Controller/Widget/BlockController.php
 *
 * Controller para os Widgets de Blocos
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



namespace Tuvais\CoreBundle\Controller\Widget;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Mastop\SystemBundle\Controller\BaseController;
use Tuvais\CoreBundle\Document\Banner;

class BlockController extends BaseController {

    /**
     * Widget que renderiza o bloco lateral
     * @Template()
     */
    public function renderAction($area = 'home', $opts = array()) {
        $session = $this->get('session');
        $ret = array();
        $c = 0;
        switch ($area) {
            case 'topL':
            case 'topR':
            case 'city': // Home de cada cidade
            case 'category': // Home de cada categoria
            case 'search': // Página de busca
            case 'content': // Página de conteúdo
            case 'deal': // Página de oferta
            case 'sell': // Página de venda
            case 'home':
            default :
                $ret[$c]['title'] = 'Bloco de Exemplo para a Home';
                $ret[$c]['content'] = 'Conteúdo de Exemplo para a Home';
                $c++;
                break;
        }
        $ret[$c]['content'] = '<a id="twitterBlock" href="http://twitter.com/tuvais" target="_blank" title="Siga o Tuvais no Twitter!">Siga o Tuvais no Twitter!</a>';
        $c++;
        $ret[$c]['widget'] = 'TuvaisCoreBundle:Widget\\Block:facebookFans';
        $ret[$c]['opts'] = array('profile' => '188401247891549', 'url' => 'http://www.facebook.com/tuvais', 'css' => 'http://www.mastop.com.br/fernando/css/facebook.css');
        //$ret[$c]['widget'] = 'TuvaisCoreBundle:Widget\\Block:facebook';
        //$ret[$c]['opts'] = array('url' => 'http://www.facebook.com/recompracoletiva', 'width' => '292', 'border' => '#FFFFFF');
        return array('blocks' => $ret, 'area' => $area);
    }

    /**
     * Widget que renderiza o Bloco do Facebook
     * @param string $url
     * @param string $width
     * @Template()
     */
    public function facebookAction($url, $width, $border = '#000000', $faces = 'true', $stream = 'false', $header = 'false') {
        return array('url' => $url, 'width' => $width, 'border' => $border, 'faces' => $faces, 'stream' => $stream, 'header' => $header);
    }
    /**
     * Widget que renderiza o Bloco do Facebook Fans
     * @param string $profile
     * @param int $width
     * @param int $height
     * @param int $connections
     * @param string $css
     * @param bool $stream
     * @param bool $header
     * @Template()
     */
    public function facebookFansAction($profile, $url, $width = 300, $height = 330, $connections = 36, $css = null, $stream = 'false', $header = 'false') {
        return array('profile' => $profile, 'url' => $url, 'width' => $width, 'height' => $height, 'connections' => $connections, 'css' => $css, 'stream' => $stream, 'header' => $header);
    }
    /**
     * Lista todas os Banners
     * 
     * @Template()
     */
    public function bannerAction()
    {
        $session = $this->get('session');
        $banner = $this->mongo('TuvaisCoreBundle:Banner')->findByCity($this->mastop()->param('core.banner.loadnum'), $session->get('tuvais.user.cityId'));
        if($banner && count($banner) > 0){
            return array(
            'banner' => $banner,
            );
        }
        return array();
    }

}