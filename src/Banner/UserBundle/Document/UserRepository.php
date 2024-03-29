<?php

namespace Banner\UserBundle\Document;

use Mastop\SystemBundle\Document\BaseRepository;
use Banner\UserBundle\Document\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserRepository extends BaseRepository implements UserProviderInterface {
    
    /**
     * Pega todos ordenado por CREATED
     *
     * @return User ou null
     **/
    public function findAllByCreated()
    {
        return $this->findBy(array(), array('created'=>'desc'));
    }

    /**
     * Encontra o user com o username fornecido
     * @param string $username
     * @return object 
     */
    public function findByUsername($username) {
        return $this->findOneBy(array('username' => $username));
    }
    
    /**
     * Encontra o user com o code fornecido
     * @param string $code
     * @return object 
     */
    public function findByCode($code) {
        return $this->findOneBy(array('code' => $code));
    }

    /**
     * Encontra o user com o email fornecido
     * @param string $email
     * @return object 
     */
    public function findByEmail($email) {
        return $this->findOneBy(array('email' => $email));
    }

    /**
     * Encontra o user com o actkey fornecido e o ativa
     * @param string $actkey
     * @return object 
     */
    public function findByActkey($actkey) {

        return $this->findOneBy(array('actkey' => $actkey));
    }

    /**
     * Altera os dados do usuário para ativar ele
     * @param id $id
     * @return null
     */
    public function activeUser($id) {
        return $this->createQueryBuilder('BannerUserBundle:User')
                ->findAndUpdate()
                ->field('id')->equals($id)
                ->update()
                ->field('actkey')->set('')
                ->field('mailOk')->set(true)
                ->field('status')->set(1)
                ->getQuery()
                ->execute()
        ;
    }
    /**
     * Bloqueia o usuário
     * @param id $id
     * @return null
     */
    public function block($user) {
        return $this->createQueryBuilder('BannerUserBundle:User')
                ->findAndUpdate()
                ->field('id')->equals($user->getId())
                ->update()
                ->field('actkey')->set('')
                ->field('mailOk')->set(true)
                ->field('status')->set(2)
                ->getQuery()
                ->execute()
        ;
    }

    public function findByField($campo, $valor, $multiplos=false) {
        if ($multiplos) {
            return $this->findBy(array($campo => $valor));
        } else {
            return $this->findOneBy(array($campo => $valor));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username) {
        $user = $this->findByEmail($username);

        if (null === $user) {
            throw new UsernameNotFoundException(sprintf('Usuário "%s" não encontrado.', $username));
        }elseif($user->getStatus() == 2){
            throw new UsernameNotFoundException(sprintf('Usuário "%s" está desativado.', $username));
        }

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user) {
        if (!$user instanceof Banner\UserBundle\Document\User) {
            throw new UnsupportedUserException(sprintf('Instâncias de "%s" não são suportadas.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getEmail());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class) {
        return $class === 'Banner\UserBundle\Document\User';
    }
}