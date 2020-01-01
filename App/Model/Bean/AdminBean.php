<?php


namespace App\Model\Bean;


use EasySwoole\Spl\SplBean;

class AdminBean extends SplBean
{
    /** @var 数据对象 */

    protected $adminId;

    protected $adminName;

    protected $adminAccount;

    protected $adminPassword;

    protected $adminSession;

    protected $adminLastLoginTime;

    protected $adminLastLoginIp;

    /**
     * @return mixed
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * @param mixed $adminId
     */
    public function setAdminId($adminId): void
    {
        $this->adminId = $adminId;
    }

    /**
     * @return mixed
     */
    public function getAdminName()
    {
        return $this->adminName;
    }

    /**
     * @param mixed $adminName
     */
    public function setAdminName($adminName): void
    {
        $this->adminName = $adminName;
    }

    /**
     * @return mixed
     */
    public function getAdminAccount()
    {
        return $this->adminAccount;
    }

    /**
     * @param mixed $adminAccount
     */
    public function setAdminAccount($adminAccount): void
    {
        $this->adminAccount = $adminAccount;
    }

    /**
     * @return mixed
     */
    public function getAdminPassword()
    {
        return $this->adminPassword;
    }

    /**
     * @param mixed $adminPassword
     */
    public function setAdminPassword($adminPassword): void
    {
        $this->adminPassword = password_hash($adminPassword,PASSWORD_BCRYPT);
    }

    /**
     * @return mixed
     */
    public function getAdminSession()
    {
        return $this->adminSession;
    }

    /**
     * @param mixed $adminSession
     */
    public function setAdminSession($adminSession): void
    {
        $this->adminSession = $adminSession;
    }

    /**
     * @return mixed
     */
    public function getAdminLastLoginTime()
    {
        return $this->adminLastLoginTime;
    }

    /**
     * @param mixed $adminLastLoginTime
     */
    public function setAdminLastLoginTime($adminLastLoginTime): void
    {
        $this->adminLastLoginTime = $adminLastLoginTime;
    }

    /**
     * @return mixed
     */
    public function getAdminLastLoginIp()
    {
        return $this->adminLastLoginIp;
    }

    /**
     * @param mixed $adminLastLoginIp
     */
    public function setAdminLastLoginIp($adminLastLoginIp): void
    {
        $this->adminLastLoginIp = $adminLastLoginIp;
    }


}