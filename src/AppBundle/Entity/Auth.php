<?php
/**
 * Auth
 *
 * @author Saswati
 *
 * @category Entity
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Auth
 *
 * @ORM\Table(name="Auth")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AuthRepository")
 */
class Auth
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="accessToken", type="string", length=255)
     */
    private $accessToken;

    /**
     * @var string
     *
     * @ORM\Column(name="realmId", type="string", length=255, unique=true)
     */
    private $realm;

    /**
     * @var string
     *
     * @ORM\Column(name="refresh_token", type="string", length=255, unique=true)
     */
    private $refresh_token;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set accessToken
     *
     * @param string $accessToken
     *
     * @return Company
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get accessToken
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set realm
     *
     * @param string $realm
     *
     * @return Company
     */
    public function setRealm($realm)
    {
        $this->realm = $realm;

        return $this;
    }

    /**
     * Get realm
     *
     * @return string
     */
    public function getRrealm()
    {
        return $this->realm;
    }

    /**
     * Set refreshToken
     *
     * @param string $refreshToken
     *
     * @return Company
     */
    public function setrefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * Get refreshToken
     *
     * @return string
     */
    public function getrefreshToken()
    {
        return $this->refreshToken;
    }
}

